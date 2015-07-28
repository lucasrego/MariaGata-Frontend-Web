function exibirRelatorioComissoes(filial, inicio, fim) {
	
	//Limpa dados atuais do relatório
	$('#corpoRelatorio').html("");
	
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
					
					//Adiciona page break print a partir do segundo elemento. Incluir impressao.css
					if (index != 0) {
						lsHTML += "<div class='page-break'></div>";
					}
					
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


$('.date-range').daterangepicker({
    "timePickerIncrement": 1,
	 "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "De",
        "toLabel": "Para",
        "customRangeLabel": "Escolher",
        "daysOfWeek": [
            "Do",
            "Se",
            "Te",
            "Qa",
            "Qi",
            "Se",
            "Sa"
        ],
        "monthNames": [
            "Janeiro",
            "Fevereiro",
            "Março",
            "Abril",
            "Maio",
            "Junho",
            "Julho",
            "Agosto",
            "Setembro",
            "Outubro",
            "Novembro",
            "Dezembro"
        ],
        "firstDay": 1
    },
    "ranges": {
        "Este Mês": [
            moment().startOf("month"),
            moment().endOf("month")
        ],
        "Mês Anterior": [
            moment().subtract(1, 'M').startOf("month"),
            moment().subtract(1, 'M').endOf("month")
        ],
        "Últimos 6 Meses": [
            moment().subtract(5, 'M').startOf("month"),
            moment().endOf("month")
        ]
    },
	//"startDate": moment().startOf("month").format('DD/MM/YYYY'),
	//"endDate": moment().endOf("month").format('DD/MM/YYYY'),
	"opens": "left",
    "drops": "down",
    "buttonClasses": "btn btn-sm",
    "applyClass": "btn-success",
    "cancelClass": "btn-default"
}, function(start, end, label) {
	$('#periodoSelecionado').text(start.format('DD/MM/YYYY') + ' a ' + end.format('DD/MM/YYYY'));
	$('#dataGeracao').text("Gerado em: " + moment().format("DD/MM/YYYY HH:mm:ss"));
	exibirRelatorioComissoes(1, start.format('YYYYMMDD'), end.format('YYYYMMDD'));
});


$('#btnImprimir').click(function (e) {
	$('.relatoriocompleto').print();
});

