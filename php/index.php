<?php

require_once(__DIR__ . '/vendor/autoload.php');

use RingCentral\SDK\Http\HttpException;
use RingCentral\SDK\Http\ApiResponse;
use RingCentral\SDK\SDK;

// Start the session
session_start();

// Parse the .env file
$dotenv = new Dotenv\Dotenv(getcwd());
$dotenv->load();

// Create SDK instance
$rcsdk = new SDK($_ENV['RC_AppKey'], $_ENV['RC_AppSecret'], $_ENV['RC_Server'], 'OAuth-Demo-PHP', '1.0.0');

// Create Platform instance
$platform = $rcsdk->platform();

// Using the authUrl to call the platform function
$url = $platform
    ->authUrl(array(
        'redirectUri' => isset($_ENV['RC_Redirect_Url']) ? $_ENV['RC_Redirect_Url'] : '',
        'state' => 'myState',
        'brandId' => '',
        'display' => '',
        'prompt' => ''
    ));

// Store the url in PHP Session Objec;
$_SESSION['url'] = $url;

//set the access token using the auth object
if (isset($_SESSION['sessionAccessToken'])) {

    $platform->auth()->setData((array)json_decode($_SESSION['sessionAccessToken']));
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script>

        var url = '<?php echo $url; ?>';
        var redirectUri = '<?php echo $_ENV['RC_Redirect_Url']; ?>';

        var config = {
            authUri: url,
            redirectUri: redirectUri,
        }

        var OAuthCode = function (config) {
            this.config = config;

            this.loginPopup = function () {
                console.log("The URL is :" + url);
                this.loginPopupUri(this.config['authUri'], this.config['redirectUri']);
            }
            this.loginPopupUri = function (authUri, redirectUri) {
                var win = window.open(authUri, 'windowname1', 'width=800, height=600');
                var pollOAuth = window.setInterval(function () {
                    try {
                        console.log(win.document.URL);
                        if (win.document.URL.indexOf(redirectUri) != -1) {
                            window.clearInterval(pollOAuth);

                            win.close();
                            location.reload();
                        }
                    } catch (e) {
                        console.log(e);
                        // win.close();
                    }
                }, 100);

            }
        }

        var oauth = new OAuthCode(config);

    </script>
</head>
<body>
<h1>RingCentral 3-Legged OAuth Demo in PHP</h1>

<p><input type="button" onclick="oauth.loginPopup()" value="Login with RingCentral"></p>

<p>After retrieving the token use the PHP SDK's auth class's set_data method to load the access_token.</p>

<p>Access Token</p>
<pre>
    <style="background-color:#efefef;padding:1em;overflow-x:scroll"><?php if ($platform->loggedIn()) echo json_encode($platform->auth()->data(), JSON_PRETTY_PRINT); ?></pre>


<p>More info:</p>
<ul>
    <li><a href="https://developer.ringcentral.com/api-docs/latest/index.html#!#AuthorizationCodeFlow">RingCentral API
            Developer Guide</a></li>
    <li><a href="https://github.com/grokify/ringcentral-oauth-demos">GitHub repo</a>
    <li><a href="https://github.com/grokify/ringcentral-oauth-demos/tree/master/python-bottle">GitHub repo Python
            README</a></p></li>
</ul>
</body>
</html>



