# CATEfoto

Página para os funcionários da CATE enviarem fotografias ao longo de um
serviço. Cada registo é classificado por **tipo de serviço** (doméstico,
hotelaria, ar condicionado), por **momento** (recolha, reparação no local,
entrada em oficina, entrega, montagem, orçamento) e, onde se aplica, pela
**garantia**.

Funciona sem servidor, sem base de dados e sem login. É só HTML, CSS e
JavaScript — as fotografias são comprimidas no próprio telemóvel e entregues
à app de email através da partilha nativa do sistema.

**Projeto autónomo.** Não depende de nenhum outro sistema, não partilha código,
base de dados nem configuração com nada. É uma pasta de ficheiros que se publica
e se usa por si.

---

## Ficheiros

| Ficheiro | Para que serve |
|---|---|
| `index.html` | A aplicação inteira |
| `logo.png` | Logótipo do cabeçalho |
| `icon-192.png`, `icon-512.png` | Ícones do ecrã principal do telemóvel |
| `manifest.webmanifest` | Faz com que abra em ecrã inteiro, sem barra do browser |

Os quatro ficheiros têm de ficar na **mesma pasta**.

---

## Publicar

A página precisa de estar em **HTTPS** — a partilha de ficheiros não funciona
em `http://` nem a abrir o ficheiro diretamente do telemóvel.

**GitHub Pages** (o que está em uso):

1. Criar o repositório `CATEfoto` em <https://github.com/new>,
   **público** (o Pages só é gratuito em repositórios públicos).
2. `git push -u origin main`
3. No repositório: *Settings* → *Pages* → *Source: Deploy from a branch* →
   ramo `main`, pasta `/ (root)` → *Save*.
4. Ao fim de um minuto fica em <https://joaocgos.github.io/CATEfoto/>.

Cada `git push` para `main` republica o site automaticamente.

O ficheiro `.nojekyll` existe para o GitHub servir os ficheiros tal como estão,
sem os passar pelo Jekyll.

**Netlify Drop** é a alternativa sem repositório público: abrir
<https://app.netlify.com/drop> e arrastar a pasta para a página.

---

## Instalar no telemóvel do técnico

1. Abrir o endereço no browser (Chrome no Android, Safari no iPhone).
2. Menu do browser → **Adicionar ao ecrã principal**.
3. Passa a abrir como uma app, com ícone próprio e sem barra de endereço.

Convém ainda **guardar o endereço de destino nos contactos** do telemóvel.
Depois do primeiro envio, a app de email passa a sugerir o endereço sozinha e
o Android chega a mostrá-lo diretamente no menu de partilha.

---

## Como se usa

1. Escolher o **tipo de serviço**, depois o **momento** e, se se aplicar, a
   **garantia**. As escolhas aparecem uma a uma, e cada uma feita encolhe para
   uma linha com "alterar". O resto do formulário só aparece no fim — assim não
   é possível preencher tudo e descobrir que faltava classificar o registo.
2. Escrever o número do serviço e quem regista — o nome fica guardado no
   telemóvel e não é preciso repetir.
3. Fotografar as **etiquetas do equipamento** (marca, modelo, número de série).
   Cabem várias, para equipamentos com mais do que uma chapa.
4. Fotografar o **equipamento** — pela câmara ou escolhendo da galeria.
5. **Partilhar registo** → abre a partilha do telemóvel → escolher o email →
   **carregar em enviar dentro da app de email**.

O corpo leva o técnico, a data e a hora a que cada fotografia foi realmente
tirada. O assunto vai no formato `26000123 · RECOLHA · DOMESTICO` — ver
*O assunto nem sempre chega*.

### O assunto depende da app de email

A partilha leva um assunto (`title`), mas **cada app decide se o usa** — não há
nada do lado da página que o force. O Gmail no Android, que é o que os técnicos
usam, preenche-o; noutras apps pode chegar vazio.

