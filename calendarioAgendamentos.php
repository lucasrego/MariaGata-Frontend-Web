<?php
include("includes/util/validar_sessao.php");
include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");
    
include 'includes/navegacao/head.php'; 

include 'includes/navegacao/navbar.php'; 
	
?>
		
		<!--page specific css styles-->
        <link rel="stylesheet" href="assets/jquery-ui/jquery-ui.min.css" />
        <link rel="stylesheet" href="assets/fullcalendar/fullcalendar/fullcalendar.css" />
		<link rel="stylesheet" href="assets/gritter/css/jquery.gritter.css">

        <!-- BEGIN Container -->
        <div class="container" id="main-container">
            
			<?php include 'includes/navegacao/menu.php'; ?>

				<!-- BEGIN Content -->
				<div id="main-content">
					<!-- BEGIN Page Title -->
					<div class="page-title">
						<div>
							<h1><i class="fa fa-search"></i> Consultar Agenda</h1>
							<h4>Agendamentos Maria Gata</h4>
						</div>
					</div>
					<!-- END Page Title -->

					<!-- BEGIN Breadcrumb -->
					<div id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="fa fa-home"></i>
								<a href="index.html">Home</a>
								<span class="divider"><i class="fa fa-angle-right"></i></span>
							</li>
							<li class="active">Consultar Agenda</li>
						</ul>
					</div>
					<!-- END Breadcrumb -->

					<!-- BEGIN Main Content -->
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-title">
									<h3><i class="fa fa-calendar"></i> Calendário</h3>
									<div class="box-tool">
										<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
										<a data-action="close" href="#"><i class="fa fa-times"></i></a>
									</div>
								</div>
								<div class="box-content">
									<div class="row">
									  <div class="col-md-3 responsive" data-tablet="col-md-12 fix-margin" data-desktop="col-md-8">
										 <!-- BEGIN DRAGGABLE EVENTS PORTLET-->
										 <h3 class="event-form-title">Filtros</h3>
										 <div id="external-events">
											<form class="inline-form">
											   <p>&nbsp;</p>
											   <p>Unidade:</p>
											   <p>
												 <select id="cmbFilial" data-placeholder="Filial" class="col-md-12 chosen">
												   <option value="1">Maria Gata Pituba</option>
												 </select>
											   </p>
											   <p>&nbsp;</p>
											   <p>Funcionário:</p>
											   <p>
												 <select id="cmbFuncionario" data-placeholder="Funcionário" class="col-md-12 chosen">
													<option value='' selected>Todos</option>
												 </select>
											   </p>
											   <p>&nbsp;</p>
											   <p><a href="#" id="filtrarCalendario" class="btn btn-primary">Filtrar</a></p>
											</form>
											<hr />
											<hr class="visible-sm" />
										 </div>
										 <!-- END DRAGGABLE EVENTS PORTLET-->
									  </div>
									  <div class="col-md-9">
										 <div id="calendar" class="has-toolbar"></div>
									  </div>
								   </div>
								</div>
							</div>
						</div>
					</div>
					<!-- END Main Content -->
					
					<footer>
						<p>2015 © Maria Gata.</p>
					</footer>

					<a id="btn-scrollup" class="btn btn-circle btn-lg" href="#"><i class="fa fa-chevron-up"></i></a>
				</div>
				<!-- END Content -->
               
            </div>
            <!-- END Content -->
        </div>
        <!-- END Container -->
				
		<!-- MODAL CONSULTAR/CANCELAR AGENDAMENTO -->
		<div id="modalConsultarAgendamento" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="modalConsultarAgendamentoTitulo">Dados do Agendamento</h3>
					</div>
					<form action="#" id="modalConsultarAgendamentoForm" method="post" class="form-horizontal" id="validation-form">
						<input type="hidden" id="modalConsultarAgendamentoLabelAgendamento" value="" />
						<div class="modal-body">
							<div class="form-group">
								<label for="textfield2" class="col-xs-3 col-lg-2 control-label">Cliente</label>
								<div class="col-sm-9 col-lg-10 controls">
									<label for="textfield2" id="modalConsultarAgendamentoLabelCliente" class="control-label"></label>
								</div>
							</div>
							<div class="form-group">
								<label for="textfield2" class="col-xs-3 col-lg-2 control-label">Data</label>
								<div class="col-sm-9 col-lg-10 controls">
									<label for="textfield2" id="modalConsultarAgendamentoLabelData" class="control-label"></label>
								</div>
							</div>
							<div class="form-group">
								<label for="textfield2" class="col-xs-3 col-lg-2 control-label">Serviços</label>
								<div class="col-sm-9 col-lg-10 controls">
									<label for="textfield2" id="modalConsultarAgendamentoLabelServicos" class="control-label"></label>
								</div>
							</div>							
							<div class="form-group">
								<label for="textfield2" class="col-xs-3 col-lg-2 control-label">Funcionários</label>
								<div class="col-sm-9 col-lg-10 controls">
									<label for="textfield2" id="modalConsultarAgendamentoLabelFuncionarios" class="control-label"></label>
								</div>
							</div>
							
						</div>
						<div class="modal-footer">
							<div class="btn-group">
								<a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle">Cancelar <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="#" id="modalConsultarAgendamentoCancelar">Confirmar Cancelamento</a></li>									
								</ul>
							</div>
							<!--<button type="button" class="btn btn-danger" align="left" id="modalConsultarAgendamentoCancelar">Cancelar Agendamento</button>-->
							<button class="btn" data-dismiss="modal" id="modalConsultarAgendamentoFechar">Fechar</button>		
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- FIM MODAL CONFIRMAR AGENDAMENTO -->
		
		<?php include 'includes/navegacao/rodape.php'; ?>
        
         <!--page specific plugin scripts-->
        <script src="assets/jquery-ui/jquery-ui.min.js"></script>
        <script src='assets/fullcalendar/lib/moment.min.js'></script>
		<script src='assets/fullcalendar/lib/jquery-ui.custom.min.js'></script>
		<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
		<script src='assets/fullcalendar/lang/pt-br.js'></script>
		<script src="assets/gritter/js/jquery.gritter.min.js"></script>

        <!--flaty scripts-->
        <script src="js/base.js"></script>
		<script src="js/calendario.js"></script>

    </body>
</html>
