<?php

session_start();

//$_SESSION['usuario'] = 1;

if(!isset($_SESSION['usuario']) || $_SESSION['usuario'] != 1) {
	//header('Location: login.php?t=Você não está mais logado no sistema Maria Gata. É possível que tenha ficado algum tempo sem utilizar o sistema.&r=Por favor, realize um novo acesso.');
	header('Location: index.php');
	exit;
}

?>