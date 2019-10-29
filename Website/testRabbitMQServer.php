#!/usr/bin/php
<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('update.php');

//Original doLogin
function doLogin($username,$password)
{
    $login;
     // lookup username in database
   // $db = new mysqli("localhost","devon","mysql","IT490");
	$db = new mysqli("localhost", "texmex", "password", "Account");

        if ($db->connect_errno != 0)
        {
                echo "Error connecting to database: ".$db->connect_error.PHP_EOL;
                exit(1);
        }
        echo "correctly connected to database".PHP_EOL;


	      $statement = "SELECT * FROM Account WHERE  Username = '$username'";
        $response = $db->query($statement);
        //$display = mysqli_fetch_array($response);
        //echo "Result: ".$display[5];


        $row = $response->fetch_assoc();
        if ($row["Password"] == $password){
                echo "passwords match for $username".PHP_EOL;
                $login="success"; echo $login;
                //return test($login);
                return "success";
                ///return"<br>GOOD JOB! GET YOURSELF SUM BUBBLE TEA!<br>Redirecting..";// password match
          }
        else if ($row["Password"] != $password){
          echo "passwords did not match for $username".PHP_EOL;
          $login="fail"; echo $login;
          return "fail";
          //return "NO PASSWORD MATCHES! GET OUTTA HERE!<br>Redirecting..";
        }
        else{
          $login="none"; echo $login;
          return "none";
          //return "No User Matches<br>Redirecting..";//no users matched username
        }

        /*
        while ($row = $response->fetch_assoc())
          {
                echo "checking password for $username".PHP_EOL;
                if ($row["Password"] == $password)
                  {
                        echo "passwords match for $username".PHP_EOL;
                        print"<br>GOOD JOB! GET YOURSELF SUM BUBBLE TEA!";// password match

                  }
      		  echo "passwords did not match for $username".PHP_EOL;
    		    return "NO PASSWORD MATCHES BITCH! GET OUTTA HERE!\n ";
          }
        return "No User Matches";//no users matched username
        */

}

function doRegister($username, $password)
{
  //DB connection
  $db = new mysqli("localhost","devon","mysql","IT490");

  //Connection test
  if ($db->connect_errno != 0)
  {
          echo "Error connecting to database: ".$db->connect_error.PHP_EOL;
          exit(1);
  }
  echo "correctly connected to database".PHP_EOL;

  //$statement = "INSERT INTO Account(Username, Password) VALUES('$username', '$password')";

  $statement = "INSERT INTO Account(Username, Password, GameID, Progress, XP,
                              Dmg1, Dmg2, Dmg3, Dmg4, Dmg5,
                              Shd1, Shd2, Shd3, Shd4, Shd5,
                              Hth1, Hth2, Hth3,
                              HthNshd1, HthNshd2, HthNshd3, HthNshd4, HthNshd5, HthNshd6,
                              HthStl1, HthStl2, HthStl3, HthStl4, HthStl5,
                              ShdStl1, ShdStl2, ShdStl3, ShdStl4, ShdStl5,
                              Reverse, Eng1, Eng2, MultX2, MultX3, MultX4)
                      VALUES('$username','$password',NULL,0,0,
                              1,1,1,0,0,
                              1,1,1,0,0,
                              0,0,0,
                              1,1,0,1,1,0,
                              1,1,1,0,0,
                              1,1,1,0,0,
                              0,0,0,0,0,0)";

  /*

  INSERT INTO `Account
  (Username,`Password`,`GameID`,`Progress`,`XP`,
  `Dmg1`,`Dmg2`,`Dmg3`,`Dmg4`,`Dmg5`,
  `Shd1`,`Shd2`,`Shd3`,`Shd4`,`Shd5`,
  `Hth1`,`Hth2`,`Hth3`,
  `HthNShd1`,`HthNShd2`,`HthNShd3`,`HthNShd4`,`HthNShd5`,`HthNShd6`,
  `HthStl1`,`HthStl2`,`HthStl3`,`HthStl4`,`HthStl5`,
  `ShdStl1`,`ShdStl2`,`ShdStl3`,`ShdStl4`,`ShdStl5`,
  `Reverse`,`Eng1`,`Eng2`,`MultX2`,`MultX3`,`MultX4`)
  VALUES
  ("Chester","beat",NULL,0,0,
  1,1,1,0,0,
  1,1,1,0,0,
  0,0,0,
  1,1,0,1,1,0,
  1,1,1,0,0,
  1,1,1,0,0,
  0,0,0,0,0,0);

  */

  if ($db->query($statement) === TRUE) {
    echo "Registration completed!";
    return "YOU NOW GOT AN ACCOUNT SOLDIER! <br> Redirecting...";
  }
  else {
    echo "Error: " . $statement . "<br>" . $db->error;
  }
}


function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  /*
  if($request['type'] === "Login")
  {
    echo "Type: ". $request['type'];
    return doLogin($request['username'],$request['password']);
  }*/

  switch ($request['type'])
  {
    case "Login":
      echo "This Type: ". $request['type']."\r\n";
      //return test();
      return doLogin($request['username'],$request['password']);
    case "Register":
      echo "Type: ". $request['type'];
      return doRegister($request['username'],$request['password']);
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
