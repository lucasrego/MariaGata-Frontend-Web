$(function() {
	//------------------------ Date Picker ------------------------//
	if (jQuery().datepicker) {
		$('.date-picker').datepicker({
			autoclose: true,
			format: 'dd/mm/yyyy',
			language: 'pt-BR',
			startDate: '-1'
		});
	}

	$( "#frmPesquisarHorarios" ).submit(function( event ) {
				
		event.preventDefault();
		
		//Valida dados de cadastro
		var unidadeAgendamento = $.trim($("#unidadeAgendamento").val());
		var dataAgendamento = $.trim($("#dataAgendamento").val());
		var pacotesAgendamento = $.trim($("#pacotesAgendamento").val());
		var esmalteriaAgendamento = $.trim($("#esmalteriaAgendamento").val());
		var escovariaAgendamento = $.trim($("#escovariaAgendamento").val());
		var maquiagemAgendamento = $.trim($("#maquiagemAgendamento").val());
		var depilacaoAgendamento = $.trim($("#depilacaoAgendamento").val());
		
		servicos = "";
		servicosnome = "";
		
		if ($('#pacotesAgendamento').val() != 0) {
			servicos += $('#pacotesAgendamento').val() + ",";
			servicosnome += $("#pacotesAgendamento option:selected").text() + ", ";				
		}
		if ($('#esmalteriaAgendamento').val() != 0) {
			servicos += $('#esmalteriaAgendamento').val() + ",";
			servicosnome += $("#esmalteriaAgendamento option:selected").text() + ", ";
		}
		if ($('#escovariaAgendamento').val() != 0) {
			servicos += $('#escovariaAgendamento').val() + ",";
			servicosnome += $("#escovariaAgendamento option:selected").text() + ", ";
		}
		if ($('#maquiagemAgendamento').val() != 0) {
			servicos += $('#maquiagemAgendamento').val() + ",";
			servicosnome += $("#maquiagemAgendamento option:selected").text() + ", ";
		}
		if ($('#depilacaoAgendamento').val() != 0) {
			servicos += $('#depilacaoAgendamento').val() + ",";
			servicosnome += $("#depilacaoAgendamento option:selected").text() + ", ";
		}
		
		if (unidadeAgendamento != 1) {
			event.preventDefault();
			alert('Selecione a unidade para atendimento.', 'Maria Gata');
			return false;
		}
		if (dataAgendamento == "") {
			event.preventDefault();
			alert('Escolha a data do agendamento.', 'Maria Gata');
			return false;
		} else {
			dataAgendamento = dataAgendamento.split("/")[2] + "-" + dataAgendamento.split("/")[1] + "-" + dataAgendamento.split("/")[0];
		}
		if (servicos == "") {
			event.preventDefault();
			alert('Nenhum pacote ou serviço selecionado.', 'Maria Gata');
			return false;			
		} else {
			//Remove vírgula para servico e virgula + espaço para servicosnome
			servicos = servicos.substring(0,(servicos.length - 1)).toString();
			servicosnome = servicosnome.substring(0,(servicosnome.length - 2)).toString();
		}
		
		temEscovaria = false;
		temEsmalteria = false;
		
		//Consultar disponibilidade de profissionais e os horário livres
		$.ajax({
			url: "http://mariagata.com.br/sistema/mariagata.php",
			type: 'POST',
			data: {
				a: 'obterprofissionaishorarios',
				filial: unidadeAgendamento,
				data: dataAgendamento,
				servicos: servicos
			},
			context: document.body			
		})
		.always(function() {		
			 			
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			alert('Ops! Ocorreu um erro inesperado ao pesquisar horários disponíveis.', 'Maria Gata');
		})
		.done(function(ret) {
			
			//Teste se o objeto retornao é JSON, ou seja, existem dados
			var jsonRetorno = jQuery.parseJSON(ret);
			
			//Se o JSON não tiver a opção resultado é porque 1 ou mais condomínios foram retornados
			if (typeof jsonRetorno.resultado === "undefined") {
				
				var newPageHorarios = 	'<div class="pages">' +
											'<div data-page="horarios" class="page">';
													
				
				var ultimoGrupo = "";
				var ultimoFuncionario = "";
				var totalItens = jsonRetorno.length;
				var lsHTML = "";
				var classeBotao = "";
				var idBotao = "";
				var classeBotaoDisponivel = "";
				var divGrupo = "";
				var qtdHorariosProfissional = 0;
				var horario = "";
								
				$.each(jsonRetorno, function( index, value ) {
					
					//{"FUNC_ID":"1","FUNC_Nome":"Tati","FUHB_Horario":"09:00:00","FUHB_HorarioBloqueado":"N","GSER_ID":"1",", FUNC_Especialidade":"Manicure e Art Designer"}
					
					//Transforma de 09:30:00 para 09:30
					horario = value.FUHB_Horario.substring(0,(value.FUHB_Horario.length - 3));
					alert(value.FUNC_Nome + ': ' + horario);
					
					//Obtem e seta a div correspondente ao grupo
					if (value.GSER_ID == 1) {
						divGrupo = $('#cardEsmalteria');
						classeBotao = "btnEsmalteria";
						classeBotaoDisponivel = "btnEsmalteriaDisponivel";
						temEsmalteria = true;						
					} else {
						divGrupo = $('#cardEscovaria');
						classeBotao = "btnEscovaria";
						classeBotaoDisponivel = "btnEscovariaDisponivel";
						temEscovaria = true;						
					}
					
					idBotao = value.FUNC_Nome + "|" + value.FUNC_ID + "|" + horario;
					
					//Se novo funcionário
					//vazio - 2, 2-2..., 2-1, 1-1, 1-3, 3-3...
					if (ultimoFuncionario != value.FUNC_ID) {
						
						qtdHorariosProfissional = 1;
						
						if (index != 0) {
							//Se não for o primeiro registro, fecha o anterior
							
							//newPageHorarios += "</div>";
						}
						
						//Se mudou de grupo, insere cabeçalho do grupo:
						if (ultimoGrupo != value.GSER_ID) {					
							if (value.GSER_ID == "1") {
								
								if (index == 0) {
									//newPageHorarios += "<div>";
								} else {
									//newPageHorarios += "<p>&nbsp;</p>";
								}
								
								//newPageHorarios += "<p><a href='#' class='button button-big button-fill color-gray'>ESCOLHA O HORÁRIO PARA MANICURE</a></p>";
							
							} else {
								
								if (index == 0) {
									newPageHorarios += "<div>";									
								} else {
									newPageHorarios += "<p>&nbsp;</p>";
								}
								
								//newPageHorarios += "<p><a href='#' class='button button-big button-fill color-gray'>ESCOLHA O HORÁRIO PARA CABELO/ESTÉTICA</a></p>";										
							}
						}	
						
						//Abre o novo funcionario e registra o 1º horário
						//newPageHorarios += "<div>";
						
						if (value.FUHB_HorarioBloqueado == "N") {
							newPageHorarios += "<div class='col-25'><a href='#' id='" + idBotao + "' class='button " + classeBotaoDisponivel + " " + classeBotao + "'>" + horario + "</a></div>";
						} else {
							newPageHorarios += "<div class='col-25'><a href='#' id='" + idBotao + "' class='button " + classeBotao + "' disabled>" + horario + "</a></div>";
						}
					} else {
						
						qtdHorariosProfissional = qtdHorariosProfissional + 1;						
						
						//Se o mesmo funcionário, insere apenas um horário novo
						if (value.FUHB_HorarioBloqueado == "N") {
							newPageHorarios += "<div class='col-25'><a href='#' id='" + idBotao + "' class='button " + classeBotaoDisponivel + " " + classeBotao + "'>" + horario + "</a></div>";
						} else {
							newPageHorarios += "<div class='col-25'><a href='#' id='" + idBotao + "' class='button btnHorario " + classeBotao + "' disabled>" + horario + "</a></div>";
						}					
					}
					
					if (index == totalItens - 1) {
						//Último item
												
					}
					
					ultimoGrupo = value.GSER_ID;
					ultimoFuncionario = value.FUNC_ID;
					
				}); //Fim each
				
				//newPageHorarios += 	'</div>' +
				
			} else {			
				if (jsonRetorno.resultado == 'NAOENCONTRADO') {			
					alert(jsonRetorno.mensagem, 'Maria Gata');				
				} else {
					alert(jsonRetorno.mensagem, 'Maria Gata');
				}
			}
			
		}); //Fim ajax pesquisarHorarios
		
		
	});
	
	$( "#frmCadastrarCliente" ).submit(function( event ) {
				
		event.preventDefault();		
		
		var cpfCadastroCliente = $.trim($("#cpfCadastroCliente").val()).replace(/\D/g,''); //Replace remove caracteres não numéricos
		
		alert('cpfCadastroCliente: ' + cpfCadastroCliente);
		
	});
	
});