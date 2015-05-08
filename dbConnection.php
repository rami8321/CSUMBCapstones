<?php
function getConnection(){
    $host = "127.0.0.1";
    $dbname= "capstones";
    $username = "root";
    $password = "s3cr3t";
    $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbConn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $dbConn;
}


?>