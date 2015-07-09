$(function() {
	
	//Preencher datas disponíveis
	function carregarDatas(qtdDiasCarregar) {
		
		$('#dataAgendamento').append("<option value='' selected>Selecione</option>");	
		for (i = 0; i < qtdDiasCarregar; i++) {
			var d = new Date();
			d.setDate( d.getDate() + i );
			var dias = ["Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sábado"];
			dia = d.getDay(); //0=dom, 1=seg, 2=ter, 3=qua, 4=qui, 5=sex, 6=sab
			nome_dia = dias[dia];
			mes = d.getMonth() + 1;
			data_id = d.getFullYear() + "/" + mes + "/" + d.getDate();
			data_exibicao = d.getDate() + "/" + mes + "/" + d.getFullYear() + " (" + nome_dia + ")";
			if ((dia != 0)&&((dia != 1))) {
				$('#dataAgendamento').append('<option value=' + data_id + '>' + data_exibicao + '</option>');
			}		
		}
		$('#dataAgendamento').trigger('chosen:updated');
		
	}
	carregarDatas(30);
	
	function carregarServicosFilial() {
		
		$.ajax({
			url: urlBackend,
			type: 'POST',
			data: {
				a: 'obterservicosfilial',
				filial: 1,
				agendamento: 'S'
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
				
			$.each(jsonRetorno, function( index, value ) {				
				
				if (value.SERV_Tipo == "PA") {
					$("#pacotesAgendamento").append( "<option data-atendimentoParalelo='" + value.FISE_AtendimentoParalelo + "' value='" + value.SERV_ID + "'>" + value.SERV_Nome + " (" + value.FISE_Preco + ")</option>");
				}
				if (value.SERV_Tipo == "EC") {
					$("#escovariaAgendamento").append( "<option data-atendimentoParalelo='" + value.FISE_AtendimentoParalelo + "' value='" + value.SERV_ID + "'>" + value.SERV_Nome + " (" + value.FISE_Preco + ")</option>");
				}
				if (value.SERV_Tipo == "EM") {
					$("#esmalteriaAgendamento").append( "<option data-atendimentoParalelo='" + value.FISE_AtendimentoParalelo + "' value='" + value.SERV_ID + "'>" + value.SERV_Nome + " (" + value.FISE_Preco + ")</option>");
				}
				if (value.SERV_Tipo == "MA") {
					$("#maquiagemAgendamento").append( "<option data-atendimentoParalelo='" + value.FISE_AtendimentoParalelo + "' value='" + value.SERV_ID + "'>" + value.SERV_Nome + " (" + value.FISE_Preco + ")</option>");					
				}
				if (value.SERV_Tipo == "DE") {
					$("#depilacaoAgendamento").append( "<option data-atendimentoParalelo='" + value.FISE_AtendimentoParalelo + "' value='" + value.SERV_ID + "'>" + value.SERV_Nome + "</option>");					
				}
				
			}); //Fim each json servicos
			
			//Atualiza combos chosen
			$('#pacotesAgendamento').trigger('chosen:updated');
			$('#escovariaAgendamento').trigger('chosen:updated');
			$('#esmalteriaAgendamento').trigger('chosen:updated');
			$('#maquiagemAgendamento').trigger('chosen:updated');
			$('#depilacaoAgendamento').trigger('chosen:updated');
			
		}); //Fim ajax
		
	}
	
	temEscovaria = false;
	temEsmalteria = false;
	dataAgendamentoExibicao = "";
	dataAgendamento = "";
	
	$('#resultadoPesquisa').hide();
	
	$('#btnAtendimentoParaleloEsmalteria').click(function (e) {
		if (atendimentoParalelo == "S") {
			if ($("#btnAtendimentoParaleloEsmalteria").hasClass("btn-gray")) {
				$('#btnAtendimentoParaleloEsmalteria').html("Atendimento Paralelo: Sim");
				$('#btnAtendimentoParaleloEsmalteria').removeClass("btn-gray").addClass( "btn-lime" );				
			} else {
				$('#btnAtendimentoParaleloEsmalteria').html("Atendimento Paralelo: Não");
				$('#btnAtendimentoParaleloEsmalteria').removeClass("btn-gray").addClass( "btn-gray" );
			}
			$('.btnEsmalteriaDisponivel').removeClass("btn-lime").addClass( "btn-pink" ); //Limpa os horário selecionados para que o usuário escolha novamente
		} else {
			exibirMensagem('Ops!', 'Pelo menos um serviço que permite Atendimento Paralelo precisa ser selecionado');
		}
		
	});
	
	$('#btnAtendimentoParaleloEscovaria').click(function (e) {
		if (atendimentoParalelo == "S") {
			if ($("#btnAtendimentoParaleloEscovaria").hasClass("btn-gray")) {
				$('#btnAtendimentoParaleloEscovaria').html("Atendimento Paralelo: Sim");
				$('#btnAtendimentoParaleloEscovaria').removeClass("btn-gray").addClass( "btn-lime" );
			} else {
				$('#btnAtendimentoParaleloEscovaria').html("Atendimento Paralelo: Não");
				$('#btnAtendimentoParaleloEscovaria').removeClass("btn-gray").addClass( "btn-gray" );
			}
			$('.btnEscovariaDisponivel').removeClass("btn-lime").addClass( "btn-pink" ); //Limpa os horário selecionados para que o usuário escolha novamente
		} else {
			exibirMensagem('Ops!', 'Pelo menos um serviço que permite Atendimento Paralelo precisa ser selecionado');
		}
	});
	
	
	function limparPesquisa() {
		$("#dataAgendamento").val("");
		$('#dataAgendamento').trigger('chosen:updated');
		
		$("#pacotesAgendamento").val("");
		$('#pacotesAgendamento').trigger('chosen:updated');
		
		$("#esmalteriaAgendamento").val("");
		$('#esmalteriaAgendamento').trigger('chosen:updated');
		
		$("#escovariaAgendamento").val("");
		$('#escovariaAgendamento').trigger('chosen:updated');
		
		$("#maquiagemAgendamento").val("");
		$('#maquiagemAgendamento').trigger('chosen:updated');
		
		$("#depilacaoAgendamento").val("");
		$('#depilacaoAgendamento').trigger('chosen:updated');
		
		$("#cmbClientes").val("");
		$('#cmbClientes').trigger('chosen:updated');
	}
	
	
	$('#btnEncontrarHorarios').click(function (e) {
		
		$('#resultadoPesquisa').hide();
		
		var unidadeAgendamento = $.trim($("#unidadeAgendamento").val());
		dataAgendamento = $("#dataAgendamento").val();
		var pacotesAgendamento = $.trim($("#pacotesAgendamento").val());
		var esmalteriaAgendamento = $.trim($("#esmalteriaAgendamento").val());
		var escovariaAgendamento = $.trim($("#escovariaAgendamento").val());
		var maquiagemAgendamento = $.trim($("#maquiagemAgendamento").val());
		var depilacaoAgendamento = $.trim($("#depilacaoAgendamento").val());
		
		temEscovaria = false;
		temEsmalteria = false;
		servicos = "";
		servicosnome = "";
		atendimentoParalelo = "N";
		
		if ($('#pacotesAgendamento').val() != 0) {
			servicos += $('#pacotesAgendamento').val() + ",";
			servicosnome += $("#pacotesAgendamento option:selected").text() + ", ";
			atendimentoParalelo = (($("#pacotesAgendamento option:selected").attr("data-atendimentoParalelo") == "S") ? "S" : "N");	
		}
		if ($('#esmalteriaAgendamento').val() != 0) {
			servicos += $('#esmalteriaAgendamento').val() + ",";
			servicosnome += $("#esmalteriaAgendamento option:selected").text() + ", ";
			atendimentoParalelo = (($("#esmalteriaAgendamento option:selected").attr("data-atendimentoParalelo") == "S") ? "S" : "N");
		}
		if ($('#escovariaAgendamento').val() != 0) {
			servicos += $('#escovariaAgendamento').val() + ",";
			servicosnome += $("#escovariaAgendamento option:selected").text() + ", ";
			atendimentoParalelo = (($("#escovariaAgendamento option:selected").attr("data-atendimentoParalelo") == "S") ? "S" : "N");
		}
		if ($('#maquiagemAgendamento').val() != 0) {
			servicos += $('#maquiagemAgendamento').val() + ",";
			servicosnome += $("#maquiagemAgendamento option:selected").text() + ", ";
			atendimentoParalelo = (($("#maquiagemAgendamento option:selected").attr("data-atendimentoParalelo") == "S") ? "S" : "N");
		}
		if ($('#depilacaoAgendamento').val() != 0) {
			servicos += $('#depilacaoAgendamento').val() + ",";
			servicosnome += $("#depilacaoAgendamento option:selected").text() + ", ";
			atendimentoParalelo = (($("#depilacaoAgendamento option:selected").attr("data-atendimentoParalelo") == "S") ? "S" : "N");
		}
		
		if (unidadeAgendamento != 1) {
			exibirMensagem('Atenção', 'Selecione a <span style="color:#00FF00">UNIDADE</span> para atendimento.');
			$("#unidadeAgendamento").trigger('chosen:open');
			return false;
		}
		if (dataAgendamento == '') {
			exibirMensagem('Atenção', 'O campo <span style="color:#00FF00">DATA</span> não foi preenchido.');
			$("#dataAgendamento").datepicker( "show" );			
			return false;
		} else {
			dataAgendamentoExibicao = $('#dataAgendamento option:selected').text();
			dataAgendamento = $('#dataAgendamento').val();
		}
		if (servicos == "") {
			exibirMensagem('Atenção', 'Nenhum <span style="color:#00FF00">PACOTE ou SERVIÇO</span> selecionado.');
			return false;
		} else {
			//Remove vírgula para servico e virgula + espaço para servicosnome
			servicos = servicos.substring(0,(servicos.length - 1)).toString();
			servicosnome = servicosnome.substring(0,(servicosnome.length - 2)).toString();
		}
		
		//exibirMensagem('Atenção', 'unidadeAgendamento: ' + unidadeAgendamento + ", dataAgendamento: " + dataAgendamento + ", servicos: " + servicos);
					
		$('#boxEsmalteriaConteudo').html("");
		$('#boxEscovariaConteudo').html("");
		
		//Consultar disponibilidade de profissionais e os horário livres
		$.ajax({
			url: urlBackend,
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
			exibirMensagem('Ops!', 'Ocorreu um erro inesperado ao pesquisar horários disponíveis.');
		})
		.done(function(ret) {
			
			var jsonRetorno = jQuery.parseJSON(ret);
			
			//Se o JSON não tiver a opção resultado é porque 1 ou mais condomínios foram retornados
			if (typeof jsonRetorno.resultado === "undefined") {
				
				$('#textoBoxPesquisar').html(dataAgendamentoExibicao + " - " + servicosnome);
				$('#box-content-pesquisar').css("display", "none");
				$('#resultadoPesquisa').show();
				
				var newPageHorarios = 	'';													
				
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
					
					//Obtem e seta a div correspondente ao grupo
					if (value.GSER_ID == 1) {
						divGrupo = $('#boxEsmalteriaConteudo');
						classeBotaoDisponivel = "btnEsmalteriaDisponivel";
						temEsmalteria = true;
					} else {
						divGrupo = $('#boxEscovariaConteudo');
						classeBotaoDisponivel = "btnEscovariaDisponivel";
						temEscovaria = true;
					}
					
					idBotao = value.FUNC_Nome + "|" + value.FUNC_ID + "|" + horario;
					
					//Se novo funcionário
					//vazio - 2, 2-2..., 2-1, 1-1, 1-3, 3-3...
					if (ultimoFuncionario != value.FUNC_ID) {
						
						qtdHorariosProfissional = 1;
						
						if (index != 0) {
							//Se não for o primeiro registro, fecha o anterior e append
							
											newPageHorarios += "</div>";
										newPageHorarios += "</div>";
									newPageHorarios += "</div>";
								newPageHorarios += "</div>";
							newPageHorarios += "</div>";
							
							divGrupoAnterior                         .append(newPageHorarios);
							newPageHorarios = ""; //Limpa variável para próximo funcionário
							
						}
						
						//Se mudou de grupo, insere cabeçalho do grupo:
						//if (ultimoGrupo != value.GSER_ID) {

							newPageHorarios += "<div class='row'>";
								newPageHorarios += "<div class='col-md-12'>";
									newPageHorarios += "<div class='box' id='func1'>";
										newPageHorarios += "<div class='box-title'>";
											newPageHorarios += "<h3><i class='fa fa-female'></i> <b>" + value.FUNC_Nome + "</b> (" + value.FUNC_Especialidade + ")</h3>";
											//newPageHorarios += "<div class='box-tool'>";
												//newPageHorarios += "<a data-action='collapse' href='#'><i class='fa fa-chevron-up'></i></a>";
											//newPageHorarios += "</div>";
										newPageHorarios += "</div>";
										newPageHorarios += "<div class='box-content'>";
											newPageHorarios += "<div class='btn-toolbar'>";
							
							//Registra horário
							if (value.FUHB_HorarioBloqueado == "N") {
								newPageHorarios += "<button id='" + idBotao + "' class='btn btn-pink btn-sm " + classeBotaoDisponivel + "'>" + horario + "</button>";						
							} else {
								newPageHorarios += "<button id='" + idBotao + "' class='btn btn-gray btn-sm disabled'>" + horario + "</button>";								
							}
						//}
					
					} else {
						
						qtdHorariosProfissional = qtdHorariosProfissional + 1;						
						
						//Registra horário
						if (value.FUHB_HorarioBloqueado == "N") {
							newPageHorarios += "<button id='" + idBotao + "' class='btn btn-pink btn-sm " + classeBotaoDisponivel + "'>" + horario + "</button>";	
						} else {
							newPageHorarios += "<button id='" + idBotao + "' class='btn btn-gray btn-sm disabled'>" + horario + "</button>";
						}				
					}
					
					if (index == totalItens - 1) {
						//Último item. Fecha ultimo grupo e apped
										newPageHorarios += "</div>";
									newPageHorarios += "</div>";
								newPageHorarios += "</div>";
							newPageHorarios += "</div>";
						newPageHorarios += "</div>";
						
						divGrupo.append(newPageHorarios);

					}
					
					ultimoGrupo = value.GSER_ID;
					ultimoFuncionario = value.FUNC_ID
					
					if (value.GSER_ID == 1) {
						divGrupoAnterior = $('#boxEsmalteriaConteudo');
					} else {
						divGrupoAnterior = $('#boxEscovariaConteudo');
					}
					
				}); //Fim each
				
				if (temEsmalteria) {
					$('#boxEsmalteria').css("display", "block");
				} else {
					$('#boxEsmalteria').css("display", "none");
				}
				
				if (temEscovaria) {
					$('#boxEscovaria').css("display", "block");
				} else {
					$('#boxEscovaria').css("display", "none");
				}
				
			} else {			
				if (jsonRetorno.resultado == 'NAOENCONTRADO') {
					exibirMensagem('Maria Gata', jsonRetorno.mensagem);	
				} else {
					exibirMensagem('Maria Gata', jsonRetorno.mensagem);	
				}
			}
			
		}); //Fim ajax pesquisarHorarios		
		
	});
	
	$(document).on('click', '.btnEsmalteriaDisponivel', function (e) {
		var limiteAtendimentoParaleloEsmalteria = 2;
		
		if ($(e.target).hasClass("btn-lime")) {
			$(e.target).removeClass("btn-lime").addClass("btn-pink");
		} else {
			//Se botão existe e atendimento paralelo desabilitado: hasClass("btn-gray")
			if (($("#btnAtendimentoParaleloEsmalteria").hasClass("btn-gray"))||($("#btnAtendimentoParaleloEsmalteria").length == 0)) {
				//Limpa a classe dos botões btnEsmalteriaDisponivel. Se não estiver disabled, aplica css do botão selecionado
				$('.btnEsmalteriaDisponivel').removeClass("btn-lime").addClass( "btn-pink" );
				$(e.target).removeClass("btn-pink").addClass("btn-lime");
			} else {			
				if ($('.btnEsmalteriaDisponivel.btn-lime').length < limiteAtendimentoParaleloEsmalteria) {
					$(e.target).removeClass("btn-pink").addClass("btn-lime");
				} else {
					exibirMensagem('Ops!', 'Apenas ' + limiteAtendimentoParaleloEsmalteria + ' atendimentos em paralelo são permitidos para a Esmalteria. Se quiser alterar, clique em um horário selecionado para liberá-lo.');
				}
			}
		}
	});

	$(document).on('click', '.btnEscovariaDisponivel', function (e) {
		var limiteAtendimentoParaleloEscovaria = 2;
		
		if ($(e.target).hasClass("btn-lime")) {
			$(e.target).removeClass("btn-lime").addClass("btn-pink");
		} else {
			//Se botão existe e atendimento paralelo desabilitado: hasClass("btn-gray")
			if (($("#btnAtendimentoParaleloEscovaria").hasClass("btn-gray"))||($("#btnAtendimentoParaleloEscovaria").length == 0)) {
				//Limpa a classe dos botões btnEscovaria. Se não estiver disabled, aplica css do botão selecionado
				$('.btnEscovariaDisponivel').removeClass("btn-lime").addClass( "btn-pink" );
				$(e.target).removeClass("btn-pink").addClass("btn-lime");
			} else {
				if ($('.btnEscovariaDisponivel.btn-lime').length < limiteAtendimentoParaleloEscovaria) {
					$(e.target).removeClass("btn-pink").addClass("btn-lime");
				} else {
					exibirMensagem('Ops!', 'Apenas ' + limiteAtendimentoParaleloEscovaria + ' atendimentos em paralelo são permitidos. Se quiser alterar, clique em um horário selecionado para liberá-lo.');
				}
			}
		}
	});
	
	IdProfissionalEsmalteria = "";
	nomeProfissionalEsmalteria = "";
	horarioEsmalteria = "";
	
	IdProfissionalEscovaria = "";
	nomeProfissionalEscovaria = "";
	horarioEscovaria = "";
	
	msgNaoSelecionado = "";
	
	idSelecionadoEsmalteria = "";
	idSelecionadoEscovaria = "";
	
	cliente = "";
	filial = "";
	
	$('#btnConfirmarAgendamento').click(function (e) {
		
		IdProfissionalEsmalteria = "";
		nomeProfissionalEsmalteria = "";
		horarioEsmalteria = "";
		
		IdProfissionalEscovaria = "";
		nomeProfissionalEscovaria = "";
		horarioEscovaria = "";
		
		msgNaoSelecionado = "";
		
		idSelecionadoEsmalteria = "";
		idSelecionadoEscovaria = "";
		
		cliente = "";
		filial = "";
		
		if ($('#cmbClientes').val().trim() == "") {
			exibirMensagem('Ops!', "Selecione um <span style='color:#00FF00'>CLIENTE</span> existente ou cadastre um novo.");
			$('#box-content-pesquisar').css("display", "block");
			$('#cmbClientes').trigger('chosen:open');
			return false;
		} else {
			cliente = $('#cmbClientes').val();
		}
		
		filial = $('#unidadeAgendamento').val();
		
		if (temEsmalteria) {
			var arrayHorariosSelecionados = $('.btnEsmalteriaDisponivel.btn-lime').toArray();			
			if (arrayHorariosSelecionados.length > 0) {
				$.each(arrayHorariosSelecionados, function( index ) {
					nomeProfissionalEsmalteria += arrayHorariosSelecionados[index].id.split("|")[0] + "|";
					IdProfissionalEsmalteria += arrayHorariosSelecionados[index].id.split("|")[1] + "|";
					horarioEsmalteria += arrayHorariosSelecionados[index].id.split("|")[2] + "|";
				});
				//Remove ultimo caracter "|"
				nomeProfissionalEsmalteria = nomeProfissionalEsmalteria.substring(0,(nomeProfissionalEsmalteria.length - 1)).toString();
				IdProfissionalEsmalteria = IdProfissionalEsmalteria.substring(0,(IdProfissionalEsmalteria.length - 1)).toString();
				horarioEsmalteria = horarioEsmalteria.substring(0,(horarioEsmalteria.length - 1)).toString();
			} else {
				msgNaoSelecionado = "Selecione um profissional e horário para o(s) serviço(s) da <span style='color:#00FF00'>Esmalteria</span>.";
			}
			
		}
		
		if (temEscovaria) {
			var arrayHorariosSelecionados = $('.btnEscovariaDisponivel.btn-lime').toArray();			
			if (arrayHorariosSelecionados.length > 0) {
				$.each(arrayHorariosSelecionados, function( index ) {
					nomeProfissionalEscovaria += arrayHorariosSelecionados[index].id.split("|")[0] + "|";
					IdProfissionalEscovaria += arrayHorariosSelecionados[index].id.split("|")[1] + "|";
					horarioEscovaria += arrayHorariosSelecionados[index].id.split("|")[2] + "|";
				});
				//Remove ultimo caracter "|"
				nomeProfissionalEscovaria = nomeProfissionalEscovaria.substring(0,(nomeProfissionalEscovaria.length - 1)).toString();
				IdProfissionalEscovaria = IdProfissionalEscovaria.substring(0,(IdProfissionalEscovaria.length - 1)).toString();
				horarioEscovaria = horarioEscovaria.substring(0,(horarioEscovaria.length - 1)).toString();
			} else {
				if ((temEsmalteria)&&(IdProfissionalEsmalteria == "")) {
					msgNaoSelecionado = "Selecione um profissional e horário para o(s) serviço(s) da <span style='color:#00FF00'> Esmalteria e Escovaria</span>.";
				} else {
					msgNaoSelecionado = "Selecione um profissional e horário para o(s) serviço(s) da <span style='color:#00FF00'>Escovaria</span>.";
				}				
			}
		}
				
		if (msgNaoSelecionado == "") {
			
			$('#modalConfirmarAgendamentoLabelUnidade').html($('#unidadeAgendamento option:selected').text());
			$('#modalConfirmarAgendamentoLabelData').html(dataAgendamentoExibicao);
			$('#modalConfirmarAgendamentoLabelCliente').html($('#cmbClientes option:selected').text() + " (" + $('#cmbClientes').val() + ")");
			$('#modalConfirmarAgendamentoLabelServicos').html(servicosnome);
			
			if (temEsmalteria) {
				var profissionaisEsmalteriaExibicao = "";
				var arrayNomesEsmalteria = nomeProfissionalEsmalteria.split("|");
				var arrayHorarioEsmalteria = horarioEsmalteria.split("|");
				
				//var qtdProfissionais = arrayNomesEsmalteria.length;
				
				$.each(arrayNomesEsmalteria, function( index ) {
					profissionaisEsmalteriaExibicao += arrayNomesEsmalteria[index] + ' (' + arrayHorarioEsmalteria[index] + 'h)' + ', ';
				});
				
				//Remove ultimos 2 caracters ", "
				profissionaisEsmalteriaExibicao = profissionaisEsmalteriaExibicao.substring(0,(profissionaisEsmalteriaExibicao.length - 2)).toString();
				
				$('#modalConfirmarAgendamentoLabelEsmalteria').html(profissionaisEsmalteriaExibicao);
			} else {
				$('#modalConfirmarAgendamentoLabelEsmalteria').html('Não pretende utilizar.');
			}
			
			if (temEscovaria) {
				var profissionaisEscovariaExibicao = "";
				var arrayNomesEscovaria = nomeProfissionalEscovaria.split("|");
				var arrayHorarioEscovaria = horarioEscovaria.split("|");
				
				//var qtdProfissionais = arrayNomesEsmalteria.length;
				
				$.each(arrayNomesEscovaria, function( index ) {
					profissionaisEscovariaExibicao += arrayNomesEscovaria[index] + ' (' + arrayHorarioEscovaria[index] + 'h)' + ', ';
				});
				
				//Remove ultimos 2 caracters ", "
				profissionaisEscovariaExibicao = profissionaisEscovariaExibicao.substring(0,(profissionaisEscovariaExibicao.length - 2)).toString();
				
				$('#modalConfirmarAgendamentoLabelEscovaria').html(profissionaisEscovariaExibicao);
			} else {
				$('#modalConfirmarAgendamentoLabelEscovaria').html('Não pretende utilizar.');
			}

			$('#modalConfirmarAgendamento').modal('show');
		} else {
			if (temEsmalteria || temEscovaria) {
				exibirMensagem('Ops!', msgNaoSelecionado);
			} else {
				exibirMensagem('Ops!', 'Pesquise e selecione os profissionais e horários para o agendamento.');
			}
		}
	});
	
	$('#btnNovaPesquisa').click(function (e) {
		
		$('#textoBoxPesquisar').html("Pesquisar");
		
		$('#box-content-pesquisar').css("display", "block");
	
		$('#resultadoPesquisa').hide();
		
	});
	
	
	$('#modalConfirmarAgendamentoConcluir').click(function (e) {
		
		//exibirMensagem('teste', IdProfissionalEsmalteria + ' - ' + horarioEsmalteria + ' - ' + IdProfissionalEscovaria + ' - ' + horarioEscovaria);
		//return false;
		
		$.ajax({
			url: urlBackend,
			type: 'POST',
			data: {
				a: 'confirmaragendamento',
				cliente: cliente,
				filial: filial,
				data: dataAgendamento,
				servicos: servicos,
				funcionarioEsmalteria: IdProfissionalEsmalteria,
				horarioEsmalteria: horarioEsmalteria,
				funcionarioEscovaria: IdProfissionalEscovaria,
				horarioEscovaria: horarioEscovaria
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
			
			//Se o JSON não tiver a opção resultado é porque 1 ou mais condomínios foram retornados
			if (jsonRetorno.resultado == 'SUCESSO') {
				exibirMensagem('Maria Gata', jsonRetorno.mensagem);
				$('#textoBoxPesquisar').html("Pesquisar");
				$('#box-content-pesquisar').css("display", "block");
				limparPesquisa();
				$('#modalConfirmarAgendamento').modal('hide');
				$('#resultadoPesquisa').hide();
			} else {
				exibirMensagem('Maria Gata', jsonRetorno.mensagem);
			}	
		}); //Fim ajax

	});
	
	carregarClientes();
	carregarServicosFilial();
	
});