Para esse caso, o cartão "Enviar para" mostra o assunto com um **botão de
copiar**, ao lado das caixas das lojas: copia-se antes de partilhar e cola-se
na app de email. E mesmo sem assunto nenhum, o registo continua identificável —
o corpo começa pelo serviço e pelo momento, e o número do serviço vai no nome
de cada ficheiro.

### O botão partilha, não envia

Uma página web não consegue enviar um email sozinha nem saber se ele chegou a
sair. O que faz é entregar as fotografias à app de email, com o texto
preenchido — o envio tem mesmo de ser confirmado lá dentro.

Por isso o botão diz *Partilhar registo* e o ecrã final diz *Falta enviar o
email*. Nenhum dos dois promete o que a página não pode garantir.

Se a partilha correr mal — a app de email fechou, o rascunho perdeu-se,
escolheu-se a app errada — o ecrã final tem **Partilhar outra vez**, que repete
tudo com as mesmas fotografias. Estas só desaparecem quando se toca em
*Novo registo*, que recomeça tudo: as fotografias, os campos, o número de
equipamentos e a classificação (tipo, momento e garantia). Só o nome de quem
regista é que se mantém.

### Descrição por fotografia

Uma pergunta única, logo à entrada das fotografias: **"Estas fotografias
precisam de descrição?"**. No caso comum fica desligada, e nada muda. Marcada,
cada fotografia — de qualquer parte do registo, etiquetas incluídas — ganha um
campo de texto opcional por baixo, até 140 caracteres, e a grelha passa de três
colunas para uma só, com espaço para escrever.

A descrição vai no corpo do email, junto da hora a que essa fotografia foi
tirada:

    Tiradas em:
      · 01 — 12/09/2026 10:03 — "risco já existente antes da recolha"
      · 02 — 12/09/2026 10:04

Desligar a pergunta apaga o que estava escrito — não fica nada escondido à
espera. Um "Novo registo" começa sempre com a pergunta desligada.

### Folha de serviço

Quando há um número de serviço preenchido — obrigatório ou não — aparece um
cartão para fotografar a folha de serviço. É opcional, cabem quatro fotografias
(frente, verso, páginas seguintes), e os ficheiros saem como
`26000123_recolha_dom_gar_folha_01.jpg`.

Ao contrário das etiquetas e das fotografias, a folha pertence ao **serviço** e
não a um equipamento: por isso tem cartão próprio e o nome do ficheiro nunca
leva o prefixo `eq`, mesmo num registo com vários equipamentos.

Sem número de serviço o cartão não aparece — não haveria folha a que se referir.

### Fatura

Nos registos **em garantia** aparece um cartão para fotografar a fatura de
compra — é o que prova que o equipamento está coberto. Cabem três
fotografias. Se o cliente tiver a fatura no telemóvel, fotografa-se o ecrã. Os
ficheiros saem como `26000123_recolha_dom_gar_fatura_01.jpg`.

No primeiro contacto é obrigatória com dispensa ("O cliente não tem a fatura");
na Entrega é opcional (ver `faturaObrigatoria`).

### Dispensa com registo

Três coisas podem ser obrigatórias e, ainda assim, faltar por boas razões: o
**número do serviço** (ainda não aberto), a **etiqueta** de um equipamento
(chapa ilegível ou inexistente) e a **fatura** (o cliente não a tem). Para
essas há uma caixa — *"… — omitir (fica registado)"* — que deixa partilhar sem
elas. Ao marcar, aparece um campo opcional para o motivo.

A omissão fica escrita no email, para quem arquiva distinguir uma decisão de
um esquecimento:

    Omitido por decisão de quem regista:
      · Número do serviço — "Serviço ainda por abrir"
      · Etiqueta do equipamento 2
      · Fatura — "Comprou online, envia depois"

Marcar a dispensa do número esvazia e bloqueia o campo; tirar a marca, ou
mudar para um momento onde a dispensa não existe, repõe o que lá estava. Um
"Novo registo" começa sempre sem dispensas.

Tal como a folha de serviço, é do serviço e não de um equipamento: nunca leva o
prefixo `eq`. Não aparece em "fora de garantia" nem no Orçamento.

### O que fica escondido não é enviado

