$(function() {

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
					url: 'http://mariagata.com.br/sistema/mariagata.php?a=obteragendamentos&filial=1',
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
								color: $(this).attr('color')
							});
						});
						callback(events);
					},
					error: function() {
						//exibirModal($('#modalMensagem'), "Ops!", "Ok", "Houve uma falha ao obter as reservas do condomínio.");
						alert('Desculpe! Houve uma falha ao obter os agendamentos.');
					}
				});
			},
			eventClick: function(calEvent, jsEvent, view) {
				alert('asdfasd');
				//Propriedades do evento: title (Nome do espaço), start, end, dataEvento, horaInicioPrevisto, idReserva, dataCriacao, nomeReservadoPara
				/*
				$('#modalVerReservaTitulo').html("<b>" + calEvent.title + "</b>");
				$('#idReserva').val(calEvent.idReserva);
				
				var lsCorpoReserva = "<b>Data do Evento:</b> " + calEvent.dataEvento + " às " + calEvent.horaInicioPrevisto + "h<br /><b>Reservado para:</b> " + calEvent.nomeReservadoPara;
				$('#modalVerReservaCorpo').html(lsCorpoReserva);
				$('#modalVerReserva').modal('show');
				*/
			}
        });
    }
	
	$('#filtrarCalendario').click(function () {
		//funcionario = $('#cmbFuncionario').val();
		//filial = $('#cmbFilial').val();		
		$('#calendar').fullCalendar( 'refetchEvents' );
	});
	
});