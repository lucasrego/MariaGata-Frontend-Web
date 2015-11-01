<?php
include("includes/util/validar_sessao.php");
include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");

//VALIDAÇÃO DE PERFIL
if (($_SESSION['usuarioperfil'] != 'A')&&($_SESSION['usuarioperfil'] != 'U')) {
	header('Location: tMensagem.php?r=Você não tem perfil para acessar esta página.');
	exit;
}
    
include 'includes/navegacao/head.php'; 

include 'includes/navegacao/navbar.php'; 

date_default_timezone_set('America/Recife');

?>
		<!--page specific css styles-->
		<link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
        <link rel="stylesheet" type="text/css" href="assets/bootstrap-daterangepicker/daterangepicker.css" />
		<link rel="stylesheet" href="assets/gritter/css/jquery.gritter.css">
		
		<!-- BEGIN Container -->
        <div class="container" id="main-container">
            
			<?php include 'includes/navegacao/menu.php'; ?>

				<!-- BEGIN Content -->
				<div id="main-content">
					<!-- BEGIN Page Title -->
					<div class="page-title">
						<div>
							<h1>
								<i class="fa fa-money"></i> Controle do Caixa: <span id="datacaixa"><?php echo date("d/m/Y") ?></span>
									<?php if ($_SESSION['usuarioperfil'] == 'A') { ?>
										<button type="button" id="btnAlterarData" class="btn"><i class="fa fa-calendar"></i></button>
									<?php } ?>
							</h1>
							<h4>Entrada e saída de dinheiro do Caixa</h4>
						</div>
					</div>
					<!-- END Page Title -->

					<!-- BEGIN Breadcrumb -->
					<!--
					<div id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="fa fa-home"></i>
								<a href="index.html">Home</a>
								<span class="divider"><i class="fa fa-angle-right"></i></span>
							</li>
							<li class="active">Controle do Caixa</li>
						</ul>
					</div>
					-->
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
													<h4>Anterior: <span id="saldoanterior">...</span></h4>
												</div>
												<div class="col-md-6 invoice-info">
													<!--
													<p class="font-size-17"><strong><i class="fa fa-calendar date-range"></i>&nbsp;&nbsp;<span id="periodoSelecionado" class="date-range">Selecione o período</span></strong></p>
													<h2>Saldo Atual: <span id="saldohoje">...</span></h2>
													-->
												</div>
											</div>
											
											<hr class="margin-0" />
										</div>
										
										<br />
										
										<div class="row">
											<div class="col-md-12">
											<div class="clearfix"></div>
												<form action="#" class="form-horizontal">
													<div class="row">
													   <div class="col-md-5 ">
															<div class="form-group">
																<label for="descricao" class="col-xs-3 col-lg-2 control-label">Descrição</label>
																<div class="col-sm-9 col-lg-10 controls">
																	<input type="text" name="descricao" id="descricao" class="form-control">
																</div>
															</div>														
													   </div>
													   <div class="col-md-3 ">
															<div class="form-group">
																<label for="valorEntrada" class="col-xs-3 col-lg-3 control-label">Entrada</label>
																<div class="col-sm-9 col-lg-9 controls">
																	<input type="text" name="valorEntrada" id="valorEntrada" class="form-control campoMoeda">
																</div>
															</div>														
													   </div>
													   <div class="col-md-3 ">
															<div class="form-group">
																<label for="valorSaida" class="col-xs-3 col-lg-3 control-label">Saída</label>
																<div class="col-sm-9 col-lg-9 controls">
																	<input type="text" name="valorSaida" id="valorSaida" class="form-control campoMoeda">
																</div>
															</div>														
													   </div>
													   <div class="col-md-1 ">
															<div class="form-group">
																<div class="col-sm-9 col-lg-10 controls">
																	<button id="btnIncluir" class="btn btn-lime">Incluir</button>
																</div>
															</div>														
													   </div>
													</div>
												 </form>
											</div>
										</div>
										
										<div class="row">
											<div class="col-md-12">
												<div class="clearfix"></div>
												<div id="tabelaCaixa"></div>																							
											</div>
										</div>
										
										<div class="row">
											<div class="col-md-12 text-right">
												<h3>Saldo Atual: <span id="saldohoje">...</span></h3>
											</div>
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

		<?php include 'includes/navegacao/rodape.php'; ?>
        
        <!--page specific plugin scripts-->
		<script type="text/javascript" src="assets/jquery-print/jquery.print.js"></script>
		<script type="text/javascript" src="assets/bootstrap-daterangepicker/moment.js"></script>
		<script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>
		<script src="assets/gritter/js/jquery.gritter.min.js"></script>
		<script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		<script src="assets/jquery-cookie/jquery.cookie.js"></script>
		<script type="text/javascript" src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
        <script src="assets/jquery-priceformat/jquery.price_format.2.0.min.js"></script>
		<script src="assets/jquery-redirect/jquery.redirect.js"></script>
		<script type="text/javascript" src="assets/bootstrap-daterangepicker/moment.js"></script>
		<script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>
		<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        
        <!--flaty scripts-->
        <script src="js/base.js"></script>
		<script src="js/controleCaixa.js"></script>
		
    </body>
</html>
