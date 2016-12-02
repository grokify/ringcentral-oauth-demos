<?php

require_once(__DIR__ . '/vendor/autoload.php');

use RingCentral\SDK\SDK;
use RingCentral\SDK\Http\HttpException;
use RingCentral\http\Response;

session_start();

// Parse the .env file
$dotenv = new Dotenv\Dotenv(getcwd());
$dotenv->load();


function processCode()
{

    if (!isset($_GET['code'])) {
        return;
    }

    // Create SDK instance
    $rcsdk = new SDK($_ENV['RC_AppKey'], $_ENV['RC_AppSecret'], $_ENV['RC_Server'], 'OAuth-Demo-PHP', '1.0.0');

    // Create Platform instance
    $platform = $rcsdk->platform();

    $qs = $platform->parseAuthRedirectUrl($_SERVER['QUERY_STRING']);
    $qs["redirectUri"] = $_ENV['RC_Redirect_Url'];

    $apiResponse = $platform->login($qs);
    $_SESSION['sessionAccessToken'] = $apiResponse->text();

}

$result = processCode();

?>