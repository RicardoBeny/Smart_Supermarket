from platform import release
from queue import Empty
import requests
import msvcrt
from msvcrt import kbhit, getch
import cv2 as cv
import sys
import time

urlLog = "http://127.0.0.1/Projeto-TI/Dashboard/API/uploadLog.php" #url para api que guarda 10 fotos, se chegar ao limite overwrite
urlRecent = "http://127.0.0.1/Projeto-TI/Dashboard/API/uploadRecentImage.php" #url para api que atualiza foto mais recente
urlGetEntrada = "http://127.0.0.1/Projeto-TI/Dashboard/API/api.php?nome=PortaEntrada"
urlGetSaida = "http://127.0.0.1/Projeto-TI/Dashboard/API/api.php?nome=PortaSaida"
count = 0
nome2 = "webcam" + ".jpg" #nome constante imagem


def get_value_Entrada (count,porta):

    r = requests.get(urlGetEntrada) #faz o get e armazena os dados em r
    status_code = r.status_code 
    valor = r.text #valor dos dados

    if (int(status_code) == 200): #se request_code = 200 continua o funcionamento normal
        if (valor == "ABERTA"): #se a porta estiver aberta e o seu estado for diferente do anterior (passado pela função) 
            #entra no codigo para tirar foto
            if (porta == valor): 
                print("\nFoto já foi tirada - Abra e fecha a Porta Entrada") #como os estado sao iguais pede para abrir e fechar a porta para tirar foto
                time.sleep(4)
            else: #se o estado da porta != estado antigo da porta tira a foto, p.e estado antigo = fechada estado novo = aberta -> tira foto
                take_photo(count)
                count += 1
                time.sleep(4)
        else:
            print("\nPorta Fechada Entrada - Abrir Porta Entrada") #porta encontra-se fechada pede para abrir para tirar foto
            time.sleep(4)
    else:
        print(f"\nERRO: Nao foi possivel realizar o pedido {r.status_code}\n") #caso request_code != 200 dá erro
        time.sleep(4)
    
    return valor,count

def get_value_Saida (count,porta):

    r = requests.get(urlGetSaida) #faz o get e armazena os dados em r
    status_code = r.status_code 
    valor = r.text #valor dos dados

    if (int(status_code) == 200): #se request_code = 200 continua o funcionamento normal
        if (valor == "ABERTA"): #se a porta estiver aberta e o seu estado for diferente do anterior (passado pela função) 
            #entra no codigo para tirar foto
            if (porta == valor): 
                print("\nFoto já foi tirada - Abra e fecha a Porta Saida") #como os estado sao iguais pede para abrir e fechar a porta para tirar foto
                time.sleep(4)
            else: #se o estado da porta != estado antigo da porta tira a foto, p.e estado antigo = fechada estado novo = aberta -> tira foto
                take_photo(count)
                count +=1
                time.sleep(4)
        else:
            print("\nPorta Fechada Saida - Abrir Porta Saida") #porta encontra-se fechada pede para abrir para tirar foto
            time.sleep(4)
    else:
        print(f"\nERRO: Nao foi possivel realizar o pedido {r.status_code}\n") #caso request_code != 200 dá erro
        time.sleep(4)
    
    return valor,count 


def send_file(url,img):

     #post com nome do ficheiro
    r = requests.post(url, files = {'imagem': (img, open(img,'rb'), 'image/jpeg')})

    if (r.status_code == 200): #se status code == 200 diz que foi realizado senao diz que nao conseguiu
        print(f"\nOK: POST realizado com sucesso {r.status_code}\n")
    else:
        print(f"\nERRO: Nao foi possivel realizar o pedido {r.status_code}\n")


def take_photo (count):
    camera = cv.VideoCapture(0,cv.CAP_DSHOW)
    ret, image = camera.read()
    #print ("Foto tirada = " + str(ret))
    #print(count)
    nome1 = "webcam" + str(count) + ".jpg" #para poder fazer hitorico de fotos necessário mudar o nome das fotos para podermos guardar todas
    #incicializar um contador que vai ser adicionado ao nome da foto: p.e foto 1 -> webcam0.jpg foto 2 -> webcam1.jpg
    #foto mais recente, nome constante para alterar a imagem anterior
    cv.imwrite(nome1, image)
    cv.imwrite(nome2, image)
    send_file(urlLog,nome1)
    send_file(urlRecent,nome2)
    camera.release()
    cv.destroyAllWindows()

