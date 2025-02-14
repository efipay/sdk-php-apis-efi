<h1 align="center">SDK PHP para APIs Efí Pay</h1>

![Banner APIs Efí Pay](https://gnetbr.com/BJgSIUhlYs)

<p align="center">
  <span><b>Português</b></span> |
  <a href="https://github.com/efipay/sdk-php-apis-efi/blob/master/README-en.md">Inglês</a>
</p>

---

[![Última versão estável](https://img.shields.io/packagist/v/efipay/sdk-php-apis-efi.svg)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![Versão PHP necessária](https://img.shields.io/packagist/php-v/efipay/sdk-php-apis-efi.svg)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![Total de downloads](https://img.shields.io/packagist/dt/efipay/sdk-php-apis-efi.svg)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![Downloads diários](https://img.shields.io/packagist/dd/efipay/sdk-php-apis-efi.svg)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![Code Climate](https://codeclimate.com/github/efipay/sdk-php-apis-efi/badges/gpa.svg)](https://codeclimate.com/github/efipay/sdk-php-apis-efi)
[![Licença](https://img.shields.io/packagist/l/efipay/sdk-php-apis-efi.svg)](https://packagist.org/packages/efipay/sdk-php-apis-efi)

SDK em PHP para integração com as APIs Efí para emissão de Pix, boletos, carnês, cartão de crédito, assinatura, link de pagamento, marketplance, Pix via Open Finance, pagamento de boletos, dentre outras funcionalidades.
Para mais [informações técnicas](https://dev.efipay.com.br/) e [valores/tarifas](http://sejaefi.com.br/tarifas), consulte nosso site.

Ir para:
- [**Requisitos**](#requisitos)
- [**Testado com**](#testado-com)
- [**Instalação**](#instalação)
- [**Começando**](#começando)
- [**Como obter as credenciais Client-Id e Client-Secret**](#como-obter-as-credenciais-client-id-e-client-secret)
	- [**Crie uma nova aplicação para usar as APIs Efí Pay:**](#crie-uma-nova-aplicação-para-usar-as-apis-efí-pay)
- [**Como gerar um certificado Pix**](#como-gerar-um-certificado-pix)
- [**Como cadastrar as chaves Pix**](#como-cadastrar-as-chaves-pix)
	- [**Cadastrar chave Pix pela conta digital web:**](#cadastrar-chave-pix-pela-conta-digital-web)
	- [**Cadastrar chave Pix através da API:**](#cadastrar-chave-pix-através-da-api)
- [**Executar exemplos**](#executar-exemplos)
- [**Guia de versão**](#guia-de-versão)
- [**Frameworks compatíveis**](#frameworks-compatíveis)
- [**Documentação Adicional**](#documentação-adicional)
- [**Comunidade no Discord**](#comunidade-no-discord)
- [**Validador de Migração**](#validador-de-migração)
	- [Como usar o Validador:](#como-usar-o-validador)
- [**Licença**](#licença)

---

## **Requisitos**
* PHP >= 7.2.5
* Guzzle >= 7.0
* Extensão [openssl](https://www.php.net/manual/en/book.openssl.php) habilitada

## **Testado com**
```
PHP 7.2, 7.3, 7.4, 8.0, 8.1, 8.2, 8.3, 8.4
```

## **Instalação**
Clone este repositório e execute o comando para instalar as dependências
```
git clone https://github.com/efipay/sdk-php-apis-efi.git
composer install
```

Ou se você já tem um projeto gerenciado com [Composer](https://getcomposer.org/), inclua a dependência em seu arquivo `composer.json`:
```
...
"require": {
  "efipay/sdk-php-apis-efi": "^1"
},
...
```

Ou baixe este pacote direto com [Composer](https://getcomposer.org/):
```
composer require efipay/sdk-php-apis-efi
```

## **Começando**

Para começar, você deve configurar as credenciais no arquivo `/examples/credentials/options.php`. Instancie as informações `clientId`, `clientSecret` para autenticação e `sandbox` igual a *true*, se seu ambiente for Homologação, ou *false*, se for Produção. Com exceção da API Cobranças (Boleto/Carnê/Cartão de crédito), é obrigatório informar no atributo `certificate` o caminho **absoluto** com o nome do arquivo no formato `.p12` ou `.pem`.

Veja um exemplo de configuração:
```php
$options = [
	"clientId" => "Client_Id...",
	"clientSecret" => "Client_Secret...",
	"certificate" => realpath(__DIR__ . "/arquivoCertificado.p12"), // Obrigatório, com exceção da API Cobranças  | Caminho absoluto para o certificado no formato .p12 ou .pem
	"pwdCertificate" => "", // Opcional | Padrão = "" | Senha de criptografia do certificado
	"sandbox" => false, // Opcional | Padrão = false | Define o ambiente de desenvolvimento entre Produção e Homologação
	"debug" => false, // Opcional | Padrão = false | Ativa/desativa os logs de requisições do Guzzle
	"timeout" => 30, // Opcional | Padrão = 30 | Define o tempo máximo de resposta das requisições
	"responseHeaders" => false, //  Optional | Default = false || Ativa/desativa o retorno do header das requisições
];
```

Para iniciar a SDK, requer o módulo e os namespaces:
```php
require __DIR__ . '/vendor/autoload.php';

use Efi\Exception\EfiException;
use Efi\EfiPay;
```

Embora as respostas dos serviços da web estejam no formato json, a SDK converterá a resposta da API em array. O código deve estar dentro de um try-catch, e podem ser tratadas da seguinte forma:

```php
try {
	$api = new EfiPay($options);
	/* chamada da função desejada */
} catch(EfiException $e) {
	/* Os erros da API virão aqui */
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription . "<br>");
} catch(Exception $e) {
	/* Outros erros virão aqui */
	print_r($e->getMessage());
}
```

## **Como obter as credenciais Client-Id e Client-Secret**

### **Crie uma nova aplicação para usar as APIs Efí Pay:**
1. Acesse o painel da conta digital Efí no menu **API**.
2. No menu lateral, clique em **Aplicações** depois em **Criar aplicação**.
3. Insira um nome para a aplicação, e selecione qual API quer ativar: **API de emissões** (boletos e carnês) e/ou **API Pix** e/ou Pagamentos. Neste caso, API Pix;que estes podem ser alterados posteriormente).
4. selecione os Escopos de Produção e Escopos de Homologação (Desenvolvimento) que deseja liberar;
5. Clique em **Criar aplicação**.
6. Informe a sua Assinatura Eletrônica para confirmar as alterações e atualizar a aplicação.

## **Como gerar um certificado Pix**

Todas as requisições do Pix devem conter um certificado de segurança que será fornecido pela Efí dentro da sua conta, no formato PFX(.p12). Essa exigência está descrita na íntegra no [manual de segurança do PIX](https://www.bcb.gov.br/estabilidadefinanceira/comunicacaodados).

**Para gerar seu certificado:** 
1. Acesse o painel da conta digital Efí no menu **API**.
2. No menu lateral, clique em **Meus Certificados** e escolha o ambiente em que deseja o certificado: **Produção** ou **Homologação**.
3. Clique em **Criar Certificado**.
4. Insira sua Assinatura Eletrônica para confirmar a alteração.

## **Como cadastrar as chaves Pix**
O cadastro das chaves Pix pode ser feito através do aplicativo mobille da Efí, conta digital web ou por um endpoint da API. A seguir você encontra os passos de como registrá-las.

### **Cadastrar chave Pix pela conta digital web:**

1. Acesse sua [conta digital](https://app.sejaefi.com.br/).
2. No menu lateral, clique em **Pix**.
3. Clique em **Minhas Chaves** e, depois clique no botão **Cadastrar Chave**.
4. Você deve escolher pelo menos 1 das 4 opções de chaves disponíveis (CPF/CNPJ, E-mail, Celular ou Chave aleatória).
5. Após cadastrar as chaves do Pix desejadas, clique em **Continuar**.
6. Insira sua Assinatura Eletrônica para confirmar o cadastro.

### **Cadastrar chave Pix através da API:**
O endpoint utilizado para criar uma chave Pix aleatória (evp), é o `POST /v2/gn/evp` ([Criar chave evp](https://dev.efipay.com.br/docs/api-pix/endpoints-exclusivos-efi#criar-chave-evp)). Um detalhe é que, através deste endpoint é realizado o registro somente de chaves Pix do tipo aleatória.

Para consumí-lo, basta executar o exemplo  `/examples/exclusive/key/pixCreateEvp.php` da nossa SDK. A requisição enviada para esse endpoint não precisa de um body. 

A resposta de exemplo abaixo representa Sucesso (201), apresentando a chave Pix registrada.
```json
{
  "chave": "345e4568-e89b-12d3-a456-006655440001"
}
```

## **Executar exemplos**
Você pode executar usando qualquer servidor web, como Apache ou nginx, e abrir qualquer exemplo em seu navegador ou linha de comando. Veja [todos os exemplo aqui](https://github.com/efipay/sdk-php-apis-efi/tree/main/examples).

⚠️ Alguns exemplos requerem que você altere alguns parâmetros para funcionar, como `/examples/charges/billet/createOneStepBillet.php` ou `/examples/pix/cob/pixCreateCharge.php`.


## **Guia de versão**

| Versão | Status | Packagist | Repo | Versão PHP |
| --- | --- | --- | --- | --- |
| 1.x | Mantido | [/efipay/sdk-php-apis-efi](https://packagist.org/packages/efipay/sdk-php-apis-efi) | [v1](https://github.com/efipay/sdk-php-apis-efi) | \>= 7.2.5 |

## **Frameworks compatíveis**

| Framework     | Versão Mínima Compatível | Observações                                    |
|---------------|--------------------------|-----------------------------------------------|
| Laravel       | 7.x e superior           | PHP >= 7.2.5, Guzzle 7.0, Symfony/Cache >= 5.0 |
| CodeIgniter   | 4.x e superior           | PHP >= 7.2.5 (Guzzle e Symfony/Cache, se usado)|
| Symfony       | 5.0 e superior           | PHP >= 7.2.5, Guzzle 7.0, Symfony/Cache >= 5.0 |

A SDK pode ser integrada também com outros frameworks PHP. Certifique-se de atender aos [**requisitos mínimos**](#requisitos).

## **Documentação Adicional**

A documentação completa com todos os endpoints e detalhes das APIs está disponível em https://dev.efipay.com.br/.

Se você ainda não tem uma conta digital Efí Bank, [abra a sua agora](https://sejaefi.com.br)!

## **Comunidade no Discord**

<a href="https://comunidade.sejaefi.com.br/"><img src="https://efipay.github.io/comunidade-discord-efi/assets/img/thumb-repository.png"></a>

Se você tem a necessidade de integrar seu sistema ou aplicação a uma API completa de pagamentos, desejos de trocar experiências e compartilhar seu conhecimento, conecte-se à [comunidade da Efí no Discord](https://comunidade.sejaefi.com.br/).

## **Validador de Migração**
Se você já possui integração com a SDK de PHP da Gerencianet e está buscando preparar a sua aplicação para as inovações futuras das APIs Efí, você pode usar o nosso validador para auxiliar na migração para esta SDK.

O Validador de Migração da SDK Efí torna o processo de migração mais suave e eficiente. **Essa ferramenta não modifica o seu código**, apenas analisa o código existente em busca de padrões específicos relacionados a classes e métodos que foram modificados na nova versão da SDK.

Antes de realizar qualquer modificação no código da sua aplicação, é altamente aconselhável fazer um backup completo de todo o seu projeto.

### Como usar o Validador:
1. Faça o download do [Validador de Migração](https://raw.githubusercontent.com/efipay/sdk-php-apis-efi/master/migrationChecker.php).
2. Certifique-se de inserir este arquivo `migrationChecker.php` no diretório raiz do seu projeto.
3. Altere o arquivo `migrationChecker.php` e certifique-se de inserir corretamente na linha *55* e *56* o caminho para os arquivos `composer.json` e `installed.json`.
4. Execute o *Verificador de Migração*, que analisará seus arquivos em busca de problemas.
5. Revise os resultados apresentados, identificando os trechos de código que precisam ser atualizados.
6. Realize as correções recomendadas, seguindo as instruções exibidas.

O verificador ajuda a identificar potenciais problemas de migração e oferece sugestões de correção, mas é essencial lembrar que cada aplicação é única e pode ter peculiaridades que não podem ser abordadas automaticamente. Após realizar as correções sugeridas, é altamente recomendado realizar testes extensivos em sua aplicação para validar o funcionamento adequado da SDK.

![Validador de Migração](https://s3.amazonaws.com/gerencianet-pub-prod-1/printscreen/2023/08/23/guilherme.cota/0e29ad-%25guic.png)

## **Licença**
[MIT](LICENSE)
