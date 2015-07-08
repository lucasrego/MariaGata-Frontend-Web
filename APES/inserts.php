<?php
include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");
include("includes/util/util.php");

date_default_timezone_set('America/Recife');
$lsDataHoraAtual = date("Y-m-d H:i:s");
$lsDataAtual = date("Y-m-d");


$funcionario_servico["FUNC_ID"]  = MySQL::SQLValue(4, MySQL::SQLVALUE_NUMBER);
$funcionario_servico["SERV_ID"]  = MySQL::SQLValue(43, MySQL::SQLVALUE_NUMBER);
$resultado_funcionario_servico = $db->InsertRow("funcionario_servico", $funcionario_servico);
if (! $resultado_funcionario_servico) {
	echo '{ "resultado": "ERRO", "mensagem": "Ops! Não consuiguimos processar seu pedido [4]. Entre em contato pelo Whatsapp (71) 8879-1014, ok? ;)" }';
	exit;
} else {
	echo '{ "resultado": "SUCESS", "mensagem": "Feito: ' . $resultado_funcionario_servico . '" }';
	exit;	
}

?>