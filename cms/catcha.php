<?php 
//INICIO DE SESSÃO
session_start();

//definir imagem a gerar

header("content-type: image/png");

//gerar codigo

$chave=RAND(0,500);

//codificar chave a apresentar

$codigo= substr(sha1($chave),0,6);

$_SESSION['codigo']=$codigo;

// definir a imagem e a cor apresentar

$imagem = imagecreatefrompng("img/capcha.png");
$cores=imagecolorallocate($imagem,255,198,29);

//centrar imagem com codigo
imagestring($imagem,5,5,8,$codigo,$cores);

//gerar imagem e mostrar
imagepng($imagem);

//destruir imagem
imagedestroy($imagem);

?>