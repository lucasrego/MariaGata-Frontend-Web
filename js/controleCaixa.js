$(function() {

	$('.campoMoeda').priceFormat({
		prefix: '',
		centsSeparator: ',',
		thousandsSeparator: '.',
		limit: 6
	});

	function atualizarPriceFormat(objeto) {
		objeto.priceFormat({
			prefix: '',
			centsSeparator: ',',
			thousandsSeparator: '.',
			limit: 6
		});
	}
	
	function obterValorPriceFormatSemMascara(objeto) {
		var valor = objeto.unmask();
		if (valor == "") {
			return parseInt(0);
		} else {
			return parseInt(valor);
		}
	}
	
	$('#btnIncluir').click(function (e) {
		inserirCaixa();
	});
	
	if (jQuery().datepicker) {
        $('.date-picker').datepicker();
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


	function carregarCaixa() {
		
		$.ajax({
			url: urlBackend,
			type: 'POST',
			data: {
				a: 'obtercaixadia'
			},
			context: document.body
		})
		.always(function() {		
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			exibirMensagem('Maria Gata', 'Desculpe! Ocorreu um erro inesperado.');
		})
		.done(function(ret) {
			
			var jsonRetorno = jQuery.parseJSON(ret);
			var lsHTML = "";
			var saldohoje = 0;
			var saldoanterior = 0;
			
			//Se o JSON não tiver a opção resultado é porque 1 ou mais condomínios foram retornados
			if (typeof jsonRetorno.resultado === 'undefined') {
				
				divRegistros = $('#tabelaCaixa');
				
				lsHTML += "<div class='table-responsive'>";
				lsHTML += "		<table class='table table-striped table-hover fill-head'>";
				lsHTML += "			<thead>";
				lsHTML += "				<tr>";
				lsHTML += "					<th>Hora</th>";
				lsHTML += "					<th>Descrição</th>";
				lsHTML += "					<th>Entrada</th>";
				lsHTML += "					<th>Saída</th>";
				lsHTML += "				</tr>";
				lsHTML += "			</thead>";
				lsHTML += "			<tbody>";
				
				$.each(jsonRetorno, function( index, value ) {
					
					if (index == 0) {
						saldoanterior = value.saldoanterior;
						saldohoje = parseFloat(value.saldoanterior);
						$('#saldoanterior').html("R$ " + saldoanterior + " (" + value.dataultimocaixa + ")");
					}
					
					if (value.CAIX_Tipo == 'E') {
						lsHTML += "<tr class='table-flag-blue'>";
					} else {
						lsHTML += "<tr class='table-flag-red'>";
					}
					lsHTML += "	<td>" + value.CAIX_Hora + "</td>";
					lsHTML += "	<td><a href='#'>" + value.CAIX_Descricao + "</a></td>";
					
					if (value.CAIX_Tipo == 'E') {
						lsHTML += "	<td><span class='label label-large label-success'>" + value.CAIX_Valor + "</span></td>";
						lsHTML += "	<td></td>";
						saldohoje = saldohoje + parseFloat(value.CAIX_Valor);
					} else {
						lsHTML += "	<td></td>";
						lsHTML += "	<td><span class='label label-large label-important'>" + value.CAIX_Valor + "</span></td>";
						saldohoje = saldohoje - parseFloat(value.CAIX_Valor);
					}
					
					lsHTML += "</tr>";
								
				});
				
				lsHTML += "		</tbody>";
				lsHTML += "	</table>";
				lsHTML += "</div>	";
				
				$('#tabelaCaixa').append(lsHTML);
				$('#saldohoje').html("R$ " + saldohoje);				
				
			} else {
				exibirMensagem(jsonRetorno.resultado, jsonRetorno.mensagem);
			}
			
		}); //Fim ajax
		
	}
	
	function inserirCaixa() {
		
		entrada = obterValorPriceFormatSemMascara($('#valorEntrada'));
		saida = obterValorPriceFormatSemMascara($('#valorSaida'));
		descricao = $('#descricao').val();
		
		if ((entrada == 0)&&(saida == 0)) {
			exibirMensagem('Ops!', 'Preencha o valor de entrada ou saída no caixa.');
			return false;
		}
		
		if ((entrada > 0)&&(saida > 0)) {
			exibirMensagem('Ops!', 'Preencha apenas o valor de entrada ou saída no caixa.');
			return false;
		}
		
		if (descricao == "") {
			exibirMensagem('Ops!', 'Preencha a descrição.');
			return false;
		}
		
		if (entrada > 0) {
			tipo = "E";
			valor = entrada;
		}
		if (saida > 0) {
			tipo = "S";
			valor = saida;
		}			
		
		$.ajax({
			url: urlBackend,
			type: 'POST',
			data: {
				a: 'inserircaixa',
				descricao: descricao,
				tipo: tipo,
				valor: valor
			},
			context: document.body
		})
		.always(function() {		
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			exibirMensagem('Maria Gata', 'Desculpe! Ocorreu um erro inesperado.');
		})
		.done(function(ret) {
			
			var jsonRetorno = jQuery.parseJSON(ret);
			
			//Se o JSON não tiver a opção resultado é porque 1 ou mais condomínios foram retornados
			if (jsonRetorno.resultado == 'SUCESSO') {
				$.redirect("controleCaixa.php");
			} else {
				exibirMensagem(jsonRetorno.resultado, jsonRetorno.mensagem);
			}
			
		}); //Fim ajax
		
	}

	carregarCaixa();
});