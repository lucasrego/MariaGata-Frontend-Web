<!-- BEGIN Sidebar -->
<div id="sidebar" class="navbar-collapse collapse sidebar-fixed">
	
	<?php
		//if ($_SESSION['condominio'] != "") {
	?>
	
	<!-- BEGIN Navlist -->
	<ul class="nav nav-list">
	
		<li>
			<a href="tPainel.php">
				<i class="fa fa-dashboard"></i>
				<span>Painel</span>
			</a>
		</li>

		<li>
			<a href="#" class="dropdown-toggle">
				<i class="fa fa-users"></i>
				<span>Atendimento</span>
				<b class="arrow fa fa-angle-right"></b>
			</a>

			<ul class="submenu">
				<li><a href="tAtendimento.php">Atender</a></li>
			</ul>
		</li>
		
		
		<li>
			<a href="#" class="dropdown-toggle">
				<i class="fa fa-users"></i>
				<span>Agendamentos</span>
				<b class="arrow fa fa-angle-right"></b>
			</a>

			<ul class="submenu">
				<li><a href="index.php">Novo</a></li>
				<li><a href="tCalendario.php">Consultar Agenda</a></li>
			</ul>
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