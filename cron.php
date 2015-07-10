<meta charset="utf-8">
<?php

include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");
include("includes/bd/conectarBanco1.php");
include("includes/util/util.php");
include("includes/util/enviar_sms.php");

date_default_timezone_set('America/Recife');
$lsDataHoraAtual = date("Y-m-d H:i:s");
$lsDataAtual = date("Y-m-d");

$debugEnvioSMS = false;

// ***************************************************************
// ************ Enviar SMS de lembrete do agendamento
// ***************************************************************

if ($debugEnvioSMS) echo "-------------- Iniciando verificação e envio de SMS de lembrete dos agendamentos próximos...";

//Obtem agendamentos do dia e dia anterior pendentes de envio de SMS
//Criar campo AGEN_DataAvisoCliente as datetime e incluir no where onde estiver NULL: and AGEN_DataAvisoCliente is NULL

$amanhaDeManha = date("Y-m-d", strtotime('tomorrow')) . " 11:00:00";

$lsSQL = "
		select a.AGEN_ID, DATE_FORMAT(AGEN_Data,'%d/%m/%y as %H:%i') as DataInicioAtendimento, c.CLIE_ID, CLIE_Nome, CLIE_Celular, CLIE_Email, AGEN_Data
		from agendamento a, cliente c
		where a.CLIE_ID = c.CLIE_ID
		and AGEN_Situacao = 'A'
		and AGEN_DataAvisoCliente is NULL
		and (
				AGEN_Data >= '" . date("Y-m-d") . "'
				AND
				AGEN_Data <= '" . $amanhaDeManha . "'					
			)
		";

				
if ($db->Query($lsSQL)) {
	
	$qtdAgendamentos = $db->RowCount();
	
	if (($qtdAgendamentos >= 0) and ($qtdAgendamentos != "")) {		

		if ($debugEnvioSMS) echo "Agendamentos pendentes de envio encontrados: " . $qtdAgendamentos;
		
		for($i = 0; $i < $qtdAgendamentos; $i++) {
			
			$agendamento = $db->Row($i);
			
			$idAgendamento = $agendamento->AGEN_ID;
			$idCliente = $agendamento->CLIE_ID;
			$dataAgendamento = $agendamento->AGEN_Data; //2015-06-15 09:30:00
			$dataHoraInicioAgendamento = $agendamento->DataInicioAtendimento; // 15/06/2015 as 09:30h
			$clienteNome = $agendamento->CLIE_Nome;
			$clienteEmail = $agendamento->CLIE_Email;
			$clienteCelular = $agendamento->CLIE_Celular;
			
			if ($debugEnvioSMS) echo "<br /><br />Iniciando processamento do agendamento: " . $idAgendamento . " - Horario Inicio: " . $dataHoraInicioAgendamento . " - Cliente: " . $clienteNome . ". Celular: " . $clienteCelular;
			
			if ((strlen($clienteCelular) != 10)&&(strlen($clienteCelular) != 11)) {
				if ($debugEnvioSMS) echo "<br />Celular nao possui 10 ou 11 digitos, desconsiderando envio: " . $clienteCelular;
			} else {
				
				if ($debugEnvioSMS) echo "<br />Verificar se faltam 3h ou é para amanhã e já passou das 19h de hoje...";
						
				$enviarSMSpeloHorario = false;
				//Se data de hoje, verifica se falta menos de 3 horas para o agendamento
				if (date("Y-m-d", strtotime($dataAgendamento)) == date("Y-m-d")) {
					if ($debugEnvioSMS) echo "<br />Agendamento para hoje: " . $dataAgendamento;
					
					//Calcula 3 horas antes do agendamento
					$horaIntervaloEnvio = new DateTime($dataAgendamento);
					$horaIntervaloEnvio = date_format($horaIntervaloEnvio->modify('-2 hour'), 'H:i:s'); //Se agendamento 2015-06-15 12:30:00 = 09:30:00
					
					//Se horario atual, já tiver passado de 2 horas do evento, envia SMS
					if (date("H:i:s") >= $horaIntervaloEnvio) {										 	
						if ($debugEnvioSMS) echo "<br />Vai enviar SMS, pois agendamento é para hoje e faltam menos de 3h. Hora atual: " . date("H:i:s");
						$enviarSMSpeloHorario = true;
					} else {
						if ($debugEnvioSMS) echo "<br />Não faltam 3h para o agendamento...";
					}
				} else {
					//Se data amanhã, verifica se horário entre 19h e 22h
					if (date("Y-m-d", strtotime($dataAgendamento)) == date("Y-m-d", strtotime('tomorrow'))) {
						if ($debugEnvioSMS) echo "<br />Agendamento para amanhã...";
						if (date("H:i:s") > "19:00:00" and date("H:i:s") < "22:00:00") {
							if ($debugEnvioSMS) echo "<br />Vai enviar SMS, pois agendamento para amanhã e horário entre 19h e 22h do dia anterior...";
							$enviarSMSpeloHorario = true;
						} else {
							if ($debugEnvioSMS) echo "<br />Horário não está entre 19h e 22h: "  . date("H:i:s");
						}
					} else {
						if ($debugEnvioSMS) echo "<br />Não é amanhã...";	
					}
				}
				
				if ($enviarSMSpeloHorario) {
					
					//Enviar SMS :: Revisar test_always_succeed no arquivo enviar_sms.php
					$msg = "Oi " . $clienteNome . ". Seu momento esta confirmado na Maria Gata para " . $dataHoraInicioAgendamento . ". Qualquer problema estou no WhatsApp 8879-1014, ok? Juliana";
					if (enviarSMS($msg, $clienteCelular)) {
						if ($debugEnvioSMS) echo "<br />SMS enviado com sucesso...";
						
						//Atualiza agendamento como enviado
						$update_agendamento["AGEN_DataAvisoCliente"]  = MySQL::SQLValue($lsDataHoraAtual);			
						if (! $db1->UpdateRows("agendamento", $update_agendamento, array("AGEN_ID" => $idAgendamento))) {						
							if ($debugEnvioSMS) echo "<br />FALHA ao setar agendamento como enviado...";									
						} else {
							if ($debugEnvioSMS) echo "<br />Setou agendamento como enviado...";
						}
						
					} else {
						if ($debugEnvioSMS) echo "<br />Falha ao enviar SMS...";
					}
				} else {
					if ($debugEnvioSMS) echo "<br />Não enviou SMS devido ao horário...";
				}				
				
			} //Fim validação celular
			
		} //Fim loop agendamentos
		
	} else {
		if ($debugEnvioSMS) echo "<br />Nenhum aviso de agendamento pendente de envio...";
	}
} else {
	if ($debugEnvioSMS) echo "<br />FALHA ao executar query para obtenção dos agendamentos pendentes: " . $db->ErrorNumber() . " - " . $db->Error();;
}

// ***************************************************************
// ************ FIM Enviar SMS de lembrete do agendamento
// ***************************************************************




?>