Changelog
=========

[Release 1.13.0](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.13.0) (2025-04-25)
-------------------------- 
* Added endpoint and example to get receipts of Pix transactions
* Refactored: Fallback to temp dir if cache dir creation fails

[Release 1.12.2](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.12.2) (2025-02-19)
-------------------------- 
* Fixed: getErrorTitle function to always return string in PixException

[Release 1.12.1](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.12.1) (2025-02-18)
-------------------------- 
* Fixed: Deprecation warning when setting array|null with PHP version >= 8.1

[Release 1.12.0](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.12.0) (2025-02-14)
-------------------------- 
* Build: "symfony/cache" dependency removed
* Added class to write and retrieve authentication in cache

[Release 1.11.3](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.11.3) (2025-02-06)
-------------------------- 
* Fixed: Validation in decrypt function

[Release 1.11.2](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.11.2) (2025-02-06)
-------------------------- 
* Fixed: Ensure the cache is always an array

[Release 1.11.1](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.11.1) (2025-01-31)
-------------------------- 
* Fixed: variable names in the Pix example with due date.

[Release 1.11.0](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.11.0) (2025-01-15)
-------------------------- 
* Added Statements API endpoints and examples
* Added endpoint and example to resend Pix webhook

[Release 1.10.1](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.10.1) (2024-12-17)
-------------------------- 
* Pix sending route updated to v3

[Release 1.10.0](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.10.0) (2024-12-05)
-------------------------- 
* Added new endpoints and examples for Pix via Open Finance
* Refactored: Options method to simplify and optimize.

[Release 1.9.3](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.9.3) (2024-09-25)
-------------------------- 
* Fixed: 'Content-Type' check and add header validation
* New exceptions validation about Charges API
* Refactored: Authentication and access token handling
* Refactored: Query params generation function
* Refactored: Return type declarations for methods.

[Release 1.9.2](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.9.2) (2024-09-25)
-------------------------- 
* Added a new endpoints and examples to list charges
* Fixed: Header parameter type 'x-skip-mtls-checking' always string

[Release 1.9.1](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.9.1) (2024-08-20)
-------------------------- 
* Fixed: header parameter type 'x-skip-mtls-checking' always string
* Fixed: Access token not found in cache

[Release 1.9.0](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.9.0) (2024-07-19)
-------------------------- 
* Added new endpoints and examples:
    - Payment API webhook
    - Pix API MED
    - Pix API QR Code payment
    - Card payment refund
* Added feature to obtain response header of requests

[Release 1.8.0](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.8.0) (2024-02-22)
-------------------------- 
* Added a new endpoint and example to update subscriptions

[Release 1.7.1](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.7.1) (2024-01-16)
-------------------------- 
* Fixed compatibility with PHP 7.x

[Release 1.7.0](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.7.0) (2024-01-10)
-------------------------- 
* Added new endpoints and examples for managing batches of due charges
* Refactored: Improved endpoint file organization

[Release 1.6.4](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.6.4) (2023-12-27)
--------------------------
* Refactored: Improved endpoint file loading
* Refactored: Improved options file loading

[Release 1.6.3](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.6.3) (2023-12-27)
--------------------------
* Certificate environment validation
* Refactored: Improved code optimization and organization

[Release 1.6.2](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.6.2) (2023-12-22)
--------------------------
* Refactored: Authentication verification improvements

[Release 1.6.1](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.6.1) (2023-11-28)
--------------------------
* Fixed compatibility with PHP versions >=7.2

[Release 1.6.0](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.6.0) (2023-11-22)
--------------------------
* Added a new endpoint and example to change expire date for installments of a carnet
* Refactored: Removal singleton pattern in class Endpoints

[Release 1.5.2](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.5.2) (2023-11-15)
--------------------------
* Refactored: access token security encryption in cache
* Checking the OpenSSL extension is enabled

[Release 1.5.1](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.5.1) (2023-11-14)
--------------------------
* Added access token security encryption in cache

[Release 1.5.0](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.5.0) (2023-11-10)
--------------------------
* Added Flexibility of the EfiPay class instance to use both "new EfiPay($options)" and "EfiPay::getInstance($options)"

[Release 1.4.0](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.4.0) (2023-10-27)
--------------------------
* Added a new endpoint and example to retry card payment
* Fixed validation of configuration parameters
* Fixed exception validation

[Release 1.3.1](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.3.1) (2023-10-12)
--------------------------
* Updated link to technical documentation for examples
* Added a new endpoint and example to cancel a scheduled Pix payment via Open Finance

[Release 1.3.0](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.3.0) (2023-10-12)
--------------------------
* Added option to enter the certificate password through the "pwdCertificate" parameter
* Added option to enable/disable cache to reuse authentication through the "cache" parameter
* Parameters "client_id" and "client_secret" changed following the camel case convention, that is, "clientId" and "clientSecret", but the old names are accepted
* Support symfony/cache v6

[Release 1.2.3](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.2.3) (2023-10-08)
--------------------------
* Fixed the use of cache attributes
* Refactor: Improved code optimization and organization

[Release 1.2.2](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.2.2) (2023-09-21)
--------------------------
* Fixed PHP [Release and dependency compatibility
* Added efí to the request header

[Release 1.2.1](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.2.1) (2023-09-21)
--------------------------
* Updated method "getAccountCertificate()" renamed to "createAccountCertificate()"
* Updated the endpoint method "/v1/conta-simplificação/:idContaSimplificação/certificate" from "GET" to "POST"

[Release 1.2.0](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.2.0) (2023-09-20)
--------------------------
* Added a new endpoint and example to query a Pix send by its Id

[Release 1.1.3](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.1.3) (2023-08-26)
--------------------------
* Refactor: Improved code optimization and organization
* Update .codeclimate.yml

[Release 1.1.2](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.1.2) (2023-08-24)
--------------------------
* Refactor: Improved code optimization and organization

[Release 1.1.1](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.1.1) (2023-08-04)
--------------------------
* Updated API base routes
* Code refactored for optimization and security
* Compatibility with PHP >= 7.2

[Release 1.1.0](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.1.0) (2023-05-18)
--------------------------
* Refactored code
* Added functionality that reuses the auth access token

[Release 1.0.1](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.0.1) (2023-02-14)
--------------------------
* Added new examples of Pix split

[Release 1.0.0](https://github.com/efipay/sdk-php-apis-efi/releases/tag/1.0.0) (2023-01-31)
--------------------------
* Initial release