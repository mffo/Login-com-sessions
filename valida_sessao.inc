<?php
session_start();

if(isset($_SESSION['email_usuario']))
	$email_usuario = $_SESSION['email_usuario'];
if(isset($_SESSION['senha_usuario']))
	$senha_usuario =$_SESSION['senha_usuario'];

if(!empty($email_usuario) OR !empty($senha_usuario)){
	
	include "conecta_mysql.inc";
	$email_usuario = $conexao->real_escape_string($email_usuario);
	$senha_usuario = $conexao->real_escape_string($senha_usuario);
	

	$resultado = $conexao->query("SELECT * FROM usuarios WHERE '$senha_usuario'= senha AND '$email_usuario'=email");
	$linhas = $resultado->num_rows;
	if($linhas==0){
		unset($_SESSION['email_usuario']);
		unset($_SESSION['senha_usuario']);
		exit();
	}
}else{
    echo "Você não efetuou o <a href='login.html'>login</a>!";

    exit();	
}
$conexao->close();
?>