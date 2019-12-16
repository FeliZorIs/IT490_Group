<?php
require_once('path.inc');
require_once('rabbitMQLib.inc');
require_once('get_host_info.inc');

function ErrorPublisher($errorLog){
  $client = new rabbitMQClient("logging.ini","testServer");
  $machine_info = date("m-d-Y h:i:s", time())." ".gethostname()." ".$errorLog.PHP_EOL;

  $response = $client->publish($machine_info);
}
?>

