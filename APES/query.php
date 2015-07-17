<?php
include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");
include("includes/util/util.php");

date_default_timezone_set('America/Recife');
$lsDataHoraAtual = date("Y-m-d H:i:s");
$lsDataAtual = date("Y-m-d");

//if ($db->Query("select s.SERV_ID, SERV_Nome, SEGS_ID, SEGS_Duracao from servico_grupo_servico sgs, servico s where sgs.SERV_ID = s.SERV_ID and GSER_ID = 2 and SERV_Nome like '%Escova%' order by s.SERV_ID")) {
//if ($db->Query("select * from funcionario_servico where FUNC_ID = 1 order by SERV_ID")) {
//if ($db->Query("select c.CLIE_ID, CLIE_Nome, CLIE_Celular, AGEN_ID, AGEN_Data, AGEN_DataAvisoCliente from agendamento a, cliente c where AGEN_Situacao = 'A' and a.CLIE_ID = c.CLIE_ID and AGEN_Data > '2015-07-10 00:00:00' and AGEN_Data < '2015-07-10 23:59:59' order by AGEN_Data")) {
if ($db->Query("select * from funcionario_horarios_base order by FUNC_ID")) {
	
	if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {
		echo $db->GetJSON();
	} else {
		echo '{ "resultado": "NAOENCONTRADO", "mensagem": "Nenhum registro encontrado" }';
		exit;
	}
} else {
	echo '{ "resultado": "ERRO", "mensagem": "Falha na query!" }';
	exit;			
}


?>