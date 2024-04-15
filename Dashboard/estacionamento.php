<?php

	session_start();
		if ( ! isset($_SESSION["user"]) ){
			header( "refresh:2;url=http://127.0.0.1/Projeto-TI/index.php" );
			die( "Acesso restrito." );
		}


    /* ELEMENTOS NECESSÁRIOS PARA DAR DECRYPT */

    $cipher = "AES-128-CTR";
    $iv = "1234567891011121";
    $key = "nPIMLCuuYW"
?>

<?php

    /* verifica se alguma coisa se encontra no ficheiro, se nao se encontrar devolve "Indiponivel", se encontrar devolve o valor*/

    if( filesize("API/Files/EntradaParque/valor.txt") == FALSE){

        $valor_entrada = "N/A";

    } else {
        $valor_entrada = file_get_contents("API/Files/EntradaParque/valor.txt"); 
        $valor_entrada = openssl_decrypt($valor_entrada, $cipher, $key, $options=0, $iv);
    }
    
    if( filesize("API/Files/EntradaParque/hora.txt") == FALSE ){

        $hora_entrada= "Indisponivel";

    }else {
        $hora_entrada = file_get_contents("API/Files/EntradaParque/hora.txt"); 
        $hora_entrada = openssl_decrypt($hora_entrada, $cipher, $key, $options=0, $iv);
    }
    
    if( filesize("API/Files/SaidaParque/valor.txt") == FALSE ){

        $valor_saida = "N/A";

    }else {
        $valor_saida = file_get_contents("API/Files/SaidaParque/valor.txt"); 
        $valor_saida = openssl_decrypt($valor_saida, $cipher, $key, $options=0, $iv);
    }

    if( filesize("API/Files/SaidaParque/hora.txt") == FALSE ){

        $hora_saida = "Indisponivel";

    }else {
        $hora_saida = file_get_contents("API/Files/SaidaParque/hora.txt"); 
        $hora_saida = openssl_decrypt($hora_saida, $cipher, $key, $options=0, $iv);
    }

    if( is_numeric($valor_entrada) && is_numeric($valor_saida) ){

        if ($valor_entrada < $valor_saida){ /* verifica se pode fazer a conta para devoler positivo */

            $pessoasEstacionamento = "N/A";
    
        }else $pessoasEstacionamento = $valor_entrada - $valor_saida;
        
    }else $pessoasEstacionamento = "N/A";

    /* intervalo livre e cheio estacionamento 50 */
    if( is_numeric($pessoasEstacionamento)){
        
        if ($pessoasEstacionamento < 50 ){ /* verifica se o valor maximo de estacionamentos ja se encontra ocupado */

            $mensagem_Estacionamento = "LIVRE";
    
        }else $mensagem_Estacionamento = "CHEIO";
    
    }else $mensagem_Estacionamento = "N/A";
    
    $erroFrig = file_get_contents("API/Notificações/TemperaturaFrigorifico.txt");
    $erroCong = file_get_contents("API/Notificações/TemperaturaCongelador.txt");
    $erroLoja = file_get_contents("API/Notificações/PessoasLoja.txt");
    $erroParque = file_get_contents("API/Notificações/PessoasParque.txt");

    $erros = intval($erroFrig) + intval($erroCong) + intval($erroLoja) + intval($erroParque);


?>



<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5">

    <title>Estacionamento</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="http://127.0.0.1/Projeto-TI/Dashboard/All-Pages-Css/All.css">

    <link rel="stylesheet" href="estacionamentos.css">


</head>

