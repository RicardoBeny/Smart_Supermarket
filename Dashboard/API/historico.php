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

        $erroFrig = file_get_contents("Notificações/TemperaturaFrigorifico.txt");
        $erroCong = file_get_contents("Notificações/TemperaturaCongelador.txt");
        $erroLoja = file_get_contents("Notificações/PessoasLoja.txt");
        $erroParque = file_get_contents("Notificações/PessoasParque.txt"); 
    
        $erros = intval($erroFrig) + intval($erroCong) + intval($erroLoja) + intval($erroParque);

        $compras
		
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5">

    <title>Historico</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="http://127.0.0.1/Projeto-TI/Dashboard/All-Pages-Css/All.css">
    
    <link rel="stylesheet" href="historico.css">

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
                        <span class="title" style="text-transform: uppercase"><?php echo($_SESSION['user'])?></span>
                    </a>
                </li>
                <li>
                    <a href="http://127.0.0.1/Projeto-TI/Dashboard/dashboard.php" class="homePage">
                        <span class="icon"><i class="bi bi-house-door-fill"></i></span> <!-- icone grafico bootstrap -->
                        <span class="title">Home Page</span>
                    </a>
                </li>
                <li>
                    <a href="http://127.0.0.1/Projeto-TI/Dashboard/sensores-Dashboard.php">
                        <span class="icon"><i class="bi bi-grid-fill"></i></span> <!-- icone dashboard bootstrap -->
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <?php

                    if( $_SESSION['user'] == "Gerente"){ /* SE USER == gerente permite ver relatorio e erros */
                        
                        print('
                        
                        <li>
                            <a href="http://127.0.0.1/Projeto-TI/Dashboard/relatorioLucro.php">
                                <span class="icon"><i class="bi bi-bar-chart-fill"></i></span> <!-- icone grafico bootstrap -->
                                <span class="title">Relatório Lucro</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="http://127.0.0.1/Projeto-TI/Dashboard/erros.php">
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
                            <a href="http://127.0.0.1/Projeto-TI/Dashboard/erros.php">
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
                    <a href="http://127.0.0.1/Projeto-TI/Dashboard/logout.php">
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
        <div class="tituloTable" style="margin-left: 40%;">
            <span><i class="bi bi-book-fill fa-3x" style="margin-left: 40%"></i></span>
            <span class="historicoText" style="margin-left: 20%">HISTORICO</span>
        </div>
        <div class="historico bdr">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Data de Registo</th>
                            <th scope="col">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                            $valido = "";

                            if(isset($_GET['nome'])){

                                $sensorGet = $_GET['nome'];

                                if($sensorGet == "TemperaturaCongelador" ||$sensorGet == "TemperaturaFrigorifico" || $sensorGet == "PesoFrutas" 
                                ||$sensorGet == "PesoEnlatados" ||$sensorGet == "PesoLiquidos" ||$sensorGet == "Caixa1" ||$sensorGet == "Caixa2" ||$sensorGet == "Caixa3" 
                                ||$sensorGet == "ClientesEntrada"  ||$sensorGet == "ClientesSaida" ||$sensorGet == "Vendas" || $sensorGet == "Compras"|| $sensorGet == "PortaEntrada" || $sensorGet == "PortaSaida"
                                || $sensorGet == "EntradaParque" || $sensorGet == "SaidaParque"){

                                    $valido = True;

                                    $caminho = ("files/$sensorGet/log.txt");

                                }else echo("Nome do sensor nao reconhecido");


                            }else echo("Sensor nao disponivel");

                            if($valido){

                                    if(0 != filesize($caminho)){ /* Verifica se o ficheiro se encontra vazio, se o ficheiro de encontrar vazio não executa o código para dar print ao seu conteúdo */

                                        $file = fopen($caminho, "r") or die ("Erro na abertura do ficheiro"); /* Não é necessário verificar se o ficheiro é aberto, pois o temos a garantia que o caminho está certo pelo if na linha 11 ? */

                                            while(!feof($file)){

                                                $line = fgets($file);

                                                $line = openssl_decrypt($line, $cipher, $key, $options=0, $iv);

                                                if( $line != "" ){
                                                    
                                                    list($data, $valor) = array_pad(explode(";", $line),2,null);

                                                    /* da print row a row dos dados no ficheiro log, se houver 4 datas faz 4 rows etc */
                                                    /* nao implementado - começa pelo mais antigo em cima e não pelo mais recente */

                                                    print(' 
                                                    
                                                    <tr>
                                                        <th scope="row">
                                                            
                                                            '. $data .'
                                                        </th>
                                                        <td>
                                                            '.$valor.'
                                                        </td>

                                                    </tr>
                                                    
                                                    ');
                                                }
                                            }

                                        fclose($file);

                                    }else{

                                        /* caso o ficheiro esteja vazio, notifica o gerente do mesmo */
                                        
                                        echo'
                                                
                                            <tr>
                                                <th scope="row" style="text-transform: uppercase; font-weight: bold;">
                                                    <span>Valor Indisponivel - Ficheiro Vazio</span>
                                                </th>
                                                <td style="text-transform: uppercase; font-weight: bold;">
                                                    <span>Valor Indisponivel - Ficheiro Vazio</span>
                                                </td>
                                            </tr>
                                                    
                                    ';

                                    } 
                            }

                        ?> 
                    </tbody>
                </table>
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


