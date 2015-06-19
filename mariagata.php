<?php
include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");
include("includes/util/util.php");
include("includes/util/class-valida-cpf-cnpj.php");
require_once("Google/autoload.php");

date_default_timezone_set('America/Recife');
$lsDataHoraAtual = date("Y-m-d H:i:s");
$lsDataAtual = date("Y-m-d");

$acao = $_POST["a"];

//Parâmetros Google Calendar
/*
$calendarId = '1qdpkmonl5mpub54h9h2ccfu60@group.calendar.google.com'; //Maria Gata
$client_email = '595270723080-jeptl2blnlafr5knjs6uibc4n9duq2u8@developer.gserviceaccount.com';
$private_key = file_get_contents('Google/Maria Gata Calendar-50ee75bea200.p12');
$scopes = array('https://www.googleapis.com/auth/calendar');
*/

function deletarEventoGoogleCalendar($idEvento) {
	
	$credentials = new Google_Auth_AssertionCredentials(
		$GLOBALS["client_email"],
		$GLOBALS["scopes"],
		$GLOBALS["private_key"]
	);
	
	$client = new Google_Client();
	$client->setAssertionCredentials($credentials);
	if ($client->getAuth()->isAccessTokenExpired()) {
	  $client->getAuth()->refreshTokenWithAssertion();
	}						
	$calendarService = new Google_Service_Calendar($client);
	
	$calendarService->events->delete($GLOBALS["calendarId"], $idEvento);
		
}	


