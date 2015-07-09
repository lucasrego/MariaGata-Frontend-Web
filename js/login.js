$(function() {
	
	
	$('#btnLogarSistema').click(function (e) {
		
		var usuario = $('#usuario').val();
		var senha = $('#senha').val();
		
		if ((usuario == "")||(senha == "")) {
			exibirMensagem('Maria Gata', 'Digite usuário e senha.');
			return false;
		} else {
			
			//Obtem histórico de atendimentos do cliente
			$.ajax({
				url: urlBackend,
				type: 'POST',
				data: {
					a: 'logarsistema',
					usuario: usuario,
					senha: senha
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
					
					//$.redirect("agendar.php");
					window.location = "agendar.php";
										
				} else {
					exibirMensagem('Maria Gata', jsonRetorno.mensagem);
				}
				
			}); //Fim ajax
			
		}		
		
	});
	
});	