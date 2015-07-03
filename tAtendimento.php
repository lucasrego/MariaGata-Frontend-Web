<?php
include("includes/util/validar_sessao.php");
include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");
    
include 'includes/navegacao/head.php'; 

include 'includes/navegacao/navbar.php'; 
	
?>
		
		<!--page specific css styles-->		
		<link rel="stylesheet" type="text/css" href="assets/jquery-ui/jquery-ui.min.css" />
		<link rel="stylesheet" type="text/css" href="assets/jquery-ui/siena.datepicker.css" />
        <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen.min.css" />
        <link rel="stylesheet" href="assets/gritter/css/jquery.gritter.css">
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">

		
        <!-- BEGIN Container -->
        <div class="container" id="main-container">
            
			<?php include 'includes/navegacao/menu.php'; ?>

				<!-- BEGIN Content -->
				<div id="main-content">
					<!-- BEGIN Page Title -->
					<div class="page-title">
						<div>
							<h1><i class="fa fa-clock-o"></i> Atendimento</h1>
							<h4>Controle das comandas</h4>
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
							<li class="active">Atendimento</li>
						</ul>
					</div>
					-->
					<!-- END Breadcrumb -->

					<!-- BEGIN Main Content -->
					<div class="row">
						<div class="col-md-3">
							<form action="#" class="form-horizontal">
								<div class="form-group">
									<div class="col-sm-12 col-lg-12 controls">
										<select class="form-control" width="" size="15" data-placeholder="Comandas" tabindex="1">
											<option class="comandaAberta" value="Category 1">Category 1</option>
											<option class="comandaPaga" value="Category 2">Category 2</option>
											<option class="comandaAberta" value="Category 3">Category 5</option>
											<option class="comandaCancelada" value="Category 4">Category 4</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-offset-1">
										<button type="submit" id="btnNovaComanda" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Nova Comanda</button>
										<button type="submit" id="btnCancelarComanda" class="btn btn-gray btn-sm"><i class="fa fa-close"></i> Cancelar</button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-9">
							<div class="box box-red">
								<div class="box-title">
									<h3><i class="fa fa-table"></i> Serviços e Produtos</h3>
									<div class="box-tool">
										<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
									</div>
								</div>
								<div class="box-content">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>#</th>
												<th><i class="fa fa-user"></i> Serviço/Produto</th>
												<th><i class="fa fa-user-md"></i> Funcionário</th>
												<th><i class="fa fa-twitter"></i> Username</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>Mark</td>
												<td><span class="label label-info"><i class="fa fa-twitter"></i> New Twitte</span> Otto</td>
												<td><span class="badge badge-success">+5</span> @mdo</td>
											</tr>
											<tr>
												<td>2</td>
												<td>Jacob</td>
												<td><span class="label label-small">No Update</span> Thornton</td>
												<td>@fat</td>
											</tr>
											<tr>
												<td>3</td>
												<td>Larry</td>
												<td><span class="label label-important">Huge Update!</span> the Bird</td>
												<td><span class="badge badge-important">+800</span> @twitter</td>
											</tr>
										</tbody>
									</table>
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
		<script type="text/javascript" src="assets/jquery-ui/jquery-ui.min.js"></script>
		<script type="text/javascript" src="assets/jquery-ui/datepicker-pt-BR.js"></script>
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/chosen-bootstrap/chosen.jquery.min.js"></script>
        <script type="text/javascript" src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
        <script src="assets/gritter/js/jquery.gritter.min.js"></script>
		
        <!--flaty scripts-->
		<script src="js/base.js"></script>
		<script src="js/atendimento.js"></script>
		<script src="js/flaty.js"></script>
		

    </body>
</html>
