<?php

include ("conexao.php");

if (isset($_POST['email']) > 0){
	if(!isset($_SESSION))
	    session_start();
	$_SESSION['email'] = $mysqli->escape_string($_POST['email']);
	$_SESSION['senha'] = md5(md5($_POST['senha']));

	$sql_code = "SELECT senha, codigo FROM usuario WHERE email = '$_SESSION[email]'";
	$sql_query = $mysqli->query($sql_code) or die($myslqi->error);
	$dado = $sql_query->fetch_assoc();
	$total = $sql_query->num_rows;

	if($total == 0){
	    $erro[] = "Este email não pertence a nenhum usuário.";
	    }elseif($dado['senha'] == $_SESSION['senha']){

				 $_SESSION['usuario'] = $dado['codigo'];
			 
	        }else{

	            $erro[] = "senha incorreta.";
	    }
	}

	if(count($erro) ==0 || !isset($erro)){
	   echo "<script>alert('Login efetuado com sucesso'); location.href='sucesso.php';</script>";"
	}

}

?><html>
    <head></head>
    <body>
        <?php if(count($erro) > 0)
             foreach($erro as $msg){
                 echo "<p>$msg</p>";

            }
        ?> 
        <form method="POST" action="">
            <p><input value="<php echo $_SESSION['email]; ?>" name="email" placeholder="E-mail" type="text"></p>
            <p><input name="senha" type="password"></p>
            <p><a href="">Esqueceu sua senha?</a></p>
            <p><input value="Entrar" type="submit"></p>
        </form>
     </body>
</html>
