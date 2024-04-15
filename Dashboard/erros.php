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

    $erroFrig = file_get_contents("API/Notificações/TemperaturaFrigorifico.txt");
    $erroCong = file_get_contents("API/Notificações/TemperaturaCongelador.txt");
    $erroLoja = file_get_contents("API/Notificações/PessoasLoja.txt");
    $erroParque = file_get_contents("API/Notificações/PessoasParque.txt"); 

    $tempFrig = file_get_contents("API/Files/TemperaturaFrigorifico/valor.txt"); $tempFrig = openssl_decrypt($tempFrig, $cipher, $key, $options=0, $iv);
    $tempCong = file_get_contents("API/Files/TemperaturaCongelador/valor.txt"); $tempCong = openssl_decrypt($tempCong, $cipher, $key, $options=0, $iv);

    $entradasLoja = file_get_contents("API/Files/ClientesEntrada/valor.txt"); $entradasLoja = openssl_decrypt($entradasLoja, $cipher, $key, $options=0, $iv);
    $saidasLoja = file_get_contents("API/Files/ClientesSaida/valor.txt"); $saidasLoja = openssl_decrypt($saidasLoja, $cipher, $key, $options=0, $iv);
    $entradasParque = file_get_contents("API/Files/EntradaParque/valor.txt"); $entradasParque = openssl_decrypt($entradasParque, $cipher, $key, $options=0, $iv);
    $saidasParque = file_get_contents("API/Files/SaidaParque/valor.txt"); $saidasParque = openssl_decrypt($saidasParque, $cipher, $key, $options=0, $iv);

    $erros = intval($erroFrig) + intval($erroCong) + intval($erroLoja) + intval($erroParque);

		
?>



<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5">

    <title>Noitificações Erro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="http://127.0.0.1/Projeto-TI/Dashboard/All-Pages-Css/All.css">

    <link rel="stylesheet" href="erros.css">

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
    <div class="controlPage">  <!-- BARRA TOP COM NOTIFICAÇÕES E FOTO DE LOGIN -->
        <div class="topbar">
            <!-- -->
            <nav class="navbar navbar-light justify-content-between" style="height: 70px; background-color: #252525;">
                <div class="toggle">
                    <i class="bi bi-list"></i> <!-- icon menu boostrap - COMO ESTA PAGINA APEANS E MOSTRADA AO TRABALHADOR E GERENTE NAO E NECESSARIO FAZER IF COM SESSION USER --> 
                </div> <!-- nao tem simbolo de notificações porque ja nos encontramos na pagina dos erros -->
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
        <div class="erros">
            <div class="row">
                <div class="col-4">
                    <div class="list-group" id="tabela">
                        
                    <?php /* FILTRAGEM DE ERROS POR CATEGORIA SE HOUVER ERROS MOSTRA MENSAGEM QUE HÁ ERROS */

                        if($erroFrig == 0 || $erroFrig == ""){
                            print('<a class="list-group-item disable" id="list-item">Frigorifico - 0 ERROS</a>');
                        }elseif ($erroFrig>=1) print('<a onclick="togglePopup1()" class="list-group-item" id="list-item">Frigorifico - 1 ERRO</a>');

                        if($erroCong == 0 || $erroCong == ""){
                            print('<a class="list-group-item disable" id="list-item">Congelador - 0 ERROS</a>');
                        }elseif ($erroCong>=1) print('<a onclick="togglePopup2()" class="list-group-item" id="list-item">Congelador - 1 ERRO</a>');

                        if($erroLoja == 0 || $erroLoja == ""){
                            print('<a class="list-group-item disable" id="list-item">Loja - 0 ERROS</a>');
                        }elseif ($erroLoja>=1) print('<a onclick="togglePopup3()" class="list-group-item" id="list-item">Loja - 1 ERRO</a>');

                        if($erroParque == 0 || $erroParque == ""){
                            print('<a class="list-group-item disable" id="list-item">Estacionamento - 0 ERROS</a>');
                        }elseif ($erroParque>=1) print('<a class="list-group-item" onclick="togglePopup4()" id="list-item">Estacionamento - 1 ERRO</a>');

                    ?>
                        
                    </div>
                </div>
            </div>
        </div>

                        
                        <!-- POPUPS DIFERNTES CONSOANTE O ITEM CLICADO -->
                        <!-- APENAS DEIXA CLICAR NO POPUP DE HOUVER ERROS -->

        <div class="popup" id="popup-1">
            <div class="overlay"></div>
                <div class="content">
                    <div class="close-btn" onclick="togglePopup1()">&times;</div> 
                    <h1>FRIGORIFICO</h1>
                    <h2><?php echo($tempFrig) ?>ºC - ALTA</h2>
                    <img src="temp-sensores/alta.png" id="temp-alta" alt="Temperatura Alta">
                </div>
        </div>
        <div class="popup" id="popup-2">
            <div class="overlay"></div>
                <div class="content">
                    <div class="close-btn" onclick="togglePopup2()">&times;</div>
                    <h1>CONGELADOR</h1>
                    <h2><?php echo($tempCong) ?>ºC - ALTA</h2>
                    <img src="temp-sensores/alta.png" id="temp-alta" alt="Temperatura Alta">
                </div>
        </div>
        <div class="popup" id="popup-3">
            <div class="overlay"></div>
                <div class="content">
                    <div class="close-btn" onclick="togglePopup3()">&times;</div>
                    <h1>CONTAGEM PESSOAS LOJA</h1>
                    <h2>CONTAGEM ERRADA - SAIDAS(<?php echo($saidasLoja) ?>) > ENTRADAS(<?php echo($entradasLoja) ?>)</h2>
                    <img src="Loja/erroLoja.png" id="erro-loja" alt="Temperatura Alta">
                </div>
        </div>
        <div class="popup" id="popup-4">
            <div class="overlay"></div>
                <div class="content">
                    <div class="close-btn" onclick="togglePopup4()">&times;</div>
                    <h1>CONTAGEM ESTACIONAMENTO</h1>
                    <h2>CONTAGEM ERRADA - SAIDAS(<?php echo($saidasParque) ?>) > ENTRADAS(<?php echo($entradasParque) ?>)</h2>
                    <img src="parqueEstacionamento/erroParque.png" id="erro-parque" alt="Temperatura Alta">
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

        <script>
            function togglePopup1 (){
                document.getElementById("popup-1").classList.toggle("active");
            }
            function togglePopup2 (){
                document.getElementById("popup-2").classList.toggle("active");
            }
            function togglePopup3 (){
                document.getElementById("popup-3").classList.toggle("active");
            }
            function togglePopup4 (){
                document.getElementById("popup-4").classList.toggle("active");
            }
        </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
crossorigin="anonymous"></script>


</body>

</html>