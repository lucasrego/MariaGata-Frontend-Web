<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Maria Gata</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <!--base css styles-->
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/gritter/css/jquery.gritter.css">
		
	
        <!--flaty css styles-->
        <link rel="stylesheet" href="css/flaty.css">
        <link rel="stylesheet" href="css/flaty-responsive.css">

        <link rel="shortcut icon" href="img/favicon.png">
    </head>
    <body class="login-page">

        <!-- BEGIN Main Content -->
		
		<div class="login-wrapper">
            <!-- BEGIN Login Form -->
            <form id="form-login" action="index.html" method="get">
                <h3>Maria Gata</h3>
                <hr/>
                <div class="form-group">
                    <div class="controls">
                        <input type="text" id="usuario" placeholder="Usuário" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <input type="password" id="senha" placeholder="Senha" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <button type="button" id="btnLogarSistema" class="btn btn-pink form-control">Acessar</button>
                    </div>
                </div>
                <hr/>
                
            </form>
            <!-- END Login Form -->

			
        </div>
        <!-- END Main Content -->


        <!--basic scripts-->
        <script src="assets/jquery/jquery-2.1.4.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/gritter/js/jquery.gritter.min.js"></script>
		<script src="assets/jquery-redirect/jquery.redirect.js"></script>

		 <!--flaty scripts-->
		<script src="js/base.js"></script>
		<script src="js/login.js"></script>
		<script src="js/flaty.js"></script>
		
    </body>
</html>
