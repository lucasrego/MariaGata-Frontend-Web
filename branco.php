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
									<h3><i class="fa fa-calendar-o"></i> Manicure</h3>
									<div class="box-tool">
										<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
									</div>
								</div>
								<div class="box-content">

									<div class="row">
										<div class="col-md-12">
											<div class="box">
												<div class="box-title">
													<h3><i class="fa fa-user"></i> Ana</h3>
													<div class="box-tool">
														<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
													</div>
												</div>
												<div class="box-content">
													<div class="btn-toolbar">
														<button class="btn btn-pink">09:00</button>
														<button class="btn btn-pink">09:30</button>
														<button class="btn btn-pink">10:00</button>
														<button class="btn btn-gray disabled">10:30</button>
														<button class="btn btn-pink">11:00</button>
														<button class="btn btn-gray disabled">11:30</button>
														<button class="btn btn-pink">12:00</button>
														<button class="btn btn-pink">12:30</button>
														<button class="btn btn-pink">13:00</button>
														<button class="btn btn-pink">13:30</button>
														<button class="btn btn-pink">14:00</button>
														<button class="btn btn-pink">14:30</button>
														<button class="btn btn-gray disabled">15:00</button>
														<button class="btn btn-gray disabled">15:30</button>
														<button class="btn btn-pink">16:00</button>
														<button class="btn btn-pink">17:30</button>
														<button class="btn btn-pink">18:00</button>													
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-12">
											<div class="box">
												<div class="box-title">
													<h3><i class="fa fa-user"></i> Tati</h3>
													<div class="box-tool">
														<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
													</div>
												</div>
												<div class="box-content">
													<div class="btn-toolbar">
														<button class="btn btn-pink">09:00</button>
														<button class="btn btn-pink">09:30</button>
														<button class="btn btn-pink">10:00</button>
														<button class="btn btn-gray disabled">10:30</button>
														<button class="btn btn-pink">11:00</button>
														<button class="btn btn-gray disabled">11:30</button>
														<button class="btn btn-pink">12:00</button>
														<button class="btn btn-pink">12:30</button>
														<button class="btn btn-pink">13:00</button>
														<button class="btn btn-pink">13:30</button>
														<button class="btn btn-pink">14:00</button>
														<button class="btn btn-pink">14:30</button>
														<button class="btn btn-gray disabled">15:00</button>
														<button class="btn btn-gray disabled">15:30</button>
														<button class="btn btn-pink">16:00</button>
														<button class="btn btn-pink">17:30</button>
														<button class="btn btn-pink">18:00</button>													
													</div>
												</div>
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


        <!--flaty scripts-->
        <script src="js/base.js"></script>

    </body>
</html>
