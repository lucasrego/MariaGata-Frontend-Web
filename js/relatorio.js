function exibirRelatorioComissoes(filial, inicio, fim) {
	//inicio e fim no formato: YYYYMMDD
	$.ajax({
		url: urlBackend,
		type: 'POST',
		data: {
			a: 'obterrelatoriocomissoes',
			filial: filial,
			inicio: inicio,
			fim: fim
		},
		context: document.body		
	})
	.always(function() {		
	})
	.fail(function(jqXHR, textStatus, errorThrown) {
		exibirMensagem('Maria Gata', 'Desculpe! Ocorreu um erro inesperado.');
	})
	.done(function(ret) {
		
		//Teste se o objeto retornao é JSON, ou seja, existem dados
		var jsonRetorno = jQuery.parseJSON(ret);
		var lsHTML = "";
		var ultimoFuncionario = "";
		var totalItens = jsonRetorno.length;
		var valorComissaoItem = 0;
		var somaComissaoFuncionario = 0;
		var somaServicosFuncionario = 0;
		
		if (typeof jsonRetorno.resultado === "undefined") {				
			$.each(jsonRetorno, function( index, value ) {
				
				//Retorno: ATEN_ID, ATEN_DataAtendimento,SERV_Nome,SERV_Tipo,ASER_ValorCobrado,
				//FUNC_ID,FUNC_Nome,FUNC_Especialidade,FUNC_ComissaoServico,FUNC_ComissaoProduto							
				
				if (value.FUNC_ID != ultimoFuncionario) {
					
					if (index != 0) {
						//Se não for o primeiro registro, fecha o anterior
						lsHTML += "						<tr>";
						lsHTML += "					<td></td>";
						lsHTML += "					<td></td>";
						lsHTML += "					<td></td>";
						lsHTML += "					<td class='right'><strong>" + somaServicosFuncionario.toFixed(2).replace('.',',') + "</strong></td>";
						lsHTML += "					<td></td>";
						lsHTML += "					<td class='right'><span class='green font-size-17'><strong>" + somaComissaoFuncionario.toFixed(2).replace('.',',') + "</strong></span></td>";
						lsHTML += "				</tr>";
						lsHTML += "			</tbody>";
						lsHTML += "		</table>";
						lsHTML += "	</div>";
						lsHTML += "</div>";
					}
					
					somaComissaoFuncionario = 0;
					somaServicosFuncionario = 0;
				
					lsHTML += "<br />";
					
					lsHTML += "<div class='invoice'>";
					lsHTML += "	<div class='row'>";
					lsHTML += "		<div class='col-md-12'>";
					lsHTML += "			<h2>" + value.FUNC_Nome + "</h2>";
					lsHTML += "		</div>";
					lsHTML += "	</div>";
					lsHTML += "	<div class='table-responsive'>";
					lsHTML += "		<table class='table table-striped table-bordered table-condensed'>";
					lsHTML += "			<thead>";
					lsHTML += "				<tr>";
					lsHTML += "					<th class='center'>#</th>";
					lsHTML += "					<th>Data</th>";
					lsHTML += "					<th>Serviço/Produto</th>";
					lsHTML += "					<th>Valor Serviço</th>";
					lsHTML += "					<th>Comissão</th>";
					lsHTML += "					<th>Valor Comissão</th>";
					lsHTML += "				</tr>";
					lsHTML += "			</thead>";
					lsHTML += "			<tbody>";
															
				}

				//Insere nova linha
				lsHTML += "<tr>";
				lsHTML += "	<td class='center'>" + value.ATEN_ID + "</td>";
				lsHTML += "	<td>" + value.ATEN_DataAtendimento + "</td>";
				lsHTML += "	<td>" + value.SERV_Nome + "</td>";
				lsHTML += "	<td>" + value.ASER_ValorCobrado.replace('.',',') + "</td>";
				
				if (value.SERV_Tipo == 'PR') {
					lsHTML += "	<td>" + value.FUNC_ComissaoProduto + "%</td>";
					valorComissaoItem = parseFloat(value.FUNC_ComissaoProduto) * value.ASER_ValorCobrado / 100;
				} else {
					lsHTML += "	<td>" + value.FUNC_ComissaoServico + "%</td>";
					valorComissaoItem = parseFloat(value.FUNC_ComissaoServico) * value.ASER_ValorCobrado / 100;
				}
				lsHTML += "	<td>" + valorComissaoItem.toFixed(2).replace('.',',') + "</td>";
				lsHTML += "</tr>";
				
				somaComissaoFuncionario += parseFloat(valorComissaoItem);
				somaServicosFuncionario += parseFloat(value.ASER_ValorCobrado);
					
				if (index == totalItens - 1) {
					//Se ultimo registro, fecha o grupo
					lsHTML += "						<tr>";
					lsHTML += "					<td></td>";
					lsHTML += "					<td></td>";
					lsHTML += "					<td></td>";
					lsHTML += "					<td class='right'><strong>" + somaServicosFuncionario.toFixed(2).replace('.',',') + "</strong></td>";
					lsHTML += "					<td></td>";
					lsHTML += "					<td class='right'><span class='green font-size-17'><strong>" + somaComissaoFuncionario.toFixed(2).replace('.',',') + "</strong></span></td>";
					lsHTML += "				</tr>";
					lsHTML += "			</tbody>";
					lsHTML += "		</table>";
					lsHTML += "	</div>";
					lsHTML += "</div>";
				}
				
				ultimoFuncionario = value.FUNC_ID;
				
			}); //Fim each
			
			$('#corpoRelatorio').append(lsHTML);
			
		} else {
			exibirMensagem('Maria Gata', jsonRetorno.mensagem);	
		} //Fim teste jsonRetorno.resultado
				
	}); //Fim ajax
	
}

