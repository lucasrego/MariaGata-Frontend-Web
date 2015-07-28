<?php
include("includes/util/validar_sessao.php");
include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");

//VALIDAÇÃO DE PERFIL
if ($_SESSION['usuarioperfil'] != 'A') {
	header('Location: tMensagem.php?r=É necessário ter o perfil Administrador para acessar esta página.');
	exit;
}
    
include 'includes/navegacao/head.php'; 

include 'includes/navegacao/navbar.php'; 



?>
		<!--page specific css styles-->
		<link rel="stylesheet" type="text/css" href="assets/bootstrap-daterangepicker/daterangepicker.css" />
		<link rel="stylesheet" href="assets/gritter/css/jquery.gritter.css">
		<link rel="stylesheet" href="css/impressao.css">
		
		<!-- BEGIN Container -->
        <div class="container" id="main-container">
            
			<?php include 'includes/navegacao/menu.php'; ?>

				<!-- BEGIN Content -->
				<div id="main-content">
					<!-- BEGIN Page Title -->
					<div class="page-title">
						<div>
							<h1><i class="fa fa-clock-o"></i> Relatório de Comissão</h1>
							<h4>Relatório de Comissão por Período</h4>
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
							<li class="active">Relatório de Comissão</li>
						</ul>
					</div>
					<!-- END Breadcrumb -->

					<!-- BEGIN Main Content -->
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-content">
									<div class="relatoriocompleto">
										<div class="invoice">
											<div class="row">
												<div class="col-md-6">
													<h2>Relatório de Comissão&nbsp;&nbsp;<button type="button" id="btnImprimir" class="btn no-print"><i class="fa fa-print"></i></button></h2>													
												</div>
												<div class="col-md-6 invoice-info">
													<p class="font-size-17"><strong><i class="fa fa-calendar date-range"></i>&nbsp;&nbsp;<span id="periodoSelecionado" class="date-range">Selecione o período</span></strong></p>
													<!--
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
														<input type="text" class="form-control date-range" />
													</div>
													-->
													<p><span id="dataGeracao"></span></p>
												</div>
											</div>
											
											<hr class="margin-0" />
										</div>
										
										<br />
										
										<div id="corpoRelatorio"></div>
										
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

		<?php include 'includes/navegacao/rodape.php'; ?>
        
        <!--page specific plugin scripts-->
		<script type="text/javascript" src="assets/jquery-print/jquery.print.js"></script>
		<script type="text/javascript" src="assets/bootstrap-daterangepicker/moment.js"></script>
		<script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>
		<script src="assets/gritter/js/jquery.gritter.min.js"></script>
		
        <!--flaty scripts-->
        <script src="js/base.js"></script>
		<script src="js/relatorio.js"></script>
		
    </body>
</html>
