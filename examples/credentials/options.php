<?php

/**
 * Environment
 */
$sandbox = false; // false = Production | true = Homologation

/**
 * Credentials of Production
 */
$clientIdProd = "Client_Id_Prod";
$clientSecretProd = "Client_Secret_Prod";
$pathCertificateProd = realpath(__DIR__ . "/productionCertificate.p12"); // Absolute path to the certificate in .pem or .p12 format

/**
 * Credentials of Homologation
 */
$clientIdHomolog = "Client_Id_Homolog";
$clientSecretHomolog = "Client_Secret_Homolog";
$pathCertificateHomolog = realpath(__DIR__ . "/developmentCertificate.p12"); // Absolute path to the certificate in .pem or .p12 format

/**
 * Array with credentials and other settings
 */
return [
	"clientId" => ($sandbox) ? $clientIdHomolog : $clientIdProd,
	"clientSecret" => ($sandbox) ? $clientSecretHomolog : $clientSecretProd,
	"certificate" => ($sandbox) ? $pathCertificateHomolog : $pathCertificateProd,
	"pwdCertificate" => "", // Optional | Default = ""
	"sandbox" => $sandbox, // Optional | Default = false
	"debug" => false, // Optional | Default = false
	"timeout" => 30, // Optional | Default = 30
	"responseHeaders" => true, //  Optional | Default = false
];
