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
													<h2>Relatório de Comissão&nbsp;&nbsp;<button type="button" id="btnImprimir" class="btn"><i class="fa fa-print"></i></button></h2>													
												</div>
												<div class="col-md-6 invoice-info">
													<p class="font-size-17"><strong>01/07/2015 a 31/07/2015</strong></p>
													<p>Gerado em 05/08/2015</p>
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
		<script src="assets/jquery-print/jquery-print.js"></script>
		
        <!--flaty scripts-->
        <script src="js/base.js"></script>
		<script src="js/relatorio.js"></script>
		
    </body>
</html>
