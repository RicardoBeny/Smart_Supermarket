
<<?php
        session_start();
        session_unset();
        session_destroy();
        header('Location:http://127.0.0.1/Projeto-TI/PaginaInicial.html'); /* redireciona para a main page */
?>