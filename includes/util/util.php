<?php

function obterNomeSistema() {
	return "Maria Gata";
}

function getFromEmail() {
	//retorna o e-mail que será utilizado para enviar os e-mails do sistema
	return "juliana@mariagata.com.br";
}

function obterURLSite() {
	return "http://mariagata.com.br/";
}

function obterURLSistema() {
	return "http://mariagata.com.br/sistema/";
}

function exibirTelaMensagemUsuarioLogado($titulo, $msg) {
	header('Status: 200');
	header('Location: tMensagem.php?t=' . $titulo . '&r=' . $msg);
	exit;
}


function exibirTelaMensagemUsuarioNaoLogado($titulo, $msg) {
	header('Status: 200');
	header('Location: tMensagemOffline.php?t=' . $titulo . '&r=' . $msg);
	exit;
}

function gerarUniqID() {
	$uniqid = md5(uniqid(rand(), true));
	return $uniqid;
}
?>