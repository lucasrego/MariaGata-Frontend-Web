<?php
include("includes/util/validar_sessao.php");
include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");
    
include 'includes/navegacao/head.php'; 

include 'includes/navegacao/navbar.php'; 
	
?>
		
		<!--page specific css styles-->		
		<link rel="stylesheet" type="text/css" href="assets/jquery-ui/jquery-ui.min.css" />
		<link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen.min.css" />
        <link rel="stylesheet" href="assets/gritter/css/jquery.gritter.css">
		<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">

		
        <!-- BEGIN Container -->
        <div class="container" id="main-container">
            
			<?php include 'includes/navegacao/menu.php'; ?>

				<!-- BEGIN Content -->
				<div id="main-content">
					<!-- BEGIN Page Title -->
					<div class="page-title">
						<div>
							<h1><i class="fa fa-ticket"></i> Atendimento</h1>
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
							<div class="box box-red">
								<div class="box-title">
									<h3><i class="fa fa-tasks"></i> Comandas</h3>
									<div class="box-tool">
										<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
									</div>
								</div>
								<div class="box-content">
									
									<form action="#" class="form-horizontal">
										<div class="form-group">
											<div class="col-sm-12 col-lg-12 col-xs-12 col-md-12 controls">
												<label for="dataAtendimento" class="col-sm-2 col-xs-2 col-lg-2 control-label"><b>Data</b></label>
												<div class="col-sm-7 col-xs-7 col-lg-7 controls">
													<input type="text" id="dataAtendimento" value="<?php echo date("d/m/Y"); ?>" data-mask="99/99/9999" placeholder="" class="form-control" tabindex="0">
												</div>
												<div class="col-sm-3 col-xs-3 col-lg-3 controls">
													<a id="btnAtualizarDataAtendimento" class="btn btn-sm btn-inverse" href="#"><i class="fa fa-refresh"></i></a>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-12 col-lg-12 controls">
												<select id="listaAtendimentos" class="form-control" width="" size="12" data-placeholder="Comandas" tabindex="-1">
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-12 col-lg-12 col-xs-12 col-md-12 controls">
												<h4 id="totalFaturadoDia" class="col-sm-8 col-xs-8 col-lg-8 campoMoeda"><b>0</b></h4>
												<div class="col-sm-4 col-xs-4 col-lg-4 controls">
													<button type="submit" id="btnConsultarComanda" class="btn btn-inverse btn-sm"><i class="fa fa-search"></i></button>
												</div>
											</div>
										</div>
									</form>								
								</div>
							</div>	
						</div>
						<div class="col-md-9">
							<div class="box box-red">
								<div class="box-title">
									<h3><i class="fa fa-clock-o"></i> Novo Atendimento</h3>
									<div class="box-tool">
										<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
									</div>
								</div>
								<div class="box-content">
									
									<div class="col-md-12">
										<form action="#" class="form-horizontal">
											<div class="form-group">
											   <label class="col-sm-2 col-lg-1 control-label"><h5>Cliente</h5></label>
											   <div class="col-sm-7 col-lg-8 controls">
												  <select id="cmbClientes"  data-placeholder="Selecione" class="col-md-12 chosen"></select>
											   </div>
											   <div class="col-sm-3 col-lg-3 controls">
													<a id="btnNovoCliente" class="btn btn-sm btn-primary" href="#"><i class="fa fa-plus"></i> Novo</a>
													<a id="btnEditarCliente" class="btn btn-sm btn-inverse show-tooltip" title="Editar Cliente" href="#"><i class="fa fa-pencil"></i></a>
													<a id="btnHistoricoCliente" class="btn btn-sm btn-inverse show-tooltip" title="Histórico de Atendimentos"  href="#"><i class="fa fa-book"></i></a>
												</div>		
											</div>
											
										</form>									
									</div>
									<div id="alertaCliente" class="col-md-12 alert alert-info">
										<button class="close" data-dismiss="alert">&times;</button>
										<span id="alertaClienteConteudo"></span>
									</div>
									<table id="tabelaServicos" class="table table-hover table-condensed">
										<thead>
											<tr>
												<th> Serviço/Produto</th>
												<th> Funcionário</th>
												<th> Valor Cobrado</th>
												<th> </th>
											</tr>
										</thead>
										<tbody id="tbodyTabelaServicos"></tbody>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-md-2 col-sm-2 col-lg-2">
									<div class="form-group">
										<label for="textfield2" class="col-xs-3 col-lg-2 control-label">Total</label>
										<div class="col-sm-9 col-lg-10 controls">
											<h3 id="totalServicos" class="campoMoeda">0</h3>
										</div>
									</div>									
								</div>
								<div class="col-md-2 col-sm-2 col-lg-2">
									<div class="form-group">
										<label for="textfield2" class="col-xs-3 col-lg-2 control-label">Vale</label>
										<div class="col-sm-9 col-lg-10 controls">
											<h3 id="valeExistente" class="campoMoeda">0</h3>
										</div>
									</div>									
								</div>
								<div class="col-md-2 col-sm-2 col-lg-2">
									<div class="form-group">
										<label for="textfield2" class="col-xs-3 col-lg-2 control-label">Dinheiro</label>
										<div class="col-sm-9 col-lg-10 controls">
											<input type="text" id="dinheiro" placeholder="" class="form-control campoMoeda campoValorResumo">
										</div>
									</div>
								</div>
								<div class="col-md-2 col-sm-2 col-lg-2">
									<div class="form-group">
										<label for="textfield2" class="col-xs-3 col-lg-2 control-label">Débito</label>
										<div class="col-sm-9 col-lg-10 controls">
											<input type="text" id="debito" placeholder="" class="form-control campoMoeda campoValorResumo">
										</div>
									</div>
								</div>
								<div class="col-md-2 col-sm-2 col-lg-2">
									<div class="form-group">
										<label for="textfield2" class="col-xs-3 col-lg-2 control-label">Crédito</label>
										<div class="col-sm-9 col-lg-10 controls">
											<input type="text" id="credito" placeholder="" class="form-control campoMoeda campoValorResumo">
										</div>
									</div>
								</div>
								<div class="col-md-2 col-sm-2 col-lg-2">
									<div class="form-group">
										<label for="textfield2" class="col-xs-3 col-lg-2 control-label"></label>
										<div class="col-sm-9 col-lg-10 controls">
											<h3 id="valeFuturo" class="campoMoedaNegativo">0</h3>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
							<p>&nbsp;</p>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-lg-12">								
									<div class="form-group">
										<div class="pull-right">
											<p>
											<button type="submit" id="btnConcluirAtendimento" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> CONCLUIR ATENDIMENTO</button>
											</p>
										</div>
									</div>								
								</div>
							</div>													
						</div>
					</div>

					<!-- END Main Content -->
					
					<!--
					<footer>
						<p>2015 © Maria Gata.</p>
					</footer>
					-->
					
					<a id="btn-scrollup" class="btn btn-circle btn-lg" href="#"><i class="fa fa-chevron-up"></i></a>
				</div>
				<!-- END Content -->
                
            </div>
            <!-- END Content -->
        </div>
        <!-- END Container -->
		
		<?php include 'includes/navegacao/modalscliente.php'; ?>
				
		<?php include 'includes/navegacao/rodape.php'; ?>
        
         <!--page specific plugin scripts-->
		<script type="text/javascript" src="assets/jquery-ui/jquery-ui.min.js"></script>
		<script type="text/javascript" src="assets/jquery-ui/datepicker-pt-BR.js"></script>
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/chosen-bootstrap/chosen.jquery.min.js"></script>
        <script type="text/javascript" src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
        <script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="assets/gritter/js/jquery.gritter.min.js"></script>
		<script src="assets/jquery-priceformat/jquery.price_format.2.0.min.js"></script>
		
        <!--flaty scripts-->
		<script src="js/base.js"></script>
		<script src="js/cliente.js"></script>
		<script src="js/atendimento.js"></script>		

    </body>
</html>
