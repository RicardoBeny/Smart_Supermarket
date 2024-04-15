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

        $caminhoEntrada = "API/Files/ClientesEntrada/valor.txt";
        $caminhoSaida = "API/Files/ClientesSaida/valor.txt";
        $caminhoCompras = "API/Files/Compras/valor.txt";
        $caminhoVendas = "API/Files/Vendas/valor.txt";
        $caminhoParqueEntrada = "API/Files/EntradaParque/valor.txt";
        $caminhoParqueSaida = "API/Files/SaidaParque/valor.txt";

        $erroFrig = file_get_contents("API/Notificações/TemperaturaFrigorifico.txt"); 
        $erroCong = file_get_contents("API/Notificações/TemperaturaCongelador.txt");
        $erroLoja = file_get_contents("API/Notificações/PessoasLoja.txt");
        $erroParque = file_get_contents("API/Notificações/PessoasParque.txt"); 
        $errosHora = file_get_contents("API/Notificações/hora.txt");

        $erros = intval($erroFrig) + intval($erroCong) + intval($erroLoja) + intval($erroParque);


        if(filesize($caminhoEntrada) == FALSE || filesize($caminhoSaida) == FALSE){ 

            /* verifica se o ficheiro valor.txt da entrada e saida de clientes esta vazio
            se estiver vazio diz que não é valido para mostrar o numero de clientes da loja
            caso seja valido, mete os valores nas respetivas variaveis
            nao se mete a codição para a atualização, porque apenas fará sentido estar a data da atualização se existir um valor */
            
            $clientesLoja = "Indisponivel";
            $cientesAtualização = "Indisponivel";

        }else{
            /* decript */
            $clientesEntrada = file_get_contents($caminhoEntrada); $clientesEntrada = openssl_decrypt($clientesEntrada, $cipher, $key, $options=0, $iv); /* sensor conta quantas pessoas entram */
            $clienteSaida = file_get_contents($caminhoSaida); $clienteSaida = openssl_decrypt($clienteSaida, $cipher, $key, $options=0, $iv); /* sensor conta quantas pessoas saiem */
            $cientesAtualização = file_get_contents("API/files/ClientesEntrada/hora.txt"); $cientesAtualização = openssl_decrypt($cientesAtualização, $cipher, $key, $options=0, $iv);

            if($clientesEntrada < $clienteSaida){ 

                $clientesLoja = "Indisponivel";

            }else $clientesLoja = $clientesEntrada - $clienteSaida;

            
        }

        /* sensor da ultima atualização, sensores programados para dar valores no mesmo intervalo de tempo entao só é necessário o valor de um deles */

        if(filesize($caminhoVendas) == FALSE || filesize($caminhoCompras) == FALSE){ 
            
            /* verifica se o ficheiro valor.txt das compras e vendas diárias da loja esta vazio
            se estiver vazio diz que não é valido para mostrar o valor
            caso seja valido, mete os valores nas respetivas variaveis
            nao se mete a codição para a atualização, porque apenas fará sentido estar a data da atualização se existir um valor */

            $lucro = "Indisponivel";
            $lucroAtualização = "Indisponivel";

        }else{
            
            $compras = file_get_contents($caminhoCompras); $compras = openssl_decrypt($compras, $cipher, $key, $options=0, $iv);
            $vendas = file_get_contents($caminhoVendas); $vendas = openssl_decrypt($vendas, $cipher, $key, $options=0, $iv);
            $lucroAtualização = file_get_contents("API/files/Compras/hora.txt"); $lucroAtualização = openssl_decrypt($lucroAtualização, $cipher, $key, $options=0, $iv);

            $lucro = $vendas - $compras;
        }

        /* sensor da ultima atualização, sensores programados para dar valores no mesmo intervalo de tempo entao só é necessário o valor de um deles */

        if(filesize($caminhoParqueEntrada) == FALSE || filesize($caminhoParqueSaida) == FALSE){ 
            
            /* verifica se o ficheiro valor.txt da entrada e saida de clientes do parque esta vazio
            se estiver vazio diz que não é valido para mostrar o valor
            caso seja valido, mete os valores nas respetivas variaveis
            nao se mete a codição para a atualização, porque apenas fará sentido estar a data da atualização se existir um valor */

            $mensagemParque = "Indisponivel";
            $parqueAtualização = "Indisponivel";

        }else{
            
            $entrada = file_get_contents($caminhoParqueEntrada); $entrada = openssl_decrypt($entrada, $cipher, $key, $options=0, $iv); /* sensor conta quantas pessoas entram */
            $saida = file_get_contents($caminhoParqueSaida); $saida = openssl_decrypt($saida, $cipher, $key, $options=0, $iv); /* sensor conta quantas pessoas saiem */
            $parqueAtualização = file_get_contents("API/files/Compras/hora.txt"); $parqueAtualização = openssl_decrypt($parqueAtualização, $cipher, $key, $options=0, $iv);

            if($entrada < $saida){
                
                $mensagemParque = "Indisponivel";

            } else{
                $parque = $entrada - $saida; /* se o numero de clientes no parque for maior que o numero de parques 50, devolve parque cheio */
                if($parque < 50){
                    $mensagemParque = "Livre";
                }else $mensagemParque = "Cheio";
            }
        }

        /* sensor da ultima atualização, sensores programados para dar valores no mesmo intervalo de tempo entao só é necessário o valor de um deles */

        /* DECIFRAR O OBTIDO COM O FILE GET CONTENTES */

        $caixa1 = file_get_contents("API/Files/Caixa1/status.txt"); $caixa1 = openssl_decrypt($caixa1, $cipher, $key, $options=0, $iv);
        $caixa2 = file_get_contents("API/Files/Caixa2/status.txt"); $caixa2 = openssl_decrypt($caixa2, $cipher, $key, $options=0, $iv);
        $caixa3 = file_get_contents("API/Files/Caixa3/status.txt"); $caixa3 = openssl_decrypt($caixa3, $cipher, $key, $options=0, $iv);

        if ($caixa1 == "" || $caixa2 == "" || $caixa3 == ""){
            $mensagemCaixas = "Indisponivel";
            $horaCaixa = "Indiponivel";
        }

        if ($caixa1 == "ABERTA" && $caixa2 == "FECHADA" && $caixa3 == "FECHADA"){ /* criação das variaveis para depois dar print consoante o seu valor */
            $mensagemCaixas="Caixa 1 ABERTA";
            $horaCaixa = file_get_contents("API/Files/Caixa1/hora.txt"); $horaCaixa = openssl_decrypt($horaCaixa, $cipher, $key, $options=0, $iv);
        }elseif ($caixa1 == "ABERTA" && $caixa2 == "ABERTA" && $caixa3 == "FECHADA"){
            $mensagemCaixas="Caixa 1 e 2 ABERTAS";
            $horaCaixa = file_get_contents("API/Files/Caixa2/hora.txt"); $horaCaixa = openssl_decrypt($horaCaixa, $cipher, $key, $options=0, $iv);
        }elseif ($caixa1 == "ABERTA" && $caixa2 == "ABERTA" && $caixa3 == "ABERTA"){
            $mensagemCaixas="Todas as caixas ABERTAS";
            $horaCaixa = file_get_contents("API/Files/Caixa3/hora.txt"); $horaCaixa = openssl_decrypt($horaCaixa, $cipher, $key, $options=0, $iv);
        }

        /* sensor de fumo get valores para alterar banner */

        $valorFumo = file_get_contents("API/Files/Fumo/valor.txt"); $valorFumo = openssl_decrypt($valorFumo, $cipher, $key, $options=0, $iv);
        $horaFumo = file_get_contents("API/Files/Fumo/hora.txt"); $horaFumo = openssl_decrypt($horaFumo, $cipher, $key, $options=0, $iv);   
        $mensagemFumo = "";

        if ($horaFumo == ""){
            $horaFumo = "Indisponivel"; 
        }

        if ($valorFumo == ""){ /* definir imagem do banner consoante o valor de fumo */
            $mensagemFumo = " - Valor Indisponivel";
            $mensagemFan = "";
            $mensagemSprinkler = "";
            $titleLeft = ""; /* align texto meio quando ha mais texto */
            $updateTop = "top: 50%"; /* align texto hora quando ha mais texto */
            $danger = ""; /* texto danger do fumo */
            $imagemFumo =  "background-image: url('imagens-card/lowFumo.png');";
        }elseif ($valorFumo <= 5){
            $imagemFumo =  "background-image: url('imagens-card/lowFumo.png');";
            $mensagemFumo = " - $valorFumo %";
            $mensagemFan = "";
            $mensagemSprinkler = "";
            $titleLeft = ""; /* align texto meio quando ha mais texto */
            $updateTop = "top: 50%"; /* align texto hora quando ha mais texto */
            $danger = ""; /* texto danger do fumo */
        }elseif ($valorFumo <= 15 ){
            $mensagemFumo = " - $valorFumo %";
            $imagemFumo =  "background-image: url('imagens-card/nivel1.png');";
            $mensagemFan = "FAN - VEL 1";
            $mensagemSprinkler = "OFF";
            $titleLeft = "left: 4%"; /* align texto meio quando ha mais texto */
            $updateTop = "top: 50%"; /* align texto hora quando ha mais texto */
            $danger = ""; /* texto danger do fumo */
        }elseif ($valorFumo <= 40){
            $mensagemFumo = " - $valorFumo %";
            $imagemFumo =  "background-image: url('imagens-card/nivel2.png');";
            $mensagemFan = "FAN - VEL 2";
            $mensagemSprinkler = "OFF";
            $titleLeft = "left: 4%";
            $updateTop = "top: 30%"; /* align texto hora quando ha mais texto */
            $danger = "DANGER"; /* texto danger do fumo */
        }else {
            $mensagemFumo = " - $valorFumo %";
            $imagemFumo =  "background-image: url('imagens-card/nivel3.png');";
            $mensagemFan = "FAN - VEL 2";
            $mensagemSprinkler = "ON";
            $titleLeft = "left: 4%";
            $updateTop = "top: 30%"; /* align texto hora quando ha mais texto */
            $danger = "DANGER"; /* texto danger do fumo */
        }
