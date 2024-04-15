<?php /* NAO MOSTRAR ERROS - como podemos ler ficheiros que nao existem os erros tem de estar desativados */
error_reporting(0);
ini_set('display_errors', 0);
?>


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
$errosHora = file_get_contents("API/Notificações/hora.txt");

$erros = intval($erroFrig) + intval($erroCong) + intval($erroLoja) + intval($erroParque);

if (filesize("API/WebCam/hora.txt") == 0){ /* se ficheiro vazio hora = indisponivel */
    $hora = "Indisponivel";
}else $hora = file_get_contents("API/WebCam/hora.txt");

/* verificar quais imagens estao disponiveis para o log de imagens */
/* se nao houver ficheiro dá return a "FALSE" */

$w0 = file_get_contents("API/WebCam/Fotos/Webcam0.jpg");
$w1 = file_get_contents("API/WebCam/Fotos/Webcam1.jpg");
$w2 = file_get_contents("API/WebCam/Fotos/Webcam2.jpg");
$w3 = file_get_contents("API/WebCam/Fotos/Webcam3.jpg");
$w4 = file_get_contents("API/WebCam/Fotos/Webcam4.jpg");
$w5 = file_get_contents("API/WebCam/Fotos/Webcam5.jpg");
$w6 = file_get_contents("API/WebCam/Fotos/Webcam6.jpg");
$w7 = file_get_contents("API/WebCam/Fotos/Webcam7.jpg");
$w8 = file_get_contents("API/WebCam/Fotos/Webcam8.jpg");
$w9 = file_get_contents("API/WebCam/Fotos/Webcam9.jpg");


?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Câmara</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="http://127.0.0.1/Projeto-TI/Dashboard/All-Pages-Css/All.css"> <!-- Css constante em todas as paginas -->

    <link rel="stylesheet" href="camaraCSS.css">

    <style>
      .log-images { /* estilo da tabela do historico das imagens  */
        position: absolute;
        top:90%;
        bottom: 0;
        left: 0;
        right: 0;

        margin: auto;
        background-color: #252525;
        border-radius: 20px;
        width: 80%;
        height: 30%;
        overflow-x: hidden;
        overflow-y: auto;
        text-align: center;
        padding: 20px;
      }
    </style>

</head>

