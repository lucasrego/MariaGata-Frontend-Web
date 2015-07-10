<?php
include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");
include("includes/util/util.php");

date_default_timezone_set('America/Recife');
$lsDataHoraAtual = date("Y-m-d H:i:s");
$lsDataAtual = date("Y-m-d");


$insert["FUNC_ID"]  = MySQL::SQLValue("");
$insert["SERV_ID"]  = MySQL::SQLValue(1, MySQL::SQLVALUE_NUMBER);

$resultado = $db->InsertRow("funcionario_servico", $insert);
if (! $resultado) {
	echo '{ "resultado": "ERRO", "mensagem": "Falha no insert" }';
	exit;
} else {
	echo '{ "resultado": "SUCESS", "mensagem": "Feito: ' . $resultado . '" }';
	exit;	
}

?>