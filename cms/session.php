<?php

//INICIO DE SESSÃO
session_start();

//GUARDA A SESSÃO
$_USERNAME=$_SESSION['login_user'];

//INCLUSÃO DA LIGAÇÃO À BASE DADOS
include('bd/acesso_bd.php'); 

// SQL Query PARA LISTAR DADOS DO UTILIZADOR
$query=mysqli_query($_CONNECTION,"select username from login where username='$_USERNAME'");
$row = mysqli_fetch_assoc($query);
$login_session =$row['username'];

if(!isset($login_session))
{
  //FECHA A LIGAÇÃO À BASE DADOS
  mysqli_close($_CONNECTION); 
  
  //REDIRECIONA PARA O INDEX.PHP
  header('Location: index.php'); 
}
?>