#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doLogin($username,$password)
{
     // lookup username in database
    $db = new mysqli("localhost","devon","mysql","IT490");

        if ($db->connect_errno != 0)
        {
                echo "Error connecting to database: ".$db->connect_error.PHP_EOL;
                exit(1);
        }
        echo "correctly connected to database".PHP_EOL;




	$statement = "SELECT * FROM Account WHERE  Username = '$username'";
        $response = $db->query($statement);

        while ($row = $response->fetch_assoc())
        {
                echo "checking password for $username".PHP_EOL;
                if ($row["Password"] == $password)
                {
                        echo "passwords match for $username".PHP_EOL;
                        return 1;// password match
                }
                echo "passwords did not match for $username".PHP_EOL;
        }
        return "Michael loves his Oloong tea";//no users matched username




    // check password
    //return true;
    //return false if not valid
}

function requestProcessor($request)
{    
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "Login":
      return doLogin($request['username'],$request['password']);
    case "validate_session":
      return doValidate($request['sessionId']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>


