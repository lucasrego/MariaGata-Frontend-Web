<?php
include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");
include("includes/util/util.php");

date_default_timezone_set('America/Recife');
$lsDataHoraAtual = date("Y-m-d H:i:s");
$lsDataAtual = date("Y-m-d");

$campo = "FUHB_HorarioBloqueado"; //<----------
$novo_valor = "N"; //<----------
$tabela = "funcionario_horarios_base"; //<----------
$chave = "FUNC_ID"; //<----------
$valor_where = 10; //<----------

//$update[$campo]  = MySQL::SQLValue($novo_valor, MySQL::SQLVALUE_NUMBER); //<----------
$update[$campo]  = MySQL::SQLValue($novo_valor); //<----------

if (! $db->UpdateRows($tabela, $update, array($chave => $valor_where))) {
	echo '{ "resultado": "ERRO", "mensagem": "Ops! Não foi possível atualizar os dados!" }';
	exit;
} else {
	echo '{ "resultado": "SUCESSO", "mensagem": "Campo ' . $valor_where . ' atualizado com: ' . $novo_valor . '"}';
	exit;
}


?>