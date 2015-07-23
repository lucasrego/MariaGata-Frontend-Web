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
	
	
$sql_query = "SELECT 
	a.ATEN_ID, ATEN_DataAtendimento, SERV_Nome, ASER_ValorCobrado, FUNC_Nome, FUNC_Especialidade 
FROM 
	atendimento a, 
	atendimento_servicos ats, 
	servico s, 
	funcionario f 
WHERE 
	a.ATEN_ID = ats.ATEN_ID 
	and ats.SERV_ID = s.SERV_ID 
	and ats.FUNC_ID = f.FUNC_ID 
	and ATEN_DataAtendimento >= '20150701' 
	and ATEN_DataAtendimento <= '20150731' 
	and ATEN_Status = 'P' 
	and a.FILI_ID = 1 
ORDER BY f.FUNC_ID, ATEN_DataAtendimento
";

try { 
	
	$db->Query($sql_query);
		
	if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {
		echo $db->GetJSON();
	} else {
		echo '{ "resultado": "NAOENCONTRADO", "mensagem": "Nenhum registro encontrado" }';
		exit;
	}

} catch(Exception $e) { 
    echo $e->getMessage(); 
} 

?>