var d = new Date();
d.setDate( d.getDate() + i );

var dias = ["Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sábado"];
dia = d.getDay(); //0=dom, 1=seg, 2=ter, 3=qua, 4=qui, 5=sex, 6=sab
nome_dia = dias[dia];

var meses = ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"];
mes = d.getMonth(); //0=Janeiro, 1=Fevereiro, 11=Dezembro
nome_mes_atual = meses[mes];
if (mes == 0) {
	nome_mes_anterior = meses[12];
} else {
	nome_mes_anterior = meses[parseInt(mes)-1];
}

alert(nome_mes_atual = " - " + nome_mes_anterior);

//data_id = d.getFullYear() + "/" + mes + "/" + d.getDate();
//data_exibicao = d.getDate() + "/" + mes + "/" + d.getFullYear() + " (" + nome_dia + ")";

$('.date-range').daterangepicker({
    "showDropdowns": true,
    "timePickerIncrement": 1,
    "ranges": {
        "Last 7 Days": [
            "2015-07-18T17:19:23.261Z",
            "2015-07-24T17:19:23.261Z"
        ],
        "Last 30 Days": [
            "2015-06-25T17:19:23.261Z",
            "2015-07-24T17:19:23.261Z"
        ],
        "This Month": [
            "2015-07-01T03:00:00.000Z",
            "2015-08-01T02:59:59.999Z"
        ],
        "Last Month": [
            "2015-06-01T03:00:00.000Z",
            "2015-07-01T02:59:59.999Z"
        ]
    },
    "startDate": "07/01/2015",
    "endDate": "07/15/2015",
    "opens": "left",
    "drops": "down",
    "buttonClasses": "btn btn-sm",
    "applyClass": "btn-success",
    "cancelClass": "btn-default"
}, function(start, end, label) {
	$('#periodoSelecionado').text(start.format('DD/MM/YYYY') + ' a ' + end.format('DD/MM/YYYY'));
	exibirRelatorioComissoes(1, start.format('YYYYMMDD'), end.format('YYYYMMDD'));
});


$('#btnImprimir').click(function (e) {
	$('.relatoriocompleto').print();
});

