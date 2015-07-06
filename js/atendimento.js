$(function() {
	
	jsonFuncionarios = "";
	selectorFuncionario = "";
	
	jsonServicos = "";
	selectorServico = "";
	
	$('#alertaCliente').hide();
	
	$('.campoMoeda').priceFormat({
		prefix: '',
		centsSeparator: ',',
		thousandsSeparator: '.',
		limit: 6
	});
	
	$('.campoMoedaNegativo').priceFormat({
		prefix: '',
		centsSeparator: ',',
		thousandsSeparator: '.',
		limit: 6,
		allowNegative: true
	});
	
	function atualizarPriceFormat(objeto) {
		objeto.priceFormat({
			prefix: '',
			centsSeparator: ',',
			thousandsSeparator: '.',
			limit: 6
		});
	}
	
	function atualizarPriceFormatNegativo(objeto) {
		objeto.priceFormat({
			prefix: '',
			centsSeparator: ',',
			thousandsSeparator: '.',
			limit: 6,
			allowNegative: true
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
	
	//$(".campoValorTabelaServicos, .campoValorResumo").focusout(function(){
	$('.campoValorTabelaServicos, .campoValorResumo').on('focusout', function() {
		atualizaValoresResumo();
	});
	
	function atualizaValoresResumo() {
		
		var somaServicos = 0;
		$(".campoValorTabelaServicos").each(function( index ) {
			somaServicos = parseInt(somaServicos) + obterValorPriceFormatSemMascara($(this));
		});
		$('#totalServicos').html(somaServicos);
		atualizarPriceFormat($('#totalServicos'));
		
		//$('#valeFuturo').html(somaServicos - obterValorPriceFormatSemMascara($('#valeExistente')) - obterValorPriceFormatSemMascara($('#dinheiro')) - obterValorPriceFormatSemMascara($('#debito')) - obterValorPriceFormatSemMascara($('#credito')));
		$('#valeFuturo').html(obterValorPriceFormatSemMascara($('#valeExistente')) + obterValorPriceFormatSemMascara($('#dinheiro')) + obterValorPriceFormatSemMascara($('#debito')) + obterValorPriceFormatSemMascara($('#credito')) - somaServicos);
		atualizarPriceFormatNegativo($('#valeFuturo'));
		
		if (obterValorPriceFormatSemMascara($('#valeFuturo')) == 0) {
			$('#btnConcluirAtendimento').text('CONCLUIR ATENDIMENTO');
			$('#btnConcluirAtendimento').removeClass("btn-danger").removeClass("btn-gray").removeClass("disabled").addClass( "btn-primary" );
		} else if (obterValorPriceFormatSemMascara($('#valeFuturo')) > 0) {
			$('#btnConcluirAtendimento').text('CONCLUIR ATENDIMENTO E GERAR VALE DE: R$ ' + $('#valeFuturo').html());
			$('#btnConcluirAtendimento').removeClass("btn-primary").removeClass("btn-gray").removeClass("disabled").addClass( "btn-danger" );
		} else if (obterValorPriceFormatSemMascara($('#valeFuturo')) < 0) {
			$('#btnConcluirAtendimento').text('PAGAMENTO PENDENTE');
			$('#btnConcluirAtendimento').removeClass("btn-primary").removeClass("btn-danger").addClass( "btn-gray" ).addClass( "disabled" );
		}

	}
	
	function adicionarLinhaTabela() {
		var lsTBody = "";
		
		var d = new Date();
		var milisegundo = d.getTime();
		
		lsTBody += "<tr class='linhaTabelaServicos' id='" + milisegundo + "'>";
		lsTBody += "	<td>";
		lsTBody += "		<select id='cmbServico" + milisegundo + "' data-placeholder='Selecione' class='col-md-12 chosen cmbServico'></select>";
		lsTBody += "	</td>";
		lsTBody += "	<td>";
		lsTBody += "		<select id='cmbFuncionario" + milisegundo + "' data-placeholder='Selecione' class='col-md-12 chosen cmbFuncionario'></select>";
		lsTBody += "	</td>";
		lsTBody += "	<td>";
		lsTBody += "		<div class='col-sm-9 col-lg-10 controls'>";
		lsTBody += "			<input type='text' id='valorCobrado' placeholder='' class='form-control campoMoeda campoValorTabelaServicos tblValorCobrado'>";
		lsTBody += "		</div>";
		lsTBody += "	</td>";
		lsTBody += "	<td>";
		lsTBody += "		<div class='btn-group'>";
		lsTBody += "			<a id='btnNovaLinha" + milisegundo + "' class='btn btn-sm btn-primary show-tooltip btnNovaLinha' title='Incluir Serviço' href='#'><i class='fa fa-plus-circle'></i></a>";
		lsTBody += "			<a class='btn btn-sm btn-danger show-tooltip btnLimparLinha' title='Excluir' href='#'><i class='fa fa-trash-o'></i></a>";
		lsTBody += "		</div>";
		lsTBody += "	</td>";
		lsTBody += "</tr>";
		
		$('#tbodyTabelaServicos').append(lsTBody);	
		
		carregarFuncionarios($('#cmbFuncionario' + milisegundo));
		carregarServicosFilial($('#cmbServico' + milisegundo));
		
		$(".chosen").chosen({
			no_results_text: "Ops, não encontramos nada com: ",
			width: "100%",
			search_contains: true
		});

		$('.campoMoeda').priceFormat({
			prefix: '',
			centsSeparator: ',',
			thousandsSeparator: '.',
			limit: 6
		});
		
		$('.campoValorTabelaServicos, .campoValorResumo').on('focusout', function() {
			atualizaValoresResumo();
		});
		
		$('#btnNovaLinha' + milisegundo).click(function (e) {
			adicionarLinhaTabela();
		});
		
		$('.btnLimparLinha').click(function (e) {
			
			var linhaClicada = $(this).closest('tr');	
			
			if ($('.linhaTabelaServicos').length == 1) {
				exibirMensagem('Maria Gata', 'A tabela de serviços deve possui pelo menos um item.');
			} else {
				//linhaClicada.remove();
				linhaClicada.detach();
				atualizaValoresResumo();
			}
		
		});
		
	}
	
	adicionarLinhaTabela();
	
	
	function carregarFuncionarios(objeto) {
		
		if (typeof objeto !== 'undefined') {
			selectorFuncionario = objeto;
		} else {
			selectorFuncionario = $('.cmbFuncionario');
		}
		
		selectorFuncionario.empty();
		selectorFuncionario.append( "<option value='0' selected>Selecione</option>");
				
		if (jsonFuncionarios == "") {
		
			$.ajax({
				url: "http://mariagata.com.br/sistema/mariagata.php",
				type: 'POST',
				data: {
					a: 'obterfuncionarios',
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
				
				var jsonRetorno = jQuery.parseJSON(ret);
				
				jsonFuncionarios = jsonRetorno;
				
				$.each(jsonRetorno, function( index, value ) {
					
					//Retorno: FUNC_ID, FUNC_Nome, FUNC_Especialidade
					selectorFuncionario.append( "<option value='" + value.FUNC_ID + "'>" + value.FUNC_Nome + "</option>");
					
				}); //Fim each json funcionarios
		
				selectorFuncionario.trigger('chosen:updated');
		
			}); //Fim ajax
		
		} else {
			$.each(jsonFuncionarios, function( index, value ) {					
				selectorFuncionario.append( "<option value='" + value.FUNC_ID + "'>" + value.FUNC_Nome + "</option>");
			});
			selectorFuncionario.trigger('chosen:updated');
		}
				
	}	
	
	$('#btnNovoCliente').click(function (e) {
		
		//Limpar campos para novo cadastro
		$('#nomeCadastroCliente').val("");
		$('#sobrenomeCadastroCliente').val("");
		$('#observacaoCadastroCliente').val("");
		$('#aniversarioCadastroCliente').val("");
		$('#celularCadastroCliente').val("");
		$('#cpfCadastroCliente').val("");
		$('#emailCadastroCliente').val("");
		
		$('#modalCadastrarCliente').modal('show');
	});
	
	
	$('#btnConcluirAtendimento').click(function (e) {
		
		var cliente = $('.cmbClientes').val();
		var dataAtendimento = $('#dataAtendimento').val();
		if ((dataAtendimento.length != 10)||(dataAtendimento == "__/__/____")) {
			exibirMensagem('Maria Gata', 'A data do atendimento não foi informada ou está inválida.');
			return false;
		} else {
			dataAtendimento = dataAtendimento.split("/")[2] + "-" + dataAtendimento.split("/")[1] + "-" + dataAtendimento.split("/")[0]; 
		}
		
		var totalServicos = $('#totalServicos').html();
		var valeExistente = $('#valeExistente').html();
		var dinheiro = $('#dinheiro').val();
		var debito = $('#debito').val();
		var credito = $('#credito').val();
		var valeFuturo = $('#valeFuturo').html();
		
		var filial = 1;
		var usuario = 1;
		
		var linhasServicos = $('.linhaTabelaServicos');
		
		if (cliente == "") {
			exibirMensagem('Maria Gata', 'Selecione ou cadastre um Cliente.');
			return false;
		}
		
		encontrouFalhaNaTabela = false;
		dadosServicosProdutos = "";
		$.each(linhasServicos, function( index, value ) {
			
			var servico = $(this).find('select.cmbServico option:selected');
			var funcionario = $(this).find('select.cmbFuncionario option:selected');	
			var valor = $(this).find('input.campoValorTabelaServicos');
			
			dadosServicosProdutos += servico.val() + "|" + funcionario.val() + "|" + valor.val() + "$";
			
			if (servico.val() == "0") {
				exibirMensagem('Maria Gata', 'selecione o serviço ou produto.');
				encontrouFalhaNaTabela = true;
				return false;
			}
			
			if (funcionario.val() == "0") {
				exibirMensagem('Maria Gata', 'Selecione um funcionário para cada serviço/produto.');
				encontrouFalhaNaTabela = true;
				return false;
			}
			
			if ((valor.val() == "")||(valor.val() == "0,00")) {
				exibirMensagem('Maria Gata', 'Todos os serviços/produtos devem ter o valor preenchido.');
				encontrouFalhaNaTabela = true;
				return false;
			}
			
		}); //Fim each
		
		dadosServicosProdutos = dadosServicosProdutos.substring(0,(dadosServicosProdutos.length - 1)).toString();
				
		//Sai da função, pois o return false dentro do each apenas sai do loop
		if (encontrouFalhaNaTabela) {
			return false;
		}		
		
		if ((totalServicos == "")||(totalServicos == "0,00")) {
			exibirMensagem('Maria Gata', 'Nenhum valor informado.');
			return false;
		}
		
		if (((valeExistente == "")||(valeExistente == "0,00"))&&((dinheiro == "")||(dinheiro == "0,00"))&&((debito == "")||(debito == "0,00"))&&((credito == "")||(credito == "0,00"))) {
			exibirMensagem('Maria Gata', 'Nenhuma forma de pagamento preenchida.');
			return false;
		}
		
		$.ajax({
			url: "http://mariagata.com.br/sistema/mariagata.php",
			type: 'POST',
			data: {
				a: 'salvaratendimento',
				dataAtendimento: dataAtendimento,
				filial: filial,
				cliente: cliente,
				usuario: usuario,
				dadosServicosProdutos: dadosServicosProdutos,
				totalServicos: totalServicos,
				valeExistente: valeExistente,
				dinheiro: dinheiro,
				debito: debito,
				credito: credito,
				valeFuturo: valeFuturo
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
				exibirAtendimentos();
				limparAtendimento();
				exibirMensagem('Maria Gata', 'Atendimento registrado com sucesso.');
			} else {
				exibirMensagem('Maria Gata', jsonRetorno.mensagem);
			}	
		}); //Fim ajax
		
	});
	
	
	function limparAtendimento() {
		$(".cmbClientes").val("");
		$('.cmbClientes').trigger('chosen:updated');
		
		$('#alertaCliente').hide();
				
		$('#tbodyTabelaServicos').empty();
		adicionarLinhaTabela();
		
		$('#dinheiro').val("");
		$('#debito').val("");
		$('#credito').val("");
		$('#valeExistente').html("0");
		
		atualizarPriceFormat($('#dinheiro'));
		atualizarPriceFormat($('#debito'));
		atualizarPriceFormat($('#credito'));
		atualizarPriceFormat($('#valeExistente'));
		
		atualizaValoresResumo();
	}
	
	
	$('.cmbClientes').on('change', function(evt, params) {
		
		$('#alertaCliente').hide();
		
		if (params.selected == "") {
			$('#valeExistente').html("0");
			atualizarPriceFormat($('#valeExistente'));
			atualizaValoresResumo();
		} else {
			//Obtem dados do cliente e verifica se possui vale
			$.ajax({
				url: "http://mariagata.com.br/sistema/mariagata.php",
				type: 'POST',
				data: {
					a: 'obterdadoscliente',
					cliente: params.selected	
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
				if (typeof jsonRetorno.resultado === "undefined") {				
					
					//CLIE_CPF, CLIE_Nome, CLIE_Sobrenome, CLIE_Observacao, CLIE_Aniversario, CLIE_Email, CLIE_Celular, CLIE_DataCadastro, CLIE_DataUltimaAtualizacaoDados, CLIE_ValeAcumulado
					
					$('#alertaClienteConteudo').html("");
					
					if ((jsonRetorno[0].CLIE_Celular == "")||(jsonRetorno[0].CLIE_Celular == null)) {
						$('#alertaClienteConteudo').append(" <strong>Atualize o celular! </strong> ");						
						$('#alertaCliente').show();
					}
					if ((jsonRetorno[0].CLIE_Email == "")||(jsonRetorno[0].CLIE_Email == null)) {
						$('#alertaClienteConteudo').append(" <strong>Atualize o email! </strong> ");						
						$('#alertaCliente').show();
					}
					if ((jsonRetorno[0].CLIE_Observacao != "")&&(jsonRetorno[0].CLIE_Observacao != null)) {
						$('#alertaClienteConteudo').append(" <strong>Observação: </strong>" + jsonRetorno[0].CLIE_Observacao);						
						$('#alertaCliente').show();
					}
					
					$('#valeExistente').html(jsonRetorno[0].CLIE_ValeAcumulado);
					atualizarPriceFormat($('#valeExistente'));
				} else {
					exibirMensagem('Maria Gata', jsonRetorno.mensagem);
				}
				atualizaValoresResumo();
			}); //Fim ajax

			
		}
		
	});

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
			
			$('.cmbClientes').empty();
			$(".cmbClientes").append( "<option value=''>Selecione ou cadastre um novo</option>");
			
			if (typeof jsonRetorno.resultado === "undefined") {				
				$.each(jsonRetorno, function( index, value ) {
					//Retorno: CLIE_ID, CLIE_Nome, CLIE_CPF, CLIE_Email, CLIE_Celular
					selected = "";				
					if (typeof clienteParaSelecionar !== 'undefined') {
						if (clienteParaSelecionar == value.CLIE_ID) {
							selected = "selected";
						}
					}
					$(".cmbClientes").append( "<option value='" + value.CLIE_ID + "' " + selected + ">" + value.CLIE_Nome + ' ' + value.CLIE_Sobrenome + " (" + value.CLIE_Celular + " / CPF: " + value.CLIE_CPF + ")</option>");
				}); //Fim each json clientes
			} else {
				exibirMensagem('Maria Gata', jsonRetorno.mensagem);	
			} //Fim teste jsonRetorno.resultado
			
			//Atualiza combo chosen
			$('.cmbClientes').trigger('chosen:updated');
			
		}); //Fim ajax
		
	}
	
	carregarClientes();
	
	function carregarServicosFilial(objeto) {
		
		if (typeof objeto !== 'undefined') {
			selectorServico = objeto;
		} else {
			selectorServico = $('.cmbFuncionario');
		}
		
		selectorServico.empty();
		selectorServico.append( "<option value='0' selected>Selecione</option>");
				
		if (jsonServicos == "") {
		
			$.ajax({
				url: "http://mariagata.com.br/sistema/mariagata.php",
				type: 'POST',
				data: {
					a: 'obterservicosfilial',
					filial: 1,
					atendimento: 'S'
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
				var totalItens = jsonRetorno.length;
				
				jsonServicos = jsonRetorno;
				
				//grupoAnterior = "";
				
				$.each(jsonRetorno, function( index, value ) {
					
					/*
					if (index != 0) {
						if (value.SERV_Tipo != grupoAnterior) {
							selectorServico.append( "</optgroup>");
						}
					}
					if (value.SERV_Tipo != grupoAnterior) {
						selectorServico.append( "<optgroup label='" + value.SERV_Tipo + "'>");
					}
					*/
					selectorServico.append( "<option value='" + value.SERV_ID + "'>" + value.SERV_Nome + "</option>");
					
					/*
					if (index == totalItens - 1) {
						selectorServico.append( "</optgroup>");
					}
					grupoAnterior = value.SERV_Tipo;
					*/
				}); //Fim each json servicos
		
				selectorServico.trigger('chosen:updated');
		
			}); //Fim ajax
		
		} else {
			$.each(jsonServicos, function( index, value ) {					
				selectorServico.append( "<option value='" + value.SERV_ID + "'>" + value.SERV_Nome + "</option>");
			});
			selectorServico.trigger('chosen:updated');
		}
		
	}
	
	
	
	$('#modalCadastrarClienteSalvar').click(function (e) {
		
		var nome = $('#nomeCadastroCliente').val().trim();
		var sobrenome = $('#sobrenomeCadastroCliente').val().trim();
		var observacao = $('#observacaoCadastroCliente').val().trim();
		var aniversario = $('#aniversarioCadastroCliente').val().trim().replace(/\D/g,'');
		var celular = $('#celularCadastroCliente').val().trim().replace(/\D/g,'');
		var cpf = $('#cpfCadastroCliente').val().trim().replace(/\D/g,'');
		var email = $('#emailCadastroCliente').val().trim();
		
		//exibirMensagem('Dados', 'aniversario: ' + aniversario + ', observacao: ' + observacao + ', sobrenome: ' + sobrenome + ', celular: ' + celular);
		//return false;
		
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
		
		if (celular != "") {
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
				nome: nome,
				sobrenome: sobrenome,
				observacao: observacao,
				aniversario: aniversario,
				celular: celular,
				cpf: cpf,
				email: email				
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
				exibirMensagem('Maria Gata', 'Cliente cadastrado com sucesso!');
				$('#modalCadastrarCliente').modal('hide');
				carregarClientes(jsonRetorno.mensagem); //Recarrega a lista de cliente e já seleciona o ID do usuário recém cadastrado.
			} else {
				exibirMensagem('Maria Gata', jsonRetorno.mensagem);
			}	
		}); //Fim ajax

	});

	
	$('#btnAtualizarDataAtendimento').click(function (e) {
		exibirAtendimentos();
	});
	
	function exibirAtendimentos() {
				
		var dataAtendimento = $('#dataAtendimento').val();
		if ((dataAtendimento.length != 10)||(dataAtendimento == "__/__/____")) {
			exibirMensagem('Maria Gata', 'A data do atendimento não foi informada ou está inválida.');
			return false;
		} else {
			
			dataAtendimento = dataAtendimento.split("/")[2] + "-" + dataAtendimento.split("/")[1] + "-" + dataAtendimento.split("/")[0];
			
			$.ajax({
				url: "http://mariagata.com.br/sistema/mariagata.php",
				type: 'POST',
				data: {
					a: 'obteratendimentos',
					dataatendimento: dataAtendimento,
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
				
				var jsonRetorno = jQuery.parseJSON(ret);
				
				$('#listaAtendimentos').empty();
				
				if (typeof jsonRetorno.resultado === "undefined") {				
					
					$.each(jsonRetorno, function( index, value ) {
						var classe = "";
						if (value.ATEN_Status == "P") {
							classe = "comandaPaga";
						} else {
							classe = "comandaCancelada";
						}
						
						//ATEN_ID, ATEN_Status, CLIE_ID, CLIE_Nome, CLIE_Sobrenome, USUA_ID, USUA_Nome, SUM(ASER_ValorCobrado) as ASER_ValorCobrado
						$('#listaAtendimentos').append( "<option class='" + classe + "' value='" + value.ATEN_ID + "'>[" + value.ATEN_ID + "] " + value.CLIE_Nome + " (" + value.ASER_ValorCobrado.replace('.',',') + ")</option>");
						
					});

				} else {
					exibirMensagem('Maria Gata', jsonRetorno.mensagem);	
				}
				
			}); //Fim ajax
			
		} //Fim teste data
				
	} //fim function exibirAtendimentos()
	
	exibirAtendimentos();
	
		
});