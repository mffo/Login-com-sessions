<?php 
/***************OBTEM OS DADOS DO FOMULARIO*************************************/

$email = filter_input(INPUT_POST,'email');
$senha = filter_input(INPUT_POST,'senha');

/***************CONCECTA COM BANCO DE DADOS*************************************/

include "conecta_mysql.inc";

/********ESCAPA CACTERES ESPECIAIS PARA EVITAR ATAQUE SQL INJECTION*************/

$email = $conexao->real_escape_string($email); 
$senha = $conexao->real_escape_string($senha);
//$email = mysqli_real_escape_string($conexao, $email);
//$senha = mysqli_real_escape_string($conexao, $senha);

/**********************BUSCA DADOS NO BANCO*************************************/

$resultado = $conexao->query("SELECT * FROM usuarios WHERE email='$email'");
$linhas = $resultado->num_rows;

/**********************VERIFICA SE EXISTE USUARIO NO BANCO**********************/

if($linhas==0){
	echo "<html><body>";
	echo "<p align=\"center\">E-mail não encontrado!</p>";
	echo "<p align=\"center\"><a href=\"javascript:history.back()\">Voltar</a></p>";
	echo "</body></html>";	
}else{
	$dados = $resultado->fetch_array();
	$senha_banco = $dados["senha"];
	
/****************VERIFICA SE A SENHA É IGUAL A SENHA DO BANCO*******************/

	if($senha_banco!=$senha){
		echo "<html><body>";
		echo "<p align=\"center\">A senha está incorreta!</p>";
		echo "<p align=\"center\"><a href=\"javascript:history.back()\">Voltar</a></p>";
		echo "</body></html>";	

/*************SE USUARIO EXISTE E SENHA SAO IGUAIS CRIA SESSAO***************/
		
	}else{
		session_start();
		$_SESSION['email_usuario'] = $email;
		$_SESSION['senha_usuario'] = $senha;
/****************DIRECIONA PARA PAGINA INICIAL DOS USUARIOS********************/
		header("Location:pagina_inicial.php");
	}
/***************DESCONECTA COM BANCO DE DADOS*************************************/
$conexao->close();
}
?>