?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="http://127.0.0.1/Projeto-TI/Dashboard/All-Pages-Css/All.css"> <!-- Css constante em todas as paginas -->
    <link rel="stylesheet" href="dashboard.css"> <!-- css apenas da main page -->
    <link rel="stylesheet" href="relogioCSS.css">


</head>

<body onload="initClock()">

    <!--  #7968FA -->


    <!-- sidebar -->

    <div class="sidebar">
        <div class="navigation">
            <ul>
                <li> <!-- ITENS DA SIDEBAR  -->
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
                    <a href="#" class="homePage">
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
                        <span class="title">Logout</span> <!-- opção de logout -->
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
        <div class="cardsMainPage" style="height: 30%; margin-top: 8%"> <!-- MAIN PAGE -->
            <div class="row" style="height:60%;">
                <div class="col-sm-4">
                    <div class="card" style="background-image: url('imagens-card/lucro.png');"> <!-- cards dependem do user que esta logado -->
                        <div class="card-body">
                            <?php

                                if($_SESSION['user'] == "Gerente"){ /* Se gerente mostra card do lucro  */
                                    
                                    print('
                                    
                                        <span class="card-title">Lucro</span>
                                        <p class="card-title">Mensal</p>
                                        <p class="card-text"> '.$lucro.' MIL € </p>
                                        <p class="text-center" style="color: #fff; padding-top: 1px; font-weight: bold;"> Atualizado : '.$lucroAtualização.'</p>
                                        
                                    
                                    ');
                                }elseif ($_SESSION['user'] == "Cliente"){ /* se for cliente mostra card dos descontos */
                                    
                                    print('
                                        <a href="sensores-dashboard.php" style="text-decoration: none;">
                                            <span class="card-title">Descontos</span>
                                            <p class="card-title">Diários</p>
                                            <p class="text-center" style="color: #fff; padding-top: 50px; font-weight: bold; font-size:1.4rem"> CLIQUE EM MIM !! </p>
                                        </a>
                                    ');
                                }elseif ($_SESSION['user'] == "Trabalhador"){ /* se trabalhador mostra card com informação das caixas */
                                    print('
                                    <a href="" style="text-decoration: none;">
                                        <span class="card-title">Caixas</span>
                                        <p class="card-title">Abertas</p>
                                        <p class="card-title" style="font-size:1.2rem; padding-top: 20px">'.$mensagemCaixas.'</p>
                                        <p class="text-center" style="color: #fff; padding-top: 10px; font-weight: bold;">Atualizado : '.$horaCaixa.'</p>
                                    </a>
                                ');
                                }

                                    
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card" style="background-image: url('imagens-card/clientes.png');"> <!-- NAO INTERESSA USER MOSTRA SEMPRE Nº PESSOAS NA LOJA -->
                            <div class="card-body">
                                <span class="card-title">Clientes</span>
                                <p class="card-title">na Loja</p>
                                <p class="card-text"><?php echo($clientesLoja) ?></p>
                                <p class="text-center" style="color: #fff; padding-top: 1px; font-weight: bold;">
                                Atualizado : <?php echo($cientesAtualização) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card" style="background-image: url('imagens-card/error.png');"> 
                            <div class="card-body">
                                <?php

                                if($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador"){ /* SE GERENTE OU TRABALHADOR MOSTRA CARD ERROS */

                                    if($errosHora == ""){
                                        $errosHora = "Indisponivel";
                                    }
                                    
                                    print('
                                    
                                        <span class="card-title">Mensagem</span>
                                        <p class="card-title">Erro</p>
                                        <p class="card-text">'.$erros.'</p>
                                        <p class="text-center" style="color: #fff; padding-top: 1px; font-weight: bold;">
                                        Atualizado : Data - '.$errosHora.'</p>
                                        
                                    ');
                                }elseif($_SESSION['user'] == "Cliente"){ /* SE CLIENTE MOSTRA CARD DO PARQUE ESTACIONAMENTO */

                                    print('
                                    
                                        <span class="card-title">Parque</span>
                                        <p class="card-title">Estacionamento</p>
                                        <p class="card-text">'.$mensagemParque.'</p>
                                        <p class="text-center" style="color: #fff; padding-top: 1px; font-weight: bold;">
                                        Atualizado : '.$parqueAtualização.'</p>
                                    
                                ');

                                }
                            
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-top: 5%"></div>

            <div class="row" style="height:20%; justify-content: center;"> 
                <!-- incio relogio -->
                <?php 
                if ($_SESSION['user'] == "Cliente"){ /* SE CLIENTE MOSTRA O RELOGIO */
                    print('<div class="relogio">
                            <div class="datetime"> 
                                <div class="date">
                                    <span id ="dayname">00</span>,
                                    <span id="month">Month</span>
                                    <span id="daynum">00</span>,
                                    <span id="year">Year</span>
                                </div>
                                <div class="time">
                                    <span id="hour">00</span> :
                                    <span id="minutes">00</span> :
                                    <span id="seconds">00</span>
                                    <span id="period">AM</span>
                                </div>
                            </div>
                        </div>');
                }
            ?>
            <?php 
                if ($_SESSION['user'] == "Gerente" || $_SESSION['user'] == "Trabalhador"){ /* SE GERENTE OU TRABALHADOR MOSTRA BANNER DO FUMO */
                    print('<div class="card card-fumo" style="'.$imagemFumo.';">
                                <div class="card-body" style="text-align: center">
                                    <span class="card-subTitle1">'.$mensagemSprinkler.'</span>
                                    <span class="card-title" style="position: relative; bottom: 5%; '.$titleLeft.'">Sensor Fumo'.$mensagemFumo.'</span>
                                    <span class="card-subTitle1" style="position: relative; bottom: 10%; left: 24%">'.$mensagemFan.'</span>
                                    <p class="card-subTitle2" style=" color: red; position: relative; top: 20%; left:0%'.$titleLeft.'">'.$danger.'</p>
                                    <p class="text-center"; style="position: relative; color: #fff; '.$updateTop.'; font-weight: bold;">
                                    Atualizado : '.$horaFumo.'</p>
                                </div>
                            </div>');
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

    <script type="text/javascript">
        function updateClock(){
        var now = new Date(); /* data no formato data */
        var dname = now.getDay(), /* dia */
            mo = now.getMonth(), /* mes */
            dnum = now.getDate(), /* mes formato string */
            yr = now.getFullYear(), /* ano */
            hou = now.getHours(), /* horas */
            min = now.getMinutes(), /* minutos */
            sec = now.getSeconds(), /* segundos */
            pe = "AM";

            if(hou >= 12){
                pe = "PM"; /* se maior que 12 PM */
            }
            if(hou == 0){
                hou = 12;
            }
            if(hou > 12){
                hou = hou - 12;
            }

            Number.prototype.pad = function(digits){
                for(var n = this.toString(); n.length < digits; n = 0 + n); /* dar dois de tamaho ao numeros, de dia = 6 passa para 06 */
                return n;
            }

            var months = ["Janeiro", "Fevereiro", "Março", "Abrul", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"]; /* vetor meses */
            var week = ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"]; /* vetor dias */
            var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds", "period"]; /* vetor de ids a substituir */
            var values = [week[dname], months[mo], dnum.pad(2), yr, hou.pad(2), min.pad(2), sec.pad(2), pe]; /* valores a substiruir nos ids */
            for(var i = 0; i < ids.length; i++)
            document.getElementById(ids[i]).firstChild.nodeValue = values[i]; /* substituição dos valores pelos ids percorrendo o vetor */
        }

        function initClock(){ /* ATUALIZAÇÃO DA PÁGINA */
            updateClock();
            window.setInterval("updateClock()", 1);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>


</body>

</html>