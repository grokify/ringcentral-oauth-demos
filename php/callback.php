<?php

require_once(__DIR__ . '/vendor/autoload.php');

use RingCentral\SDK\SDK;
use RingCentral\SDK\Http\HttpException;
use RingCentral\http\Response;

session_start();

// Parse the .env file
$dotenv = new Dotenv\Dotenv(getcwd());
$dotenv -> load();


function processCode()
{

    if(!isset($_GET['code'])) 
    {
        return;
    }

    $_SESSION['query'] = $_SERVER['QUERY_STRING']; 
 
}

$result= processCode();

?>



