$(function() {

	function carregarFuncionarios() {
		
		var filial = $('#cmbFilial').val();
		
		$.ajax({
			url: urlBackend,
			type: 'POST',
			data: {
				a: 'obterfuncionarios',
				filial: filial
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
			
			$('#cmbFuncionario').empty();			
			$("#cmbFuncionario").append( "<option value='' selected>Todos</option>");
				
			$.each(jsonRetorno, function( index, value ) {
				
				//Retorno: FUNC_ID, FUNC_Nome, FUNC_Especialidade
				$("#cmbFuncionario").append( "<option value='" + value.FUNC_ID + "'>" + value.FUNC_Nome + "</option>");
				
			}); //Fim each json clientes
			
			//Atualiza combo chosen
			$('#cmbFuncionario').trigger('chosen:updated');
			
		}); //Fim ajax
		
	}
	
	carregarFuncionarios();
	
	//----------------------------- Calanedar --------------------------------//
    if (jQuery().fullCalendar) {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        var h = {};

        if ($(window).width() <= 480) {
            h = {
                left: 'title, prev,next',
                center: '',
                right: 'month,agendaWeek,agendaDay'
            };
        } else {
            h = {
                left: 'prev,next,today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            };
        }
		
		var funcionario = "";
		var filial = '1';
		
        $('#calendar').fullCalendar({
            header: h,
            editable: false,
            droppable: false,
			allDayDefault: false,
			//lang: 'pt-br',
			timezone: 'America/Recife',
			eventLimit: true,
			timeformat: {
				// agenda: for agendaWeek and agendaDay
				agenda: 'h:mm{ - h:mm}', // 5:00 - 6:30
				'': 'HH:mm'            // 7p
			},
			columnFormat: {
				month: 'ddd',    // Mon
				week: 'ddd d/M', // Mon 9/7
				day: 'dddd d/M'  // Monday 9/7
			},
			events: function(start, end, timezone, callback) {
				$.ajax({
					url: urlBackend,
					dataType: 'json',
					method: 'POST',
					data: {
						a: 'obteragendamentos',
						filial: $('#cmbFilial').val(),
						funcionario: $('#cmbFuncionario').val()
					},
					success: function(doc) {
						var events = [];
						$(doc).each(function() {
							events.push({
								id: $(this).attr('id'),
								title: $(this).attr('title'),
								start: $(this).attr('start'),
								end: $(this).attr('end'),
								color: $(this).attr('color'),
								dataAgendamento: $(this).attr('dataAgendamento'),
								dataCriacao: $(this).attr('dataCriacao'),
								nomeCliente: $(this).attr('nomeCliente'),
								celularCliente: $(this).attr('celularCliente'),
								horaInicio: $(this).attr('horaInicio'),
								funcionarios: $(this).attr('funcionarios')
							});
						});
						callback(events);
					},
					error: function() {
						//exibirModal($('#modalMensagem'), "Ops!", "Ok", "Houve uma falha ao obter as reservas do condomínio.");
						exibirMensagem('Desculpe!', 'Houve uma falha ao obter os agendamentos.');
					}
				});
			},
			eventClick: function(calEvent, jsEvent, view) {
				
				$.ajax({
					url: urlBackend,
					type: 'POST',
					data: {
						a: 'obterdetalhesagendamento',
						agendamento: calEvent.id
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
					var dataAgendamento = "";
					var unidade = "";
					var funcionarios = "";
					var servicos = "";
					var ultimoFuncionario = "";
					
					$.each(jsonRetorno, function( index, value ) {
						
						if (index == 0) {
							dataAgendamento = value.DataAgendamento;
							unidade = value.NomeUnidade;
						}
						
						if (ultimoFuncionario != value.FUNC_ID) {
							funcionarios += value.FUNC_Nome + " (" + value.AGFU_HoraInicio + " às " + value.AGFU_HoraFim + "), ";
						}
						
						//Se serviço ainda não foi inserdo, adiciona a variável de exibição
						if (servicos.indexOf(value.SERV_Nome) == -1) {
							servicos += value.SERV_Nome + ', ';
						}
						
						ultimoFuncionario = value.FUNC_ID;
						
					}); //Fim each json
					
					funcionarios = funcionarios.substring(0,(funcionarios.length - 2)).toString();
					servicos = servicos.substring(0,(servicos.length - 2)).toString();
					
					$('#modalConsultarAgendamentoLabelAgendamento').val(calEvent.id);
					$('#modalConsultarAgendamentoLabelData').html(calEvent.dataAgendamento + " " + calEvent.horaInicio + 'h');
					$('#modalConsultarAgendamentoLabelCliente').html(calEvent.nomeCliente + " (" + calEvent.celularCliente + ")");
					$('#modalConsultarAgendamentoLabelServicos').html(servicos);
					$('#modalConsultarAgendamentoLabelFuncionarios').html(funcionarios);
								
					$('#modalConsultarAgendamento').modal('show');
					
				}); //Fim ajax
				
			}
        });
    }
	
	
	$('#modalConsultarAgendamentoCancelar').click(function () {
		
		$.ajax({
			url: urlBackend,
			type: 'POST',
			data: {
				a: 'cancelaragendamento',
				agendamento: $('#modalConsultarAgendamentoLabelAgendamento').val()
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
				$('#modalConsultarAgendamento').modal('hide');
				$('#calendar').fullCalendar( 'refetchEvents' );
			} else {
				exibirMensagem('Maria Gata', jsonRetorno.mensagem);
			}	
		}); //Fim ajax
		
	});
	
	
	$('#filtrarCalendario').click(function () {
		$('#calendar').fullCalendar( 'refetchEvents' );
	});
	
});