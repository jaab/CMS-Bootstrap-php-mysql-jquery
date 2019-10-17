<?php
// DEFENIR PATH DP SERVIDOR
$_URL_SITE = "http://localhost/javacurso/if/clinica/";
$_URL_CMS = "http://localhost/javacurso/if/clinica/cms";
$_PATH_SERVIDOR ="xampp/htdocs/javacurso/if/clinica/";
$_PATH_UPLOADS_MED ="uploads/medicos/";
$_PATH_UPLOADS_PACIENTES ="uploads/pacientes/";
$_PATH_UPLOADS_FUNCIONARIOS ="uploads/funcionarios/";
// DEFENIR CONSTANTES DE ACESSO AO SERVIDOR
define('SERVIDOR','localhost');
define('USERNAME','root');
define('PASSWORD','');
define('DATABASE','clinica');
// LIGAÇÃO À BASE DE DADOS
$_CONNECTION = mysqli_connect(SERVIDOR,USERNAME,""); 
// SELECÇAÕ DOS DADOS
$db = mysqli_select_db($_CONNECTION,DATABASE); 
// VERIFICAR LIGAÇÃO
if(!$_CONNECTION)
{
die("ERROR! não foi possivel estabelecer ligação à base dados".mysqli_connect_error());
}
?>