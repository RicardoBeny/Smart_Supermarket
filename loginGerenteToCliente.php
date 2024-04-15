<?php
	session_start();
?>

<!-- DIFERENÇA DESTE FICHEIRO PARA O INDEX.PHP - este ficheiro autopreenche os dados para o gerente dar login como cliente, o código é todo igual -->

<!DOCTYPE html>
<html lang="pt">
<link rel="stylesheet" href="login.css">

  <head>
    <meta charset="utf-8">
    <title>Log-in</title>
  </head>
  <body>
  
	<?php
		
		    $username_cliente = "Cliente";
            $password_cliente = "123";

            $username_gerente = "Gerente";
            $password_gerente = "123";

            if (isset ($_POST['username']) && isset ($_POST['password'])) { /* verificação das credenciais */

                if (($_POST['username'] == $username_cliente && $_POST['password'] == $password_cliente) || ($_POST['username'] == $username_gerente && $_POST['password'] == $password_gerente)) {

                    echo "credenciais corretas";
                    header("Location: http://127.0.0.1/Projeto-TI/Dashboard/dashboard.php");  
                    $_SESSION["user"]=$_POST['username'];

                }
			}
		?>
  
  <div class="center" style="box-shadow: 0 0 30px 4px rgb(0, 0, 0);"> <!-- caixa do login -->
        <h1 class="loginText">INCIE SESSÃO</h1> <!-- texto inicie sessao -->
        <form method="post">
            <div class="txt_field"> <!-- sitio para preencher com o username -->
                <input type="text" class="form-control" id="usr" name="username" autocomplete="off" value="Cliente" required>
                <span></span>
                <label>Username</label> 
            </div>
            <div class="txt_field"> <!-- sitio para preencher com a password -->
                <input type="password" class="form-control" id="pwd" name="password" value="123" required>
                <span></span>
                <label>Password</label>
            </div>
            <input type="submit" value="Login" id="clickButton">
        </form>
    </div>

    <script> /* ficheiros distintos de login para quando o gerente pretende ter a vista de cliente da sua página */
    /* função que identifica o button do typw="submit" pelo id 'clickButton' e que quando a página é aberta dá autoclick no mesmo */
        window.onload = function(){
        var button = document.getElementById('clickButton');
        button.form.submit();
}
    </script>

  </body>
</html>

