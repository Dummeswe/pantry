<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'aragon');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'inventory');

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