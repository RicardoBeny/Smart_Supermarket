<?php 

    define('KB', 1024);

    if(isset($_POST)){
    
        echo("Recebido um POST - ");

        if( $_SERVER['REQUEST_METHOD'] == "POST") { /* se metodo post faz codigo */

            if (isset($_FILES['imagem'])){

                date_default_timezone_set('Europe/Lisbon');

                #cria mensagem que para dar echo, nome tamanho e tipo ficheiro
                $mensagem = $_FILES['imagem']['name']; $mensagem .= " | size =  "; $mensagem .= $_FILES['imagem']['size']; $mensagem .= " | type = "; $mensagem .= $_FILES['imagem']['type'];
                
                echo $mensagem;

                #cria caminho para guardar a imagem webcam, nome constante para atualizar a foto mais recente sempre na mesma 
                $name = "WebCam/Fotos/"; $name .= $_FILES['imagem']['name'];

                if ($_FILES['imagem']['size'] > 1000*KB){ /* se tamanho da imagem superior > 1000KB nao permite passar */
                    http_response_code(400);
                    echo "ERRO: Tamanho máximo 1000KB";
                }elseif($_FILES['imagem']['type'] != "image/jpeg" && $_FILES['imagem']['type'] != "image/png"){  /* se tipo imagem != jpeg e != png nao deixa passar */
                    http_response_code(400);
                    echo "ERRO: Extensões permitidas .png e .jpg";
                }else{ /* depois de verificadas as duas condições anteriores deixa passar */
                    save_file($_FILES['imagem']['tmp_name'],$name);
                    write_date();
                    http_response_code(200);
                }

                

            }else{
                http_response_code(400);
                echo("Erro nos dados nao existe elemento imagem");
            }
        }
    
    }else{

        http_response_code(403);
        echo("Metodo nao permitido");
    } 

    function save_file ($source_file, $new_location){
        if (move_uploaded_file($source_file,$new_location)){  /* se conseguiu meter o ficheiro no sitio correto da print que conseguiu senao da print que nao conseguiu */
            echo (" - Foi realizado o upload do ficheiro com sucesso");
        }else echo(" - Não foi possivel realizar o upload do ficheiro");
    }

    function write_date (){ /* função para esrecver a data */
        
        $string = date("d/m/y H:i:s"); /* como é a hora da foto mais recente não interessa o nome */

        file_put_contents("WebCam/hora.txt",$string);
    }

?>