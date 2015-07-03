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
        <!--<link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />-->
        <link rel="stylesheet" href="assets/gritter/css/jquery.gritter.css">
				
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
					
					<!-- INICIO Form Pesquisa -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="box box-green">
								<div class="box-title">
									<h3><i class="fa fa-search"></i> <span id="textoBoxPesquisar">Pesquisar</span></h3>
									<div class="box-tool">
										<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
									</div>
								</div>
								<div id="box-content-pesquisar" class="box-content">
									<form action="#" id="frmPesquisarHorarios" class="form-horizontal">
										<div class="row">
											<div class="col-md-6 ">
											  <!-- BEGIN Left Side -->
											  
												<div class="form-group">
													<label class="col-sm-3 col-lg-2 control-label">Unidade</label>
													<div class="col-sm-9 col-lg-10 controls">
														<select id="unidadeAgendamento" class="form-control chosen" data-placeholder="Selecione" tabindex="1">
															<option value="1">Maria Gata Pituba</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-lg-2 control-label">Data</label>
													<div class="col-sm-9 col-lg-10 controls">
														<!--
														<div id="datepicker"></div>
														<div class="datepicker ll-skin-siena"></div>
														<input class="form-control" id="dataAgendamento" type="text" value="" />
														-->
														<select id="dataAgendamento" class="form-control chosen" data-placeholder="Selecione" tabindex="6">
														</select>														
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-3 col-lg-2 control-label">Cliente</label>
													<div class="col-sm-6 col-lg-7 controls">
														<select id="cmbClientes" class="form-control chosen" data-placeholder="Selecione ou cadastre um novo" tabindex="6">
															
														</select>
													</div>
													<div class="col-sm-2 col-lg-2">
													   <button type="submit" id="btnCadastrarCliente" class="btn btn-inverse btn-smbtn-sm"><i class="fa fa-check"></i> Novo</button>
													</div>
												</div>											
											  <!-- END Left Side -->
										   </div>
										   <div class="col-md-6 ">
											  <!-- BEGIN Right Side -->
											  	<div class="form-group">
													<label class="col-sm-3 col-lg-2 control-label">Pacotes Especiais</label>
													<div class="col-sm-9 col-lg-10 controls">
														<select id="pacotesAgendamento" class="form-control chosen" data-placeholder="Selecione" tabindex="3">
															<option value="">Selecione</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-lg-2 control-label">Serviços de Unha</label>
													<div class="col-sm-9 col-lg-10 controls">
														<select id="esmalteriaAgendamento" class="form-control chosen" data-placeholder="Selecione" tabindex="4">
															<option value="">Selecione</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-lg-2 control-label">Serviços de Cabelo</label>
													<div class="col-sm-9 col-lg-10 controls">
														<select id="escovariaAgendamento" class="form-control chosen" data-placeholder="Selecione" tabindex="5">
															<option value="">Selecione</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-lg-2 control-label">Maquiagem</label>
													<div class="col-sm-9 col-lg-10 controls">
														<select id="maquiagemAgendamento" class="form-control chosen" data-placeholder="Selecione" tabindex="6">
															<option value="">Selecione</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-lg-2 control-label">Depilação</label>
													<div class="col-sm-9 col-lg-10 controls">
														<select id="depilacaoAgendamento" class="form-control chosen" data-placeholder="Selecione" tabindex="6">
															<option value="">Selecione</option>
														</select>
													</div>													
												</div>												
											  <!-- END Right Side -->
										   </div>
										   
										</div> <!-- Fim row -->
										<div class="row">
											<div class="col-md-12 col-sm-12 col-lg-12">													
												<div class="form-group">
													<div class="col-sm-10 col-sm-offset-2 col-lg-7 col-lg-offset-5">
													   <button type="submit" id="btnEncontrarHorarios" class="btn btn-primary"><i class="fa fa-check"></i> Encontrar Horários</button>
													</div>
												</div>
											</div>
										</div>
										</form>
								</div>
							</div>
						</div>
					</div>
						
					<!-- FIM Form Pesquisa -->
					<div id="resultadoPesquisa">
						<div class="row">
							<div class="col-md-6">
								<div class="box" id="boxEsmalteria">
									<div class="box-title">
										<h3><i class="fa fa-arrow-circle-right"></i> Esmalteira</h3>
										<div class="box-tool">
											<a class="btn btn-gray" href="#" id="btnAtendimentoParaleloEsmalteria">Atendimento Paralelo: Não</a>
											<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
										</div>
									</div>
									<div class="box-content" id="boxEsmalteriaConteudo"></div>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="box" id="boxEscovaria">
									<div class="box-title">
										<h3><i class="fa fa-arrow-circle-right"></i> Escovaria</h3>
										<div class="box-tool">
											<!--<a class="btn btn-gray" href="#" id="btnAtendimentoParaleloEscovaria">Atendimento Paralelo: Não</a>-->
											<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
										</div>
									</div>
									<div class="box-content" id="boxEscovariaConteudo"></div>
								</div>
							</div>					
							
						</div> <!-- Fim Row Manicure/Escovista-->
						
						<!--
						<div class="row">
							<div class="col-md-12 col-sm-12 col-lg-12">													
								<div class="form-group">
									<div class="col-sm-10 col-sm-offset-2 col-lg-7 col-lg-offset-5">
									   <button type="button" id="btnNovaPesquisa" class="btn btn-gray"><i class="fa fa-check"></i> Nova Pesquisa</button>
									</div>
									<div class="col-sm-10 col-sm-offset-2 col-lg-7 col-lg-offset-5">
									   <button type="button" id="btnConfirmarAgendamento" class="btn btn-primary"><i class="fa fa-check"></i> Agendar</button>
									</div>
								</div>
							</div>
						</div>
						-->
						<p>
							<button type="button" id="btnNovaPesquisa" class="btn btn-gray"><i class="fa fa-check"></i> Nova Pesquisa</button>
							<button type="button" id="btnConfirmarAgendamento" class="btn btn-primary"><i class="fa fa-check"></i> Agendar</button>
						</p>
					</div> <!-- FIM DIV resultadoPesquisa -->
					
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
		
		<!-- MODAL CADASTRAR CLIENTE -->
		<div id="modalCadastrarCliente" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="modalCadastrarClienteTitulo">Cadastrar Cliente</h3>
					</div>
					<form action="#" id="modalCadastrarClienteForm" method="post" class="form-horizontal" id="validation-form">
						<div class="modal-body">						
							<div class="form-group">
								<label for="textfield2" class="col-xs-3 col-lg-2 control-label">Nome</label>
								<div class="col-sm-9 col-lg-10 controls">
									<input type="text" id="nomeCadastroCliente" placeholder="" class="form-control" tabindex="1">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 col-lg-2 control-label">Celular</label>
								<div class="col-sm-9 col-lg-10 controls">
									<input class="form-control col-md-5" type="text" id="celularCadastroCliente" data-mask="(99) 9999-9999" placeholder="" tabindex="2">
									<span class="help-inline">(99) 9999-9999</span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 col-lg-2 control-label">CPF</label>
								<div class="col-sm-9 col-lg-10 controls">
									<input class="form-control col-md-5" type="text" id="cpfCadastroCliente" data-mask="999.999.999-99" placeholder="" tabindex="3">
									<span class="help-inline">999.999.999-99</span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 col-lg-2 control-label">E-mail</label>
								<div class="col-sm-9 col-lg-10 controls">
									<div class="input-group">
										<span class="input-group-addon">@</span>
										<input class="form-control" type="text" id="emailCadastroCliente" placeholder="E-mail" tabindex="4" />
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" align="left" id="modalCadastrarClienteSalvar">Salvar</button>
							<button class="btn " data-dismiss="modal" id="modalCadastrarClienteFechar">Fechar</button>						
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- FIM MODAL CADASTRAR CLIENTE -->
		
		<!-- MODAL CONFIRMAR AGENDAMENTO -->
		<div id="modalConfirmarAgendamento" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="modalConfirmarAgendamentoTitulo">Confirma Agendamento?</h3>
					</div>
					<form action="#" id="modalConfirmarAgendamentoForm" method="post" class="form-horizontal" id="validation-form">
						<div class="modal-body">
							<div class="form-group">
								<label for="textfield2" class="col-xs-3 col-lg-2 control-label">Unidade</label>
								<div class="col-sm-9 col-lg-10 controls">
									<label for="textfield2" id="modalConfirmarAgendamentoLabelUnidade" class="control-label"></label>
								</div>
							</div>
							<div class="form-group">
								<label for="textfield2" class="col-xs-3 col-lg-2 control-label">Data</label>
								<div class="col-sm-9 col-lg-10 controls">
									<label for="textfield2" id="modalConfirmarAgendamentoLabelData" class="control-label"></label>
								</div>
							</div>
							<div class="form-group">
								<label for="textfield2" class="col-xs-3 col-lg-2 control-label">Cliente</label>
								<div class="col-sm-9 col-lg-10 controls">
									<label for="textfield2" id="modalConfirmarAgendamentoLabelCliente" class="control-label"></label>
								</div>
							</div>
							<div class="form-group">
								<label for="textfield2" class="col-xs-3 col-lg-2 control-label">Serviços</label>
								<div class="col-sm-9 col-lg-10 controls">
									<label for="textfield2" id="modalConfirmarAgendamentoLabelServicos" class="control-label"></label>
								</div>
							</div>							
							<div class="form-group">
								<label for="textfield2" class="col-xs-3 col-lg-2 control-label">Esmalteria</label>
								<div class="col-sm-9 col-lg-10 controls">
									<label for="textfield2" id="modalConfirmarAgendamentoLabelEsmalteria" class="control-label"></label>
								</div>
							</div>
							
							<div class="form-group">
								<label for="textfield2" class="col-xs-3 col-lg-2 control-label">Escovaria</label>
								<div class="col-sm-9 col-lg-10 controls">
									<label for="textfield2" id="modalConfirmarAgendamentoLabelEscovaria" class="control-label"></label>
								</div>
							</div>
							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" align="left" id="modalConfirmarAgendamentoConcluir">Sim</button>
							<button class="btn " data-dismiss="modal" id="modalConfirmarAgendamentoFechar">Revisar</button>						
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- FIM MODAL CONFIRMAR AGENDAMENTO -->
		
		
		<?php include 'includes/navegacao/rodape.php'; ?>
        
        <!--page specific plugin scripts-->
		<script type="text/javascript" src="assets/jquery-ui/jquery-ui.min.js"></script>
		<script type="text/javascript" src="assets/jquery-ui/datepicker-pt-BR.js"></script>
		<script type="text/javascript" src="assets/chosen-bootstrap/chosen.jquery.min.js"></script>
        <script type="text/javascript" src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
        <!--<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>-->
		<script src="assets/gritter/js/jquery.gritter.min.js"></script>
		
        <!--flaty scripts-->
		<script src="js/base.js"></script>
		<script src="js/agendar.js"></script>
		<script src="js/flaty.js"></script>
		
    </body>
</html>
