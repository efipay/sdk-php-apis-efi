<h1 align="center">PHP SDK for APIs Efí Pay</h1>

![Banner APIs Efí Pay](https://gnetbr.com/BJgSIUhlYs)

<p align="center">
  <a href="https://github.com/efipay/sdk-php-apis-efi">Portuguese</a> |
  <span><b>English</b></span>  
</p>

---

[![Latest Stable Version](https://img.shields.io/packagist/v/efipay/sdk-php-apis-efi.svg)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![Versão PHP necessária](https://img.shields.io/packagist/php-v/efipay/sdk-php-apis-efi.svg)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![Total Downloads](https://img.shields.io/packagist/dt/efipay/sdk-php-apis-efi.svg)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![Daily Downloads](https://img.shields.io/packagist/dd/efipay/sdk-php-apis-efi.svg)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![Code Climate](https://codeclimate.com/github/efipay/sdk-php-apis-efi/badges/gpa.svg)](https://codeclimate.com/github/efipay/sdk-php-apis-efi)
[![License](https://img.shields.io/packagist/l/efipay/sdk-php-apis-efi.svg)](https://packagist.org/packages/efipay/sdk-php-apis-efi)

SDK in PHP for integration with Efí APIs for Pix issuance, boletos (banking payment slips), payment slips, credit card, subscription, payment links, marketplace, Pix via Open Finance, payment of boletos, among other functionalities. For more [technical information](https://dev.efipay.com.br/) and [pricing](http://sejaefi.com.br/tarifas), please refer to our website.

Jump To:
- [**Requirements**](#requirements)
- [**Tested with**](#tested-with)
- [**Installation**](#installation)
- [**Getting started**](#getting-started)
- [**How to get Client-Id and Client-Secret credentials**](#how-to-get-client-id-and-client-secret-credentials)
- [**How to generate a Pix certificate**](#how-to-generate-a-pix-certificate)
- [**How to register Pix keys**](#how-to-register-pix-keys)
  - [**Register Pix key via web digital account:**](#register-pix-key-via-web-digital-account)
  - [**Register Pix key via API:**](#register-pix-key-via-api)
- [**Running examples**](#running-examples)
- [**Version Guidance**](#version-guidance)
- [**Supported frameworks**](#supported-frameworks)
- [**Additional Documentation**](#additional-documentation)
- [**Discord Community**](#discord-community)
- [**Migration Validator**](#migration-validator)
  - [How to use the Validator:](#how-to-use-the-validator)
- [**License**](#license)

---

## **Requirements**
* PHP >= 7.2.5
* Guzzle >= 7.0
* [openssl](https://www.php.net/manual/en/book.openssl.php) extension enabled

## **Tested with**
```
PHP 7.2, 7.3, 7.4, 8.0, 8.1, 8.2, 8.3, 8.4
```

## **Installation**
Clone this repository and run the command to install the dependencies:

```
git clone https://github.com/efipay/sdk-php-apis-efi.git
composer install
```

Or if you already have a project managed with [Composer](https://getcomposer.org/), include the dependency in your `composer.json` file:

```
...
"require": {
  "efipay/sdk-php-apis-efi": "^1"
},
...
```

Or download this package directly with [Composer](https://getcomposer.org/):

```
composer require efipay/sdk-php-apis-efi
```

## **Getting started**

To start, you should configure the credentials in the file `/examples/credentials/options.php`. Instantiate the `clientId` and `clientSecret` for authentication, and set `sandbox` to *true* if your environment is for testing (Homologação), or *false* if it's for production (Produção). With the exception of the Cobranças API (Boleto/Credit card), it is mandatory to inform in the `certificate` attribute the **absolute** path with the file name in `.p12` or `.pem` format.

Here's an example of the configuration in PHP:

```php
$options = [
    "clientId" => "Client_Id...",
    "clientSecret" => "Client_Secret...",
    "certificate" => realpath(__DIR__ . "/certificateFile.p12"), // Mandatory, with the exception of the Billing API | Absolute path to the certificate in .p12 or .pem format
    "pwdCertificate" => "", // Optional | Default = "" | Certificate encryption password
    "sandbox" => false, // Optional | Default = false | Defines the development environment as Production or Homologation
    "debug" => false, // Optional | Default = false | Enable/disable Guzzle request logs
    "timeout" => 30, // Optional | Default = 30 | Defines the maximum response time for requests
    "responseHeaders" => false, //  Optional | Default = false | Enables/disable returning the header requests
];
```

To initiate the SDK, you need to require the module and namespaces, and handle the API responses as follows:

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use Efi\Exception\EfiException;
use Efi\EfiPay;

try {
    $api = new EfiPay($options);
    /* Call the desired function */
} catch (EfiException $e) {
    /* API errors will come here */
    print_r($e->code . "<br>");
    print_r($e->error . "<br>");
    print_r($e->errorDescription . "<br>");
} catch (Exception $e) {
    /* Other errors will come here */
    print_r($e->getMessage());
}
?>
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
You can run it using any web server like Apache or nginx and open any example in your browser or command line. [See all examples here](https://github.com/efipay/sdk-php-apis-efi/tree/main/examples).

⚠️ Some examples may require you to modify certain parameters to work, such as `/examples/charges/billet/createOneStepBillet.php` or `/examples/pix/cob/pixCreateCharge.php`.


## **Version Guidance**

| Version | Status | Packagist | Repo | Version PHP |
| --- | --- | --- | --- | --- |
| 1.x | Maintained | [/efipay/sdk-php-apis-efi](https://packagist.org/packages/efipay/sdk-php-apis-efi) | [v1](https://github.com/efipay/sdk-php-apis-efi) | \>= 7.2 |

## **Supported frameworks**

| Framework     | Minimum Compatible Version | Notes                                        |
|---------------|--------------------------|-----------------------------------------------|
| Laravel       | 7.x and above             | PHP >= 7.2.5, Guzzle 7.0, Symfony/Cache >= 5.0 |
| CodeIgniter   | 4.x and above             | PHP >= 7.2.5 (Guzzle and Symfony/Cache, if used)|
| Symfony       | 5.0 and above             | PHP >= 7.2.5, Guzzle 7.0, Symfony/Cache >= 5.0 |

The SDK can also be integrated with other PHP frameworks. Make sure to meet the [**minimum requirements**](#requirements).


## **Additional Documentation**

The complete documentation containing all endpoints and API details is available at https://dev.efipay.com.br/.

If you don't have an Efí Bank digital account yet, [open yours now](https://app.sejaefi.com.br)!

## **Discord Community**

If you need to integrate your system or application with a comprehensive payment API, want to exchange experiences, and share your knowledge, connect to the [Efipay community on Discord](https://comunidade.sejaefi.com.br/).

## **Migration Validator**
If you're already integrated with the Gerencianet PHP SDK and are looking to prepare your application for future innovations in the Efí APIs, you can use our validator to assist in migrating to this SDK.

The Efí SDK Migration Validator makes the migration process smoother and more efficient. **This tool doesn't modify your code**, it simply analyzes the existing code for specific patterns related to classes and methods that have been changed in the new version of the SDK.

Before making any modifications to your application's code, it's highly advisable to create a complete backup of your entire project.

### How to use the Validator:
1. Download the [Migration Validator](https://raw.githubusercontent.com/efipay/sdk-php-apis-efi/master/migrationChecker.php).
2. Make sure to place this `migrationChecker.php` file in the root directory of your project.
3. Edit the `migrationChecker.php` file and make sure to correctly input the paths to the `composer.json` and `installed.json` files on lines *55* and *56*.
4. Run the *Migration Checker*, which will analyze your files for issues.
5. Review the presented results, identifying code snippets that need to be updated.
6. Make the recommended corrections following the displayed instructions.

The validator helps identify potential migration problems and provides suggestions for correction, but it's essential to remember that each application is unique and may have intricacies that cannot be automatically addressed. After making the suggested corrections, it's highly recommended to conduct extensive testing on your application to validate the proper functioning of the SDK.

![Validador de Migração](https://s3.amazonaws.com/gerencianet-pub-prod-1/printscreen/2023/08/23/guilherme.cota/0e29ad-%25guic.png)

## **License**
[MIT](LICENSE)
