<?php
include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");
include("includes/util/util.php");

date_default_timezone_set('America/Recife');
$lsDataHoraAtual = date("Y-m-d H:i:s");
$lsDataAtual = date("Y-m-d");


$update_cliente["FUHB_HorarioBloqueado"]  = MySQL::SQLValue("N");
if (! $db->UpdateRows("funcionario_horarios_base", $update_cliente, array("FUNC_ID" => 10))) {
	echo '{ "resultado": "ERRO", "mensagem": "Ops! Não conseguimos salvar" }';
	exit;
} else {
	echo '{ "resultado": "SUCESSO", "mensagem": "Tudo certo: 10" }';
	exit;	
}


?>