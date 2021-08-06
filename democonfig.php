<?php

define('DB_SERVER', 'localserveraddress');
define('DB_USERNAME', 'username');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'nameofdatabase');

//connect
try{
$pdo = new PDO("mysql:host=" . DB_SERVER . 
            ";dbname=" .       DB_NAME,
                               DB_USERNAME,
                               DB_PASSWORD);

//set pdo error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e)
{
    die("ERROR: Could not connect" . 
    $e->getMessage());
}

?>
