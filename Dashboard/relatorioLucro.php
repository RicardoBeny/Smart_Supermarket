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

        $erroFrig = file_get_contents("API/Notificações/TemperaturaFrigorifico.txt");
        $erroCong = file_get_contents("API/Notificações/TemperaturaCongelador.txt");
        $erroLoja = file_get_contents("API/Notificações/PessoasLoja.txt");
        $erroParque = file_get_contents("API/Notificações/PessoasParque.txt"); 
    
        $erros = intval($erroFrig) + intval($erroCong) + intval($erroLoja) + intval($erroParque);

        $compras = "";

        $dataLucro = "";

        $vendas = "";

        /* valores para usar no grafico */
        
        $mensagemGraf="";

        if((0 != filesize("API/Files/Compras/log.txt")) && (0 != filesize("API/Files/Vendas/log.txt"))){ /* Verifica se o ficheiro se encontra vazio, se o ficheiro de encontrar vazio não executa o código para dar print ao seu conteúdo */

            $file1 = fopen("API/Files/Compras/log.txt", "r") or die ("Erro na abertura do ficheiro"); /* Não é necessário verificar se o ficheiro é aberto, pois o temos a garantia que o caminho está certo pelo if na linha 11 ? */
            $file2 = fopen("API/Files/Vendas/log.txt", "r") or die ("Erro na abertura do ficheiro");
            $tamCompras = 0;
            $tamVendas = 0;

                while(!feof($file1)){

                    $line = fgets($file1);

                    $line = openssl_decrypt($line, $cipher, $key, $options=0, $iv);

                    if( $line != "" ){
                        
                        list($data, $valor) = array_pad(explode(";", $line),2,null);

                        /* da print row a row dos dados no ficheiro log, se houver 4 datas faz 4 rows etc */
                        /* nao implementado - começa pelo mais antigo em cima e não pelo mais recente */

                        /* descript */

                        $compras .=" "; $compras .= $valor; $compras .= ","; 

                        $data = explode("/", $data); /* obter array para escolher o mes */

                        $dia = explode(" ", $data[2]); /* obter array para escolher o dia */

                        $dataLucro .= '"'; $dataLucro .= $dia[0] ; $dataLucro .= "/"; $dataLucro .= $data[1]; $dataLucro .= '" ,';

                        $tamCompras+=1;

                    }
                }

                while(!feof($file2)){

                    $line = fgets($file2);

                    $line = openssl_decrypt($line, $cipher, $key, $options=0, $iv);

                    if( $line != "" ){
                        
                        list($data, $valor) = array_pad(explode(";", $line),2,null);

                        /* da print row a row dos dados no ficheiro log, se houver 4 datas faz 4 rows etc */
                        /* nao implementado - começa pelo mais antigo em cima e não pelo mais recente */

                        $vendas .=" "; $vendas .= $valor; $vendas .= ",";

                        $tamVendas+=1;

                    }
                }

            fclose($file1);
            fclose($file2);

            $valido = 1;

            if(strlen($compras) == strlen($vendas)){
                $valido = 0;
            }

            /* tira a "," do final e fecha a string */

            $vendas=rtrim($vendas,", ");
            $compras=rtrim($compras,", ");

            /* calcular o lucro */

            $lucro="";

            if($tamCompras == $tamVendas){

                $compras = explode(",", $compras);
                $vendas = explode(",", $vendas);

                for ($i = 0; $i < $tamCompras; $i++){

                    $valor = $vendas[$i]-$compras[$i];

                    $lucro.=$valor; $lucro.=",";

                }

                $lucro=rtrim($lucro,", ");

        }else $mensagemGraf = 'Número de compras diferente do numero de vendas';

        }else $mensagemGraf = "Impossivel fazer o gráfico ficheiro log sem valores";

        /* verfifica se num compras = num vendas, caso for diferente nao consegue fazer o grafico */
        
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="20">

    <title>Relatório Lucro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="http://127.0.0.1/Projeto-TI/Dashboard/All-Pages-Css/All.css">

    <link rel="stylesheet" href="ReLucroCSS.css">

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
        <div class="titulo">
            <h1>RELATÓRIO ANUAL DO LUCRO</h1> <!-- titulo -->
        </div>

        <?php
            if($mensagemGraf != ""){ /* se houveres valores da print ao grafico senao mostra mensagem de erro */

                print('
                <div class="erro1">
                    <h1>'.$mensagemGraf.'</h1>
                </div>');

            }else print('
            <div class="grafCanvas">
                <div class="chart">
                    <canvas id="myChart"></canvas>
                </div>
            </div>');
            
            
            
        ?>  

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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" 
        integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" 
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script> /* código gráfico */
        
            const ctx = document.getElementById("myChart").getContext("2d");

            let delayed;

            //Gradient Fill

            let gradient = ctx.createLinearGradient(0,0,0,400); /* variavel de um gradiente */
            gradient.addColorStop(0, "rgba(0, 80, 255, 0.3)");
            gradient.addColorStop(0.5, "rgba(0, 126, 255, 0.6)");
            gradient.addColorStop(1, "rgba(0, 255, 255, 0.6)");

            const labels = [<?php echo ($dataLucro)?>]; /* eixo x */

            const data = { /* eixo y */
                labels,
                datasets: [
                    {
                        data: [<?php echo ($lucro)?>],
                        label: "Lucro",
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: "#fff",
                        pointBackgroundColor: "#0a97cf",
                        tension: 0.4,
                    },
                ],
            };
        
            const config = { /* configs do gráfico, animação ao iniciar a página, tamanho pontos e animação hover e mudança dos valores do eixo y para terem "mil €" */
                type: "line",
                data: data,
                options: {
                    hitRadius: 30,
                    hoverRadius: 12,
                    radius: 5,
                    responsive: true,
                    animation: {
                        onComplete: () => {
                            delayed = true;
                        },
                        delay: (context) => {
                            let delay = 0;
                            if (context.type === "data" && context.mode === "default" && !delayed) { /* delay animação gráfico */
                                delay = context.dataIndex * 300 + context.datasetIndex * 100;
                            }
                            return delay;
                        },
                    },
                    scales: {
                        y: {
                            ticks: {
                                callback: function (value){
                                    return value + " mil €";
                                },
                            },
                        },
                    },
                },
            };

            const myChart = new Chart(ctx, config); /* criação do gráfico */
            
        </script>

</body>

</html>