try:
    
    print ("Usage:\n[0]Manual\n[1]Automático\n[CTRL+C]Terminar") #primeiro menu

    while True:
        if msvcrt.kbhit():
            key = msvcrt.getch()

            if (key == b'0'): #se pressionado vai para o sub-menu MANUAL

                print ("\nUsage:\n[0]Tirar foto\n[1]Mostrar imagem\n[2]Voltar\n[CTRL+C]Terminar") #manual usage
                key2 = msvcrt.getch()

                if (key2 == b'0'):
                    
                    take_photo(count) #função que tira a foto passa count para poder dar nome diferente à fotos para o log
                    count = count + 1
                    if(count == 10): #quando o contado chega a 10, dá reset para dar overwrite às fotos
                        count = 0

                    print ("\nUsage:\n[0]Manual\n[1]Automático\n[CTRL+C]Terminar") #program usage

                elif (key2 == b'1'): #se premido 1 mostra foto mais recente

                    print("A mostrar imagem mais recente")
                    img = cv.imread(nome2)
                    cv.imshow('Imagem', img)
                    cv.waitKey(5000)
                    cv.destroyAllWindows()
                    print ("\nUsage:\n[0]Manual\n[1]Automático\n[CTRL+C]Terminar") #program usage

                elif (key2 == b'2'): #se premido 2 volta para o menu principal
                    print ("\nUsage:\n[0]Manual\n[1]Automático\n[CTRL+C]Terminar") #program usage
                    continue
                
                else: #opções invalidas causam o programa voltar para o menu
                    print("\nOpção inávlida") 
                    print("\nUsage:\n[0]Manual\n[1]Automático\n[CTRL+C]Terminar") #program usage


            elif (key == b'1'): #entra no modo automatico, para parar tem de se parar o programa, CTRL+C

                print ("\nModo: Automático\n")
                print ("\nUsage:\n[0]Porta Entrada\n[1]Porta Saida\n[2]Voltar") #pergunta à pessoa se tem a certeza que quer continuar
                key3 = msvcrt.getch()

                if key3 == b'0':

                    print("\nUsage:\n[0]Terminar modo Automático\n[ANY]Continuar")

                    key4 = msvcrt.getch()

                    if(key4 == b'0'):
                        break;

                    count = 0; #count para o nome das fotos, se chega a 10 passa para 0, máximo de 10 fotos
                    porta = Empty
                    while True:
                        
                        porta,count = get_value_Entrada(count,porta) #ao entrar no ciclo chama função para o get e enviar o ultimo estado da porta

                        if (count == 10): #se chega a 10 passa para 0, máximo de 10 fotos
                            count = 0

                        print("\nParar programa [CTRL+C]")

                elif key3 == b'1':

                    print("\nUsage:\n[0]Terminar modo Automático\n[ANY]Continuar")

                    key4 = msvcrt.getch()

                    if(key4 == b'0'):
                        break;

                    count = 0; #count para o nome das fotos, se chega a 10 passa para 0, máximo de 10 fotos
                    porta = Empty
                    while True:
                        
                        porta,count = get_value_Saida(count,porta) #ao entrar no ciclo chama função para o get e enviar o ultimo estado da porta

                        if (count == 10): #se chega a 10 passa para 0, máximo de 10 fotos
                            count = 0

                        print("\nParar programa [CTRL+C]")

                elif (key3 == b'2'): #se premido 2 volta para o menu principal
                    print ("\nUsage:\n[0]Manual\n[1]Automático\n[CTRL+C]Terminar") #program usage
                    continue

                else: #opções invalidas causam o programa voltar para o menu
                    print("\nOpção inávlida") 
                    print("\nUsage:\n[0]Manual\n[1]Automático\n[CTRL+C]Terminar") #program usage
                
            else:
                print("\nOpcao Invalida")
                print("\nUsage:\n[0]Manual\n[1]Automático\n[CTRL+C]Terminar")

except KeyboardInterrupt:
        
    print( "\nPrograma terminado pelo utilizador\n")

except : # caso haja um erro qualquer

    print( "Ocorreu um erro:", sys.exc_info() )

finally : # executa sempre, independentemente se ocorreu exception

    print( "\nFim do programa\n") 

