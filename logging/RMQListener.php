<?php
require_once('path.inc');
require_once('rabbitMQLib.inc');
require_once('get_host_info.inc');


function errorLogListener($errorLog)
{
        echo "received error log".PHP_EOL;
        file_put_contents("logging.txt", $errorLog.PHP_EOL, FILE_USE_INCLUDE_PATH | FILE_APPEND);
}
$server = new rabbitMQServer("logging.ini","testServer");
$server->process_requests('errorLogListener');
exit();
?>

