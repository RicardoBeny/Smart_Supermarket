<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="pt">
<link rel="stylesheet" href="index.css">

  <head>
    <meta charset="utf-8">
    <title>Log-in</title>
  </head>
  <body style=" background: url('loginBackground/bglogin.png');">
  
	<?php
		
		    $username_cliente = "Cliente";
            $password_cliente = "123";

            $username_gerente = "Gerente";
            $password_gerente = "321";

            $username_trabalhador = "Trabalhador";
            $password_trabalhador = "111";

            $error=0;

            if (isset ($_POST['username']) && isset ($_POST['password'])) { /* verificação das credenciais */

                if (($_POST['username'] == $username_cliente && $_POST['password'] == $password_cliente) 
                || ($_POST['username'] == $username_gerente && $_POST['password'] == $password_gerente
                || ($_POST['username'] == $username_trabalhador && $_POST['password'] == $password_trabalhador))) {

                    header("Location: http://127.0.0.1/Projeto-TI/Dashboard/dashboard.php");  
                    $_SESSION["user"]=$_POST['username'];

                }else $error = 1; /* se forem erradas atribui valor 1 ao erro para poder mostrar a mensagem de credenciais erradas */
			}
		?>
  
        <div class="center" style="box-shadow: 0 0 30px 4px rgb(0, 0, 0);">
                <h1 class="loginText">Login</h1>
                <?php 
                    if ($error == 1){ /* se credenciais erradas mostra a mensagem de "Credenciais Incorretas" */
                        print("<div id='error'>Credenciais Incorretas</div>");
                    }
                ?>
                <form method="post">
                    <div class="txt_field"> <!-- sitio para preencher com o username -->
                        <input type="text" class="form-control" id="usr" name="username" autocomplete="off" required>
                        <span></span>
                        <label>Username</label>
                    </div>
                    <div class="txt_field"> <!-- sitio para preencher com a password -->
                        <input type="password" class="form-control" id="pwd" name="password" required>
                        <span></span>
                        <label>Password</label>
                    </div>
                    <input type="submit" value="Login">
                </form>
            </div>

  </body>
</html>

