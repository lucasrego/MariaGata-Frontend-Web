<?php

function geraSenha($tamanho = 5, $maiusculas = false, $numeros = true, $simbolos = false) {

	//Código obtido em: http://blog.thiagobelem.net/gerando-senhas-aleatorias-com-php/
	
	// Caracteres de cada tipo
	$lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890';
	$simb = '!@#$%*-';

	// Variáveis internas
	$retorno = '';
	$caracteres = '';

	// Agrupamos todos os caracteres que poderão ser utilizados
	$caracteres .= $lmin;
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	if ($simbolos) $caracteres .= $simb;

	// Calculamos o total de caracteres possíveis
	$len = strlen($caracteres);

	for ($n = 1; $n <= $tamanho; $n++) {
	// Criamos um número aleatório de 1 até $len para pegar um dos caracteres
	$rand = mt_rand(1, $len);
	// Concatenamos um dos caracteres na variável $retorno
	$retorno .= $caracteres[$rand-1];
	}

	return $retorno;
}


function gerarUniqID() {
	$uniqid = md5(uniqid(rand(), true));
	return $uniqid;
}
?>