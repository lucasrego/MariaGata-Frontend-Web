<!-- BEGIN Sidebar -->
<div id="sidebar" class="navbar-collapse collapse sidebar-fixed">
	
	<?php
		//if ($_SESSION['condominio'] != "") {
	?>
	
	<!-- BEGIN Navlist -->
	<ul class="nav nav-list">
	
		<li>
			<a href="painel.php">
				<i class="fa fa-dashboard"></i>
				<span>Painel</span>
			</a>
		</li>
		
		<li>
			<a href="atendimento.php">
				<i class="fa fa-ticket"></i>
				<span>Atender</span>
			</a>
		</li>
		
		<li>
			<a href="agendar.php">
				<i class="fa fa-clock-o"></i>
				<span>Agendar</span>
			</a>
		</li>
		
		<li>
			<a href="calendarioAgendamentos.php">
				<i class="fa fa-search"></i>
				<span>Consultar Agenda</span>
			</a>
		</li>
		
		<li>
			<a href="sair.php">
				<i class="fa fa-close"></i>
				<span>Sair</span>
			</a>
		</li>
		
		<!--
		<li>
			<a href="#" class="dropdown-toggle">
				<i class="fa fa-users"></i>
				<span>Moradores</span>
				<b class="arrow fa fa-angle-right"></b>
			</a>

			<ul class="submenu">
				<li><a href="tMoradoresListar.php">Consultar / Editar</a></li>
				<li><a href="tMoradoresConvidar.php">Convidar</a></li>
			</ul>
		</li>
		-->
		
	</ul>
	<!-- END Navlist -->

	<!-- BEGIN Sidebar Collapse Button -->
	<div id="sidebar-collapse" class="visible-lg">
		<i class="fa fa-angle-double-left"></i>
	</div>
	<!-- END Sidebar Collapse Button -->
	
	<?php 
	//} 
	?>
	
</div>
<!-- END Sidebar -->