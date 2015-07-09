
// ******************************************//
// ************** OBTER CLIENTE *************//
// ******************************************//

function carregarClientes(clienteParaSelecionar) {
	
	$.ajax({
		url: urlBackend,
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
		
		if (typeof jsonRetorno.resultado === "undefined") {				
			$.each(jsonRetorno, function( index, value ) {
				//Retorno: CLIE_ID, CLIE_Nome, CLIE_CPF, CLIE_Email, CLIE_Celular, CLIE_Sobrenome, CLIE_Observacao, CLIE_Aniversario
				selected = "";				
				if (typeof clienteParaSelecionar !== 'undefined') {
					if (clienteParaSelecionar == value.CLIE_ID) {
						selected = "selected";
					}
				}
				$("#cmbClientes").append( "<option value='" + value.CLIE_ID + "' " + selected + ">" + "[" + value.CLIE_ID + "] " + value.CLIE_Nome + ' ' + value.CLIE_Sobrenome + " (" + value.CLIE_Celular + " / CPF: " + value.CLIE_CPF + ")</option>");
			}); //Fim each json clientes
		} else {
			exibirMensagem('Maria Gata', jsonRetorno.mensagem);	
		} //Fim teste jsonRetorno.resultado
		
		//Atualiza combo chosen
		$('#cmbClientes').trigger('chosen:updated');
		
	}); //Fim ajax
	
}


// ******************************************//
// ************ FIM OBTER CLIENTE ***********//
// ******************************************//



// ******************************************//
// ************** NOVO CLIENTE **************//
// ******************************************//

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
		url: urlBackend,
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


// ******************************************//
// ************** NOVO CLIENTE **************//
// ******************************************//





// ******************************************//
// ************* EDITAR CLIENTE *************//
// ******************************************//

$('#btnEditarCliente').click(function (e) {
	
	//Limpar campos
	$('#nomeEditarCliente').val("");
	$('#sobrenomeEditarCliente').val("");
	$('#observacaoEditarCliente').val("");
	$('#aniversarioEditarCliente').val("");
	$('#celularEditarCliente').val("");
	$('#cpfEditarCliente').val("");
	$('#emailEditarCliente').val("");
	
	var cliente = $('#cmbClientes').val();
	if (cliente == "") {
		exibirMensagem('Maria Gata', 'Selecione um Cliente.');
		return false;
	} else {
		
		//Obtem dados do cliente
		$.ajax({
			url: urlBackend,
			type: 'POST',
			data: {
				a: 'obterdadoscliente',
				cliente: cliente
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
				
				//CLIE_ID, CLIE_CPF, CLIE_Nome, CLIE_Sobrenome, CLIE_Observacao, CLIE_Aniversario, CLIE_Email, CLIE_Celular, CLIE_DataCadastro, CLIE_DataUltimaAtualizacaoDados, CLIE_ValeAcumulado
				
				if ((jsonRetorno[0].CLIE_ID != "")&&(jsonRetorno[0].CLIE_ID != null)) {
					$('#IDEditarCliente').val(jsonRetorno[0].CLIE_ID);
				}
				if ((jsonRetorno[0].CLIE_Nome != "")&&(jsonRetorno[0].CLIE_Nome != null)) {
					$('#nomeEditarCliente').val(jsonRetorno[0].CLIE_Nome);
				}
				if ((jsonRetorno[0].CLIE_Sobrenome != "")&&(jsonRetorno[0].CLIE_Sobrenome != null)) {
					$('#sobrenomeEditarCliente').val(jsonRetorno[0].CLIE_Sobrenome);
				}
				if ((jsonRetorno[0].CLIE_Observacao != "")&&(jsonRetorno[0].CLIE_Observacao != null)) {
					$('#observacaoEditarCliente').val(jsonRetorno[0].CLIE_Observacao);
				}
				if ((jsonRetorno[0].CLIE_Aniversario != "")&&(jsonRetorno[0].CLIE_Aniversario != null)) {
					$('#aniversarioEditarCliente').val(jsonRetorno[0].CLIE_Aniversario);
				}
				if ((jsonRetorno[0].CLIE_Celular != "")&&(jsonRetorno[0].CLIE_Celular != null)) {
					$('#celularEditarCliente').val(jsonRetorno[0].CLIE_Celular);
				}
				if ((jsonRetorno[0].CLIE_CPF != "")&&(jsonRetorno[0].CLIE_CPF != null)) {
					$('#cpfEditarCliente').val(jsonRetorno[0].CLIE_CPF);
				}
				if ((jsonRetorno[0].CLIE_Email != "")&&(jsonRetorno[0].CLIE_Email != null)) {
					$('#emailEditarCliente').val(jsonRetorno[0].CLIE_Email);
				}
				
				$('#modalEditarCliente').modal('show');
				
			} else {
				exibirMensagem('Maria Gata', jsonRetorno.mensagem);
			}
			
		}); //Fim ajax
		
	}		
	
});