Algumas partes do formulário aparecem e desaparecem conforme as escolhas: a
folha precisa de número de serviço, a fatura precisa de "em garantia", e o
Orçamento troca os blocos de equipamento pelas fotografias do local. Se uma
dessas partes tiver fotografias e depois desaparecer — por exemplo, mudar para
Orçamento depois de fotografar equipamentos — essas fotografias **ficam de fora**
do email e do total. Só vai o que o técnico está a ver.

Nesse momento aparece um aviso breve — por exemplo, *"As 3 fotografias do
equipamento ficam guardadas, mas não seguem neste registo."* — para o técnico
não pensar que as perdeu, nem que vão no email. Se voltar atrás, reaparecem.

### Vários equipamentos

Um registo pode cobrir mais do que um equipamento — típico em hotelaria, onde
se vai lá uma vez e se mexe em cinco máquinas. O contador no cartão
*Equipamentos* faz aparecer um bloco por cada, com etiquetas e fotografias
próprias.

Isto existe para quem recebe o email conseguir dizer que fotografia pertence a
que máquina. Sem os blocos, cinco equipamentos dariam um monte único de fotos
indistinguíveis.

Baixar o contador não apaga nada em silêncio: se o último bloco tiver
fotografias, o contador recusa e pede que sejam removidas primeiro. E ao
partilhar, um bloco vazio no meio dos outros é assinalado pelo nome
("O equipamento 2 não tem fotografias") em vez de passar despercebido.

### As etiquetas

Cabem várias por equipamento — há máquinas com mais do que uma chapa, e às
vezes é preciso repetir uma que saiu tremida.

Se o serviço já tiver levado etiquetas noutro registo, aparece um aviso a
dizer em qual e quando. É só informação: não desaconselha repetir, porque uma
etiqueta a mais nunca fez mal e uma a menos obriga a voltar ao equipamento.
Esse aviso vive no telemóvel de quem as enviou, por isso outro técnico não o vê.

Quando um registo segue sem etiquetas, o email leva sempre uma linha a dizer
porquê — `Etiquetas: nenhuma neste registo — já enviadas no registo de Recolha
(07/09/2026 14:02).` ou `Etiquetas: nenhuma neste registo.` — para quem arquiva
distinguir uma omissão deliberada de um esquecimento.

### Sem rede em casa do cliente

Não é problema. O técnico tira as fotografias com a câmara normal do telemóvel
e mais tarde, já com rede, envia-as pela galeria. A página lê a data original
de cada fotografia (EXIF) e é essa que vai no email — fica sempre registada a
hora a que se esteve com o equipamento, não a hora do envio.

---

## Afinações

Tudo o que se mexe está no bloco `CONFIG`, no início do `<script>` do
`index.html`:

```js
const CONFIG = {
  EMAIL_CAIXA: "recolhas",          // o endereço é montado em tempo de
  EMAIL_DOMINIO: "cate.com.pt",     // execução, ver nota abaixo
  MAX_FOTOS: 6,         // fotografias POR equipamento
  MAX_ETIQUETAS: 2,     // etiquetas POR equipamento
  MAX_EQUIPAMENTOS: 20, // equipamentos declaráveis num registo
  AVISO_TAMANHO: 8 * 1024 * 1024,  // a partir daqui avisa que o registo é pesado
  PERFIS: {
    texto: { lado: 2048, qualidade: 0.82 },  // etiquetas, fatura, folha
    foto:  { lado: 1600, qualidade: 0.78 },  // equipamento, local
  },
  LOJAS: [            // caixas das lojas (ver abaixo)
    { nome: "Famalicão", caixa: "fotos.famalicao", dominio: "cate.com.pt" },
    { nome: "Porto",     caixa: "fotos.porto",     dominio: "cate.com.pt" },
  ],
  ENDPOINT: null,
};
```

