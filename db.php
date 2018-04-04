<?php 
session_start();
try{
$options = array(PDO::ATTR_EMULATE_PREPARES => false,  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
$db = new PDO('mysql:host=localhost;dbname=hostel','root','',$options);
			
			//echo "Connection Successfully";
}catch(PDOException $e){
echo "Connection Failed".$e->message();
}



?>