<?php

include("includes/util/validar_sessao.php");
include("includes/util/util.php");

session_destroy();

//exibirTelaMensagemUsuarioNaoLogado("Você saiu do sistema com segurança!", "Caso deseje, acesso novamente o sistema realizando um novo login.");

header('Status: 200');
header('Location: login.php');
exit;

?>