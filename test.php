<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('update.php');
// lookup username in database
$db = new mysqli("localhost","devon","mysql","KitchenWars");

   if ($db->connect_errno != 0)
   {
           echo "<br>Error connecting to database: ".$db->connect_error.PHP_EOL;
           exit(1);
   }
   echo "Connected to database".PHP_EOL;

   $statement = "SELECT Username FROM Account";
   // $response = $db->query($statement);
   // if ($response->num_rows > 0) {
   //  // output data of each row
   //  while($row = $response->fetch_assoc()){
   //      echo "Profile"."\r\n"
   //      echo "id: " . $row["Username"]."\r\n";}
   //  } else {
   //      echo "0 results";
   //  }
 ?>
