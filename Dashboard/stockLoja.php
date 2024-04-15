<?php

	session_start();
		if ( ! isset($_SESSION["user"]) ){
			header( "refresh:2;url=http://127.0.0.1/Projeto-TI/index.php" );
			die( "Acesso restrito." );
		}

    /* ELEMENTOS NECESSÁRIOS PARA DAR DECRYPT */

    $cipher = "AES-128-CTR";
    $iv = "1234567891011121";
    $key = "nPIMLCuuYW";
?>

<?php

    /* verifica se alguma coisa se encontra no ficheiro, se nao se encontrar devolve "Indiponivel"*/

    /* ENLATADOS */

    if( filesize("API/Files/PesoEnlatados/valor.txt") == FALSE){

        $mensagem_enlatados = "N/A";

    } else {
        
        $peso_enlatados = file_get_contents("API/Files/PesoEnlatados/valor.txt"); $peso_enlatados = openssl_decrypt($peso_enlatados, $cipher, $key, $options=0, $iv);

        if( $peso_enlatados < 2) {  /* devolve o peso da parteleira dos enlatados, caso este seja menor que 2 kilos alerta o gerente para repor */

            $mensagem_enlatados = "Necessário Repor";

        }else $mensagem_enlatados = "Em stock";

    }

    if( filesize("API/Files/PesoEnlatados/hora.txt") == FALSE ){

        $hora_enlatados = "Indisponivel";

    }else { 
        
        $hora_enlatados = file_get_contents("API/Files/PesoEnlatados/hora.txt"); 
        $hora_enlatados = openssl_decrypt($hora_enlatados, $cipher, $key, $options=0, $iv);
    }

    /* FRUTAS */

    if( filesize("API/Files/PesoFrutas/valor.txt") == FALSE ){

        $mensagem_frutas = "N/A";

    }else {
        
        $peso_frutas = file_get_contents("API/Files/PesoFrutas/valor.txt"); $peso_frutas = openssl_decrypt($peso_frutas, $cipher, $key, $options=0, $iv);

        if( $peso_frutas < 2) { /* devolve o peso das frutas ao todo, caso este seja menor que 2 kilos alerta o gerente para repor */

            $mensagem_frutas = "Necessário Repor";

        }else $mensagem_frutas = "Em stock";
    }

    if( filesize("API/Files/PesoFrutas/hora.txt") == FALSE ){

        $hora_frutas = "Indisponivel";

    }else {
        $hora_frutas = file_get_contents("API/Files/PesoFrutas/hora.txt"); 
        $hora_frutas = openssl_decrypt($hora_frutas, $cipher, $key, $options=0, $iv);
    }

    /* LIQUIDOS */

    if( filesize("API/Files/PesoLiquidos/valor.txt") == FALSE ){

        $mensagem_liquidos = "N/A"; /* devolve o peso da parteleira dos liquidos, caso este seja menor que 5 kilos alerta o gerente para repor */

    }else {
        
        $peso_liquidos = file_get_contents("API/Files/PesoLiquidos/valor.txt"); $peso_liquidos = openssl_decrypt($peso_liquidos, $cipher, $key, $options=0, $iv);

        if( $peso_liquidos < 10) { /* devolve o peso das frutas ao todo, caso este seja menor que 10 kilos alerta o gerente para repor */

            $mensagem_liquidos = "Necessário Repor";

        }else $mensagem_liquidos = "Em stock";
    }

    if( filesize("API/Files/PesoLiquidos/hora.txt") == FALSE ){

        $hora_liquidos = "Indisponivel";

    }else {
        $hora_liquidos = file_get_contents("API/Files/PesoLiquidos/hora.txt"); 
        $hora_liquidos = openssl_decrypt($hora_liquidos, $cipher, $key, $options=0, $iv);
    }

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

    <title>Stock da Loja</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="http://127.0.0.1/Projeto-TI/Dashboard/All-Pages-Css/All.css">

    <link rel="stylesheet" href="stockLoja.css">


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
                        <span class="title" style="text-transform: uppercase"><?php echo($_SESSION['user'])?></span> <!-- PRINT SESSION USER -->
                    </a>
                </li>
                <li>
                    <a href="dashborad.php" class="homePage">
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



    <div class="controlPage">
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
        <div class="cardsMainPage">
            <div class="card shadow-none rounded-0" > <!-- CARD ENLATADOS -->
                <div class="card-top-enlatados">
                    <h1 class="heading">Enlatados</h1>
                    <p class="valor">
                        <span class="valor-value" style= "font-size: 50px"><?php echo ($mensagem_enlatados)?></span>
                    </p>
                </div>
                <div class="card-body"> <!-- espaço entre cards -->
                    <p class="card-text text-center">Atualização : <?php echo ($hora_enlatados)?></p>
                    <a href="API/historico.php?nome=PesoEnlatados" style="text-decoration: none">
                        <div class="card">
                                <span class="historicoText text-center">HISTORICO</span>
                        </div>
                    </a>
                </div>
            </div>
            <div style="width: 5%"></div> <!-- espaço entre cards -->
            <div class="card shadow-none rounded-0" style="width: 450px; height: 750px">
                <div class="card-top-frutas"> <!-- CARD FRUTAS -->
                <h1 class="heading">Frutas</h1>
                <p class="valor">
                    <span class="valor-value"  style= "font-size: 50px"><?php echo ($mensagem_frutas)?></span>
                </p>
                </div>
                <div class="card-body">
                    <p class="card-text text-center">Atualização : <?php echo ($hora_frutas)?></p>
                    <a href="API/historico.php?nome=PesoFrutas" style="text-decoration: none">
                        <div class="card">
                                <span class="historicoText text-center">HISTORICO</span>
                        </div>
                    </a>
                </div>
            </div>
            <div style="width: 5%"></div> <!-- espaço entre cards -->
            <div class="card shadow-none rounded-0" >
                <div class="card-top-liquidos">
                    <h1 class="heading">Liquidos</h1> <!-- CARD LIQUIDOS -->
                    <p class="valor">
                        <span class="valor-value"  style= "font-size: 50px"><?php echo ($mensagem_liquidos)?></span>
                    </p>
                </div>
                <div class="card-body">
                    <p class="card-text text-center">Atualização : <?php echo ($hora_liquidos)?></p>
                    <a href="API/historico.php?nome=PesoLiquidos" style="text-decoration: none">
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