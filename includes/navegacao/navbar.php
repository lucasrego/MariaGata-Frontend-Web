<!-- BEGIN Navbar -->
<div id="navbar" class="navbar navbar-fixed">
	<button type="button" class="navbar-toggle navbar-btn collapsed" data-toggle="collapse" data-target="#sidebar">
		<span class="fa fa-bars"></span>
	</button>
	<a class="navbar-brand" href="#">
		<small>
			<i class="fa fa-desktop"></i>
			Maria Gata
		</small>
	</a>

	<!-- BEGIN Navbar Buttons -->
	
	<ul class="nav flaty-nav pull-right">

		<li class="user-profile">
			<a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
				<!--<img class="nav-user-photo" src="" alt="" />-->
				<span class="hhh" id="user_info">
					<?php
						 session_start();
						echo $_SESSION['usuarionome'];
					?>
				</span>
				<!--<i class="fa fa-caret-down"></i>-->
			</a>
			
			<!--
			<ul class="dropdown-menu dropdown-navbar" id="user_menu">
				<li>
					<a href="#">
						<i class="fa fa-cog"></i>
						Configurações
					</a>
				</li>

				<li>
					<a href="#">
						<i class="fa fa-user"></i>
						Editar Dados
					</a>
				</li>

				<li class="divider"></li>

				<li>
					<a href="cSairSistema.php">
						<i class="fa fa-off"></i>
						Sair
					</a>
				</li>
			</ul>
			-->
		</li>
	</ul>
	
	
	<!-- END Navbar Buttons -->
</div>
<!-- END Navbar -->
