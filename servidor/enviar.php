<?php
// CATEfoto — recebe um registo da app e envia-o por email, a partir da caixa
// de envio da CATE, para a caixa da loja escolhida pelo técnico.
//
// Instalação: ver servidor/LEIA-ME.md. Este ficheiro não tem segredos; o
// código de acesso e os endereços ficam em config.php, só no servidor.

declare(strict_types=1);

$cfg = require __DIR__ . '/config.php';

// ── CORS: só a app publicada (e o teste local) podem chamar este script ──
$origem = $_SERVER['HTTP_ORIGIN'] ?? '';
if (in_array($origem, $cfg['origens'], true)) {
    header('Access-Control-Allow-Origin: ' . $origem);
    header('Vary: Origin');
    header('Access-Control-Allow-Methods: POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Access-Control-Max-Age: 86400');
}
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') { http_response_code(204); exit; }

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function responder(int $codigo, string $erro = ''): void {
    http_response_code($codigo);
    echo json_encode($erro === '' ? ['ok' => true] : ['ok' => false, 'erro' => $erro]);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') responder(405, 'metodo');
if (!in_array($origem, $cfg['origens'], true)) responder(403, 'origem');

// Pedido maior que o post_max_size do PHP: o PHP descarta tudo em silêncio.
if (empty($_POST) && (int)($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) responder(413, 'grande');

// ── Limite por IP: trava abusos se o código de acesso escapar ──
$ip = $_SERVER['REMOTE_ADDR'] ?? 'x';
$marca = sys_get_temp_dir() . '/catefoto_' . md5($ip);
$agora = time();
$recentes = array_filter(
    is_file($marca) ? (array)json_decode((string)file_get_contents($marca), true) : [],
    fn($t) => is_int($t) && $t > $agora - 3600
);
if (count($recentes) >= $cfg['max_por_hora']) responder(429, 'limite');

// ── Código de acesso ──
$codigo = (string)($_POST['codigo'] ?? '');
if ($codigo === '' || !hash_equals((string)$cfg['codigo'], $codigo)) {
    $recentes[] = $agora;   // tentativas erradas também contam
    @file_put_contents($marca, json_encode(array_values($recentes)), LOCK_EX);
    responder(401, 'codigo');
}

// ── Destino: só as lojas da configuração; a app nunca escolhe o endereço ──
$loja = (string)($_POST['loja'] ?? '');
if (!isset($cfg['lojas'][$loja])) responder(400, 'loja');
$para = $cfg['lojas'][$loja];

$assunto = trim(str_replace(["\r", "\n"], ' ', (string)($_POST['assunto'] ?? '')));
$corpo = (string)($_POST['corpo'] ?? '');
if ($assunto === '' || mb_strlen($assunto) > 200 || mb_strlen($corpo) > 20000) responder(400, 'texto');

// ── Fotografias: só JPEG, nomes limpos, limites de quantidade e tamanho ──
$fotos = $_FILES['fotos'] ?? null;
if (!$fotos || !is_array($fotos['name'])) responder(400, 'fotos');
$n = count($fotos['name']);
if ($n < 1 || $n > 80) responder(400, 'fotos');
$anexos = [];
$total = 0;
for ($i = 0; $i < $n; $i++) {
    if ($fotos['error'][$i] !== UPLOAD_ERR_OK) responder(413, 'grande');
    $tmp = $fotos['tmp_name'][$i];
    $dados = (string)file_get_contents($tmp);
    if (substr($dados, 0, 3) !== "\xFF\xD8\xFF") responder(400, 'formato');
    $total += strlen($dados);
    if ($total > $cfg['max_bytes']) responder(413, 'grande');
    $nome = preg_replace('/[^A-Za-z0-9_.-]/', '_', basename((string)$fotos['name'][$i]));
    $anexos[] = [$nome, $dados];
}

// ── Mensagem MIME ──
$fronteira = 'catefoto_' . bin2hex(random_bytes(12));
$cab = [
    'From: ' . $cfg['remetente_nome'] . ' <' . $cfg['remetente'] . '>',
    'MIME-Version: 1.0',
    'Content-Type: multipart/mixed; boundary="' . $fronteira . '"',
    'X-Mailer: CATEfoto',
];
$msg = "--$fronteira\r\n"
     . "Content-Type: text/plain; charset=UTF-8\r\n"
     . "Content-Transfer-Encoding: base64\r\n\r\n"
     . chunk_split(base64_encode($corpo)) . "\r\n";
foreach ($anexos as [$nome, $dados]) {
    $msg .= "--$fronteira\r\n"
          . "Content-Type: image/jpeg; name=\"$nome\"\r\n"
          . "Content-Disposition: attachment; filename=\"$nome\"\r\n"
          . "Content-Transfer-Encoding: base64\r\n\r\n"
          . chunk_split(base64_encode($dados)) . "\r\n";
}
$msg .= "--$fronteira--\r\n";

$enviado = mail(
    $para,
    '=?UTF-8?B?' . base64_encode($assunto) . '?=',
    $msg,
    implode("\r\n", $cab),
    '-f' . $cfg['remetente']
);

$recentes[] = $agora;
@file_put_contents($marca, json_encode(array_values($recentes)), LOCK_EX);

if (!$enviado) responder(502, 'mail');
responder(200);
