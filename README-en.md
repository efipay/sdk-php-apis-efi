<h1 align="center">PHP SDK for Efí Bank APIs</h1>

![Efí Bank APIs Banner](https://gnetbr.com/BJgSIUhlYs)

<p align="center">
  <span><b>Portuguese</b></span> |
  <a href="https://github.com/efipay/sdk-php-apis-efi/blob/master/README-en.md">English</a>
</p>

---

[![Latest Stable Version](https://img.shields.io/packagist/v/efipay/sdk-php-apis-efi.svg)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![Required PHP Version](https://img.shields.io/packagist/php-v/efipay/sdk-php-apis-efi.svg)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![Total Downloads](https://img.shields.io/packagist/dt/efipay/sdk-php-apis-efi.svg)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![Daily Downloads](https://img.shields.io/packagist/dd/efipay/sdk-php-apis-efi.svg)](https://packagist.org/packages/efipay/sdk-php-apis-efi)
[![Code Climate](https://codeclimate.com/github/efipay/sdk-php-apis-efi/badges/gpa.svg)](https://codeclimate.com/github/efipay/sdk-php-apis-efi)
[![License](https://img.shields.io/packagist/l/efipay/sdk-php-apis-efi.svg)](https://packagist.org/packages/efipay/sdk-php-apis-efi)

PHP SDK for integrating with Efí APIs to issue Pix, boletos, carnês, credit cards, subscriptions, payment links, marketplaces, Pix via Open Finance, boleto payments, and other functionalities.
For more [technical information](https://dev.efipay.com.br/) and [pricing/fees](http://sejaefi.com.br/tarifas), visit our website.

Go to:
- [**Requirements**](#requirements)
- [**Tested With**](#tested-with)
- [**Version Guide**](#version-guide)
- [**Installation**](#installation)
- [**Getting Started**](#getting-started)
- [**Running Examples**](#running-examples)
- [**How to Get Client-Id and Client-Secret Credentials**](#how-to-get-client-id-and-client-secret-credentials)
	- [**Create a New Application to Use Efí Pay APIs:**](#create-a-new-application-to-use-efí-pay-apis)
- [**How to Generate a Pix Certificate**](#how-to-generate-a-pix-certificate)
- [**How to Register Pix Keys**](#how-to-register-pix-keys)
	- [**Register Pix Key via Web Account:**](#register-pix-key-via-web-account)
	- [**Register Pix Key via API:**](#register-pix-key-via-api)
- [**Compatible Frameworks**](#compatible-frameworks)
- [**Additional Documentation**](#additional-documentation)
- [**Discord Community**](#discord-community)
- [**Migration Validator**](#migration-validator)
	- [How to Use the Validator:](#how-to-use-the-validator)
- [**License**](#license)

---

## **Requirements**
* PHP >= 7.2.5
* Guzzle >= 7.0
* [openssl](https://www.php.net/manual/en/book.openssl.php) extension enabled in PHP

## **Tested With**
```
PHP 7.2, 7.3, 7.4, 8.0, 8.1, 8.2, 8.3, 8.4
```

## **Version Guide**

| Version | Status | Packagist | Repo | PHP Version |
| --- | --- | --- | --- | --- |
| 1.x | Maintained | [/efipay/sdk-php-apis-efi](https://packagist.org/packages/efipay/sdk-php-apis-efi) | [v1](https://github.com/efipay/sdk-php-apis-efi) | \>= 7.2.5 |

## **Installation**
Clone this repository and run the command to install dependencies
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

## **Getting Started**

To get started, you must configure the credentials in the `/examples/credentials/options.php` file. Instantiate the `clientId`, `clientSecret` for authentication, and `sandbox` as *true* if your environment is Sandbox, or *false* if it's Production. Except for the Charges API (Boleto/Carnê/Credit Card), it is mandatory to provide the `certificate` attribute with the **absolute** path to the file in `.p12` or `.pem` format. In the section below, you can follow [how to obtain the credentials and certificate](#how-to-get-client-id-and-client-secret-credentials).

See an example of credential configuration in the SDK:
```php
$options = [
	"clientId" => "Client_Id...",
	"clientSecret" => "Client_Secret...",
	"certificate" => realpath(__DIR__ . "/certificateFile.p12"), // Mandatory, except for the Charges API | Absolute path to the certificate in .p12 or .pem format
	"pwdCertificate" => "", // Optional | Default = "" | Certificate encryption password
	"sandbox" => false, // Optional | Default = false | Sets the development environment between Production and Sandbox
	"debug" => false, // Optional | Default = false | Enables/disables Guzzle request logs
	"timeout" => 30, // Optional | Default = 30 | Sets the maximum response time for requests
	"responseHeaders" => false, //  Optional | Default = false || Enables/disables the return of request headers
];
```

To start the SDK, require the module and namespaces:
```php
require __DIR__ . '/vendor/autoload.php';

use Efi\Exception\EfiException;
use Efi\EfiPay;
```

Although the responses from the API services are in JSON format, the SDK will convert the API response into an array. The code should be inside a try-catch block and handled as follows:

```php
try {
	$api = new EfiPay($options);
	/* call the desired function */
} catch(EfiException $e) {
	/* API errors will come here */
	print_r($e->code . "<br>");
	print_r($e->error . "<br>");
	print_r($e->errorDescription . "<br>");
} catch(Exception $e) {
	/* Other errors will come here */
	print_r($e->getMessage());
}
```

## **Running Examples**
You can run using any web server, such as Apache or nginx, and open any example in your browser or command line. See [all examples here](https://github.com/efipay/sdk-php-apis-efi/tree/main/examples).

⚠️ Some examples require you to change some parameters to work, such as `/examples/charges/billet/createOneStepBillet.php` or `/examples/pix/cob/pixCreateCharge.php`.

## **How to Get Client-Id and Client-Secret Credentials**

### **Create a New Application to Use Efí Bank APIs:**
1. Access the Efí digital account dashboard in the **API** menu.
2. In the side menu, click on **Applications** and then **Create Application**.
3. Enter a name for the application and select which APIs you want to activate:  
   - **Charges API** (boletos, carnês, credit cards, payment links, subscriptions);  
   - **Pix API**;  
   - **Pix via Open Finance API**;  
   - **Bill Payment API**;  
   - **Statements API**.  
4. Select the Production and Sandbox scopes you want to enable.
5. Click on **Create Application**.
6. Enter your Electronic Signature to confirm the application creation.

## **How to Generate an API Authentication Certificate**

All API requests, **except for the Charges API**, must include a security certificate provided by Efí in your account, in PFX (.p12) format.

### **To Generate Your Certificate:**  
1. Access the Efí digital account dashboard in the **API** menu.
2. In the side menu, click on **My Certificates** and choose the desired environment: **Production** or **Sandbox**.
3. Click on **Create Certificate**.
4. Enter your Electronic Signature or authenticate with the QR Code to confirm the creation.

## **How to Register Pix Keys**
Pix key registration can be done via the Efí mobile app, web account, or an API endpoint. Below are the steps to register them.

### **Register Pix Key via Web Account:**
1. Access your [digital account](https://app.sejaefi.com.br/).
2. In the side menu, click on **Pix**.
3. Select **My Keys** and then click on the **Register Key** button.
4. Choose at least one of the 4 available key options:  
   - CPF/CNPJ  
   - Email  
   - Phone  
   - Random Key  
5. After registering the desired Pix keys, click on **Continue**.
6. Enter your Electronic Signature to confirm the registration.

### **Register Pix Key via API:**
The endpoint used to create a random Pix key (EVP) is `POST /v2/gn/evp` ([Create EVP Key](https://dev.efipay.com.br/docs/api-pix/endpoints-exclusivos-efi#create-evp-key)). It's worth noting that this endpoint can only register random Pix keys.

To consume it, simply run the `/examples/exclusive/key/pixCreateEvp.php` example from our SDK. The request sent to this endpoint does not require a body.

The response below represents a success example (201), with the Pix key registered:
```json
{
  "key": "345e4568-e89b-12d3-a456-006655440001"
}
```

## **Compatible Frameworks**

| Framework     | Minimum Compatible Version | Notes                                    |
|---------------|--------------------------|-----------------------------------------------|
| Laravel       | 7.x and higher           | PHP >= 7.2.5, Guzzle 7.0, Symfony/Cache >= 5.0 |
| CodeIgniter   | 4.x and higher           | PHP >= 7.2.5 (Guzzle and Symfony/Cache, if used)|
| Symfony       | 5.0 and higher           | PHP >= 7.2.5, Guzzle 7.0, Symfony/Cache >= 5.0 |

The SDK can also be integrated with other PHP frameworks. Ensure you meet the [**minimum requirements**](#requirements).

## **Additional Documentation**

The complete documentation with all endpoints and API details is available at https://dev.efipay.com.br/.

If you don't have an Efí Bank digital account yet, [open yours now](https://sejaefi.com.br)!

## **Discord Community**

<a href="https://comunidade.sejaefi.com.br/"><img src="https://efipay.github.io/comunidade-discord-efi/assets/img/thumb-repository.png"></a>

If you need to integrate your system or application with a complete payment API, want to exchange experiences, and share your knowledge, connect to the [Efí community on Discord](https://comunidade.sejaefi.com.br/).

## **Migration Validator**
If you already have an integration with the Gerencianet PHP SDK and are looking to prepare your application for the future innovations of Efí APIs, you can use our validator to assist in migrating to this SDK.

The Efí SDK Migration Validator makes the migration process smoother and more efficient. **This tool does not modify your code**, it only analyzes the existing code for specific patterns related to classes and methods that have been modified in the new SDK version.

Before making any changes to your application's code, it is highly advisable to make a full backup of your entire project.

### How to Use the Validator:
1. Download the [Migration Validator](https://raw.githubusercontent.com/efipay/sdk-php-apis-efi/master/migrationChecker.php).
2. Make sure to place this `migrationChecker.php` file in the root directory of your project.
3. Modify the `migrationChecker.php` file and ensure you correctly insert the paths to the `composer.json` and `installed.json` files on lines *55* and *56*.
4. Run the *Migration Checker*, which will analyze your files for issues.
5. Review the results presented, identifying the code segments that need updating.
6. Make the recommended corrections, following the displayed instructions.

The checker helps identify potential migration issues and offers correction suggestions, but it's essential to remember that each application is unique and may have peculiarities that cannot be automatically addressed. After making the suggested corrections, it is highly recommended to perform extensive testing on your application to validate the proper functioning of the SDK.

![Migration Validator](https://s3.amazonaws.com/gerencianet-pub-prod-1/printscreen/2023/08/23/guilherme.cota/0e29ad-%25guic.png)

## **License**
[MIT](LICENSE)