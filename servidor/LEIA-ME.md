# Envio direto (cPanel)

Com isto, o botão da app passa a **Enviar registo**: as fotografias seguem
sozinhas para a caixa da loja do técnico, assinadas por `info@cate.com.pt`.
A partilha pela app de email fica como alternativa («Sem rede? Partilhar pela
app de email»).

## Instalar

1. No cPanel, **Gestor de ficheiros**: criar a pasta `public_html/catefoto/`.
2. Carregar para lá `enviar.php`.
3. Copiar `config.exemplo.php` para `config.php`, na mesma pasta, e preencher:
   - `codigo`: um código longo e aleatório. É o que se dá aos técnicos.
   - `remetente`: `info@cate.com.pt` (tem de existir neste cPanel).
   - `lojas`: as caixas de cada loja.
4. **MultiPHP INI Editor**: `upload_max_filesize` e `post_max_size` com pelo
   menos `25M`; `max_file_uploads` com pelo menos `80`.
5. Abrir `https://<domínio>/catefoto/enviar.php` no browser: deve responder
   `{"ok":false,"erro":"metodo"}`. Isso quer dizer que está a funcionar.
6. Dizer o endereço final a quem mantém a app: entra em `CONFIG.ENVIO_URL` e
   no `connect-src` da CSP do `index.html`.

## Segurança

- O `config.php` **nunca** vai para o GitHub (está no `.gitignore`).
- Só aceita pedidos da app publicada, com o código certo, para as lojas da
  configuração (a app não escolhe o endereço) e só fotografias JPEG.
- Máximo de envios por IP e por hora (`max_por_hora`), incluindo códigos errados.
- Se o código escapar, muda-se no `config.php` e dá-se o novo aos técnicos.
