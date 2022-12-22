<h1 align="center">PHP SDK for APIs Efí Pay</h1>

![Banner APIs Efí Pay](https://gnetbr.com/BJgSIUhlYs)

<p align="center">
  <a href="https://github.com/efipay/sdk-php-apis-efi">Portuguese</a> |
  <span><b>English</b></span>  
</p>

---

[![Latest Stable Version](http://poser.pugx.org/efipay/sdk-php-apis-efi/v)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![License](http://poser.pugx.org/efipay/sdk-php-apis-efi/license)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![Total Downloads](http://poser.pugx.org/efipay/sdk-php-apis-efi/downloads)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![Code Climate](https://codeclimate.com/github/efipay/sdk-php-apis-efi/badges/gpa.svg)](https://codeclimate.com/github/efipay/sdk-php-apis-efi)

SDK in PHP for integration with Efí APIs for emission Pix, bank slips, carnet, credit card, subscription, payment link, marketplance, Pix through Open Finance, among other features.
For more informations about [parameters](http://dev.sejaefi.com.br) and [values](http://sejaefi.com.br/tarifas) see our website.

Jump To:
* [Requirements](#requirements)
* [Teted with](#tested-with)
* [Installation](#installation)
* [Getting started](#getting-started)
  * [How to get Client_Id and Client_Secret credentials](#how-to-get-client-id-and-client-secret-credentials)
  * [How to generate Pix certificate](#how-to-generate-a-pix-certificate)
  * [How to register Pix keys](#how-to-register-pix-keys)
* [Running examples](#running-examples)
* [Version Guidance](#version-guidance)
* [Additional Documentation](#additional-documentation)
* [License](#license)

---

## **Requirements**
* PHP >= 7.2
* Guzzle >= 7.0

## **Tested with**
```
PHP 7.2, 7.3, 7.4, 8.0 and 8.1
```

## **Installation**
Clone this repository and execute the following command to install the dependencies
```
composer install
```

Or if you already have a project with composer, include the dependency in your `composer.json`:
```
...
"require": {
  "efipay/sdk-php-apis-efi": "^1"
},
...
```

Or download this package direct with [composer](https://getcomposer.org/):
```
composer require efipay/sdk-php-apis-efi
```

## **Getting started**

To begin, you must configure the parameters in the `/examples/credentials/options.php` file. Instantiate the information `client_id`, `client_secret` for authentication and `sandbox` equal to *true*, if your environment is Homologation, or *false*, if it is Production. If you use Pix charges, inform in the attribute `certificate` with the relative **absolute** directory and name of your certificate in `.p12` or `.pem`. format.

See configuration examples below:

### **For homologation environment**
Instantiate the module parameters using `client_id`, `client_secret`, `sandbox` equal to **true** and `certificate` with the name of the approval certificate:
```php
$options = [
	"client_id" => "Client_Id...",
	"client_secret" => "Client_Secret...",
	"certificate" => realpath(__DIR__ . "/homologation.p12"), // Absolute path to the certificate in .p12 or .pem format
	"sandbox" => true,
	"debug" => false,
	"timeout" => 30
];
```

### **For production environment**
Instantiate the module parameters using `client_id`, `client_secret`, `sandbox` equals *false* and `certificate` with the name of the production certificate:
```php
$options = [
	"client_id" => "Client_Id...",
	"client_secret" => "Client_Secret...",
	"certificate" => realpath(__DIR__ . "/production.p12"), // Absolute path to the certificate in .p12 or .pem format
	"sandbox" => false,
	"debug" => false,
	"timeout" => 30
];
```

Require the module and namespaces:
```php
require __DIR__ . '/vendor/autoload.php';

use Efi\Exception\EfiPayException;
use Efi\EfiPay;
```
Although the web services responses are in json format, the SDK will convert any server response to array. The code must be within a try-catch and exceptions can be handled as follow:
```php
try {
  /* call the desired function */
} catch(EfiPayException $e) {
  /* API errors will come here */
} catch(Exception $e) {
  /* Other errors will come here */
}
```

## **How to get Client-Id and Client-Secret credentials**

**Create a new application to use the Efí Pay API:** 
1. Access the Efí panel in the **API** menu.
2. In the side menu, click on **Aplicações** then on **Criar aplicação**.
3. Enter a name for the application, and select which API you want to activate: **API de emissões** (slips and booklets) and/or **API Pix** and/or Payments. In this case, API Pix; these can be changed later).
4. Select the Scopes of Production and Scopes of Homologation (Development) that you want to release;
5. Click **Criar aplicação**.
6. Enter your Electronic Signature to confirm the changes and update the application.

## **How to generate a Pix certificate**

All Pix requests must contain a security certificate that will be provided by Efí within your account, in PFX(.p12) format. This requirement is fully described in the [PIX security manual](https://www.bcb.gov.br/estabilidadefinanceira/comunicacaodados).

**To generate your certificate:**
1. Access the Efí panel in the **API** menu.
2. In the left corner, click on **Meus certificados** and choose the environment in which you want the certificate: **Produção** or **Homologação**.
3. Click **Criar certificado**.
4. Enter your Electronic Signature to confirm the change.

## **How to register Pix keys**
The registration of Pix keys can be done through the Efí mobille app, web digital account or through an API endpoint. Below you will find the steps on how to register them.

### **Register Pix key via web digital account:**

1. Access your [digital account](https://app.sejaefi.com.br/).
2. In the side menu, touch **Pix** to start your registration.
3. Click **Minhas Chaves** and then **Cadastrar Chave**.
4. You must choose at least 1 of the 4 available key options (CPF/CNPJ, cell phone, email or random key).
5. After registering the desired Pix keys, click **Continuar**.
6. Enter your Electronic Signature to confirm registration.

### **Register Pix key via API:**
The endpoint used to create a random Pix key (evp), is `POST /v2/gn/evp` ([Register evp key](https://dev.sejaefi.com.br/docs/api-pix-endpoints#section-criar-chave-evp)). A detail is that, through this endpoint, only random Pix keys are registered.

To consume it, just run the `/examples/exclusive/key/pixCreateEvp.php` example from our SDK. The request sent to this endpoint does not need a body.

The example response below represents Success (201), showing the registered Pix key.
```json
{
  "chave": "345e4568-e89b-12d3-a456-006655440001"
}
```


## **Running examples**
You can run it using any web server like apache or nginx and open any example in your browser.

:warning: Some examples require you to change some parameters to work, like `/examples/charges/billet/createOneStepBillet.php` or `/examples/pix/cob/pixCreateCharge.php`.


## **Version Guidance**

| Version | Status | Packagist | Repo | Version PHP |
| --- | --- | --- | --- | --- |
| 1.x | Discontinued | [/efipay/sdk-php-apis-efi#1.0.17](https://packagist.org/packages/efipay/sdk-php-apis-efi#1.0.17) | [v1](https://github.com/efipay/sdk-php-apis-efi/tree/1.x) | \>= 5.4 |
| 2.x | Discontinued | [/efipay/sdk-php-apis-efi#2.4.1](https://packagist.org/packages/efipay/sdk-php-apis-efi#2.4.1) | [v2](https://github.com/efipay/sdk-php-apis-efi/tree/2.x) | \>= 5.5 |
| 3.x | Discontinued | [/efipay/sdk-php-apis-efi#3.2.0](https://packagist.org/packages/efipay/sdk-php-apis-efi#3.2.0) | [v3](https://github.com/efipay/sdk-php-apis-efi/tree/3.x) | \>= 5.6 |
| 4.x | Maintained | [/efipay/sdk-php-apis-efi#4.1.1](https://packagist.org/packages/efipay/sdk-php-apis-efi#4.1.1) | [v4](https://github.com/efipay/sdk-php-apis-efi/tree/4.x) | \>= 7.2 |
| 5.x | Maintained | [/efipay/sdk-php-apis-efi](https://packagist.org/packages/efipay/sdk-php-apis-efi) | [v5](https://github.com/efipay/sdk-php-apis-efi) | \>= 7.2 |

## **Additional Documentation**

Complete documentation with all endpoints and API details is available at https://dev.sejaefi.com.br/.

If you don't have a Efí Bank digital account yet, [open yours now](https://sistema.sejaefi.com.br/)!

## **License**
[MIT](LICENSE)
