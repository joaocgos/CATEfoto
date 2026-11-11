<?php
// Copiar para config.php (na mesma pasta do enviar.php, no servidor) e
// preencher. O config.php NUNCA vai para o GitHub: tem o código de acesso.
return [
    // Código que os técnicos escrevem uma vez no telemóvel. Longo e aleatório;
    // se escapar, muda-se aqui e dá-se o novo aos técnicos.
    'codigo' => 'MUDAR-ISTO-POR-UM-CODIGO-LONGO',

    // Caixa que assina os emails: tem de existir no cPanel deste domínio.
    'remetente' => 'info@cate.com.pt',
    'remetente_nome' => 'CATEfoto',

    // Chave enviada pela app => caixa da loja.
    'lojas' => [
        'famalicao' => 'fotos.famalicao@cate.com.pt',
        'porto'     => 'fotos.porto@cate.com.pt',
    ],

    // Sites que podem chamar este script.
    'origens' => [
        'https://joaocgos.github.io',
        'http://localhost:8777',
    ],

    // Envios (e tentativas com código errado) por IP e por hora.
    'max_por_hora' => 60,

    // Tamanho máximo das fotografias de um registo. O post_max_size e o
    // upload_max_filesize do PHP (cPanel > MultiPHP INI Editor) têm de ser
    // maiores do que isto.
    'max_bytes' => 20 * 1024 * 1024,
];
