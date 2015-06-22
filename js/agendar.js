$(function() {
	//------------------------ Date Picker ------------------------//
	/*
	$( "#dataAgendamento" ).datepicker({
		minDate: 0,
		dateFormat: "DD, d MM, yy"
	});
	$( "#dataAgendamento" ).datepicker( $.datepicker.regional[ "pt-BR" ] );
	
	
	$( ".datepicker" ).datepicker({
		inline: true,
		showOtherMonths: true
	});
	*/
	
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
	
	function carregarClientes(clienteParaSelecionar) {
		
		$.ajax({
			url: "http://mariagata.com.br/sistema/mariagata.php",
			type: 'POST',
			data: {
				a: 'obterclientes'
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
			var selected = "";
			
			$('#cmbClientes').empty();			
			
			$("#cmbClientes").append( "<option value=''>Selecione ou cadastre um novo</option>");
			
			//Se o JSON não tiver a opção resultado é porque 1 ou mais condomínios foram retornados
			if (typeof jsonRetorno.resultado === "undefined") {				
				$.each(jsonRetorno, function( index, value ) {
					//Retorno: CLIE_ID, CLIE_Nome, CLIE_CPF, CLIE_Email, CLIE_Celular
					selected = "";				
					if (typeof clienteParaSelecionar !== 'undefined') {
						if (clienteParaSelecionar == value.CLIE_ID) {
							selected = "selected";
						}
					}
					$("#cmbClientes").append( "<option value='" + value.CLIE_ID + "' " + selected + ">" + value.CLIE_Nome + " (" + value.CLIE_Celular + " / CPF: " + value.CLIE_CPF + ")</option>");
				}); //Fim each json clientes
			} else {
				exibirMensagem('Maria Gata', jsonRetorno.mensagem);	
			} //Fim teste jsonRetorno.resultado
			
			//Atualiza combo chosen
			$('#cmbClientes').trigger('chosen:updated');
			
		}); //Fim ajax
		
	}
	
	function carregarServicosFilial() {
		
		$.ajax({
			url: "http://mariagata.com.br/sistema/mariagata.php",
			type: 'POST',
			data: {
				a: 'obterservicosfilial',
				filial: 1
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
					$("#pacotesAgendamento").append( "<option value='" + value.SERV_ID + "'>" + value.SERV_Nome + "</option>");
				}
				if (value.SERV_Tipo == "EC") {
					$("#escovariaAgendamento").append( "<option value='" + value.SERV_ID + "'>" + value.SERV_Nome + "</option>");
				}
				if (value.SERV_Tipo == "EM") {
					$("#esmalteriaAgendamento").append( "<option value='" + value.SERV_ID + "'>" + value.SERV_Nome + "</option>");
				}
				if (value.SERV_Tipo == "MA") {
					$("#maquiagemAgendamento").append( "<option value='" + value.SERV_ID + "'>" + value.SERV_Nome + "</option>");					
				}
				if (value.SERV_Tipo == "DE") {
					$("#depilacaoAgendamento").append( "<option value='" + value.SERV_ID + "'>" + value.SERV_Nome + "</option>");					
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
	
	$('#btnEncontrarHorarios').click(function (e) {	
		
		$('#resultadoPesquisa').hide();
		
		//Valida dados de cadastro
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
			exibirMensagem('Ops!', 'Ocorreu um erro inesperado ao pesquisar horários disponíveis.');
		})
		.done(function(ret) {
			
			var jsonRetorno = jQuery.parseJSON(ret);
			
			//Se o JSON não tiver a opção resultado é porque 1 ou mais condomínios foram retornados
			if (typeof jsonRetorno.resultado === "undefined") {
				
				//Fecha o grupo da pesquisa
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
		//Limpa a classe dos botões btnEsmalteriaDisponivel. Se não estiver disabled, aplica css do botão selecionado
		$('.btnEsmalteriaDisponivel').removeClass("btn-lime").addClass( "btn-pink" );
		$(e.target).removeClass( "btn-pink" ).addClass( "btn-lime" );
	});

	$(document).on('click', '.btnEscovariaDisponivel', function (e) {
		//Limpa a classe dos botões btnEscovaria. Se não estiver disabled, aplica css do botão selecionado
		$('.btnEscovariaDisponivel').removeClass("btn-lime").addClass( "btn-pink" );
		$(e.target).removeClass( "btn-pink" ).addClass( "btn-lime" );
	});
	
	$('#btnCadastrarCliente').click(function (e) {
		$('#modalCadastrarCliente').modal('show');
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
			idSelecionadoEsmalteria = $('.btnEsmalteriaDisponivel.btn-lime').attr('id');
			if (idSelecionadoEsmalteria === undefined) {
				msgNaoSelecionado = "Selecione um profissional e horário para o(s) serviço(s) da <span style='color:#00FF00'>Esmalteria</span>.";
			} else {
				nomeProfissionalEsmalteria = idSelecionadoEsmalteria.split("|")[0];
				IdProfissionalEsmalteria = idSelecionadoEsmalteria.split("|")[1];
				horarioEsmalteria = idSelecionadoEsmalteria.split("|")[2];
			}			
		}
		if (temEscovaria) {
			idSelecionadoEscovaria = $('.btnEscovariaDisponivel.btn-lime').attr('id');
			if (idSelecionadoEscovaria === undefined) {
				if ((temEsmalteria)&&((idSelecionadoEsmalteria === undefined)||(idSelecionadoEsmalteria == ""))) {
					msgNaoSelecionado = "Selecione um profissional e horário para o(s) serviço(s) da <span style='color:#00FF00'> Esmalteria e Escovaria</span>.";
				} else {
					msgNaoSelecionado = "Selecione um profissional e horário para o(s) serviço(s) da <span style='color:#00FF00'>Escovaria</span>.";
				}
			} else {
				nomeProfissionalEscovaria = idSelecionadoEscovaria.split("|")[0];
				IdProfissionalEscovaria = idSelecionadoEscovaria.split("|")[1];
				horarioEscovaria = idSelecionadoEscovaria.split("|")[2];
			}
		}
		
		if (msgNaoSelecionado == "") {
			//exibirMensagem('OK', nomeProfissionalEsmalteria + "-" + IdProfissionalEsmalteria + "-" + horarioEsmalteria);
			
			//Preenche labels do modal de confirmação
			$('#modalConfirmarAgendamentoLabelUnidade').html($('#unidadeAgendamento option:selected').text());
			$('#modalConfirmarAgendamentoLabelData').html(dataAgendamentoExibicao);
			$('#modalConfirmarAgendamentoLabelCliente').html($('#cmbClientes option:selected').text() + " (" + $('#cmbClientes').val() + ")");
			$('#modalConfirmarAgendamentoLabelServicos').html(servicosnome);
			
			if (temEsmalteria) {
				$('#modalConfirmarAgendamentoLabelEsmalteria').html(nomeProfissionalEsmalteria + ' (' + horarioEsmalteria + 'h)');
			} else {
				$('#modalConfirmarAgendamentoLabelEsmalteria').html('Não pretende utilizar.');
			}
			
			if (temEscovaria) {
				$('#modalConfirmarAgendamentoLabelEscovaria').html(nomeProfissionalEscovaria + ' (' + horarioEscovaria + 'h)');
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
		
		//Exibe o grupo da pesquisa
		$('#box-content-pesquisar').css("display", "block");
	
		$('#resultadoPesquisa').hide();
		
	});
	
	$('#modalCadastrarClienteSalvar').click(function (e) {
		
		var cpf = $('#cpfCadastroCliente').val().trim().replace(/\D/g,'');
		var nome = $('#nomeCadastroCliente').val().trim();
		var email = $('#emailCadastroCliente').val().trim();
		var celular = $('#celularCadastroCliente').val().trim().replace(/\D/g,'');
		
		//exibirMensagem('Dados', 'cpf: ' + cpf + ', nome: ' + nome + ', email: ' + email + ', celular: ' + celular);
		
		if (cpf != "") {
			if (cpf.length != 11) {
				exibirMensagem('Atenção', 'O campo <span style="color:#00FF00">CPF</span> deve possuir 11 dígitos.');		
				return false;
			}
		}
		
		if (nome == "") {
			exibirMensagem('Atenção', 'O campo <span style="color:#00FF00">NOME</span> não foi preenchido.');			
			return false;
		}
		
		if (celular == "") {
			exibirMensagem('Atenção', 'O campo <span style="color:#00FF00">CELULAR</span> não foi preenchido.');			
			return false;
		} else {
			if ((celular.length != 10)&&(celular.length != 11)) {				
				exibirMensagem('Atenção', 'O campo <span style="color:#00FF00">CELULAR</span> deve possuir 10 ou 11 dígitos.');		
				return false;
			}
		}
		
		$.ajax({
			url: "http://mariagata.com.br/sistema/mariagata.php",
			type: 'POST',
			data: {
				a: 'salvardadosusuario',
				cpf: cpf,
				nome: nome,
				email: email,
				celular: celular
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
				exibirMensagem('Maria Gata', 'Usuário cadastrado com sucesso!');
				$('#modalCadastrarCliente').modal('hide');
				carregarClientes(jsonRetorno.mensagem); //Recarrega a lista de cliente e já seleciona o ID do usuário recém cadastrado.
			} else {
				exibirMensagem('Maria Gata', jsonRetorno.mensagem);
			}	
		}); //Fim ajax

	});

	
	$('#modalConfirmarAgendamentoConcluir').click(function (e) {
		
		$.ajax({
			url: "http://mariagata.com.br/sistema/mariagata.php",
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
				exibirMensagem('Maria Gata', 'Agendamento realizado com sucesso!');
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