<?php
require_once "config.php";

try {
    $db = new PDO('mysql:dbname=' . DBNAME . ';host=' . HOST, USER, PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

function redirect(){
	header('Location: ../view.php');
	exit();
}
?>