<body>

    <!--  #7968FA -->

    <!-- sidebar -->


    <div class="sidebar">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon"><i class="bi bi-shop" id="iconPerfil" style="top:10%"></i></span>
                        <!-- icone loja bootstrap -->
                    </a>
                </li>
                <li>
                    <a style="pointer-events: none" class="homePage">
                        <span class="icon"><i class="bi bi-person-bounding-box"></i></span> <!-- icone grafico bootstrap -->
                        <span class="title" style="text-transform: uppercase"><?php echo($_SESSION['user'])?></span> <!-- PRINT AO TIPO DE USER -->
                    </a>
                </li>
                <li>
                    <a href="dashboard.php" class="homePage">
                        <span class="icon"><i class="bi bi-house-door-fill"></i></span> <!-- icone grafico bootstrap -->
                        <span class="title">Home Page</span>
                    </a>
                </li>
                <li>
                    <a href="sensores-Dashboard.php">
                        <span class="icon"><i class="bi bi-grid-fill"></i></span> <!-- icone dashboard bootstrap -->
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <?php

                    if( $_SESSION['user'] == "Gerente"){ /* SE USER == gerente permite ver relatorio e erros */
                        
                        print('
                        
                        <li>
                            <a href="relatorioLucro.php">
                                <span class="icon"><i class="bi bi-bar-chart-fill"></i></span> <!-- icone grafico bootstrap -->
                                <span class="title">Relatório Lucro</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="erros.php">
                                <span class="icon"><i class="bi bi-exclamation-diamond-fill"></i></span>
                                <!-- icone ajuda bootstrap -->
                                <span class="title">Erros</span>
                            </a>
                        </li>

                        ');
                    }
		
                    if( $_SESSION['user'] == "Trabalhador"){ /*  se user ==  trabalhador permite ver apenas erros */
                        
                        print('
                        <li>
                            <a href="erros.php">
                                <span class="icon"><i class="bi bi-exclamation-diamond-fill"></i></span>
                                <!-- icone ajuda bootstrap -->
                                <span class="title">Erros</span>
                            </a>
                        </li>

                        ');
                    }
                ?>
                <?php

                    if( $_SESSION['user'] == "Gerente"){ /* se user == gerente permite ver a opção de interface de cliente para mudar para cliente */
                        
                        print('
                        
                        <li>
                        <a href="http://127.0.0.1/Projeto-TI/loginGerenteToCliente.php">
                            <span class="icon"><i class="bi bi-cart-plus-fill"></i></span> <!-- icone cliente bootstrap -->
                            <span class="title">Interface Cliente</span>
                        </a>
                        </li>

                        ');
                    }
		
                ?>
                <li>
                    <a href="logout.php">
                        <span class="icon"><i class="bi bi-box-arrow-left"></i></span> <!-- icone logout bootstrap -->
                        <span class="title">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="controlPage"> <!-- BARRA TOP COM NOTIFICAÇÕES E FOTO DE LOGIN -->
    <div class="topbar">
            <!-- -->
            <nav class="navbar navbar-light justify-content-between" style="height: 70px; background-color: #252525;">
                <div class="toggle">
                    <i class="bi bi-list"></i> <!-- icon menu boostrap-->
                </div>
                <div class="notificações" style="position:absolute; bottom: 0.3em; left:10%">
                    <?php
                        if($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador"){ /* se user gerente e trabalhador tem acesso ao sino das notificações para os erros */
                            if($erros==0){
                                print('<i class="bi bi-bell" style="color: white;"></i>');
                            }else print('<i class="bi bi-bell-fill" style="color: white;"></i>');
                        }   
                    ?> 
                    <div class="notificações-content" >
                        <?php
                            if($erros==0){
                                print("<span>Sem Notificações</span>"); /* se nao houver erros mete sino sem cor e nao permite clicar no dropdown */
                            }elseif ($erros==1){ /* se houver erros sino com cor e permite clicar no dropdown e mostra a quantidade de erros */
                                print("<a href='erros.php' style='text-decoration: none;'><span>$erros ERRO Notificações</span></a>");
                            }else print("<a href='erros.php' style='text-decoration: none;'><span>$erros ERROS Notificações</span></a>");
                            
                        ?>  
                    </div>
                </div>
                <div class="perfilDropdown" style="position:absolute;">
                    <?php
                        if ($_SESSION['user'] == "Gerente"){ /* consoante o user muda a imagem de perfil */
                            print('<img src="imagem-topbar/gerente.png" alt="Imagem de Perfil" class="perfilFoto">');
                        }elseif ($_SESSION['user'] == "Trabalhador"){
                            print('<img src="imagem-topbar/trabalhador.png" alt="Imagem de Perfil" style="width:40px; height:58px; margin-left:10px">');
                        }else{
                            print('<img src="imagem-topbar/cliente.png" alt="Imagem de Perfil" class="perfilFoto" style="margin-left:10px">');
                        }
                    ?> 
                    <div class="perfil-content">
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </nav>
        </div>
        <div class="cardsMainPage"> <!-- CARDS COM A INFORMAÇÃO RELATICA AO ESTACIONAMENTO -->
            <div class="card shadow-none rounded-0" >
                    <div class="card-top-entrada">
                        <h1 class="heading">Entrada Parque</h1> <!-- ENTRADA PARQUE numero pessoas -->
                        <p class="park">
                            <span class="park-value"><?php echo ($valor_entrada)?></span>
                        </p>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-center">Atualização : <?php echo ($hora_entrada)?></p>
                        <a href="API/historico.php?nome=EntradaParque" style="text-decoration: none">
                            <div class="card">
                                    <span class="historicoText text-center">HISTORICO</span>
                            </div>
                        </a>
                    </div>
            </div>
            <div style="width: 5%"></div> 
            <div class="card shadow-none rounded-0" style="width: 450px; height: 750px">
                <div class="card-top-estado">
                    <h1 class="heading">Parque</h1> <!-- ESTADO PARQUE -->
                    <p class="park">
                        <span class="park-value"><?php echo ($mensagem_Estacionamento)?></span>
                    </p>
                </div>
                <div class="card-body">
                    <p class="card-text text-center" style="margin-top: 14%">Atualização : <?php echo ($hora_entrada)?></p>
                </div>
            </div>
            <div style="width: 5%"></div>
            <div class="card shadow-none rounded-0" >
                <div class="card-top-saida">
                    <h1 class="heading">Saida Parque</h1> <!-- SAIDA PARQUE numero pessoas -->
                    <p class="park">
                        <span class="park-value"><?php echo ($valor_saida)?></span>
                    </p>
                </div>
                <div class="card-body">
                    <p class="card-text text-center">Atualização : <?php echo ($hora_saida)?></p>
                    <a href="API/historico.php?nome=SaidaParque" style="text-decoration: none">
                        <div class="card">
                                <span class="historicoText text-center">HISTORICO</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script> /* identifica quando o rato dá hover a uma das opções do sidebar ("Dashboard" etc) e cria uma class temporária no item <li class="hovered"> */

        /* usado para manter a cor quando p.e dashboard e selecionada */
        let list = document.querySelectorAll('.navigation li');

        function activelink() {
            list.forEach((item) =>
                item.classList.remove('hovered'));
            this.classList.add('hovered');
        }
        list.forEach((item) =>
            item.addEventListener('mouseover', activelink));

        /* FORMATO DE USO DA CLASS EM CSS
    
          .navigation ul li:hover,
          .navigation ul li.hovered
    
        */
    </script>

    <script> /* toggle do butao para abrir o sidemenu */

        let toggle = document.querySelector('.toggle');
        let navigation = document.querySelector('.navigation');
        let controlPage = document.querySelector('.controlPage');

        toggle.onclick = function () { /* função para a main page acompanhar quando o side menu encolhe ou abre */
            navigation.classList.toggle('active');
            controlPage.classList.toggle('active');
        }

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>


</body>

</html>