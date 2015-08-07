<?php
include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");
include("includes/util/util.php");
include("includes/util/class-valida-cpf-cnpj.php");

date_default_timezone_set('America/Recife');
$lsDataHoraAtual = date("Y-m-d H:i:s");
$lsDataAtual = date("Y-m-d");

$acao = $_POST["a"];


function validarData($data)
{
    $d = DateTime::createFromFormat('Y-m-d', $data);
    return $d && $d->format('Y-m-d') == $data;
}


switch ($acao) {
	
	case "vendasAgrupadasPorDia":
	
		//http://mariagata.com.br/sistema/mariagata.php?a=vendasAgrupadasPorDia&filial=1&inicio=20150701&fim=20150731
		
		$filial = $_POST["filial"];
		$inicio = $_POST["inicio"];
		$fim = $_POST["fim"];
		
		$sql_query = "SELECT 
							DATE_FORMAT(ATEN_DataAtendimento,'%d/%m') as dataAtendimento,
							SUM(APAG_ValorPago) as valor
						FROM
							atendimento a,
							atendimento_pagamento atp,
							forma_pagamento fp
						WHERE
							a.ATEN_ID = atp.ATEN_ID
							and atp.FPAG_ID = fp.FPAG_ID
							and ATEN_DataAtendimento >= '" . $inicio . "'
							and ATEN_DataAtendimento <= '" . $fim . "'
							and ATEN_Status = 'P'
							and a.FILI_ID = " . $filial . "
						GROUP BY DATE_FORMAT(ATEN_DataAtendimento,'%d/%m')
						";
		
		//echo $sql_query;
		//exit;
		
		if ($db->Query($sql_query)) {
			if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {
				echo $db->GetJSON();
			} else {
				echo '{ "resultado": "NAOENCONTRADO", "mensagem": "Nenhum atendimento encontrado para o período."}';
				exit;
			}
		} else {
			echo '{ "resultado": "ERRO", "mensagem": "Ops! Não conseguimos obter os dados para o período."}';
			exit;			
		}
		
		break;
	
	
	case "vendasAgrupadasPorTipoPagamento":
	
		//http://mariagata.com.br/sistema/mariagata.php?a=vendasAgrupadasPorTipoPagamento&filial=1&inicio=20150701&fim=20150731
		
		$filial = $_POST["filial"];
		$inicio = $_POST["inicio"];
		$fim = $_POST["fim"];
		
		$sql_query = "SELECT 
							atp.FPAG_ID,
							FPAG_Nome,
							SUM(APAG_ValorPago) as valor
						FROM
							atendimento a,
							atendimento_pagamento atp,
							forma_pagamento fp
						WHERE
							a.ATEN_ID = atp.ATEN_ID
							and atp.FPAG_ID = fp.FPAG_ID
							and ATEN_DataAtendimento >= '" . $inicio . "'
							and ATEN_DataAtendimento <= '" . $fim . "'
							and ATEN_Status = 'P'
							and a.FILI_ID = " . $filial . "
						GROUP BY FPAG_ID
						";
		
		//echo $sql_query;
		//exit;
		
		if ($db->Query($sql_query)) {
			if (($db->RowCount() >= 0) and ($db->RowCount() != "")) {
				echo $db->GetJSON();
			} else {
				echo '{ "resultado": "NAOENCONTRADO", "mensagem": "Nenhum atendimento encontrado para o período."}';
				exit;
			}
		} else {
			echo '{ "resultado": "ERRO", "mensagem": "Ops! Não conseguimos obter os dados para o período."}';
			exit;			
		}
		
		break;
		
}

?>