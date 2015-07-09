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
		
<!-- MODAL HISTÓRICO DE ATENDIMENTO DO CLIENTE -->
<div id="modalHistoricoCliente" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="modalHistoricoClienteTitulo">Histórico do Cliente</h3>
			</div>
			<div class="modal-body">						
				<div class="row">
					<div class="col-md-12 slimScroll" style="height: 70px">
						<table class="table table-condensed">
							<thead>
								<tr>
									<th>#</th>
									<th>Data</th>
									<th>Total</th>
									<th>Serviços / Produtos</th>
								</tr>
							</thead>
							<tbody id="tbodyTabelaHistoricoAtendimentosCliente"></tbody>									
						</table>									
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn " data-dismiss="modal" id="modalHistoricoClienteFechar" tabindex="9">Fechar</button>
			</div>
			
		</div>
	</div>
</div>
<!-- FIM MODAL HISTÓRICO DE ATENDIMENTO DO CLIENTE -->

<!-- MODAL EDITAR CLIENTE -->
<div id="modalEditarCliente" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="modalEditarClienteTitulo">Editar Dados Cliente</h3>
			</div>
			<form action="#" id="modalEditarClienteForm" method="post" class="form-horizontal" id="validation-form">
				<input type="hidden" id="IDEditarCliente" placeholder="" class="form-control">
				<div class="modal-body">						
					<div class="form-group">
						<label for="nomeEditarCliente" class="col-xs-2 col-lg-2 control-label">Nome</label>
						<div class="col-sm-4 col-lg-4 controls">
							<input type="text" id="nomeEditarCliente" placeholder="" class="form-control" tabindex="1">
						</div>
						<label for="sobrenomeEditarCliente" class="col-xs-2 col-lg-2 control-label">Sobrenome</label>
						<div class="col-sm-4 col-lg-4 controls">
							<input type="text" id="sobrenomeEditarCliente" placeholder="" class="form-control" tabindex="2">
						</div>
					</div>
					<div class="form-group">
						<label for="observacaoEditarCliente" class="col-xs-2 col-lg-2 control-label">Obs</label>
						<div class="col-sm-4 col-lg-4 controls">
							<input type="text" id="observacaoEditarCliente" placeholder="" class="form-control" tabindex="3">
						</div>
						<label for="aniversarioEditarCliente" class="col-xs-2 col-lg-2 control-label">Aniversário</label>
						<div class="col-sm-4 col-lg-4 controls">
							<input type="text" id="aniversarioEditarCliente" data-mask="99/99" placeholder="" class="form-control" tabindex="4">
							<span class="help-inline">Ex: 08/11</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-lg-2 control-label">Celular</label>
						<div class="col-sm-4 col-lg-4 controls">
							<input class="form-control col-md-5" type="text" id="celularEditarCliente" data-mask="(99) 9999-9999" placeholder="" tabindex="5">
							<span class="help-inline">(99) 9999-9999</span>
						</div>
						<label class="col-sm-2 col-lg-2 control-label">CPF</label>
						<div class="col-sm-4 col-lg-4 controls">
							<input class="form-control col-md-5" type="text" id="cpfEditarCliente" data-mask="999.999.999-99" placeholder="" tabindex="6">
							<span class="help-inline">999.999.999-99</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 col-lg-2 control-label">E-mail</label>
						<div class="col-sm-9 col-lg-10 controls">
							<div class="input-group">
								<span class="input-group-addon">@</span>
								<input class="form-control" type="text" id="emailEditarCliente" placeholder="E-mail" tabindex="7" />
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" align="left" id="modalEditarClienteSalvar" tabindex="8">Salvar</button>
					<button class="btn " data-dismiss="modal" id="modalEditarClienteFechar" tabindex="9">Fechar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- FIM MODAL EDITAR CLIENTE -->