$('#modalEditarClienteSalvar').click(function (e) {
	
	var cliente = $('#IDEditarCliente').val().trim();
	var nome = $('#nomeEditarCliente').val().trim();
	var sobrenome = $('#sobrenomeEditarCliente').val().trim();
	var observacao = $('#observacaoEditarCliente').val().trim();
	var aniversario = $('#aniversarioEditarCliente').val().trim().replace(/\D/g,'');
	var celular = $('#celularEditarCliente').val().trim().replace(/\D/g,'');
	var cpf = $('#cpfEditarCliente').val().trim().replace(/\D/g,'');
	var email = $('#emailEditarCliente').val().trim();
	
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
		url: urlBackend,
		type: 'POST',
		data: {
			a: 'editardadosusuario',
			cliente: cliente,
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
			exibirMensagem('Maria Gata', 'Dados do cliente salvos com sucesso!');
			$('#modalEditarCliente').modal('hide');
			carregarClientes(jsonRetorno.mensagem); //Recarrega a lista de cliente e já seleciona o ID do usuário recém editado.
		} else {
			exibirMensagem('Maria Gata', jsonRetorno.mensagem);
		}	
	}); //Fim ajax

});

// ******************************************//
// *********** FIM EDITAR CLIENTE ***********//
// ******************************************//


// ******************************************//
// ************ HISTÓRICO CLIENTE ***********//
// ******************************************//


$('#btnHistoricoCliente').click(function (e) {
	
	var cliente = $('#cmbClientes').val();
	if (cliente == "") {
		exibirMensagem('Maria Gata', 'Selecione um Cliente.');
		return false;
	} else {
		
		//Obtem histórico de atendimentos do cliente
		$.ajax({
			url: urlBackend,
			type: 'POST',
			data: {
				a: 'obterhistoricoatendimentoscliente',
				cliente: cliente
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
			
			if (typeof jsonRetorno.resultado === "undefined") {
				
				$('#tbodyTabelaHistoricoAtendimentosCliente').empty();
				var lsTBody = "";
				var textoServicos = "";
				
				$.each(jsonRetorno, function( index, value ) {
					
					//ATEN_ID, ATEN_DataAtendimento, ATEN_Status, FILI_ID, 
					//CLIE_ID, CLIE_Nome, CLIE_Sobrenome, USUA_ID, USUA_Nome, ASER_ValorCobrado,
					//servicos (Separados por PIPE), precos (Separados por PIPE), funcionarios (Separados por PIPE)
											
					var arrayServicos = value.servicos.split("|");
					var arrayPrecos = value.precos.split("|");
					var arrayFuncionarios = value.funcionarios.split("|");						
					textoServicos = "";
					
					$.each(arrayServicos, function( index, value ) {
						textoServicos += arrayServicos[index] + " (" + arrayFuncionarios[index] + " / " + arrayPrecos[index] + "), ";
					});					
					textoServicos = textoServicos.substring(0,(textoServicos.length - 2)).toString();
	
	
					lsTBody += "<tr id='" + value.ATEN_ID + "'>";
					lsTBody += "	<td>";
					lsTBody += value.ATEN_ID;
					lsTBody += "	</td>";
					lsTBody += "	<td>";
					lsTBody += value.ATEN_DataAtendimento;
					lsTBody += "	</td>";
					lsTBody += "	<td>";
					lsTBody += value.ASER_ValorCobrado;
					lsTBody += "	</td>";
					lsTBody += "	<td>";
					lsTBody += textoServicos;
					lsTBody += "	</td>";
					lsTBody += "</tr>";
					
				}); //Fim each json
				
				$('#tbodyTabelaHistoricoAtendimentosCliente').append(lsTBody);
				$('.popoverServicos').addClass('show-popover');					
				$('#modalHistoricoCliente').modal('show');
				
			} else {
				exibirMensagem('Maria Gata', jsonRetorno.mensagem);	
			} //Fim teste jsonRetorno.resultado
			
			
		}); //Fim ajax
		
	}		
	
});


// ******************************************//
// ********* FIM HISTÓRICO CLIENTE **********//
// ******************************************//

