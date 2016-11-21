<?php

require_once(__DIR__ . '/vendor/autoload.php');

use RingCentral\SDK\SDK;

session_start();

// Parse the .env file
$dotenv = new Dotenv\Dotenv(getcwd());
$dotenv -> load();

// retrieve the sdk from session object
$rcsdk = $_SESSION['sdk'];

function processCode($rcsdk)
{


    // $rcsdk = $_SESSION['sdk'];
    
    if(!isset($_GET['code'])) 
    {
        return;
    }

    $qs = $rcsdk->platform()->parseAuthRedirectUrl($_SERVER['QUERY_STRING']);
    $qs["redirectUri"] = $_ENV['RC_Redirect_Url'];

    $apiResponse = $rcsdk->platform()->login($qs);

    $body = json_encode(json_decode($apiResponse->text(), true), JSON_PRETTY_PRINT);

    $_SESSION['response'] = $apiResponse->text();

}

$result= processCode($rcsdk);

session_write_close();

?>



