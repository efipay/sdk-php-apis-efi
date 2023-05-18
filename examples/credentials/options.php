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
 * Array with credentials for sending requests
 */
$options = [
	"client_id" => ($sandbox) ? $clientIdHomolog : $clientIdProd,
	"client_secret" => ($sandbox) ? $clientSecretHomolog : $clientSecretProd,
	"certificate" => ($sandbox) ? $pathCertificateHomolog : $pathCertificateProd,
	"sandbox" => $sandbox,
	"debug" => false,
	"timeout" => 30
];
