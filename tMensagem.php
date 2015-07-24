<?php

include("includes/util/validar_sessao.php");
include("includes/bd/mysql.class.php");
include("includes/bd/conectarBanco.php");
    
include 'includes/navegacao/head.php'; 

include 'includes/navegacao/navbar.php'; 
	
?>

        <!-- BEGIN Container -->
        <div class="container" id="main-container">
            
			<?php include 'includes/navegacao/menu.php'; ?>
			
			<?php 
			if(isset($_GET["r"]) and $_GET["r"] != "") { 
				$lsMensagem  = $_GET["r"];
				if(isset($_GET["t"]) and $_GET["t"] != "") { 
					$lsTitulo = $_GET["t"];
				} else {
					$lsTitulo = "Ops! Algo estranho ocorreu...";
				}
			} else {
				$lsMensagem  = "Ops! Não houve retorno da mensagem a ser exibida.";
			}
			?>
			
            <!-- BEGIN Content -->
            <div id="main-content">
                <!-- BEGIN Page Title -->
                <div class="page-title">
                    <div>
                        <h1><i class="fa fa-comment-o"></i> <?php echo $lsTitulo; ?></h1>
                    </div>
                </div>
                <!-- END Page Title -->
				
				<!-- BEGIN Main Content -->
				<div class="alert alert-info">
					<button class="close" data-dismiss="alert">&times;</button>
					<?php echo $_GET["r"]; ?>
				</div>
				<!--
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-2 col-md-offset-6">
							<button class="btn btn-primary" id="btnVoltar" name="btnVoltar"><i class="fa fa-arrow-left"></i> Voltar</button>
						</div>
					</div>
				</div>
				-->
                <!-- END Main Content -->
                
                <a id="btn-scrollup" class="btn btn-circle btn-lg" href="#"><i class="fa fa-chevron-up"></i></a>
            </div>
            <!-- END Content -->
        </div>
        <!-- END Container -->

		<?php include 'includes/navegacao/rodape.php'; ?>
        
        <!--page specific plugin scripts-->
		<script src="js/base.js"></script>

    </body>
</html>
