<?php

    /* ELEMENTOS NECESSÁRIOS PARA DAR DECRYPT */
    $iv = "1234567891011121"; 
    $key="nPIMLCuuYW";
    $cipher = "AES-128-CTR";

    header('Content-Type: text/html; charset=utf-8');

    if(isset($_POST)){

        if( $_SERVER['REQUEST_METHOD'] == "POST") {

            if (isset($_POST['nome'])){

                if(isset($_POST['hora'])){

                    if(isset($_POST['valor'])){

                        if(isset($_POST['status'])){

                            $sensorPost = $_POST['nome'];

                            if( $sensorPost == "TemperaturaCongelador" || $sensorPost == "TemperaturaFrigorifico" || $sensorPost == "PesoFrutas" 
                                || $sensorPost == "PesoEnlatados" || $sensorPost == "PesoLiquidos" || $sensorPost == "Caixa1" || $sensorPost == "Caixa2" || $sensorPost == "Caixa3" 
                                || $sensorPost == "ClientesEntrada"  || $sensorPost == "ClientesSaida" || $sensorPost == "Vendas" || $sensorPost == "Compras" || $sensorPost == "PortaEntrada" || $sensorPost == "PortaSaida"
                                || $sensorPost == "EntradaParque" || $sensorPost == "SaidaParque" || $sensorPost == "Fumo"){

                                /* o sensor que conta o numero de pessoas que entram e saiam, guarda o ultimo valor atribuido somando o proximo, dando assim o valor total de pessoas que saiem e entram na loja
                                nao senso preciso adicionar os seus valores quando os escrevemos no ficheiro valor.txt */

                                /* nas portas e caixas queremos saber se eles se encontram fechadas ou abertas nao o seu valor, entao apenas usamos os ficheiros necessários */

                                /* encriptar valores dados pelo sensor */

                                $ivlen = openssl_cipher_iv_length($cipher);
                                $ciphervalor = openssl_encrypt($_POST['valor'], $cipher, $key, $options=0, $iv);
                                $ciphernome = openssl_encrypt($_POST['nome'], $cipher, $key, $options=0, $iv);
                                $cipherhora = openssl_encrypt($_POST['hora'], $cipher, $key, $options=0, $iv);
                                $cipherstatus = openssl_encrypt($_POST['status'], $cipher, $key, $options=0, $iv); 
                                
                                /* se for porta entrada saida ou as caixas apenas escreve a hora nome e status porque nao há valor */

                                if($sensorPost == "PortaEntrada" || $sensorPost == "PortaSaida" || $sensorPost == "Caixa1" || $sensorPost == "Caixa2" || $sensorPost == "Caixa3"){ 
                                    
                                    file_put_contents("files/$sensorPost/hora.txt",$cipherhora);
                                    file_put_contents("files/$sensorPost/nome.txt",$ciphernome);
                                    file_put_contents("files/$sensorPost/status.txt",$cipherstatus);

                                    $string = $_POST['hora']; $string .= ";"; $string .= $_POST['status'];
                                    $cipherstring = openssl_encrypt($string, $cipher, $key, $options=0, $iv);
                                    $cipherstring .= "\n";  

                                    file_put_contents("files/$sensorPost/log.txt", $cipherstring, FILE_APPEND);
                                }else{
                                    
                                    /* se for as restantes escreve os parâmetros todos */

                                    file_put_contents("files/$sensorPost/valor.txt",$ciphervalor);
                                    file_put_contents("files/$sensorPost/hora.txt",$cipherhora);
                                    file_put_contents("files/$sensorPost/nome.txt",$ciphernome);
                                    file_put_contents("files/$sensorPost/status.txt",$cipherstatus);

                                    $string = $_POST['hora']; $string .= ";"; $string .= $_POST['valor'];
                                    $cipherstring = openssl_encrypt($string, $cipher, $key, $options=0, $iv);
                                    $cipherstring .= "\n";  

                                    file_put_contents("files/$sensorPost/log.txt", $cipherstring, FILE_APPEND);

                                    if ($sensorPost == "TemperaturaFrigorifico" || $sensorPost == "TemperaturaCongelador" || $sensorPost == "ClientesSaida" || $sensorPost == "ClientesEntrada" 
                                    || $sensorPost == "EntradaParque" || $sensorPost == "SaidaParque"){

                                        file_put_contents("Notificações/hora.txt",$_POST['hora']);

                                    }
                                    
                                    /* ******************************NOTIFICAÇÕES****************************** */

                                    switch ($sensorPost){ /* caso seja temp frig */
                                        case "TemperaturaFrigorifico":
                                            
                                            if (!(filesize("Notificações/$sensorPost.txt"))){ /* menor que 5 escreve 0 no ficheiro de erros */
                                                file_put_contents("Notificações/$sensorPost.txt",0);
                                            }

                                            if ($_POST['valor']>5){ /* se o seu valor for maior que 5 escreve 1 no ficheiro de erros */
                                                file_put_contents("Notificações/$sensorPost.txt",1);
                                            }else file_put_contents("Notificações/$sensorPost.txt",0);

                                            break;

                                        case "TemperaturaCongelador": 
                                            
                                            if (!(filesize("Notificações/$sensorPost.txt"))){ /* menor que -18 escreve 0 no ficheiro de erros */
                                                 file_put_contents("Notificações/$sensorPost.txt",0);
                                            }
     
                                            if ($_POST['valor']>-18){ /* maior que -18 escreve 1 no ficheiro de erros */
                                                file_put_contents("Notificações/$sensorPost.txt",1);
                                            }else file_put_contents("Notificações/$sensorPost.txt",0);
    
                                            break;

                                        case "ClientesSaida":
                                        case "ClientesEntrada":
                                            
                                            if (!(filesize("Notificações/PessoasLoja.txt"))){
                                                 file_put_contents("Notificações/PessoasLoja.txt",0);
                                            }
                                                
                                            $saida = file_get_contents("files/ClientesSaida/valor.txt"); 
                                            $saida = openssl_decrypt($saida, $cipher, $key, $options=0, $iv); /* decrypt valor */
                                            $entrada = file_get_contents("files/ClientesEntrada/valor.txt");
                                            $entrada = openssl_decrypt($entrada, $cipher, $key, $options=0, $iv); /* decrypt valor */
    
                                            if ($saida>$entrada){ /* se o numero de saida for maior que a entrada escreve 1 no ficheiro de erros se for menor escreve 0 */
                                                file_put_contents("Notificações/PessoasLoja.txt",1);
                                            }else file_put_contents("Notificações/PessoasLoja.txt",0);
    
                                            break;
                                        
                                        case "EntradaParque":
                                        case "SaidaParque":
                                            
                                            if (!(filesize("Notificações/PessoasParque.txt"))){
                                                 file_put_contents("Notificações/PessoasParque.txt",0);
                                            }

                                            $saida = file_get_contents("files/SaidaParque/valor.txt");
                                            $saida = openssl_decrypt($saida, $cipher, $key, $options=0, $iv); /* decrypt valor */
                                            $entrada = file_get_contents("files/EntradaParque/valor.txt");
                                            $entrada = openssl_decrypt($entrada, $cipher, $key, $options=0, $iv); /* decrypt valor */
    
                                            if ($saida>$entrada){ /* se o numero de saida for maior que a entrada escreve 1 no ficheiro de erros se for menor escreve 0 */
                                                file_put_contents("Notificações/PessoasParque.txt",1);
                                            }else file_put_contents("Notificações/PessoasParque.txt",0);
    
                                            break;
   
                                    }


                                }

                                http_response_code(200);

                            }else {
                                
                                $erroPOST = "Erro - Valores medidos nao pertencem a nenhum sensor - "; $erroPOST .= $_POST['hora']; $erroPOST .= "\n\n";

                                file_put_contents("files/logErrosPost.txt", $erroPOST, FILE_APPEND);

                                echo("\nParamêtros recebidos não são válidos - POST");
                                
                                http_response_code(400);
                            }  

                        }else{

                            $erroPOST = "Erro - Stautus nao inserido - "; $erroPOST .= $_POST['hora']; $erroPOST .= "\n\n";

                            file_put_contents("files/logErrosPost.txt", $erroPOST, FILE_APPEND);

                            echo("\nParamêtros recebidos não são válidos - POST");
                            
                            http_response_code(400);

                        }

                    }else{

                        $erroPOST = "Erro - Valores nao inseridos - "; $erroPOST .= $_POST['hora']; $erroPOST .= "\n\n";

                        file_put_contents("files/logErrosPost.txt", $erroPOST, FILE_APPEND);

                        echo("\nParamêtros recebidos não são válidos - POST");
                        
                        http_response_code(400);

                    }

                }else{

                    $erroPOST = "Erro - Hora nao inserida - "; $erroPOST .= "\n\n";

                    file_put_contents("files/logErrosPost.txt", $erroPOST, FILE_APPEND);

                    echo("\nParamêtros recebidos não são válidos - POST");
                    
                    http_response_code(400);

                }

            }else{

                $erroPOST = "Erro - Nome nao inserido - "; $erroPOST .= "\n\n";

                file_put_contents("files/logErrosPost.txt", $erroPOST, FILE_APPEND);

                echo("\nParamêtros recebidos não são válidos - POST");
                
                http_response_code(400);

            }

        }else if ($_SERVER['REQUEST_METHOD'] == "GET"){

            if (isset($_GET["nome"])){

                $sensorGET = $_GET['nome'];

                if($sensorGET == "TemperaturaCongelador" || $sensorGET == "TemperaturaFrigorifico" || $sensorGET == "PesoFrutas" 
                || $sensorGET == "PesoEnlatados" || $sensorGET == "PesoLiquidos" || $sensorGET == "Caixa1" || $sensorGET == "Caixa2" || $sensorGET == "Caixa3" 
                || $sensorGET == "ClientesEntrada"  || $sensorGET == "ClientesSaida" || $sensorGET == "Vendas" || $sensorGET == "Compras" || $sensorGET == "PortaEntrada" || $sensorGET == "PortaSaida"
                || $sensorGET == "EntradaParque" || $sensorGET == "SaidaParque" || $sensorGET == "Fumo"){

                    if($sensorGET == "PortaEntrada"|| $sensorGET == "PortaSaida" || $sensorGET == "Caixa1" || $sensorGET == "Caixa2" || $sensorGET == "Caixa3"){ 
                                    
                        if (!(filesize("files/$sensorGET/status.txt") == 0)){ /* caso seja portas e caixas da get do status em vez do valor */
                            $get = file_get_contents("files/$sensorGET/status.txt");
                            $get = openssl_decrypt($get, $cipher, $key, $options=0, $iv);
                            echo $get;
                        }
                    }else{

                        if (!(filesize("files/$sensorGET/valor.txt") == 0)){ /* caso seja as restantes da get do valor e nao do status */
                            $get = file_get_contents("files/$sensorGET/valor.txt");
                            $get = openssl_decrypt($get, $cipher, $key, $options=0, $iv);
                            echo $get;
                        }  
                    }

                    http_response_code(200);

                }else {

                    $erroGET = "Erro - Valores solicitados não existem \nNome do sensor solicitado :  "; $erroGET .= $sensorGET;  $erroGET .= "\n\n";

                    file_put_contents("files/logErrosGet.txt", $erroGET, FILE_APPEND);

                    http_response_code(400);
                }

            }else {
                http_response_code(403);
            }

        }else echo("Metodo nao permitido");

    }else{
        http_response_code(403);
    } 
?>