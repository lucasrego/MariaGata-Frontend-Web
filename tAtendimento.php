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
											<div class="col-sm-12 col-lg-12 controls">
												<label for="dataAtendimento" class="col-sm-2 col-xs-2 col-lg-2 control-label"><b>Data</b></label>
												<div class="col-sm-7 col-sm-7 col-lg-7 controls">
													<input type="text" id="dataAtendimento" value="<?php echo date("d/m/Y"); ?>" data-mask="99/99/9999" placeholder="" class="form-control" tabindex="0">
												</div>
												<div class="col-sm-3 col-lg-3 controls">
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
											<div class="col-xs-offset-4 col-sm-offset-4 col-md-offset-1 col-lg-offset-2">
												<button type="submit" id="btnCancelarComanda" class="btn btn-inverse btn-sm"><i class="fa fa-search"></i> Detalhes Comanda</button>
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
											   <div class="col-sm-8 col-lg-9 controls">
												  <select data-placeholder="Selecione" class="col-md-12 chosen cmbClientes"></select>
											   </div>
											   <div class="col-sm-2 col-lg-2 controls">
													<a id="btnNovoCliente" class="btn btn-sm btn-primary" href="#"><i class="fa fa-plus"></i> Novo</a>
												</div>		
											</div>
											
										</form>									
									</div>
									<div id="alertaCliente" class="col-md-12 alert alert-info">
										<button class="close" data-dismiss="alert">&times;</button>
										<span id="alertaClienteConteudo"></span>
									</div>
									<table id="tabelaServicos" class="table table-hover">
										<thead>
											<tr>
												<th> Serviço/Produto</th>
												<th> Funcionário</th>
												<th> Valor Cobrado</th>
												<th> </th>
											</tr>
										</thead>
										<tbody id="tbodyTabelaServicos">
											<!--
											<tr>
												<td>
													<select data-placeholder="Selecione" class="col-md-12 chosen cmbServico">
													</select>
												</td>
												<td>
													<select data-placeholder="Selecione" class="col-md-12 chosen cmbFuncionario">
													</select>
												</td>
												<td>
													<div class="col-sm-9 col-lg-10 controls">
														<input type="text" id="valorCobrado" placeholder="" class="form-control campoMoeda campoValorTabelaServicos tblValorCobrado">
													</div>
												</td>
												<td>
													<div class="btn-group">
														<a class="btn btn-sm btn-danger show-tooltip btnLimparLinha" title="Excluir" href="#"><i class="fa fa-trash-o"></i></a>
														<a class="btn btn-sm btn-primary show-tooltip btnNovaLinha" title="Incluir Serviço" href="#"><i class="fa fa-plus-circle"></i></a>
													</div>
												</td>
											</tr>
											-->
										</tbody>
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
		
		<!-- MODAL CADASTRAR CLIENTE -->
		<div id="modalCadastrarCliente" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="modalCadastrarClienteTitulo">Novo Cliente</h3>
					</div>
					<form action="#" id="modalCadastrarClienteForm" method="post" class="form-horizontal" id="validation-form">
						<div class="modal-body">						
							<div class="form-group">
								<label for="nomeCadastroCliente" class="col-xs-2 col-lg-2 control-label">Nome</label>
								<div class="col-sm-4 col-lg-4 controls">
									<input type="text" id="nomeCadastroCliente" placeholder="" class="form-control" tabindex="1">
								</div>
								<label for="sobrenomeCadastroCliente" class="col-xs-2 col-lg-2 control-label">Sobrenome</label>
								<div class="col-sm-4 col-lg-4 controls">
									<input type="text" id="sobrenomeCadastroCliente" placeholder="" class="form-control" tabindex="2">
								</div>
							</div>
							<div class="form-group">
								<label for="observacaoCadastroCliente" class="col-xs-2 col-lg-2 control-label">Obs</label>
								<div class="col-sm-4 col-lg-4 controls">
									<input type="text" id="observacaoCadastroCliente" placeholder="" class="form-control" tabindex="3">
								</div>
								<label for="aniversarioCadastroCliente" class="col-xs-2 col-lg-2 control-label">Aniversário</label>
								<div class="col-sm-4 col-lg-4 controls">
									<input type="text" id="aniversarioCadastroCliente" data-mask="99/99" placeholder="" class="form-control" tabindex="4">
									<span class="help-inline">Ex: 08/11</span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 col-lg-2 control-label">Celular</label>
								<div class="col-sm-4 col-lg-4 controls">
									<input class="form-control col-md-5" type="text" id="celularCadastroCliente" data-mask="(99) 9999-9999" placeholder="" tabindex="5">
									<span class="help-inline">(99) 9999-9999</span>
								</div>
								<label class="col-sm-2 col-lg-2 control-label">CPF</label>
								<div class="col-sm-4 col-lg-4 controls">
									<input class="form-control col-md-5" type="text" id="cpfCadastroCliente" data-mask="999.999.999-99" placeholder="" tabindex="6">
									<span class="help-inline">999.999.999-99</span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 col-lg-2 control-label">E-mail</label>
								<div class="col-sm-9 col-lg-10 controls">
									<div class="input-group">
										<span class="input-group-addon">@</span>
										<input class="form-control" type="text" id="emailCadastroCliente" placeholder="E-mail" tabindex="7" />
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" align="left" id="modalCadastrarClienteSalvar" tabindex="8">Salvar</button>
							<button class="btn " data-dismiss="modal" id="modalCadastrarClienteFechar" tabindex="9">Fechar</button>						
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- FIM MODAL CADASTRAR CLIENTE -->
		
		
		<?php include 'includes/navegacao/rodape.php'; ?>
        
         <!--page specific plugin scripts-->
		<script type="text/javascript" src="assets/jquery-ui/jquery-ui.min.js"></script>
		<script type="text/javascript" src="assets/jquery-ui/datepicker-pt-BR.js"></script>
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/chosen-bootstrap/chosen.jquery.min.js"></script>
        <script type="text/javascript" src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
        <script src="assets/gritter/js/jquery.gritter.min.js"></script>
		<script src="assets/jquery-priceformat/jquery.price_format.2.0.min.js"></script>
		
        <!--flaty scripts-->
		<script src="js/base.js"></script>
		<script src="js/atendimento.js"></script>
		<script src="js/flaty.js"></script>
		

    </body>
</html>