**Tipos, momentos e garantia** — as listas `SERVICOS`, `MOMENTOS` e `GARANTIAS`,
logo a seguir ao `CONFIG`. São independentes: uma recolha doméstica tanto pode
ser em garantia como fora dela. Para acrescentar, remover ou reordenar mexe-se
só aí — os botões, o prefixo do assunto, o corpo do email e os nomes dos
ficheiros são todos gerados a partir delas. As entradas de `SERVICOS` e
`GARANTIAS` levam também `curta`, o código que vai nos nomes dos ficheiros.

Cada entrada precisa de `chave` (vai no nome do ficheiro), `marca` (prefixo do
assunto, sem acentos), `nome`, `texto` (corpo do email), `icone` e, se fizer
sentido, `detalhe` para a segunda linha do botão — que pode ficar vazia.

**Exceções por momento.** Nem todos os momentos precisam das mesmas coisas, e
essas diferenças declaram-se na própria entrada em vez de ficarem espalhadas
pelo código. As marcas existentes:

    numeroOpcional: true
    numeroDispensavel: true
    etiquetaObrigatoria: true
    faturaObrigatoria: true
    campoRecebidoPor: true
    ajudaEtiquetas: "..."
    ajudaFotos: "..."
    semEquipamentos: true
    clienteSempre: true
    camposContacto: true
    campoPretendido: true
    semGarantia: true

**O número do serviço** tem três níveis:

- **Obrigatório** — Entrada Oficina, Entrega e Montagem, onde o serviço já
  existe: exigir o número é o que liga o registo ao processo.
- **Obrigatório com dispensa** (`numeroDispensavel`) — Recolha e Reparação no
  local: vai-se a casa do cliente e o serviço pode ser aberto só depois. O
  número é pedido, mas pode ser omitido com a caixa por baixo do campo (ver
  *Dispensa com registo*).
- **Opcional** (`numeroOpcional`) — Orçamento: as fotografias servem
  justamente para *produzir* o serviço. O rótulo diz "(opcional)" e não há
  caixa.

Sem número, o registo tem de ser atribuível a alguém. Na Recolha e na
Reparação, o **Nome do cliente** e a **Morada / local** só aparecem depois de se
marcar a dispensa — e aí são ambos obrigatórios. Com número, o serviço já diz
de quem é e onde, e os campos ficam escondidos (o que lá estiver escrito não
segue). No Orçamento o nome do cliente e a morada estão sempre à vista.

`etiquetaObrigatoria` está ligada na **Entrada Oficina** e na **Montagem**: é
pela chapa que a oficina identifica a máquina que acabou de entrar. O cartão
passa a dizer "Etiquetas · obrigatória" e, se faltar, a validação aponta o
equipamento em causa. Como há chapas ilegíveis ou arrancadas, cada equipamento
tem a sua caixa de dispensa. Nos outros momentos as etiquetas são opcionais.

`faturaObrigatoria` marca o **primeiro contacto** — Recolha, Reparação no
local, Entrada Oficina e Montagem. Aí, em garantia, a fatura passa a
obrigatória com dispensa. Na Entrega fica opcional e sem caixa: nessa altura a
fatura normalmente já seguiu, e uma caixa em todos os registos virava reflexo.

`ajudaEtiquetas` e `ajudaFotos` substituem o texto de ajuda dessas secções. O
mesmo campo pede coisas diferentes conforme o momento: na Entrada Oficina a
chapa serve para identificar a máquina que entrou, na Montagem é o que dá acesso
à garantia do equipamento novo. E num equipamento acabado de instalar não há
danos anteriores a documentar, por isso a Montagem pede "o equipamento instalado
e as ligações feitas" em vez de "o estado do equipamento e qualquer dano
visível". Quando o momento não define nenhum texto, usa-se o genérico.

`campoRecebidoPor` está ligada na **Entrega** e na **Montagem**: faz aparecer um campo opcional
"Recebido por". Numa entrega, quem recebeu é parte da prova — sem isso o registo
mostra o estado do equipamento mas não que chegou às mãos de alguém. Uma
instalação acaba da mesma maneira, com o equipamento entregue a funcionar. Fica
opcional para não travar a partilha quando não se soube. O valor só entra no
email nos momentos onde o campo existe.

