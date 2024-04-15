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

    /* CAMINHOS */

    $caminhoCaixa1 = "API/Files/Caixa1";
    $caminhoCaixa2 = "API/Files/Caixa2";
    $caminhoCaixa3 = "API/Files/Caixa3";
    $caminhoEnlatados = "API/Files/PesoEnlatados";
    $caminhoLiquidos = "API/Files/PesoLiquidos";
    $caminhoFruta = "API/Files/PesoFrutas";
    $caminhoFrig = "API/Files/TemperaturaFrigorifico";
    $caminhoCong = "API/Files/TemperaturaCongelador";
    $caminhoEntrada = "API/Files/PortaEntrada";
    $caminhoSaida = "API/Files/PortaSaida";
    $caminhoSensorEntrada = "API/Files/ClientesEntrada";
    $caminhoSensorSaida = "API/Files/ClientesSaida";
    $caminhoParqueEntrada = "API/Files/EntradaParque";
    $caminhoParqueSaida = "API/Files/SaidaParque";
    $caminhoFumo = "API/Files/Fumo";

    /* VALOR DO STATUS */

    $status_caixa1 = file_get_contents("$caminhoCaixa1/status.txt"); $status_caixa1 = openssl_decrypt($status_caixa1, $cipher, $key, $options=0, $iv);
    $status_caixa2 = file_get_contents("$caminhoCaixa2/status.txt"); $status_caixa2 = openssl_decrypt($status_caixa2, $cipher, $key, $options=0, $iv);
    $status_caixa3 = file_get_contents("$caminhoCaixa3/status.txt"); $status_caixa3 = openssl_decrypt($status_caixa3, $cipher, $key, $options=0, $iv);
    $status_Enlatados = file_get_contents("$caminhoEnlatados/status.txt"); $status_Enlatados = openssl_decrypt($status_Enlatados, $cipher, $key, $options=0, $iv);
    $status_Liquidos = file_get_contents("$caminhoLiquidos/status.txt"); $status_Liquidos = openssl_decrypt($status_Liquidos, $cipher, $key, $options=0, $iv);
    $status_Fruta = file_get_contents("$caminhoFruta/status.txt"); $status_Fruta = openssl_decrypt($status_Fruta, $cipher, $key, $options=0, $iv);
    $status_Frig = file_get_contents("$caminhoFrig/status.txt"); $status_Frig = openssl_decrypt($status_Frig, $cipher, $key, $options=0, $iv);
    $status_Cong = file_get_contents("$caminhoCong/status.txt"); $status_Cong = openssl_decrypt($status_Cong, $cipher, $key, $options=0, $iv);
    $status_Entrada = file_get_contents("$caminhoEntrada/status.txt"); $status_Entrada = openssl_decrypt($status_Entrada, $cipher, $key, $options=0, $iv);
    $status_Saida = file_get_contents("$caminhoSaida/status.txt"); $status_Saida = openssl_decrypt($status_Saida, $cipher, $key, $options=0, $iv);
    $status_ClientesEntrada = file_get_contents("$caminhoSensorEntrada/status.txt"); $status_ClientesEntrada = openssl_decrypt($status_ClientesEntrada, $cipher, $key, $options=0, $iv);
    $status_ClienteSaida = file_get_contents("$caminhoSensorSaida/status.txt"); $status_ClienteSaida = openssl_decrypt($status_ClienteSaida, $cipher, $key, $options=0, $iv);
    $status_ParqueEntrada = file_get_contents("$caminhoParqueEntrada/status.txt"); $status_ParqueEntrada = openssl_decrypt($status_ParqueEntrada, $cipher, $key, $options=0, $iv);
    $status_ParqueSaida = file_get_contents("$caminhoParqueSaida/status.txt"); $status_ParqueSaida = openssl_decrypt($status_ParqueSaida, $cipher, $key, $options=0, $iv);
    $status_Fumo = file_get_contents("$caminhoFumo/status.txt"); $status_Fumo = openssl_decrypt($status_Fumo, $cipher, $key, $options=0, $iv);
	
    /* STRING DA ATUALIZAÇÃO */

    $hora_caixa1 = file_get_contents("$caminhoCaixa1/hora.txt"); $hora_caixa1 = openssl_decrypt($hora_caixa1, $cipher, $key, $options=0, $iv);
    $hora_caixa2 = file_get_contents("$caminhoCaixa2/hora.txt"); $hora_caixa2 = openssl_decrypt($hora_caixa2, $cipher, $key, $options=0, $iv);
    $hora_caixa3 = file_get_contents("$caminhoCaixa3/hora.txt"); $hora_caixa3 = openssl_decrypt($hora_caixa3, $cipher, $key, $options=0, $iv);
    $hora_Enlatados = file_get_contents("$caminhoEnlatados/hora.txt"); $hora_Enlatados = openssl_decrypt($hora_Enlatados, $cipher, $key, $options=0, $iv);
    $hora_Liquidos = file_get_contents("$caminhoLiquidos/hora.txt"); $hora_Liquidos = openssl_decrypt($hora_Liquidos, $cipher, $key, $options=0, $iv);
    $hora_Fruta = file_get_contents("$caminhoFruta/hora.txt"); $hora_Fruta = openssl_decrypt($hora_Fruta, $cipher, $key, $options=0, $iv);
    $hora_Frig = file_get_contents("$caminhoFrig/hora.txt"); $hora_Frig = openssl_decrypt($hora_Frig, $cipher, $key, $options=0, $iv);
    $hora_Cong = file_get_contents("$caminhoCong/hora.txt"); $hora_Cong = openssl_decrypt($hora_Cong, $cipher, $key, $options=0, $iv);
    $hora_Entrada = file_get_contents("$caminhoEntrada/hora.txt"); $hora_Entrada = openssl_decrypt($hora_Entrada, $cipher, $key, $options=0, $iv);
    $hora_Saida = file_get_contents("$caminhoSaida/hora.txt"); $hora_Saida = openssl_decrypt($hora_Saida, $cipher, $key, $options=0, $iv);
    $hora_ClientesEntrada = file_get_contents("$caminhoSensorEntrada/hora.txt"); $hora_ClientesEntrada = openssl_decrypt($hora_ClientesEntrada, $cipher, $key, $options=0, $iv);
    $hora_ClienteSaida = file_get_contents("$caminhoSensorEntrada/hora.txt"); $hora_ClienteSaida = openssl_decrypt($hora_ClienteSaida, $cipher, $key, $options=0, $iv);
    $hora_ParqueEntrada = file_get_contents("$caminhoParqueEntrada/hora.txt"); $hora_ParqueEntrada = openssl_decrypt($hora_ParqueEntrada, $cipher, $key, $options=0, $iv);
    $hora_ParqueSaida = file_get_contents("$caminhoParqueSaida/hora.txt"); $hora_ParqueSaida = openssl_decrypt($hora_ParqueSaida, $cipher, $key, $options=0, $iv);
    $hora_Fumo = file_get_contents("$caminhoParqueSaida/hora.txt"); $hora_Fumo = openssl_decrypt($hora_Fumo, $cipher, $key, $options=0, $iv);

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
    

    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="http://127.0.0.1/Projeto-TI/Dashboard/All-Pages-Css/All.css">

    <link rel="stylesheet" href="sensores_Dashboard.css">
            
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
        <div class="cardsMainPage">
            <div class="allButtons"> <!-- na página dashboard para o cliente nao ter acesso ao mesmo sensores que o gerente fazemos uma separação dos mesmos através de um if 
        onde o cliente apenas tem acesso ao stock da loja nas 3 secções, parque de estacionamento e o estado das caixas-->
                <?php 
                
                    if($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador"){ /* se gerente ou trabalhador mostra todos os banners dos sensores */
                        print('
                            <div class="topButtons" style="margin-top: 40px;">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="button">
                                            <a class="btn" href="temperaturaSensores.php" role="button" id="temp">
                                                <div style="position: relative;">
                                                    <i class="bi bi-snow" style="color: #a1f2fa; font-size: 5rem;"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="button">
                                            <a class="btn" href="segurançaSensores.php" role="button" id="segurança">
                                                <div style="position: relative;">
                                                    <i class="bi bi-shield-lock-fill" style="color: #ba97fb;  font-size: 5rem;"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="button">
                                            <a class="btn" href="stockLoja.php" role="button" id="stock">
                                                <div style="position: relative;">
                                                    <i class="bi bi-basket-fill" style="color: #ff8d41;  font-size: 5rem;"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bottomButtons" style="margin-top: 80px;">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="button">
                                            <a class="btn" href="camara.php" role="button" id="camera">
                                                <div style="position: relative;">
                                                    <i class="bi bi-camera-video-fill" style="color: #f1536e;  font-size: 5rem;"></i>
                                                </div>
                                            </a>

                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="button">
                                            <a class="btn" href="estacionamento.php" role="button" id="park">
                                                <div style="position: relative;">
                                                    <i class="bi bi-check-circle-fill" style="color: #64b462;  font-size: 5rem;"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="button">
                                            <a class="btn" href="estadoCaixas.php" role="button" id="moeda">
                                                <div style="position: relative;">
                                                    <i class="bi bi-currency-exchange" style="color: #fce041;  font-size: 5rem;"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ');
                    }else{ /* sae for cliente mostra apenas estacionamento, estado caixas e stock da loja */
                        print('
                            <div class="topButtons" style="margin-top: 40px;">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="button">
                                            <a class="btn" href="estacionamento.php" role="button" id="park">
                                                <div style="position: relative;">
                                                    <i class="bi bi-check-circle-fill" style="color: #64b462;  font-size: 5rem;"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="button">
                                            <a class="btn" href="estadoCaixas.php" role="button" id="moeda">
                                                <div style="position: relative;">
                                                    <i class="bi bi-currency-exchange" style="color: #fce041;  font-size: 5rem;"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="button">
                                            <a class="btn" href="stockLoja.php" role="button" id="stock">
                                                <div style="position: relative;">
                                                    <i class="bi bi-basket-fill" style="color: #ff8d41;  font-size: 5rem;"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        ');

                    }
                
                ?>
                    <div class="tituloTable" style="margin-left: 37%">
                        <span>STATUS SENSORES</span> <!-- TABELA DOS STATUS DOS SENSORES -->
                    </div>
                <div class="sensorStatus bdr">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                              <tr>
                                <th scope="col">Status</th>
                                <th scope="col">Nome Sensor</th>
                                <th scope="col">Ultimo Funcionamento</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row">
                                <?php
                                    if($status_Enlatados == "ON"){ /* primeiro veririfica se esta on, depois se esta off e depois tudo o resto que tiver como status no ficheiro o seu estado fica sempre Indisponivel */
                                        echo '<span class="badge rounded-pill bg-success">ON</span>';
                                    }elseif($status_Enlatados == "OFF"){
                                        echo '<span class="badge rounded-pill bg-danger">OFF</span>';
                                    }else  echo '<span class="badge rounded-pill bg-warning">INDISPONIVEL</span>';
                                ?>   
                                </th>
                                <td>Stock Enlatados</td>
                                <td>                               
                                <?php
                                    if($hora_Enlatados == ""){ /* se o ficheiro estiver vazio nao devolve nada logo o estado do sensor é indisponivel */
                                        echo ("Data e hora Indisponivel");
                                    }else echo ($hora_Enlatados);
                                ?>   
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">
                                <?php
                                    if($status_Liquidos == "ON"){ /* primeiro veririfica se esta on, depois se esta off e depois tudo o resto que tiver como status no ficheiro o seu estado fica sempre Indisponivel */
                                        echo '<span class="badge rounded-pill bg-success">ON</span>';
                                    }elseif($status_Liquidos == "OFF"){
                                        echo '<span class="badge rounded-pill bg-danger">OFF</span>';
                                    }else  echo '<span class="badge rounded-pill bg-warning">INDISPONIVEL</span>';
                                ?> 
                                </th>
                                <td>Stock Líquidos</td>
                                <td>
                                <?php
                                    if($hora_Liquidos == ""){ /* se o ficheiro estiver vazio nao devolve nada logo o estado do sensor é indisponivel */
                                        echo ("Data e hora Indisponivel");
                                    }else echo ($hora_Liquidos);
                                ?>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">
                                <?php
                                    if($status_Fruta == "ON"){ /* primeiro veririfica se esta on, depois se esta off e depois tudo o resto que tiver como status no ficheiro o seu estado fica sempre Indisponivel */
                                        echo '<span class="badge rounded-pill bg-success">ON</span>';
                                    }elseif($status_Fruta == "OFF"){
                                        echo '<span class="badge rounded-pill bg-danger">OFF</span>';
                                    }else  echo '<span class="badge rounded-pill bg-warning">INDISPONIVEL</span>';
                                ?> 
                                </th>
                                <td>Stock Frutas</td>
                                <td>
                                <?php
                                    if($hora_Fruta == ""){ /* se o ficheiro estiver vazio nao devolve nada logo o estado do sensor é indisponivel */
                                        echo ("Data e hora Indisponivel");
                                    }else echo ($hora_Fruta);
                                ?>
                                </td>
                              </tr>
                               <!-- FRIGORIFICO -->
                                <?php
                                    if($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador"){
                                        
                                        print('
                                            <tr>
                                            <th scope="row">
                                        ');
                                        
                                        if($status_Frig == "ON"){ /* primeiro veririfica se esta on, depois se esta off e depois tudo o resto que tiver como status no ficheiro o seu estado fica sempre Indisponivel */
                                            echo '<span class="badge rounded-pill bg-success">ON</span>';
                                        }elseif($status_Frig == "OFF"){
                                            echo '<span class="badge rounded-pill bg-danger">OFF</span>';
                                        }else echo '<span class="badge rounded-pill bg-warning">INDISPONIVEL</span>';

                                        print('
                                            </th>
                                            <td>Frigorifico</td>
                                            <td>
                                        ');

                                        if($hora_Frig == ""){ /* se o ficheiro estiver vazio nao devolve nada logo o estado do sensor é indisponivel */
                                            echo ("Data e hora Indisponivel");
                                        }else echo ($hora_Frig);

                                        print('
                                            </td>
                                            </tr>
                                        ');
                                    }

                                ?>
                                <!-- CONGELADOR -->
                                <?php

                                 if($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador"){
                                    print('
                                        <tr>
                                        <th scope="row">
                                    ');

                                    if($status_Cong == "ON"){ /* primeiro veririfica se esta on, depois se esta off e depois tudo o resto que tiver como status no ficheiro o seu estado fica sempre Indisponivel */
                                        echo '<span class="badge rounded-pill bg-success">ON</span>';
                                    }elseif($status_Cong == "OFF"){
                                        echo '<span class="badge rounded-pill bg-danger">OFF</span>';
                                    }else echo '<span class="badge rounded-pill bg-warning">INDISPONIVEL</span>';

                                    print('
                                            </th>
                                            <td>Congelador</td>
                                            <td>
                                        ');

                                    if($hora_Cong == ""){ /* se o ficheiro estiver vazio nao devolve nada logo o estado do sensor é indisponivel */
                                        echo ("Data e hora Indisponivel");
                                    }else echo ($hora_Cong);

                                    print('
                                        </td>
                                        </tr>
                                    ');

                                }

                                ?>
                              <tr>
                                <th scope="row">
                                <?php
                                    if($status_caixa1 == "ABERTA"){ /* primeiro veririfica se esta on, depois se esta off e depois tudo o resto que tiver como status no ficheiro o seu estado fica sempre Indisponivel */
                                        echo '<span class="badge rounded-pill bg-success">ABERTA</span>';
                                    }elseif($status_caixa1 == "FECHADA"){
                                        echo '<span class="badge rounded-pill bg-danger">FECHADA</span>';
                                    }else  echo '<span class="badge rounded-pill bg-warning">INDISPONIVEL</span>';
                                ?> 
                                </th>
                                <td>Caixa 1</td>
                                <td>
                                <?php
                                    if($hora_caixa1 == ""){ /* se o ficheiro estiver vazio nao devolve nada logo o estado do sensor é indisponivel */
                                        echo ("Data e hora Indisponivel");
                                    }else echo ($hora_caixa1);
                                ?>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">
                                <?php
                                    if($status_caixa2 == "ABERTA"){ /* primeiro veririfica se esta on, depois se esta off e depois tudo o resto que tiver como status no ficheiro o seu estado fica sempre Indisponivel */
                                        echo '<span class="badge rounded-pill bg-success">ABERTA</span>';
                                    }elseif($status_caixa2 == "FECHADA"){
                                        echo '<span class="badge rounded-pill bg-danger">FECHADA</span>';
                                    }else  echo '<span class="badge rounded-pill bg-warning">INDISPONIVEL</span>';
                                ?>
                                </th>
                                <td>Caixa 2</td>
                                <td>
                                <?php
                                    if($hora_caixa2 == ""){ /* se o ficheiro estiver vazio nao devolve nada logo o estado do sensor é indisponivel */
                                        echo ("Data e hora Indisponivel");
                                    }else echo ($hora_caixa2);
                                ?>
                                </td>
                              </tr>
                              <tr>
                                <th scope="row">
                                <?php
                                    if($status_caixa3 == "ABERTA"){ /* primeiro veririfica se esta on, depois se esta off e depois tudo o resto que tiver como status no ficheiro o seu estado fica sempre Indisponivel */
                                        echo '<span class="badge rounded-pill bg-success">ABERTA</span>';
                                    }elseif($status_caixa3 == "FECHADA"){
                                        echo '<span class="badge rounded-pill bg-danger">FECHADA</span>';
                                    }else  echo '<span class="badge rounded-pill bg-warning">INDISPONIVEL</span>';
                                ?>
                                </th>
                                <td>Caixa 3</td>
                                <td>
                                <?php
                                    if($hora_caixa3 == ""){ /* se o ficheiro estiver vazio nao devolve nada logo o estado do sensor é indisponivel */
                                        echo ("Data e hora Indisponivel");
                                    }else echo ($hora_caixa3);
                                ?>
                                </td>
                              </tr>
                              <!-- PORTA ENTRADA -->
                                <?php

                                    if($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador"){
                                        print('
                                            <tr>
                                            <th scope="row">
                                        ');
                                    }

                                    if($status_Entrada == "ABERTA" && ($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador")){ /* primeiro veririfica se esta on, depois se esta off e depois tudo o resto que tiver como status no ficheiro o seu estado fica sempre Indisponivel */
                                        echo '<span class="badge rounded-pill bg-success">ABERTA</span>';
                                    }elseif($status_Entrada == "FECHADA" && ($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador")){
                                        echo '<span class="badge rounded-pill bg-danger">FECHADA</span>';
                                    }elseif($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador")  {
                                        echo '<span class="badge rounded-pill bg-warning">INDISPONIVEL</span>';
                                    }

                                    if($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador"){
                                        print('
                                            </th>
                                            <td>Porta Entrada</td>
                                            <td>
                                        ');
                                    }

                                    if($hora_Entrada == "" && ($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador")){ /* se o ficheiro estiver vazio nao devolve nada logo o estado do sensor é indisponivel */
                                        echo ("Data e hora Indisponivel");
                                    }else echo ($hora_Entrada);

                                    if($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador"){
                                        print('
                                            </td>
                                            </tr>
                                        ');
                                    }
                                ?>
                                <!-- PORTA SAIDA -->
                                <?php

                                    if($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador"){
                                        print('
                                            <tr>
                                            <th scope="row">
                                        ');

                                        if($status_Saida == "ABERTA"){ /* primeiro veririfica se esta on, depois se esta off e depois tudo o resto que tiver como status no ficheiro o seu estado fica sempre Indisponivel */
                                            echo '<span class="badge rounded-pill bg-success">ABERTA</span>';
                                        }elseif($status_Saida == "FECHADA"){
                                            echo '<span class="badge rounded-pill bg-danger">FECHADA</span>';
                                        }else echo '<span class="badge rounded-pill bg-warning">INDISPONIVEL</span>';

                                        print('
                                            </th>
                                            <td>Porta Saida</td>
                                            <td>
                                        ');

                                        if($hora_Entrada == "" ){ /* se o ficheiro estiver vazio nao devolve nada logo o estado do sensor é indisponivel */
                                            echo ("Data e hora Indisponivel");
                                        }else echo ($hora_Saida);

                                        print('
                                            </td>
                                            </tr>
                                        ');
                                    }
                                ?>
                                <!-- CONTAGEM ENTRADA DE CLIENTES -->
                                <?php
                                    if($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador"){
                                        print('
                                        <tr>
                                        <th scope="row">
                                        ');

                                        if($status_ClientesEntrada == "ON"){ /* primeiro veririfica se esta on, depois se esta off e depois tudo o resto que tiver como status no ficheiro o seu estado fica sempre Indisponivel */
                                            echo '<span class="badge rounded-pill bg-success">ON</span>';
                                        }elseif($status_ClientesEntrada == "OFF"){
                                            echo '<span class="badge rounded-pill bg-danger">OFF</span>';
                                        }else  echo '<span class="badge rounded-pill bg-warning">INDISPONIVEL</span>';

                                        print('
                                            </th>
                                            <td>Contagem Entrada Clientes</td>
                                            <td>
                                        ');

                                        if($hora_ClientesEntrada == ""){ /* se o ficheiro estiver vazio nao devolve nada logo o estado do sensor é indisponivel */
                                            echo ("Data e hora Indisponivel");
                                        }else echo ($hora_ClientesEntrada);

                                        print('
                                        </td>
                                        </tr>
                                        ');
                                    }
                                ?>
                              <!-- CONTAGEM SAIDA DE CLIENTES -->
                                <?php

                                    if($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador"){
                                        print('
                                        <tr>
                                        <th scope="row">
                                        ');

                                    if($status_ClienteSaida == "ON"){ /* primeiro veririfica se esta on, depois se esta off e depois tudo o resto que tiver como status no ficheiro o seu estado fica sempre Indisponivel */
                                        echo '<span class="badge rounded-pill bg-success">ON</span>';
                                    }elseif($status_ClienteSaida == "OFF"){
                                        echo '<span class="badge rounded-pill bg-danger">OFF</span>';
                                    }else  echo '<span class="badge rounded-pill bg-warning">INDISPONIVEL</span>';

                                    print('
                                        </th>
                                        <td>Contagem Saida Clientes</td>
                                        <td>
                                    ');

                                    if($hora_ClienteSaida == ""){ /* se o ficheiro estiver vazio nao devolve nada logo o estado do sensor é indisponivel */
                                        echo ("Data e hora Indisponivel");
                                    }else echo ($hora_ClienteSaida);

                                    print('
                                        </td>
                                        </tr>
                                    ');

                                    } 

                                ?>
                                <!-- CONTAGEM ENTRADA PARQUE -->
                                <?php
                                    if($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador"){
                                        print('
                                        <tr>
                                        <th scope="row">
                                        ');

                                        if($status_ParqueEntrada == "ON"){ /* primeiro veririfica se esta on, depois se esta off e depois tudo o resto que tiver como status no ficheiro o seu estado fica sempre Indisponivel */
                                            echo '<span class="badge rounded-pill bg-success">ON</span>';
                                        }elseif($status_ParqueEntrada == "OFF"){
                                            echo '<span class="badge rounded-pill bg-danger">OFF</span>';
                                        }else  echo '<span class="badge rounded-pill bg-warning">INDISPONIVEL</span>';

                                        print('
                                            </th>
                                            <td>Contagem Entrada Parque</td>
                                            <td>
                                        ');

                                        if($hora_ParqueEntrada == ""){ /* se o ficheiro estiver vazio nao devolve nada logo o estado do sensor é indisponivel */
                                            echo ("Data e hora Indisponivel");
                                        }else echo ($hora_ParqueEntrada);

                                        print('
                                        </td>
                                        </tr>
                                        ');
                                    }
                                ?>
                                <!-- CONTAGEM SAIDA PARQUE -->
                                <?php
                                    if($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador"){
                                        print('
                                        <tr>
                                        <th scope="row">
                                        ');

                                        if($status_ParqueSaida == "ON"){ /* primeiro veririfica se esta on, depois se esta off e depois tudo o resto que tiver como status no ficheiro o seu estado fica sempre Indisponivel */
                                            echo '<span class="badge rounded-pill bg-success">ON</span>';
                                        }elseif($status_ParqueSaida == "OFF"){
                                            echo '<span class="badge rounded-pill bg-danger">OFF</span>';
                                        }else  echo '<span class="badge rounded-pill bg-warning">INDISPONIVEL</span>';

                                        print('
                                            </th>
                                            <td>Contagem Saida Parque</td>
                                            <td>
                                        ');

                                        if($hora_ParqueSaida == ""){ /* se o ficheiro estiver vazio nao devolve nada logo o estado do sensor é indisponivel */
                                            echo ("Data e hora Indisponivel");
                                        }else echo ($hora_ParqueSaida);

                                        print('
                                        </td>
                                        </tr>
                                        ');
                                    }
                                ?>
                                <?php
                                    if($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador"){
                                        print('
                                        <tr>
                                        <th scope="row">
                                        ');

                                        if($status_Fumo == "ON"){ /* primeiro veririfica se esta on, depois se esta off e depois tudo o resto que tiver como status no ficheiro o seu estado fica sempre Indisponivel */
                                            echo '<span class="badge rounded-pill bg-success">ON</span>';
                                        }elseif($status_ParqueSaida == "OFF"){
                                            echo '<span class="badge rounded-pill bg-danger">OFF</span>';
                                        }else  echo '<span class="badge rounded-pill bg-warning">INDISPONIVEL</span>';

                                        print('
                                            </th>
                                            <td>Sensor Fumo</td>
                                            <td>
                                        ');

                                        if($hora_ParqueSaida == ""){ /* se o ficheiro estiver vazio nao devolve nada logo o estado do sensor é indisponivel */
                                            echo ("Data e hora Indisponivel");
                                        }else echo ($hora_ParqueSaida);

                                        print('
                                        </td>
                                        </tr>
                                        ');
                                    }
                                ?>
                            </tbody>
                          </table>
                    </div>
                </div>
                <?php /* botao de desconto para o cliente, quando clica nele é chamada a função do javascipt que faz uma alertbox na página que nao sai do reload */
                      /* faltou implementar botao com click unico */

                    if($_SESSION['user'] == "Cliente"){
                        print('
                        
                        <center>
                            <a class="buttonDisc" href="#" role="button" id="desconto" onclick="disCode();">
                                <div class="tituloTableDisc">
                                    <span class="desconto">DESCONTO</span>
                                </div>
                                <span id="code" class="codigo"></span>
                            </a>
                        </center>
                        
                        ');
                    }

                ?>
                
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

    <script> /* gerador dos codigos de desconto para os clientes - ainda não adaptado - click unico do botao e tirar o refresh da pagina com o click*/
        
        function disCode(){
	        var randomNumber = Math.floor(1000 + Math.random() * 9000);
            alert("\n                           O seu código de desconto é : " + randomNumber); /* da print ao valor do codigo na alertbox do browser */
        }

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>


</body>

</html>