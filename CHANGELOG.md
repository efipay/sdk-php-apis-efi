Changelog
=========

Version 1.4.0 (2023-10-27)
--------------------------
* Added a new endpoint and example to retry card payment
* Fixed validation of configuration parameters
* Fixed exception validation

Version 1.3.1 (2023-10-12)
--------------------------
* Updated link to technical documentation for examples
* Added a new endpoint and example to cancel a scheduled Pix payment via Open Finance

Version 1.3.0 (2023-10-12)
--------------------------
* Added option to enter the certificate password through the "pwdCertificate" parameter
* Added option to enable/disable cache to reuse authentication hrough the "cache" parameter
* Parameters "client_id" and "client_secret" changed following the camel case convention, that is, "clientId" and "clientSecret", but the old names are accepted
* Support symfony/cache v6

Version 1.2.3 (2023-10-08)
--------------------------
* Fixed the use of cache attributes
* Refactor: Improved code optimization and organization

Version 1.2.2 (2023-09-21)
--------------------------
* Fixed PHP version and dependency compatibility
* Added efí to the request header

Version 1.2.1 (2023-09-21)
--------------------------
* Updated method "getAccountCertificate()" renamed to "createAccountCertificate()"
* Updated the endpoint method "/v1/conta-simplificação/:idContaSimplificação/certificate" from "GET" to "POST"

Version 1.2.0 (2023-09-20)
--------------------------
* Added a new endpoint and example to query a Pix send by its Id

Version 1.1.3 (2023-08-26)
--------------------------
* Refactor: Improved code optimization and organization
* Update .codeclimate.yml

Version 1.1.2 (2023-08-24)
--------------------------
* Refactor: Improved code optimization and organization

Version 1.1.1 (2023-08-04)
--------------------------
* Updated API base routes
* Code refactored for optimization and security
* Compatibility with PHP >= 7.2

Version 1.1.0 (2023-05-18)
--------------------------
* Refactored code
* Added functionality that reuses the auth access token


Version 1.0.1 (2023-02-14)
--------------------------
* Added new examples of Pix split


Version 1.0.0 (2023-01-31)
--------------------------
* Initial release