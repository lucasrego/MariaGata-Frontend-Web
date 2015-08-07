<?php
include("includes/util/validar_sessao.php");
include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");
    
include 'includes/navegacao/head.php'; 

include 'includes/navegacao/navbar.php'; 
	
?>

        <!-- BEGIN Container -->
        <div class="container" id="main-container">
            
			<?php include 'includes/navegacao/menu.php'; ?>

				<!-- BEGIN Content -->
				<div id="main-content">
					<!-- BEGIN Page Title -->
					<div class="page-title">
						<div>
							<h1><i class="fa fa-clock-o"></i> Disponibilidade de Horários</h1>
							<h4>Selecione o horário e profissionais</h4>
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
							<li class="active">Disponibilidade de Horários</li>
						</ul>
					</div>
					<!-- END Breadcrumb -->

					<!-- BEGIN Main Content -->
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-title">
									<h3><i class="fa fa-bar-chart-o"></i> Bar Chart</h3>
									<div class="box-tool">
										<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
										<a data-action="close" href="#"><i class="fa fa-times"></i></a>
									</div>
								</div>
								<div class="box-content">
									<div id="vendasPorDia" style="height:350px;"></div>
									<div class="btn-toolbar">
										
										<div class="btn-group graphControls pull-right">
											<input type="button" class="btn" value="Bars" />
											<input type="button" class="btn" value="Lines" />
											<input type="button" class="btn" value="Lines with steps" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="box">
								<div class="box-title">
									<h3><i class="fa fa-bar-chart-o"></i> Forma de Pagamento</h3>									
								</div>
								<div class="box-content">
									<div id="vendarPorFormaPagamento" class="chart"></div>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="box">
								<div class="box-title">
									<h3><i class="fa fa-bar-chart-o"></i> Interactive Chart</h3>									
								</div>
								<div class="box-content">
									<div id="graph_3" class="chart"></div>
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
		<script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		<script src="assets/flot/jquery.flot.js"></script>
        <script src="assets/flot/jquery.flot.resize.js"></script>
        <script src="assets/flot/jquery.flot.pie.js"></script>
        <script src="assets/flot/jquery.flot.stack.js"></script>
        <script src="assets/flot/jquery.flot.crosshair.js"></script>

        <!--flaty scripts-->
        <script src="js/base.js"></script>
		<script src="js/painel.js"></script>

    </body>
</html>