### O Orçamento é outra coisa

As últimas quatro marcas existem por causa dele. O Orçamento não é um registo de
equipamento: é um **levantamento do local** para depois se planear a execução.
Não há máquina para identificar, logo não há blocos de equipamento nem
etiquetas — `semEquipamentos` troca tudo isso por um cartão único,
"Fotografias do local".

Em contrapartida, o que quem orçamenta precisa é de saber **de quem** e **onde**,
e sobretudo **o que lhe estão a pedir**: `clienteSempre` exige o nome mesmo
havendo número de serviço, `camposContacto` acrescenta morada (obrigatória) e
contacto (opcional), e `campoPretendido` acrescenta um campo obrigatório
"O que o cliente pretende". Quem vai pôr um preço nas fotografias não esteve lá;
sem isto, veria imagens sem saber o que se lhe pede.

Também não tem garantia (`semGarantia`): um levantamento de local não tem
estado de garantia, por isso o seletor nem aparece. Os ficheiros saem sem `eq`,
sem `etiqueta` e sem garantia: `26000123_orcamento_dom_01.jpg`.

Sem número, o assunto identifica pelo cliente
(`Maria Fernandes · RECOLHA · DOMESTICO`) e os ficheiros levam um
carimbo de data e hora à cabeça (`20260909_2322_recolha_dom_gar_01.jpg`), para
que dois registos do mesmo tipo no mesmo dia não deem ficheiros com o mesmo
nome.

**Limites por equipamento** — `MAX_FOTOS` e `MAX_ETIQUETAS` valem para *cada*
equipamento, não para o registo todo: com três equipamentos declarados cabem
três vezes isto. Os valores são provisórios; ajustar com o uso real.

**Caixas das lojas** — a lista `LOJAS`. A partilha dos telemóveis não deixa a
app preencher o destinatário, por isso, com lojas configuradas, aparecem as
caixas de todas lado a lado num cartão no fim do formulário, cada uma com um
botão de copiar: o técnico copia a da sua loja e cola-a no "Para" do email. O
rodapé fica só com uma linha, "Destino: a caixa da tua loja", que leva até lá —
com as lojas no rodapé fixo, ocupavam quase um terço do ecrã. Cada
entrada leva `nome`, `caixa` e `dominio` — o endereço é montado em tempo de
execução, como o de cima, para não aparecer por extenso no código. Com a lista
vazia mostra-se o destino único.

**Qualidade das fotografias** — dois perfis em `PERFIS`. Onde há texto que tem
de se ler (etiquetas, fatura, folha de serviço) usa-se o `texto`, a 2048 px e
qualidade 0.82; nas fotografias do equipamento e do local, o `foto`, a 1600 px
e 0.78. Medido com uma chapa e uma superfície riscada simuladas numa foto de
12 MP: a 1280 px (a regulação anterior) os algarismos da letra miúda já se
confundiam; as amolgadelas veem-se em qualquer regulação; os riscos muito finos
numa foto de conjunto não são garantidos por nenhuma — por isso a ajuda das
fotografias pede uma foto de perto a cada dano. A regulação pesa mais do que
parece porque a cópia do email é quase sempre a única: as fotos tiradas pelo
botão Câmara em regra não ficam na galeria.

---

## Envio automático (para mais tarde, se fizer falta)

Neste momento o técnico tem de escolher a app de email no menu de partilha e
confirmar o envio lá dentro. Não é envio automático a sério, e a página não
consegue saber se a mensagem chegou a sair.

Para eliminar esse passo é preciso um endpoint que receba as fotografias e as
reencaminhe por email. Basta apontar `CONFIG.ENDPOINT` para o seu URL e o botão
passa a enviar sozinho — o resto da página já está preparado. O endpoint recebe
um `multipart/form-data` com os campos `para`, `assunto`, `corpo`, `numero`,
`momento`, `tipo`, `garantia` (só quando se aplica) e as imagens em `fotos`.

Nesse modo o ecrã final passa a dizer *Registo enviado*, porque aí a resposta
do servidor é confirmação a sério.