<body>

    <!--  #7968FA -->


    <!-- sidebar -->

    <div class="sidebar"> <!-- SIDEBAR -->
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
                        <span class="title">Logout</span> <!-- opção de logout -->
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="controlPage" > <!-- BARRA TOP COM NOTIFICAÇÕES E FOTO DE LOGIN -->
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
        <div class="row" style="top:5%; position:relative;"> <!-- IMAGEM ATUAL CAIXA -->
            <div class="col-md-4">
            </div>
            <div class="col-md-4 foto" style="background-color: #252525; border-top: 16px; border-style: solid; 
            border-color: #252525; box-shadow: 0 0 30px -2px rgb(0, 0, 0) !important; border-radius: 10px;">
                <div class="thumbnail">
                <span target="_blank"> 
                    <div class="caption text-center" style = "color: #fff;">
                        <p style="font-weight: bold; letter-spacing: 0.8px; font-size: 1.6rem; text-transform: uppercase;">Última foto</p>
                    </div> <!-- ?t= time usado para nao guardar imagens na cache -->
                    <img src="API/WeBcam/Fotos/Webcam.jpg?t=<?php echo time() ?>" alt="NENHUMA IMAGEM DISPONIVEL" style="width:100%; border-radius: 10px; color: #ffff">
                    <div class="caption text-center" style = "color: #fff; margin-top: 12px;">
                        <p style="letter-spacing: 0.8px; font-size: 1.2rem; margin-top: 6px">Atualização : <?php echo $hora ?> </p> <!-- ATUALIZAÇÃO foto -->
                    </div>
                </span>
                </div>
            </div>
            <div class="col-md-4">
            </div>
        </div>
        <div class="log-images"> <!-- CAIXA HISTORICO IMAGENS MÁX.10 -->
            <table class="table">
            <thead>
                <tr>
                <th scope="col">Atualização</th>
                <th scope="col">Imagem</th>
                </tr>
            </thead>
            <tbody> <!-- verifica um a um se há a imagem, caso haja cria uma row com a imagem e o tempo de atualização -->
                <?php 

                if ($w0 == FALSE && $W1 == FALSE && $W2 == FALSE && $W3 == FALSE && $W4 == FALSE && $W5 == FALSE && $W6 == FALSE
                && $W7 == FALSE && $W8 == FALSE && $W9 == FALSE){
                    print('<tr>
                    <th scope="row">Nenhuma imagem</th>
                    <td class = "atual">Nenhuma imagem</td>
                    </tr>');
                }else{

                    if ($w0 != FALSE){

                        $horaw0 = filemtime("API/WebCam/Fotos/Webcam0.jpg"); /* vai buscar ultima tempo da ultima modificação da img */
                        $horaw0 = date("Y/m/d H:i:s", $horaw0); /* transforma no formato usado YYYY/MM/DD HH:MM:SS */
                        $random = time();
                        print('<tr>
                        <th scope="row">'.$horaw0.'</th>
                        <td class = "atual"><img src="API/WeBcam/Fotos/Webcam0.jpg?t='.$random.'" alt="" style="width: 150px; height; 150px; border: 1px solid white; border-radius: 10px"></td>
                        </tr>');
                    }

                    if ($w1 != FALSE){

                        $horaw1 = filemtime("API/WebCam/Fotos/Webcam1.jpg"); /* vai buscar ultima tempo da ultima modificação da img */
                        $horaw1 = date("Y/m/d H:i:s", $horaw1); /* transforma no formato usado YYYY/MM/DD HH:MM:SS */
                        $random = time();

                        print('<tr>
                        <th scope="row">'.$horaw1.'</th>
                        <td class = "atual"><img src="API/WeBcam/Fotos/Webcam1.jpg?t='.$random.'" alt="" style="width: 150px; height; 150px; border: 1px solid white; border-radius: 10px"></td>
                        </tr>');
                    }

                    if ($w2 != FALSE){

                        $horaw2 = filemtime("API/WebCam/Fotos/Webcam2.jpg"); /* vai buscar ultima tempo da ultima modificação da img */
                        $horaw2 = date("Y/m/d H:i:s", $horaw2); /* transforma no formato usado YYYY/MM/DD HH:MM:SS */
                        $random = time();

                        print('<tr>
                        <th scope="row">'.$horaw2.'</th>
                        <td class = "atual"><img src="API/WeBcam/Fotos/Webcam2.jpg?t='.$random.'" alt="" style="width: 150px; height; 150px; border: 1px solid white; border-radius: 10px"></td>
                        </tr>');
                    }

                    if ($w3 != FALSE){

                        $horaw3 = filemtime("API/WebCam/Fotos/Webcam3.jpg"); /* vai buscar ultima tempo da ultima modificação da img */
                        $horaw3 = date("Y/m/d H:i:s", $horaw3); /* transforma no formato usado YYYY/MM/DD HH:MM:SS */
                        $random = time();

                        print('<tr>
                        <th scope="row">'.$horaw3.'</th>
                        <td class = "atual"><img src="API/WeBcam/Fotos/Webcam3.jpg?t='.$random.'" alt="" style="width: 150px; height; 150px; border: 1px solid white; border-radius: 10px"></td>
                        </tr>');
                    }

                    if ($w4 != FALSE){

                        $horaw4 = filemtime("API/WebCam/Fotos/Webcam4.jpg"); /* vai buscar ultima tempo da ultima modificação da img */
                        $horaw4 = date("Y/m/d H:i:s", $horaw4); /* transforma no formato usado YYYY/MM/DD HH:MM:SS */
                        $random = time();

                        print('<tr>
                        <th scope="row">'.$horaw4.'</th>
                        <td class = "atual"><img src="API/WeBcam/Fotos/Webcam4.jpg?t='.$random.'" alt="" style="width: 150px; height; 150px; border: 1px solid white; border-radius: 10px"></td>
                        </tr>');
                    }

                    if ($w5 != FALSE){

                        $horaw5 = filemtime("API/WebCam/Fotos/Webcam5.jpg"); /* vai buscar ultima tempo da ultima modificação da img */
                        $horaw5 = date("Y/m/d H:i:s", $horaw5); /* transforma no formato usado YYYY/MM/DD HH:MM:SS */
                        $random = time();

                        print('<tr>
                        <th scope="row">'.$horaw5.'</th>
                        <td class = "atual"><img src="API/WeBcam/Fotos/Webcam5.jpg?t='.$random.'" alt="" style="width: 150px; height; 150px; border: 1px solid white; border-radius: 10px"></td>
                        </tr>');
                    }

                    if ($w6 != FALSE){

                        $horaw6 = filemtime("API/WebCam/Fotos/Webcam6.jpg"); /* vai buscar ultima tempo da ultima modificação da img */
                        $horaw6 = date("Y/m/d H:i:s", $horaw6); /* transforma no formato usado YYYY/MM/DD HH:MM:SS */
                        $random = time();

                        print('<tr>
                        <th scope="row">'.$horaw6.'</th>
                        <td class = "atual"><img src="API/WeBcam/Fotos/Webcam6.jpg?t='.$random.'" alt="" style="width: 150px; height; 150px; border: 1px solid white; border-radius: 10px"></td>
                        </tr>');
                    }

                    if ($w7 != FALSE){

                        $horaw7 = filemtime("API/WebCam/Fotos/Webcam7.jpg"); /* vai buscar ultima tempo da ultima modificação da img */
                        $horaw7 = date("Y/m/d H:i:s", $horaw7); /* transforma no formato usado YYYY/MM/DD HH:MM:SS */
                        $random = time();

                        print('<tr>
                        <th scope="row">'.$horaw7.'</th>
                        <td class = "atual"><img src="API/WeBcam/Fotos/Webcam7.jpg?t='.$random.'" alt="" style="width: 150px; height; 150px; border: 1px solid white; border-radius: 10px"></td>
                        </tr>');
                    }

                    if ($w8 != FALSE){

                        $horaw8 = filemtime("API/WebCam/Fotos/Webcam8.jpg"); /* vai buscar ultima tempo da ultima modificação da img */
                        $horaw8 = date("Y/m/d H:i:s", $horaw8); /* transforma no formato usado YYYY/MM/DD HH:MM:SS */
                        $random = time();

                        print('<tr>
                        <th scope="row">'.$horaw8.'</th>
                        <td class = "atual"><img src="API/WeBcam/Fotos/Webcam8.jpg?t='.$random.'" alt="" style="width: 150px; height; 150px; border: 1px solid white; border-radius: 10px"></td>
                        </tr>');
                    }

                    if ($w9 != FALSE){

                        $horaw9 = filemtime("API/WebCam/Fotos/Webcam9.jpg"); /* vai buscar ultima tempo da ultima modificação da img */
                        $horaw9 = date("Y/m/d H:i:s", $horaw9); /* transforma no formato usado YYYY/MM/DD HH:MM:SS */
                        $random = time();

                        print('<tr>
                        <th scope="row">'.$horaw9.'</th>
                        <td class = "atual"><img src="API/WeBcam/Fotos/Webcam9.jpg?t='.$random.'" alt="" style="width: 150px; height; 150px; border: 1px solid white; border-radius: 10px"></td>
                        </tr>');
                    }
                }

                ?>
        
            </tbody>
            </table>
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