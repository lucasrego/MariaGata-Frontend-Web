<?php
include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");
include("includes/util/util.php");

date_default_timezone_set('America/Recife');
$lsDataHoraAtual = date("Y-m-d H:i:s");
$lsDataAtual = date("Y-m-d");

$campo = "SEGS_Duracao"; //<----------
$valor = 90; //<----------
$tabela = "servico_grupo_servico"; //<----------
$chave = "SEGS_ID"; //<----------
$chave_valor = 42; //<----------

$update[$campo]  = MySQL::SQLValue($valor, MySQL::SQLVALUE_NUMBER); //<----------
if (! $db->UpdateRows($tabela, $update, array($chave => $chave_valor))) {
	echo '{ "resultado": "ERRO", "mensagem": "Ops! Não foi possível atualizar os dados!" }';
	exit;
} else {
	echo '{ "resultado": "SUCESSO", "mensagem": "Campo ' . $chave_valor . ' atualizado com: ' . $valor . '"}';
	exit;
}


?>