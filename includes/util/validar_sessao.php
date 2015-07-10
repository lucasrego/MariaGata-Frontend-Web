<?php

session_start();

//$_SESSION['usuario'] = 1;

if(!isset($_SESSION['usuario']) || $_SESSION['usuario'] == "") {
	header('Location: index.php');
	exit;
}

?>