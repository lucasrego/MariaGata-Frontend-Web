<?php

session_start();

$_SESSION['logado'] = 1;

if(!isset($_SESSION['logado']) || $_SESSION['logado'] != 1) {
	header('Location: tMensagemOffline.php?t=Ops! Você não está mais logado no sistema Maria Gata. É possível que tenha ficado algum tempo sem utilizar o sistema.&r=Por favor, realize um novo acesso.');
	exit;    
}

?>