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

        <!-- BEGIN Container -->
        <div class="container" id="main-container">
            
			<?php include 'includes/navegacao/menu.php'; ?>

				<!-- BEGIN Content -->
				<div id="main-content">
					<!-- BEGIN Page Title -->
					<div class="page-title">
						<div>
							<h1><i class="fa fa-clock-o"></i> Consultar Agenda</h1>
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
												   <option value="">Todos</option>
												   <option value="1">Ana</option>
												   <option value="2">Tati</option>
												   <option value="3">Carmem</option>
												   <option value="4">Kely</option>
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
                
				<footer>
                    <p>2015 © Maria Gata</p>
                </footer>
				
                <a id="btn-scrollup" class="btn btn-circle btn-lg" href="#"><i class="fa fa-chevron-up"></i></a>
            </div>
            <!-- END Content -->
        </div>
        <!-- END Container -->

		<?php include 'includes/navegacao/rodape.php'; ?>
        
         <!--page specific plugin scripts-->
        <script src="assets/jquery-ui/jquery-ui.min.js"></script>
        <script src='assets/fullcalendar/lib/moment.min.js'></script>
		<script src='assets/fullcalendar/lib/jquery-ui.custom.min.js'></script>
		<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
		<script src='assets/fullcalendar/lang/pt-br.js'></script>

        <!--flaty scripts-->
        <script src="js/base.js"></script>
		<script src="js/calendario.js"></script>

    </body>
</html>
