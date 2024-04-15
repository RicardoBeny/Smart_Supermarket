import requests
from time import strftime, gmtime
from msvcrt import kbhit, getch
import sys

def datahora():
    hora = strftime("%d/%m/%Y %H:%M:%S")
    return hora

url = 'http://127.0.0.1/Projeto-TI/Dashboard/API/api.php'

def send_to_api(valores):
    print(valores)
    x = requests.post(url, data = valores)
    if (x.status_code == 200):
        print ("OK: POST realizado com sucesso")
        print (x.status_code)
    else:
        print ("ERRO: Não foi possível realizar o pedido")
        print (x.status_code)

try:

    porta = "porta"
    print ("Usage:\n[0]Fechar a porta entrada\n[1]Abrir a porta entrada\n[2]Fechar a porta saida\n[3]Abrir a porta saida\n[CTRL+C]Terminar")
    while True:
        
        if kbhit() :
            tecla = getch()
            print("\nValor lido do teclado: ", tecla)

            if (tecla == b'1'):
                valores = {'nome': 'PortaEntrada', 'valor': 'null', 'hora': datahora(), 'status': 'ABERTA'}
                send_to_api(valores)
                print("\nPorta foi Aberta")
                print ("Usage:\n[0]Fechar a porta entrada\n[1]Abrir a porta entrada\n[2]Fechar a porta saida\n[3]Abrir a porta saida\n[CTRL+C]Terminar")
            elif (tecla == b'0'):
                valores = {'nome': 'PortaEntrada', 'valor': 'null', 'hora': datahora(), 'status': 'FECHADA'}
                send_to_api(valores)
                print("\nPorta foi Fechada")
                print ("Usage:\n[0]Fechar a porta entrada\n[1]Abrir a porta entrada\n[2]Fechar a porta saida\n[3]Abrir a porta saida\n[CTRL+C]Terminar")
            elif (tecla == b'2'):
                valores = {'nome': 'PortaSaida', 'valor': 'null', 'hora': datahora(), 'status': 'FECHADA'}
                send_to_api(valores)
                print("\nPorta foi Fechada")
                print ("Usage:\n[0]Fechar a porta entrada\n[1]Abrir a porta entrada\n[2]Fechar a porta saida\n[3]Abrir a porta saida\n[CTRL+C]Terminar")
            elif (tecla == b'3'):
                valores = {'nome': 'PortaSaida', 'valor': 'null', 'hora': datahora(), 'status': 'ABERTA'}
                send_to_api(valores)
                print("\nPorta foi Aberta")
                print ("Usage:\n[0]Fechar a porta entrada\n[1]Abrir a porta entrada\n[2]Fechar a porta saida\n[3]Abrir a porta saida\n[CTRL+C]Terminar")
            else:
                print("Opcao invalida")
                print ("Usage:\n[0]Fechar a porta entrada\n[1]Abrir a porta entrada\n[2]Fechar a porta saida\n[3]Abrir a porta saida\n[CTRL+C]Terminar")


except KeyboardInterrupt: # caso haja interrupção de teclado CTRL+C

    print( "Programa terminado pelo utilizador")

finally : # executa sempre, independentemente se ocorreu exception

    print( "\n")