Só vale a pena se a fricção se revelar um incómodo real: obriga a uma conta de
serviço de email e a uma chave guardada no servidor.

---

## Nome dos ficheiros

Com um só equipamento:

    26000123_oficina_dom_fg_etiqueta_01.jpg
    26000123_oficina_dom_fg_01.jpg

Com vários, entra o número do equipamento — que só aparece quando é preciso,
para não alongar o nome no caso comum:

    26000123_recolha_hot_gar_eq1_etiqueta_01.jpg
    26000123_recolha_hot_gar_eq2_01.jpg

O assunto — quando a app de email o aceita — leva o número do serviço, o
momento e o tipo, por esta ordem: `26000123 · OFICINA · DOMESTICO`. O número
vem à frente porque a lista do email no telemóvel mostra pouco mais de 30
caracteres, e é por ele que se procura um registo; a garantia fica de fora
porque vai no corpo, por extenso. Nos ficheiros, o tipo e a garantia entram por
códigos curtos — `dom`, `hot`, `ac` e `gar`, `fg` — porque é o que mais pesa no
comprimento do nome.

O padrão é fixo e previsível de propósito: se algum dia se quiser arquivar esta
caixa de correio automaticamente, o número do serviço e o tipo lêem-se do
nome do ficheiro e do assunto, sem depender de nada do lado da página.

---

## Segurança e privacidade

A app não tem servidor, não tem base de dados e não guarda fotografias em lado
nenhum: elas existem na memória do telemóvel até serem entregues à app de email.
Não há dependências externas nem código de terceiros — o que reduz a superfície
de ataque a quase nada.

**As fotografias não levam a morada do cliente.** A recompressão passa a imagem
por um `canvas`, o que descarta todos os metadados do original — incluindo as
coordenadas GPS que os telemóveis gravam. A data em que a fotografia foi tirada
é lida *antes* disso e vai no texto do email, por isso guarda-se o que é útil e
deita-se fora o que exporia a casa do cliente. Verificado com uma imagem de
teste com GPS: sai sem qualquer bloco EXIF.

**O endereço de destino não aparece por extenso no código.** É montado em tempo
de execução a partir de duas partes, e a página traz `noindex` e um
`robots.txt`. Isto trava os robôs que recolhem emails para spam e mantém a
página fora dos motores de busca. Não é segredo — quem abrir a página vê o
endereço no rodapé — mas deixa de ser apanhável automaticamente.

**A página é aberta a quem tiver o endereço.** Não tem autenticação, por opção:
pôr logins nos telemóveis dos técnicos custaria mais do que protege. Quem
descobrir o URL consegue produzir um email com o formato certo — mas consegue
igualmente escrever um email à mão para a mesma caixa, por isso a app não
acrescenta poder nenhum a um atacante.

> **Importante para o futuro:** se algum dia se arquivar esta caixa
> automaticamente, **não confiar no assunto nem no nome dos ficheiros** para
> decidir o que é legítimo. Esses são falsificáveis por qualquer pessoa. O único
> sinal de confiança é o **remetente** do email, que deve ser validado contra
> uma lista de endereços conhecidos dos técnicos.

**Riscos residuais assumidos:**

- O nome do técnico é escrito à mão e não é verificado. Quem assina de facto é a
  conta de email que envia.
- O `localStorage` guarda o nome do técnico e os números de serviço que já
  levaram etiqueta. Num telemóvel partilhado, outra pessoa com acesso ao mesmo
  browser consegue lê-los.
- A página pode ser embebida noutro site (`frame-ancestors` só se define por
  cabeçalho HTTP, que o GitHub Pages não deixa configurar). Sem ações
  privilegiadas na página, o proveito para um atacante é nulo.

---

## Compatibilidade

A partilha de ficheiros funciona no Chrome do Android e no Safari do iPhone
(iOS 15+). Em telemóveis onde não exista, a página descarrega as fotografias já
comprimidas e abre o email com o destinatário e o assunto preenchidos, ficando
só a faltar anexá-las.
