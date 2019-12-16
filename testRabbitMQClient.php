#!/usr/bin/php
<?php session_start(); ?>
<?php

if (ob_get_level()) {
    $buf = ob_get_clean();
    ob_start();
    // Refill the buffer, but without the shebang line:
    echo substr($buf, 0, strpos($buf, file(__FILE__)[0]));
} // else { out of luck... }

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('update.php');



$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

$request = array();
$request['type'] = $_POST['account'];
$request['username'] = $_SESSION['S_username'] = $_POST['username'];
$request['password'] = $_SESSION['S_password'] = $_POST['password'];
$request['message'] = $msg;
$response = $client->send_request($request);
//$response = $client->publish($request);

$result = $_GET[$login];

//echo "client received response: ".PHP_EOL;
//print_r($response);
echo "Taadaa: ".$result;
echo "\n\n";


if($response == 'success'){
  echo"<br>GOOD JOB! GET YOURSELF SUM BUBBLE TEA!<br>Redirecting..";
  header("Refresh:3; url=gamepage.html");
}
elseif($response == 'fail'){
  echo"NO PASSWORD MATCHES! GET OUTTA HERE!<br>Redirecting..";
  header("Refresh:3; url=index.html");
}
else{
  echo "No User Matches. Redirecting...";
  header("Refresh:3; url=index.html");
}







//header("Refresh:3; url=gamepage.html");

//echo "<br> END".PHP_EOL;
