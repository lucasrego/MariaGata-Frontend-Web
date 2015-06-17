<?php
include("includes/util/validar_sessao.php");
include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");
    
include 'includes/navegacao/head.php'; 

include 'includes/navegacao/navbar.php'; 
	
?>

		<!--page specific css styles-->
        <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen.min.css" />
        <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
        
		
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
									<h3><i class="fa fa-bars"></i> Pesquisar Horários</h3>
									<div class="box-tool">
										<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
									</div>
								</div>
								<div class="box-content">
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
													<div class="col-sm-5 col-lg-3 controls">
														<input class="form-control date-picker" id="dataAgendamento" size="16" type="text" value="" />
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-3 col-lg-2 control-label">Cliente</label>
													<div class="col-sm-9 col-lg-10 controls">
														<select id="cmbClientes" class="form-control chosen" data-placeholder="Selecione ou cadastre" tabindex="6">
															<option value=""></option>
															<option value="0">CADASTRAR NOVO CLIENTE</option>
															<option value="1">Maria</option>
															<option value="2">Joana</option>
														</select>
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
															<option value="0"> </option>
															<option value="7">Escova + Pé e Mão + Hidratação</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-lg-2 control-label">Serviços de Unhas</label>
													<div class="col-sm-9 col-lg-10 controls">
														<select id="esmalteriaAgendamento" class="form-control chosen" data-placeholder="Selecione" tabindex="4">
															<option value="0"> </option>
															<option value="1">Pé e Mão</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-lg-2 control-label">Serviços de Cabelo</label>
													<div class="col-sm-9 col-lg-10 controls">
														<select id="escovariaAgendamento" class="form-control chosen" data-placeholder="Selecione" tabindex="5">
															<option value="0"> </option>
															<option value="1">Escova</option>
															<option value="2">Hidratação</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-lg-2 control-label">Maquiagem</label>
													<div class="col-sm-9 col-lg-10 controls">
														<select id="maquiagemAgendamento" class="form-control chosen" data-placeholder="Selecione" tabindex="6">
															<option value="0"> </option>
															<option value="1">Maquiagem Simples</option>
															<option value="2">Buço</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 col-lg-2 control-label">Depilação</label>
													<div class="col-sm-9 col-lg-10 controls">
														<select id="depilacaoAgendamento" class="form-control chosen" data-placeholder="Selecione" tabindex="6">
															<option value="0"> </option>
															<option value="1">Maquiagem Simples</option>
															<option value="2">Buço</option>
														</select>
													</div>
												</div>												
											  <!-- END Right Side -->
										   </div>
										   
										</div> <!-- Fim row -->
										<div class="row">
											<div class="col-md-12 ">
												<div class="form-group">
													<div class="col-sm-12 col-sm-offset-3 col-lg-3">
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
					
					
					<div class="row">
						<div class="col-md-6">
							<div class="box" id="manicure">
								<div class="box-title">
									<h3><i class="fa fa-calendar-o"></i> Manicure</h3>
									<div class="box-tool">
										<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
									</div>
								</div>
								<div class="box-content">

									<div class="row">
										<div class="col-md-12">
											<div class="box" id="func1">
												<div class="box-title">
													<h3><i class="fa fa-user"></i> Carmem</h3>
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
											<div class="box" id="func2">
												<div class="box-title">
													<h3><i class="fa fa-user"></i> Kely</h3>
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
						
						<div class="col-md-6">
							<div class="box" id="manicure">
								<div class="box-title">
									<h3><i class="fa fa-calendar-o"></i> Escovista</h3>
									<div class="box-tool">
										<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
									</div>
								</div>
								<div class="box-content">

									<div class="row">
										<div class="col-md-12">
											<div class="box" id="func1">
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
											<div class="box" id="func2">
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
						
					</div> <!-- Fim Row Manicure/Escovista-->

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
		
		<!-- BEGIN MODALS -->
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
									<input type="text" id="nomeCadastroCliente" placeholder="Sem acentos" class="form-control">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 col-lg-2 control-label">CPF</label>
								<div class="col-sm-9 col-lg-10 controls">
									<input class="form-control col-md-5" type="text" id="cpfCadastroCliente" data-mask="999.999.999-99" placeholder="">
									<span class="help-inline">999.999.999-99</span>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 col-lg-2 control-label">E-mail</label>
								<div class="col-sm-9 col-lg-10 controls">
									<div class="input-group">
										<span class="input-group-addon">@</span>
										<input class="form-control" type="text" id="emailCadastroCliente" placeholder="E-mail" />
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 col-lg-2 control-label">Celular</label>
								<div class="col-sm-9 col-lg-10 controls">
									<input class="form-control col-md-5" type="text" id="celularCadastroCliente" data-mask="(99) 9999-9999" placeholder="">
									<span class="help-inline">(99) 9999-9999</span>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn" align="left" id="modalCadastrarClienteSalvar">Salvar</button>
							<button class="btn btn-primary" data-dismiss="modal" id="modalCadastrarClienteFechar">Fechar</button>						
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<?php include 'includes/navegacao/rodape.php'; ?>
        
        <!--page specific plugin scripts-->
		<script type="text/javascript" src="assets/chosen-bootstrap/chosen.jquery.min.js"></script>
        <script type="text/javascript" src="assets/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
        <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
        

        <!--flaty scripts-->
		<script src="js/base.js"></script>
		<script src="js/agendar.js"></script>
		<script src="js/flaty.js"></script>

    </body>
</html>