switch ($acao) {
	
	case "googlecalendarnovoevento":
				
		//http://mariagata.com.br/sistema/mariagata.php?a=googlecalendarnovoevento
		
		/*
		$credentials = new Google_Auth_AssertionCredentials(
			$client_email,
			$scopes,
			$private_key
		);		
		$client = new Google_Client();
		$client->setAssertionCredentials($credentials);
		if ($client->getAuth()->isAccessTokenExpired()) {
		  $client->getAuth()->refreshTokenWithAssertion();
		}						
		$calendarService = new Google_Service_Calendar($client);
		
		$event = new Google_Service_Calendar_Event(array(
			'summary' => 'resumo do evento Maria Gata',
			'location' => 'Alameda Benevento, 20, Salvador, Bahia, 41830595',
			'description' => 'descricao evento',
			'start' => array(
				'dateTime' => '2015-06-05T10:00:00-07:00',
				'timeZone' => 'America/Recife',
			),
			'end' => array(
				'dateTime' => '2015-06-05T11:00:00-07:00',
				'timeZone' => 'America/Recife',
			),
		));

		$eventoCriado = $calendarService->events->insert($calendarId, $event);
		echo $eventoCriado->id;
		*/
		
		break;
		
		
	case "obterservicosfilial":	
		
		//http://mariagata.com.br/sistema/mariagata.php?filial=1&a=obterservicosfilial
		
		$filial = $_POST["filial"];

		if ($db->Query("select s.SERV_ID, SERV_Nome, SERV_Tipo from servico s, filial_servico fs where s.SERV_ID = fs.SERV_ID and FILI_ID = '" . $filial . "' and FISE_DelecaoLogica = 'N' order by SERV_Tipo desc, SERV_Ordem, SERV_Nome")) {
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
		
		break;


	case "obterclientes":	
		
		//http://mariagata.com.br/sistema/mariagata.php?a=obterclientes
		
		if ($db->Query("select CLIE_ID, CLIE_Nome, IFNULL(CLIE_CPF, ' ') as CLIE_CPF, CLIE_Email, CLIE_Celular from cliente order by CLIE_Nome")) {
			if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {
				echo $db->GetJSON();
			} else {
				echo '{ "resultado": "NAOENCONTRADO", "mensagem": "Ops! Cliente encontrado." }';
				exit;
			}
		} else {
			echo '{ "resultado": "ERRO", "mensagem": "Ops! Por um problema técnico não conseguimos obter os cliente." }';
			exit;			
		}
		
		break;


	case "obterfuncionarios":	
		
		//http://mariagata.com.br/sistema/mariagata.php?a=obterfuncionarios&filial=1
		
		$filial = $_POST["filial"];
		
		if ($db->Query("select FUNC_ID, FUNC_Nome, FUNC_Especialidade from funcionario where FILI_ID = " . $filial . " order by FUNC_Nome")) {
			if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {
				echo $db->GetJSON();
			} else {
				echo '{ "resultado": "NAOENCONTRADO", "mensagem": "Ops! Cliente encontrado." }';
				exit;
			}
		} else {
			echo '{ "resultado": "ERRO", "mensagem": "Ops! Por um problema técnico não conseguimos obter os funcionários filial." }';
			exit;			
		}
		
		break;
		
	
	case "obterdetalhesagendamento":
		
		//http://mariagata.com.br/sistema/mariagata.php?a=obterdetalhesagendamento&agendamento=1
		
		$agendamento = $_POST["agendamento"];
	
		$sql_query = "SELECT DATE_FORMAT(AGFU_HoraInicio,'%d/%m/%Y') as DataAgendamento, f.FUNC_ID, FUNC_Nome, FUNC_Especialidade, DATE_FORMAT(AGFU_HoraInicio,'%H:%i') as AGFU_HoraInicio, DATE_FORMAT(AGFU_HoraFim,'%H:%i') as AGFU_HoraFim, s.SERV_ID, SERV_Nome, SERV_Tipo, FILI_Nome as NomeUnidade FROM 
						agendamento a, filial fi, agendamento_funcionario agf, funcionario f, agendamento_servicos ags, servico s
						where 
						a.AGEN_ID = " . $agendamento . "
						and a.FILI_ID = fi.FILI_ID
						and a.AGEN_ID = agf.AGEN_ID
						and ags.AGEN_ID = agf.AGEN_ID
						and ags.SERV_ID = s.SERV_ID
						and agf.FUNC_ID = f.FUNC_ID
						order by f.FUNC_ID, SERV_ID
						";

		if ($db->Query($sql_query)) {
			if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {
				echo $db->GetJSON();
			} else {
				echo '{ "resultado": "NAOENCONTRADO", "mensagem": "Ops! Não não foi possível obter os detalhes do agendamento [' . $agendamento . ']."}';
				exit;
			}
		} else {
			echo '{ "resultado": "ERRO", "mensagem": "Ops! Por um problema técnico não conseguimos obter os detalhes do agendamento [' . $agendamento . ']. Entre em contato pelo Whatsapp (71) 8879-1014, ok? ;)" }';
			exit;
		}
		
		
		break;
	

	case "cancelaragendamento":
		
		//http://mariagata.com.br/sistema/mariagata.php?a=cancelaragendamento&agendamento=1
		
		$agendamento = $_POST["agendamento"];
	
		$sql_query = "SELECT AGEN_GoogleCalendar FROM 
						agendamento
						where 
						AGEN_ID = " . $agendamento . "
						";

		if ($db->Query($sql_query)) {
			if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {
				$linha = $db->Row(0);
				$eventogooglecalendar = $linha->AGEN_GoogleCalendar;
				
				//CANCELAR AGENDAMENTO BD
				$update_agendamento["AGEN_Situacao"]  = MySQL::SQLValue('C');
				$update_agendamento["AGEN_DataCancelamento"]  = MySQL::SQLValue($lsDataHoraAtual);
				if (! $db->UpdateRows("agendamento", $update_agendamento, array("AGEN_ID" => $agendamento))) {
					$db->TransactionRollback();
					$db->Kill();
					echo '{ "resultado": "ERRO", "mensagem": "Ops! Não conseguimos cancelar o agendamento [' . $agendamento . ']. Entre em contato pelo Whatsapp (71) 8879-1014, ok? ;)" }';
					exit;	
				}
				
				//Deleta evento do Google Calendar
				if ($eventogooglecalendar != "") {
					//deletarEventoGoogleCalendar($eventogooglecalendar);
				}
				
				$db->TransactionEnd(); //Commit
				echo '{ "resultado": "SUCESSO", "mensagem": "Agendamento cancelado com sucesso!"}';
				exit;
								
			} else {
				echo '{ "resultado": "NAOENCONTRADO", "mensagem": "Ops! Não não foi possível cancelar o agendamento [' . $agendamento . ']. Entre em contato pelo Whatsapp (71) 8879-1014, ok? ;)"}';
				exit;
			}
		} else {
			echo '{ "resultado": "ERRO", "mensagem": "Ops! Por um problema técnico não conseguimos cancelar o agendamento [' . $agendamento . ']. Entre em contato pelo Whatsapp (71) 8879-1014, ok? ;)" }';
			exit;
		}
		
		
		break;
			
	case "obteragendamentoscliente":	
		
		//http://mariagata.com.br/sistema/mariagata.php?a=obteragendamentoscliente&cpf=80941818500
		
		$cpf = $_POST["cpf"];
		
		// Verifica se o CPF ou CNPJ é válido
		$cpf_cnpj = new ValidaCPFCNPJ($cpf);
		if ( $cpf_cnpj->valida() == false) {
			echo '{ "resultado": "ERRO", "mensagem": "Ops! Parece que o CPF cadastrado não está válido (' . $cpf . '). Altere seu cadastro e tente novamente. Se ainda tiver problemas, nos falamos pelo Whatsapp (71) 8879-1014, ok? ;)" }';
			exit;			
		}
		
		$sql_query = "
		select 
			AGEN_ID, min(DataFormatada) as DataFormatada
		from
			(
				select a.AGEN_ID, CONCAT(DATE_FORMAT(AGFU_HoraInicio,'%d/%m/%Y às %H:%i'), 'h') as DataFormatada
				from agendamento a, cliente c, agendamento_funcionario af
				where a.CLIE_ID = c.CLIE_ID
				and a.AGEN_ID = af.AGEN_ID
				and CLIE_CPF = " . $cpf . "
				and AGEN_Situacao = 'A'
				and AGEN_Data >= '" . date("Y-m-d") . "'
			) a
		group by AGEN_ID
		";


		if ($db->Query($sql_query)) {
			if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {
				echo $db->GetJSON();
			} else {
				echo '{ "resultado": "NAOENCONTRADO", "mensagem": "Não encontramos agendamentos futuros para você (CPF: ' . $cpf . ')"}';
				exit;
			}
		} else {
			echo '{ "resultado": "ERRO", "mensagem": "Ops! Por um problema técnico não conseguimos obter seus agendamentos. Entre em contato pelo Whatsapp (71) 8879-1014, ok? ;)" }';
			exit;
		}
		
		break;
	
	
	case "obterprofissionaishorarios": 
		
		//http://mariagata.com.br/sistema/mariagata.php?a=obterprofissionaishorarios&filial=1&servicos=7|4&data=2015-06-03
				
		$filial = $_POST["filial"];
		$data = $_POST["data"];
		$servicos = $_POST["servicos"];
		
		//Valida se data caiu domingo ou segunda
		$diaSemana = date('w', strtotime($data));
		if (($diaSemana == 0)||($diaSemana == 1)) {
			echo '{ "resultado": "ERRO", "mensagem": "A Maria Gata abre de terça a sábado. Escolha uma nova data que não seja Domingo ou Segunda, ok?" }';
			exit;
		}
		
		//Valida se data é anterior a hoje
		if (date($data) < date("Y-m-d")) {
			echo '{ "resultado": "ERRO", "mensagem": "A data que você escolheu já passou! Ajuste o dia escolhido e tente novamente." }';
			exit;
		}
		
		//Se agendamento para o mesmo dia: Não deixa se o horário for muito tarde e se horário já passou
		if (date($data) == date("Y-m-d")) {
			if (date("H:i:s") > date("16:00:00")) {
				echo '{ "resultado": "ERRO", "mensagem": "Como está um pouco tarde, não é possível agendar seu momento para hoje. Escolha outro dia ou entre em contato pelo Whatsapp (71) 8879-1014, ok?" }';
				exit;
			}
		}

		$sql_query = "
		SELECT 
			f.FUNC_ID, f.FUNC_Nome, FUHB_Horario, FUHB_HorarioBloqueado, GSER_ID, FUNC_Especialidade
		FROM 
			funcionario f, funcionario_grupo_servicos fgs, funcionario_horarios_base fhb
		WHERE 
			f.FILI_ID = " . $filial . "
			and FUNC_DisponivelAgendamento = 'S'
			and f.FUNC_ID = fgs.FUNC_ID
            and f.FUNC_ID = fhb.FUNC_ID
			and f.FUNC_ID NOT IN
				(select f2.FUNC_ID 
					from funcionario f2, funcionario_ausencias fa 
					where 
					f2.FUNC_ID = fa.FUNC_ID
					and f2.FILI_ID = " . $filial . "
					and FUAU_Data = '" . $data . "'
				)
			and GSER_ID IN
				(SELECT distinct sgs.GSER_ID 
					FROM servico_grupo_servico sgs, servico s, filial_servico fs
					where 
					sgs.SERV_ID = s.SERV_ID
					and s.SERV_ID = fs.SERV_ID
					and fs.FILI_ID = " . $filial . "
					and sgs.SERV_ID in (" . $servicos . ")
				)
			and f.FUNC_ID IN #O funcionário deve atender todos os serviços do grupo para ser retornado
				(SELECT fs.FUNC_ID
					FROM 
						funcionario_servico fs, funcionario_grupo_servicos fgs
					WHERE 
						fs.FUNC_ID = fgs.FUNC_ID
						and fs.SERV_ID in (" . $servicos . ")
						and GSER_ID = 2
					GROUP BY fs.FUNC_ID
					HAVING COUNT(SERV_ID) = 
						(
                        SELECT 
							COUNT(1)
						FROM 
							servico_grupo_servico
						where 
							GSER_ID = 2
							and SERV_ID in (" . $servicos . ")
                        ) #Qtd de serviços selecionados pelo usuário que fazem parte do grupo 2 Escova (O funcionário deve atender todos para ser retornado).
                    UNION
					SELECT fs.FUNC_ID
					FROM 
						funcionario_servico fs, funcionario_grupo_servicos fgs
					WHERE 
						fs.FUNC_ID = fgs.FUNC_ID
						and fs.SERV_ID in (" . $servicos . ")
						and GSER_ID = 1
					GROUP BY fs.FUNC_ID
					HAVING COUNT(SERV_ID) = 
						(
                        SELECT 
							COUNT(1)
						FROM 
							servico_grupo_servico
						where 
							GSER_ID = 1
							and SERV_ID in (" . $servicos . ")
                        ) #Qtd de serviços selecionados pelo usuário que fazem parte do grupo 1 Manicure(O funcionário deve atender todos para ser retornado).
				)
		ORDER BY GSER_ID, f.FUNC_Nome, f.FUNC_ID, FUHB_Horario
		";
		
		if ($db->Query($sql_query)) {
			if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {
				
				//echo $db->GetJSON();
				
				$json = $db->GetJSON();				
				$arrayJson = json_decode($json, true);
				$ultimoFuncionario = "";
				$funTemAgendamentosNoDia = false;
				
				foreach($arrayJson as $key => $item) {
					
					if ($item['FUNC_ID'] != $ultimoFuncionario) {
						
						//Obtem agendamentos marcados no dia para o funcionario
						
						$funTemAgendamentosNoDia = false;					
						
						if ($db->Query("select TIME(AGFU_HoraInicio) as AGFU_HoraInicio, TIME(AGFU_HoraFim) as AGFU_HoraFim, AGEN_DataCancelamento from agendamento a, agendamento_funcionario af where a.AGEN_ID = af.AGEN_ID and FUNC_ID = " . $item['FUNC_ID'] . " and DATE(AGFU_HoraInicio) = '" . $data . "' order by AGFU_HoraInicio")) {
							
							if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {
								
								$agendamentosFuncionario = $db->RecordsArray(); 
								$funTemAgendamentosNoDia = true;
								
							}							
						}
					}
					
					//Se funcionario tem agendamentos marcados no dia, comparar o horário para ver se bloqueia ou não
					if ($funTemAgendamentosNoDia) {						
						foreach($agendamentosFuncionario as $horario) {
							
							$agendamentoCancelado = false;
							if (DateTime::createFromFormat('Y-m-d G:i:s', $horario['AGEN_DataCancelamento']) !== FALSE) {
								$agendamentoCancelado = true;
							}
							
							//Exemplo retorno: AGFU_HoraInicio: 13:30:00 e AGFU_HoraFim: 14:30:00
							//Se horário livre e/ou agendamento cancelado, libera horário
							if ($item['FUHB_Horario'] >= $horario['AGFU_HoraInicio'] and $item['FUHB_Horario'] < $horario['AGFU_HoraFim'] and $agendamentoCancelado == false) {
								$arrayJson[$key]['FUHB_HorarioBloqueado'] = "S";
								//echo "item[FUNC_ID]: " . $item['FUNC_ID'] . ", item[FUHB_Horario]: " . $item['FUHB_Horario'] . ", horario[AGFU_HoraInicio]: " . $horario['AGFU_HoraInicio'] . ", horario[AGFU_HoraFim]: " . $horario['AGFU_HoraFim'] . " <br />";
								//exit;
							}
						}						
					}
					
					$ultimoFuncionario = $item['FUNC_ID'];
					
				}
				
				//$out = array_values($arrayJson);
				echo json_encode($arrayJson);
				
			} else {
				echo '{ "resultado": "NAOENCONTRADO", "mensagem": "Ops! Nenhum profissional disponível. Acho que posso resolver isto pelo Whatsapp! ;) (71) 8879-1014" }';
				exit;
			}
		} else {
			echo '{ "resultado": "ERRO", "mensagem": "Ops! Não consuiguimos obter os profissionais e horários disponíveis. Entre em contato pelo Whatsapp (71) 8879-1014, ok? ;)" }';
			exit;
		}
		
		break;
	
	
	case "salvardadosusuario":
		
		//http://mariagata.com.br/sistema/mariagata.php?a=salvardadosusuario&nome=Lucas&cpf=80941818500&email=lucasrego@gmail.com&celular=7188145976
		
		$cpf = trim($_POST["cpf"]);
		$nome = trim($_POST["nome"]);
		$email = trim($_POST["email"]);
		$celular = trim($_POST["celular"]);
		
		if ($cpf != "") {
			// Verifica se o CPF ou CNPJ é válido
			$cpf_cnpj = new ValidaCPFCNPJ($cpf);
			if ( $cpf_cnpj->valida() == false) {
				echo '{ "resultado": "ERRO", "mensagem": "Ops! Parece que o CPF informado não é válido (' . $cpf . ')." }';
				exit;
			}
		}
	
		if ($email != "") {
			if ($email != filter_var($email, FILTER_VALIDATE_EMAIL)) {
				echo '{ "resultado": "ERRO", "mensagem": "Ops! Parece que o e-mail informado não é válido (' . $email . ')." }';
				exit;
			}
		}
		
		if (strlen($nome) <= 1) {
			echo '{ "resultado": "ERRO", "mensagem": "Ops! Revise o nome informado." }';
			exit;
		}
		
		if ((strlen($celular) != 10)&&(strlen($celular) != 11)) {
			echo '{ "resultado": "ERRO", "mensagem": "Ops! Revise o celular informado. Altere seu cadastro e tente novamente. Se ainda tiver problemas, nos falamos pelo Whatsapp (71) 8879-1014, ok? ;)" }';
			exit;
		}
		
		$db->TransactionBegin();
		
		//OBTER CLIENTE
		if ($cpf != "") {
			if ($db->Query("SELECT CLIE_ID FROM cliente where CLIE_CPF = " . $cpf)) {
				if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {
					
					$linha = $db->Row(0);
					$cliente = $linha->CLIE_ID;
					
					//UPDATE NOS DADOS DO CLIENTE
					$update_cliente["CLIE_Nome"]  = MySQL::SQLValue($nome); //Atualiza para perfil morador, pois se trata de um novo convite.
					$update_cliente["CLIE_Email"]  = MySQL::SQLValue($email);
					$update_cliente["CLIE_Celular"]  = MySQL::SQLValue($celular);
					$update_cliente["CLIE_DataUltimaAtualizacaoDados"]  = MySQL::SQLValue($lsDataHoraAtual);
					if (! $db->UpdateRows("cliente", $update_cliente, array("CLIE_ID" => $cliente))) {
						$db->TransactionRollback();
						$db->Kill();
						echo '{ "resultado": "ERRO", "mensagem": "Ops! Não conseguimos salvar seus dados [0]. Entre em contato pelo Whatsapp (71) 8879-1014, ok? ;)" }';
						exit;
					}
					
					$db->TransactionEnd(); //Commit
					echo '{ "resultado": "SUCESSO", "mensagem": "' . $cliente . '"}';
					exit;
					
				} else {
					//INSERE CLIENTE
					$cliente["CLIE_CPF"]  = MySQL::SQLValue($cpf, MySQL::SQLVALUE_NUMBER);
					$cliente["CLIE_Nome"]  = MySQL::SQLValue($nome);
					$cliente["CLIE_Email"]  = MySQL::SQLValue($email);
					$cliente["CLIE_Celular"] = MySQL::SQLValue($celular);
					$cliente["CLIE_DataCadastro"] = MySQL::SQLValue($lsDataHoraAtual);
					
					$resultado_cliente = $db->InsertRow("cliente", $cliente);
					if (! $resultado_cliente) {
						$db->TransactionRollback();
						$db->Kill();
						echo '{ "resultado": "ERRO", "mensagem": "Ops! Não conseguimos salvar seus dados [1]. Entre em contato pelo Whatsapp (71) 8879-1014, ok? ;)" }';
						exit;
					}
					
					$db->TransactionEnd(); //Commit
					echo '{ "resultado": "SUCESSO", "mensagem": "' . $resultado_cliente . '"}';
					exit;					
				}
			} else {
				$db->TransactionRollback();
				$db->Kill();
				echo '{ "resultado": "ERRO", "mensagem": "Ops! Tivemos um problema técnico e não conseguimos agendar seu momento [5]! Tente pelo Whatsapp (71) 8879-1014" }';
				exit;			
			}
		} else { //Fim if se cpf possui valro
			
			//INSERE CLIENTE SEM CPF
			$cliente["CLIE_CPF"]  = MySQL::SQLValue("");
			$cliente["CLIE_Nome"]  = MySQL::SQLValue($nome);
			$cliente["CLIE_Email"]  = MySQL::SQLValue($email);
			$cliente["CLIE_Celular"] = MySQL::SQLValue($celular);
			$cliente["CLIE_DataCadastro"] = MySQL::SQLValue($lsDataHoraAtual);
			
			$resultado_cliente = $db->InsertRow("cliente", $cliente);
			if (! $resultado_cliente) {
				$db->TransactionRollback();
				$db->Kill();
				echo '{ "resultado": "ERRO", "mensagem": "Ops! Não conseguimos salvar os dados [8]." }';
				exit;
			}
			
			$db->TransactionEnd(); //Commit
			echo '{ "resultado": "SUCESSO", "mensagem": "' . $resultado_cliente . '"}';
			exit;
		}
		break;
		
	case "obteragendamentos":
		
		//http://mariagata.com.br/sistema/mariagata.php?a=obteragendamentos&filial=1
				
		$filial = $_POST["filial"];
		
		if (isset($_POST["funcionario"])) {
			$funcionario = $_POST["funcionario"];
			if ($funcionario == "") {
				$queryFuncionario = "";				
			} else {
				$queryFuncionario = " and af.FUNC_ID = " . $funcionario;
				//$queryFuncionario = " and a.AGEN_ID in (select AGEN_ID from agendamento_funcionario where FUNC_ID = " . $funcionario . ") ";
			}
			
		} else {
			$funcionario = "";
			$queryFuncionario = "";
		}		
		
		$sql_query = "
				select 
					AGEN_ID as id,
					color,
					CONCAT(CLIE_Nome, ' (', GROUP_CONCAT(FUNC_Nome SEPARATOR ' e '), ') [', AGEN_ID, ']') as title,
					CONCAT(GROUP_CONCAT(FUNC_Nome SEPARATOR ' e '), ' (', GROUP_CONCAT(DATE_FORMAT(start ,'%H:%i') SEPARATOR ' e '), ')') as funcionarios,
					min(start) as start,
					max(end) as end,
					dataAgendamento,
					dataCriacao,
					nomeCliente,
					celularCliente,
					horaInicio
				from
					(
						SELECT 
							a.AGEN_ID,
							CASE MOD(f.FUNC_ID,9) WHEN 0 THEN '#7D9D0B' WHEN 1 THEN '#1EA994' WHEN 2 THEN '#2985F0' WHEN 3 THEN '#EC2D2D' WHEN 4 THEN '#000000' WHEN 5 THEN '#F02972' WHEN 6 THEN '#7C29F0' WHEN 6 THEN '#CEB517' ELSE '#F0830E' END as color,
							CLIE_Nome,
							FUNC_Nome,
							AGFU_HoraInicio as start,
							AGFU_HoraFim as end,
							DATE_FORMAT(AGEN_Data,'%d/%m/%Y') as dataAgendamento,
							AGEN_DataCriacao as dataCriacao,
							c.CLIE_Nome as nomeCliente,
							c.CLIE_Celular as celularCliente,
							DATE_FORMAT(AGFU_HoraInicio,'%H:%i') as horaInicio
						FROM 
							agendamento a, cliente c, agendamento_funcionario af, funcionario f
						where
							a.FILI_ID = " . $filial . "
							and a.AGEN_ID = af.AGEN_ID
							" . $queryFuncionario . "
							and a.CLIE_ID = c.CLIE_ID
							and af.FUNC_ID = f.FUNC_ID
							and AGEN_Situacao = 'A'
					) a
				group by a.AGEN_ID
				";
		
		//echo $sql_query;
		//exit;
				
		//Obtem agendamentos para uma filial ou filial+funcionário
		if ($db->Query($sql_query)) {
			echo $db->GetJSON();
			//Propriedades do evento: color,title (Nome do espaço), start, end, dataEvento, horaInicioPrevisto, idReserva, dataCriacao, nomeReservadoPara
		} else {
			echo "erro";
		}
		
		break;
		
		
	case "confirmaragendamento":
		
		//http://mariagata.com.br/sistema/mariagata.php?a=confirmaragendamento&cpf=80941818500&filial=1&data=2015-06-13&servicos=7&funcionarioEsmalteria=1&horarioEsmalteria=09:00&funcionarioEscovaria=4&horarioEscovaria=14:00
		
		if (isset($_POST["cliente"])) {
			$cliente = $_POST["cliente"];
		} else {
			if (isset($_POST["cpf"])) {
				$cpf = $_POST["cpf"];
				
				// Verifica se o CPF ou CNPJ é válido
				$cpf_cnpj = new ValidaCPFCNPJ($cpf);
				if ( $cpf_cnpj->valida() == false) {
					echo '{ "resultado": "ERRO", "mensagem": "Ops! Parece que o CPF informado não está válido (' . $cpf . '). Altere seus dados e tente novamente. Se ainda tiver problemas, nos falamos pelo Whatsapp (71) 8879-1014, ok? ;)" }';
					exit;
				}
				
				//OBTER CLIENTE
				if ($db->Query("SELECT CLIE_ID FROM cliente where CLIE_CPF = " . $cpf)) {
					if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {				
						$linha = $db->Row(0);
						$cliente = $linha->CLIE_ID;								
					} else {
						$db->Kill();
						echo '{ "resultado": "ERRO", "mensagem": "Não encontramos o seu CPF no cadastro Maria Gata. Preencha novamente seu dados na tela de cadastro e tente novamente." }';
						exit;
					}
				} else {
					$db->Kill();
					echo '{ "resultado": "ERRO", "mensagem": "Ops! Tivemos um problema técnico e não conseguimos agendar seu momento [5]! Tente pelo Whatsapp (71) 8879-1014" }';
					exit;
				}
			} else {
				echo '{ "resultado": "ERRO", "mensagem": "Ops! Não identificamos um identificador de cliente ou CPF." }';
				exit;
			}
		}
		
		$filial = $_POST["filial"];
		$data = $_POST["data"];
		$servicos = $_POST["servicos"];
		
		if (isset($_POST["funcionarioEsmalteria"])) {
			$funcionarioEsmalteria = $_POST["funcionarioEsmalteria"];
		} else {
			$funcionarioEsmalteria = "";
		}
		
		if (isset($_POST["horarioEsmalteria"])) {
			$horarioEsmalteria = $_POST["horarioEsmalteria"];
		} else {
			$horarioEsmalteria = "";
		}
		
		if (isset($_POST["funcionarioEscovaria"])) {
			$funcionarioEscovaria = $_POST["funcionarioEscovaria"];
		} else {
			$funcionarioEscovaria = "";
		}
		
		if (isset($_POST["horarioEscovaria"])) {
			$horarioEscovaria = $_POST["horarioEscovaria"];
		} else {
			$horarioEscovaria = "";
		}
		
		//TRATAR E VALIDAR PARÂMETROS
		$servicosVirgula = str_replace("|", ",", $servicos);
		$laServicos = explode(",", $servicos);
		
		//INSERE NA AGENDA DO GOOGLE CALENDAR
		//https://developers.google.com/google-apps/calendar/v3/reference/events/insert
		
		/*
		$credentials = new Google_Auth_AssertionCredentials(
			$client_email,
			$scopes,
			$private_key
		);		
		$client = new Google_Client();
		$client->setAssertionCredentials($credentials);
		if ($client->getAuth()->isAccessTokenExpired()) {
		  $client->getAuth()->refreshTokenWithAssertion();
		}						
		$calendarService = new Google_Service_Calendar($client);
		
		$event = new Google_Service_Calendar_Event(array(
			'summary' => 'resumo do evento Maria Gata',
			'location' => 'Alameda Benevento, 20, Salvador, Bahia, 41830595',
			'description' => 'descricao evento',
			'start' => array(
				'dateTime' => '2015-06-11T10:00:00-07:00',
				'timeZone' => 'America/Recife',
			),
			'end' => array(
				'dateTime' => '2015-06-11T11:00:00-07:00',
				'timeZone' => 'America/Recife',
			),
		));

		$eventoCriado = $calendarService->events->insert($calendarId, $event);
		*/
		
		//INSERIR AGENDAMENTO
		$db->TransactionBegin();
		
		//Define o menor horário dos servicos para formar a data do agendamento
		if (trim($horarioEsmalteria) != "") {
			$dataHoraAgendamento = $horarioEsmalteria;
			if (trim($horarioEscovaria) != "") {
				if ($horarioEscovaria < $horarioEsmalteria) {
					$dataHoraAgendamento = $horarioEscovaria;
				}
			}
		} else {
			$dataHoraAgendamento = $horarioEscovaria;
		}
		
		$dataHoraAgendamento = $data . " " . $dataHoraAgendamento . ":00";
		
		$agendamento["AGEN_Data"]  = MySQL::SQLValue($dataHoraAgendamento);
		$agendamento["CLIE_ID"]  = MySQL::SQLValue($cliente, MySQL::SQLVALUE_NUMBER);
		$agendamento["FILI_ID"]  = MySQL::SQLValue($filial, MySQL::SQLVALUE_NUMBER);
		$agendamento["AGEN_DataCriacao"] = MySQL::SQLValue($lsDataHoraAtual);
		$agendamento["AGEN_Situacao"] = MySQL::SQLValue('A');
		$agendamento["AGEN_GoogleCalendar"] = MySQL::SQLValue("");
				
		$resultado_agendamento = $db->InsertRow("agendamento", $agendamento);
		
		if (! $resultado_agendamento) {
			//deletarEventoGoogleCalendar($eventoCriado->id);
			$db->TransactionRollback();
			$db->Kill();
			echo '{ "resultado": "ERRO", "mensagem": "Ops! Não consuiguimos processar seu pedido [1]. Entre em contato pelo Whatsapp (71) 8879-1014, ok? ;)" }';
			exit;
		} else {
			
			foreach ($laServicos as &$idservico) {
				
				//INSERE AGENDAMENTO_SERVICOS
				$agendamento_servicos["AGEN_ID"]  = MySQL::SQLValue($resultado_agendamento, MySQL::SQLVALUE_NUMBER);
				$agendamento_servicos["SERV_ID"]  = MySQL::SQLValue($idservico, MySQL::SQLVALUE_NUMBER);
				
				$resultado_agendamento_servicos = $db->InsertRow("agendamento_servicos", $agendamento_servicos);
				if (! $resultado_agendamento_servicos) {
					//deletarEventoGoogleCalendar($eventoCriado->id);
					$db->TransactionRollback();
					$db->Kill();
					echo '{ "resultado": "ERRO", "mensagem": "Ops! Não consuiguimos processar seu pedido [2]. Entre em contato pelo Whatsapp (71) 8879-1014, ok? ;)" }';
					exit;
				}
				
			}
			
			//INSERE AGENDAMENTO_FUNCIONARIO (ESMALTERIA E ESCOVARIA)
			
			//ESMALTERIA
			if ($funcionarioEsmalteria != "") {				
				
				//Obtem o tempo de execucao dos servicos para calcular o horário final de alocação do funcionário
				if ($db->Query("SELECT SUM(SEGS_Duracao) as duracao FROM servico_grupo_servico where SERV_ID in (" . $servicosVirgula . ") and GSER_ID = 1 group by GSER_ID")) {
					if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {
						
						$linha = $db->Row(0);
						$duracao = $linha->duracao;
						
						//$horarioFinalEsmalteria = $horarioEsmalteria + $duracao; Ex: 09:30 + 120 min
						$horarioFinalEsmalteria = date("H:i", strtotime('+' . $duracao . ' minutes', strtotime($horarioEsmalteria)));  //11:30

						//Valida se o horário final invade um horário futuro já reservado				
						$sql_query = "
								SELECT 
									DATE_FORMAT(AGFU_HoraInicio,'%Y-%m-%d') as data, DATE_FORMAT(AGFU_HoraInicio,'%H:%i') as hora 
								FROM 
									agendamento_funcionario
								where 
									FUNC_ID = " . $funcionarioEsmalteria . "
									and '" . $data . "' = DATE_FORMAT(AGFU_HoraInicio,'%Y-%m-%d')
									and '" . $horarioEsmalteria . "' < DATE_FORMAT(AGFU_HoraFim,'%H:%i')
									and '" . $horarioFinalEsmalteria . "' > DATE_FORMAT(AGFU_HoraInicio,'%H:%i')
								";
						
						if ($db->Query($sql_query)) {
							if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {
								//deletarEventoGoogleCalendar($eventoCriado->id);
								echo '{ "resultado": "ERRO", "mensagem": "A duração estimada do(s) serviço(s) de Manicure que você escolheu (' . $duracao . ' min) invade o horário do próximo cliente. Diminua a quantidade de serviços ou escolha outro horário, ok? [' . $data . ' ' . $horarioEsmalteria . ' a ' . $horarioFinalEsmalteria . ']"}';
								exit;
							}
						} else {
							//deletarEventoGoogleCalendar($eventoCriado->id);
							echo '{ "resultado": "ERRO", "mensagem": "Ops! Por um problema técnico não conseguimos agendar o seu momento [6]. Falsmos pelo Whatsapp 8879-1014, ok?" }';
							exit;
						}
						
						$agendamento_funcionario_esmalteria["AGEN_ID"]  = MySQL::SQLValue($resultado_agendamento, MySQL::SQLVALUE_NUMBER);
						$agendamento_funcionario_esmalteria["FUNC_ID"]  = MySQL::SQLValue($funcionarioEsmalteria, MySQL::SQLVALUE_NUMBER);
						$agendamento_funcionario_esmalteria["AGFU_HoraInicio"]  = MySQL::SQLValue($data . " " . $horarioEsmalteria);
						$agendamento_funcionario_esmalteria["AGFU_HoraFim"] = MySQL::SQLValue($data . " " . $horarioFinalEsmalteria);
						
						$resultado_agendamento_funcionario_esmalteria = $db->InsertRow("agendamento_funcionario", $agendamento_funcionario_esmalteria);
						if (! $resultado_agendamento_funcionario_esmalteria) {
							//deletarEventoGoogleCalendar($eventoCriado->id);
							$db->TransactionRollback();
							$db->Kill();
							echo '{ "resultado": "ERRO", "mensagem": "Ops! Não consuiguimos processar seu pedido [4]. Entre em contato pelo Whatsapp (71) 8879-1014, ok? ;)" }';
							exit;
						}
						
					} else {
						//deletarEventoGoogleCalendar($eventoCriado->id);
						echo '{ "resultado": "ERRO", "mensagem": "Ops! Tivemos um problema técnico e não conseguimos agendar seu momento [0]! Tente pelo Whatsapp (71) 8879-1014" }';
						exit;
					}
				} else {
					//deletarEventoGoogleCalendar($eventoCriado->id);
					echo '{ "resultado": "ERRO", "mensagem": "Ops! Tivemos um problema técnico e não conseguimos agendar seu momento [1]! Tente pelo Whatsapp (71) 8879-1014" }';
					exit;			
				}
								
			}
			
			//ESCOVARIA
			if ($funcionarioEscovaria != "") {
				
				//Obtem o tempo de execucao dos servicos para calcular o horário final de alocação do funcionário
				if ($db->Query("SELECT SUM(SEGS_Duracao) as duracao FROM servico_grupo_servico where SERV_ID in (" . $servicosVirgula . ") and GSER_ID = 2 group by GSER_ID")) {
					if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {
						
						$linha = $db->Row(0);
						$duracao = $linha->duracao;
						
						//$horarioFinalEscovaria = $horarioEscovaria + $duracao; Ex: 09:30 + 120 min
						$horarioFinalEscovaria = date("H:i", strtotime('+' . $duracao . ' minutes', strtotime($horarioEscovaria)));
						
						//Valida se o horário final invade um horário futuro já reservado				
						$sql_query = "
								SELECT 
									DATE_FORMAT(AGFU_HoraInicio,'%Y-%m-%d') as data, DATE_FORMAT(AGFU_HoraInicio,'%H:%i') as hora 
								FROM 
									agendamento_funcionario
								where 
									FUNC_ID = " . $funcionarioEscovaria . "
									and '" . $data . "' = DATE_FORMAT(AGFU_HoraInicio,'%Y-%m-%d')
									and '" . $horarioEscovaria . "' < DATE_FORMAT(AGFU_HoraFim,'%H:%i')
									and '" . $horarioFinalEscovaria . "' > DATE_FORMAT(AGFU_HoraInicio,'%H:%i')
								";
						
						if ($db->Query($sql_query)) {
							if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {
								//deletarEventoGoogleCalendar($eventoCriado->id);
								echo '{ "resultado": "ERRO", "mensagem": "A duração estimada do(s) serviço(s) de Cabelo ou Estética que você escolheu (' . $duracao . ' min) invade o horário do próximo cliente. Diminua a quantidade de serviços ou escolha outro horário, ok? [' . $data . ' ' . $horarioEscovaria . ' a ' . $horarioFinalEscovaria . ']"}';
								exit;
							}
						} else {
							//deletarEventoGoogleCalendar($eventoCriado->id);
							echo '{ "resultado": "ERRO", "mensagem": "Ops! Por um problema técnico não conseguimos agendar o seu momento [7]. Falsmos pelo Whatsapp 8879-1014, ok?" }';
							exit;
						}
						
						$agendamento_funcionario_escovaria["AGEN_ID"]  = MySQL::SQLValue($resultado_agendamento, MySQL::SQLVALUE_NUMBER);
						$agendamento_funcionario_escovaria["FUNC_ID"]  = MySQL::SQLValue($funcionarioEscovaria, MySQL::SQLVALUE_NUMBER);
						$agendamento_funcionario_escovaria["AGFU_HoraInicio"]  = MySQL::SQLValue($data . " " . $horarioEscovaria);
						$agendamento_funcionario_escovaria["AGFU_HoraFim"] = MySQL::SQLValue($data . " " . $horarioFinalEscovaria);
						
						$resultado_agendamento_funcionario_escovaria = $db->InsertRow("agendamento_funcionario", $agendamento_funcionario_escovaria);
						if (! $resultado_agendamento_funcionario_escovaria) {
							//deletarEventoGoogleCalendar($eventoCriado->id);
							$db->TransactionRollback();
							$db->Kill();
							echo '{ "resultado": "ERRO", "mensagem": "Ops! Não consuiguimos processar seu pedido [4]. Entre em contato pelo Whatsapp (71) 8879-1014, ok? ;)" }';
							exit;
						}
						
					} else {
						//deletarEventoGoogleCalendar($eventoCriado->id);
						echo '{ "resultado": "ERRO", "mensagem": "Ops! Tivemos um problema técnico e não conseguimos agendar seu momento [2]! Tente pelo Whatsapp (71) 8879-1014" }';
						exit;
					}
				} else {
					//deletarEventoGoogleCalendar($eventoCriado->id);
					echo '{ "resultado": "ERRO", "mensagem": "Ops! Tivemos um problema técnico e não conseguimos agendar seu momento [3]! Tente pelo Whatsapp (71) 8879-1014" }';
					exit;			
				}
			}
			
			$db->TransactionEnd(); //Commit
			//$diasSemana = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
			$dataExibicao = date("d/m/Y", strtotime($data)); //Ex: 03/06/2015
			//$dataExibicao = $dataExibicao . " (" . $diasSemana[date("w", $data)] . ")"; // <- Não está calculado o dia da semana corretamente
			echo '{ "resultado": "SUCESSO", "mensagem": "Agendamento confirmado! Nos vemos na Maria Gata em ' . $dataExibicao . '"}';
			//$db->TransactionRollback();
			//$db->Kill();
			exit;
			
		}
						
		
		//echo '{ "resultado": "NAOENCONTRADO", "mensagem": "' . $nome . ' - ' . $email . ' - ' . $data . ' - ' . $filial . ' - ' . $celular . ' - ' . $servicos . ' - ' . $funcionarioEsmalteria . ' - ' . $horarioEsmalteria . ' - ' . $funcionarioEscovaria . ' - ' . $horarioEscovaria . '"}';
				
		break;
		
}

?>