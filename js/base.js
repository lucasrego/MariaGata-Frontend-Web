
//urlBackend = "http://mariagata.com.br/sistemateste/mariagata.php"; //Teste

var ambiente = "TES"; //TES ou PRO

if (ambiente == "TES") {
	urlBackend = "http://mariagata.com.br/sistemateste/mariagata.php"; //Teste
	$('body').removeClass("skin-pink").addClass("skin-black");
} else {
	urlBackend = "http://mariagata.com.br/sistema/mariagata.php"; //Produção
	$('body').removeClass("skin-black").addClass("skin-pink");
}




function exibirMensagem(titulo, msg) {
	$.gritter.add({
		title: titulo,
		text: msg
	});
}

$(function() {
	
	$( document ).ajaxStart(function() {
		$('.ajax-loading').show();
	});

	$( document ).ajaxStop(function() {
		$('.ajax-loading').hide();
	});

	$( document ).on( 'submit', 'form', function( e ) {
		//Previne submit dos formularios. Será controlado pelo clique nos botões
		event.preventDefault();
	});
	
	//---------------- Sidebar -------------------------------//
    //Scrollable fixed sidebar
    var scrollableSidebar = function() {
        if ($('#sidebar.sidebar-fixed').size() == 0) {
            $('#sidebar .nav').css('height', 'auto');
            return;
        }
        if ($('#sidebar.sidebar-fixed.sidebar-collapsed').size() > 0) {
            $('#sidebar .nav').css('height', 'auto');
            return;
        }
        var winHeight = $(window).height() - 90;
        $('#sidebar.sidebar-fixed .nav').slimScroll({height: winHeight + 'px', position: 'left'});
    }
    scrollableSidebar();
    //Submenu dropdown
    $('#sidebar a.dropdown-toggle').click(function() {
        var submenu = $(this).next('.submenu');
        var arrow = $(this).children('.arrow');
        if (arrow.hasClass('fa-angle-right')) {
            arrow.addClass('anim-turn90');
        }
        else {
            arrow.addClass('anim-turn-90');
        }
        submenu.slideToggle(400, function(){
            if($(this).is(":hidden")) {
                arrow.attr('class', 'arrow fa fa-angle-right');
            } else {
                arrow.attr('class', 'arrow fa fa-angle-down');
            }
            arrow.removeClass('anim-turn90').removeClass('anim-turn-90');
        });
    });

    //Collapse button
    $('#sidebar.sidebar-collapsed #sidebar-collapse > i').attr('class', 'fa fa-angle-double-right');
    $('#sidebar-collapse').click(function(){
        $('#sidebar').toggleClass('sidebar-collapsed');
        if ($('#sidebar').hasClass('sidebar-collapsed')) {
            $('#sidebar-collapse > i').attr('class', 'fa fa-angle-double-right');
            $.cookie('sidebar-collapsed', 'true');
            $("#sidebar ul.nav-list").parent('.slimScrollDiv').replaceWith($("#sidebar ul.nav-list"));
        } else {
            $('#sidebar-collapse > i').attr('class', 'fa fa-angle-double-left');
            $.cookie('sidebar-collapsed', 'false');
            scrollableSidebar();
        }
    });

    $('#sidebar').on('show.bs.collapse', function () {
        if ($(this).hasClass('sidebar-collapsed')) {
            $(this).removeClass('sidebar-collapsed');
        }
    });

    //--------------------- Go Top Button ---------------------//
    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('#btn-scrollup').fadeIn();
        } else {
            $('#btn-scrollup').fadeOut();
        }
    });
    $('#btn-scrollup').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });
	
	//----------------------- Chosen Select ---------------------//
    if (jQuery().chosen) {
        $(".chosen").chosen({
            no_results_text: "Ops, não encontramos nada com: ",
            width: "100%",
			search_contains: true
        });

        $(".chosen-with-diselect").chosen({
            allow_single_deselect: true,
            width: "100%"
        });
    }
	
	
	//------------------------- Table --------------------------//
    //Check all and uncheck all table rows
    $('.table > thead > tr > th:first-child > input[type="checkbox"]').change(function() {
        var check = false;
        if ($(this).is(':checked')) {
            check = true;
        }
        $(this).parents('thead').next().find('tr > td:first-child > input[type="checkbox"]').prop('checked', check);
    })

    $('.table > tbody > tr > td:first-child > input[type="checkbox"]').change(function() {
        var check = false;
        if ($(this).is(':checked')) {
            check = true;
        }
        if (!check) {
            $('.table > thead > tr > th:first-child > input[type="checkbox"]').prop('checked', false);
        }
    })
	
	//------------------------------ Form validation --------------------------//
    if (jQuery().validate) {
        var removeSuccessClass = function(e) {
            $(e).closest('.form-group').removeClass('has-success');
        }
        var $validator = $('#validation-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",

            invalidHandler: function (event, validator) { //display error alert on form submit              
                
            },

            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change dony by hightlight
                $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
                setTimeout(function(){removeSuccessClass(element);}, 3000);
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
            }
        });
    }
	
});