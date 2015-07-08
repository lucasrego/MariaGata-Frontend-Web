<?php
include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");
include("includes/util/util.php");

date_default_timezone_set('America/Recife');
$lsDataHoraAtual = date("Y-m-d H:i:s");
$lsDataAtual = date("Y-m-d");

//if ($db->Query("select * from funcionario_servico where FUNC_ID = 1 order by SERV_ID")) {
if ($db->Query("select * from usuario")) {
	if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {
		echo $db->GetJSON();
	} else {
		echo '{ "resultado": "NAOENCONTRADO", "mensagem": "Ops! Nenhum serviço está disponível no momento para esta unidade Maria Gata." }';
		exit;
	}
} else {
	echo '{ "resultado": "ERRO", "mensagem": "Ops! Por um problema técnico não conseguimos obter os serviços. Entre em contato pelo Whatsapp (71) 8879-1014, ok? ;)" }';
	exit;			
}


?>