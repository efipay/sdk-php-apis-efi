<h1 align="center">SDK PHP para APIs Efí Pay</h1>

![Banner APIs Efí Pay](https://gnetbr.com/BJgSIUhlYs)

<p align="center">
  <span><b>Português</b></span> |
  <a href="https://github.com/efipay/sdk-php-apis-efi/blob/master/README-en.md">Inglês</a>
</p>

---

[![Última versão estável](http://poser.pugx.org/efipay/sdk-php-apis-efi/v)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![Licença](http://poser.pugx.org/efipay/sdk-php-apis-efi/license)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![Total de downloads](http://poser.pugx.org/efipay/sdk-php-apis-efi/downloads)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![Code Climate](https://codeclimate.com/github/efipay/sdk-php-apis-efi/badges/gpa.svg)](https://codeclimate.com/github/efipay/sdk-php-apis-efi)

SDK em PHP para integração com as APIs Efí para emissão de Pix, boletos, carnês, cartão de crédito, assinatura, link de pagamento, marketplance, Pix via Open Finance, pagamento de boletos, dentre outras funcionalidades.
Para mais informações sobre [parâmetros](http://sejaefi.com.br/api) e [valores/tarifas](http://sejaefi.com.br/tarifas) consulte nosso site.

Ir para:
* [Requisitos](#requisitos)
* [Testado com](#testado-com)
* [Instalação](#instalação)
* [Começando](#começando)
  * [Como obter as credenciais Client_Id e Client_Secret](#como-obter-as-credenciais-client-id-e-client-secret)
  * [Como gerar certificado Pix](#como-gerar-um-certificado-pix)
  * [Como cadastrar chave Pix](#como-cadastrar-as-chaves-pix)
* [Executar exemplos](#executar-exemplos)
* [Guia de versão](#guia-de-versão)
* [Documentação Adicional](#documentação-adicional)
* [Licença](#licença)

---

## **Requisitos**
* PHP >= 7.2
* Guzzle >= 7.0

## **Testado com**
```
PHP 7.2, 7.3, 7.4, 8.0 e 8.1
```

## **Instalação**
Clone este repositório e execute o seguinte comando para instalar as dependências
```
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

Para começar, você deve configurar as credenciais no arquivo `/examples/credentials/options.php`. Instancie as informações `client_id`, `client_secret` para autenticação e `sandbox` igual a *true*, se seu ambiente for Homologação, ou *false*, se for Produção. Se você usa cobrança Pix, informe no atributo `certificate` o diretório **absoluto** e o nome do seu certificado no formato `.p12` ou `.pem`.

Veja exemplos de configuração a seguir:

### **Para ambiente de homologação**
Instancie os parâmetros do módulo usando `client_id`, `client_secret`, `sandbox` igual a **true** e `certificate` com o nome do certificado de homologação:
```php
$options = [
	"client_id" => "Client_Id...",
	"client_secret" => "Client_Secret...",
	"certificate" => realpath(__DIR__ . "/homologacao.p12"), // Caminho absoluto para o certificado no formato .p12 ou .pem
	"sandbox" => true,
	"debug" => false,
	"timeout" => 30
];
```

### **Para ambiente de produção**
Instancie os parâmetros do módulo usando `client_id`, `client_secret`, `sandbox` igual a *false* e `certificate` com o nome do certificado de produção:
```php
$options = [
	"client_id" => "Client_Id...",
	"client_secret" => "Client_Secret...",
	"certificate" => realpath(__DIR__ . "/producao.p12"), // Caminho absoluto para o certificado no formato .p12 ou .pem
	"sandbox" => false,
	"debug" => false,
	"timeout" => 30
];
```

Para iniciar a SDK, requer o módulo e os namespaces:
```php
require __DIR__ . '/vendor/autoload.php';

use Efi\Exception\EfiPayException;
use Efi\EfiPay;
```

Embora as respostas dos serviços da web estejam no formato json, a SDK converterá qualquer resposta do servidor em array. O código deve estar dentro de um try-catch, e podem ser tratadas da seguinte forma:

```php
try {
  /* chamada da função desejada */
} catch(EfiPayException $e) {
  /* Os erros da API virão aqui */
} catch(Exception $e) {
  /* Outros erros virão aqui */
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
3. Clique em **Minhas Chaves** e depois clique no botão **Cadastrar Chave**.
4. Você deve escolher pelo menos 1 das 4 opções de chaves disponíveis (CPF/CNPJ, E-mail, Celular ou Chave aleatória).
5. Após cadastrar as chaves do Pix desejadas, clique em **Continuar**.
6. Insira sua Assinatura Eletrônica para confirmar o cadastro.

### **Cadastrar chave Pix através da API:**
O endpoint utilizado para criar uma chave Pix aleatória (evp), é o `POST /v2/gn/evp` ([Criar chave evp](https://dev.sejaefi.com.br/docs/api-pix-endpoints#section-criar-chave-evp)). Um detalhe é que, através deste endpoint é realizado o registro somente de chaves Pix do tipo aleatória.

Para consumí-lo, basta executar o exemplo  `/examples/exclusive/key/pixCreateEvp.php` da nossa SDK. A requisição enviada para esse endpoint não precisa de um body. 

A resposta de exemplo abaixo representa Sucesso (201), apresentando a chave Pix registrada.
```json
{
  "chave": "345e4568-e89b-12d3-a456-006655440001"
}
```

## **Executar exemplos**
Você pode executar usando qualquer servidor web, como Apache ou nginx e abrir qualquer exemplo em seu navegador.

:warning: Alguns exemplos requerem que você altere alguns parâmetros para funcionar, como `/examples/charges/billet/createOneStepBillet.php` ou `/examples/pix/cob/pixCreateCharge.php`.


## **Guia de versão**

| Versão | Status | Packagist | Repo | Versão PHP |
| --- | --- | --- | --- | --- |
| 1.x | Mantido | [/efipay/sdk-php-apis-efi](https://packagist.org/packages/efipay/sdk-php-apis-efi) | [v1](https://github.com/efipay/sdk-php-apis-efi) | \>= 7.2 |

## **Documentação Adicional**

A documentação completa com todos os endpoints e detalhes das APIs está disponível em https://dev.sejaefi.com.br/.

Se você ainda não tem uma conta digital Efí Bank, [abra a sua agora](https://app.sejaefi.com.br)!

## **Licença**
[MIT](LICENSE)
