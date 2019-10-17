<?php
    session_start();
    if(session_destroy()) // Destroi todas as sessões
    {
     header("Location: index.php"); // redireciona para a pagina index.php
    }
?>