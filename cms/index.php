<?php
// INCLUSÃO DO LOGIN
include('login.php'); 
?>
<!DOCTYPE html>

<html lang="pt">

<head>
  <!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
     x                                                                         x
     x  Copyright (c), 2019- jaab@DNM - Design New Markets                     x
     x   Telemóvel: 919 768 329                                                x
     x   E-mail: jaab@designewmarkets.com                                      x
     x   Licensed under the IPV License                                        x
     x                                                                         x
     xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
  <title>DNM CMS CLINIC</title>

  <!-- META TAGS -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/x-icon" href="img/logo.png">	
  <meta name="author" content="@jaab">

<!-- BOOTSTRAP CSS -->
<link rel="stylesheet" href="css/bootstrap-social.css">
<link rel="stylesheet" href="css/font-awesome.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!--BOOTSTRAP JS-->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <style>
  #corpo {
  background-color: #212529;
  background-image: url("img/bg_paginas.png");
  background-repeat: repeat;
  background-position: center;
}

#footer {
  background-color: #212529;
  background-image: url("img/capcha.png");
  background-repeat: repeat;
  background-position: center;
}
  </style>
</head>

<body id="footer">
  
  <!-- REGISTAR USER -->
  <section class="page-section" id="corpo">
  <div class="container-fluid border border-secondary">
     <?php
     if(isset($_GET['p'])) 
     {
      $_PAG=$_GET['p'];
     
      switch ($_PAG) 
      {
      case md5('1'):
     ?>
     <div class="col form-group rounded mx-auto d-block" style="margin-top:5px;width:640px;">
     <div class="row">
      <div class="col-sm-12">
      <h1 class="text-light text-center text-monospace">ADERIR-MY-DNM</h1>
      <h5 class="text-light text-center text-monospace">Dados Pessoais</h5>
      </div>
      </div>
     <div class="row">
      <div class="col-sm-5 text-white m-auto">
       Para garantir a segurança e confidencialidade dos seus dados, o primeiro nível de acesso ao
       My DNM permite-lhe apenas marcar consultas , consultar a agenda das marcações do dia, futuras ,histórico
       e aceder à área de Dados Pessoais
       
      </div>
      <div class="col-sm-7 form-group rounded mx-auto d-block">
      <form action="" id="form-registo" method="post" enctype="multipart/form-data">
        <label class="form-check-label text-white text-monospace" for="validationDefaultUsername"></label>
        <input class="form-control" id="validationDefaultUsername" name="username" placeholder="Escolher Username*" type="text" aria-describedby="inputGroupPrepend2" required>
        <label class="form-check-label text-white text-monospace" for="validationDefaultPassword"></label>
        <input class="form-control"  id="validationDefaultPassword" name="password" placeholder="Escolher Password*" type="password" aria-describedby="inputGroupPrepend2" required>
        <label class="form-check-label text-white text-monospace" for="validationDefaultEmail"></label>
        <input class="form-control"  id="validationDefaultEmail" name="email_user" placeholder="Email*" type="email" aria-describedby="inputGroupPrepend2" required>
        <label class="form-check-label text-white text-monospace" for="validationDefaultNif"></label>
        <input class="form-control"  id="validationDefaultNif" name="nif" placeholder="Numero de identificação fiscal*" type="text" aria-describedby="inputGroupPrepend2" required><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="custom-control-input" id="customControlValidation1" name="termos"  required>
        <label class="custom-control-label" for="customControlValidation1"><a href="#" class="text-light">Li e aceito os termos e condições</a></label><br><br>
        <input class="btn btn-primary btn-sm" name="submit2" type="submit" value=" Aderir ">
        <input class="btn btn-primary btn-sm" name="reset" onclick="document.getElementById('form-reset').innerHTML=''" type="button" value=" Reset ">
      </form>
      <br><span class="text-danger"><?php echo $error;?></span>
      </div>
      </div>
      <!-- RECUPERAR PASSWORD - Escolher Password -->
     <?php
     break;
     case md5('2'):
     $_username=$_GET['u'];
     ?>
      <div class="col form-group rounded mx-auto d-block" style="margin-top:60px;width:640px;">
     <div class="form-row ">
      <div class="col">
      <h1 class="text-light text-center">RECUPERAR-PASSWORD</h1>
      <h5 class="text-light text-center">Escolher nova password</h5>
      </div>
      </div>
      <div class="col form-group rounded mx-auto d-block">
      <form action="" id="form-registo" method="post" enctype="multipart/form-data">
      <input type="hidden" name="username" value="<?php echo $_username;?>">
      <label class="form-check-label text-white text-monospace" for="validationDefaultPassword"></label>
        <input class="form-control"  id="validationDefaultPassword" name="password" placeholder="Escolher nova Password*" type="password" aria-describedby="inputGroupPrepend2" required><br>
        <input class="btn btn-primary btn-sm" name="submit4" type="submit" value=" Recuperar ">
        <input class="btn btn-primary btn-sm" name="reset" onclick="document.getElementById('form-reset').innerHTML=''" type="button" value=" Reset ">
      </form>
      <br><span class="text-danger"><?php echo $error;?></span>
      </div>
      </div>
      <!-- RECUPERAR PASSWORD - Confirmar Link-->
      <?php
      break;
      case md5('3'):
      ?>
       <div class="col form-group rounded mx-auto d-block" style="margin-top:60px;width:640px;">
     <div class="form-row ">
      <div class="col">
      <h1 class="text-light text-center text-monospace">RECUPERAR-PASSWORD</h1>
      <h5 class="text-light text-center text-monospace">Insira o seu mail de registo</h5>
      </div>
      </div>
      <div class="col form-group rounded mx-auto d-block">
      <form action="" id="form-registo" method="post" enctype="multipart/form-data">
        <label class="form-check-label text-white text-monospace" for="validationDefaultEmail"></label>
        <input class="form-control"  id="validationDefaultEmail" name="email_user" placeholder="Email*" type="email" aria-describedby="inputGroupPrepend2" required><br>
        <input class="btn btn-primary btn-sm" name="submit3" type="submit" value="Recuperar">
        <input class="btn btn-primary btn-sm" name="reset" onclick="document.getElementById('form-reset').innerHTML=''" type="button" value=" Reset ">
      </form>
      <br><span class="text-danger"><?php echo $error;?></span>
      </div>
      </div>
     <?php
      break;
      case md5('4'):
      ?>
       <div class="form-group rounded mx-auto d-block" style="width:330px;">
       <h1 class="text-light text-center text-monospace">CONTACTAR-ADMIN</h1>
       <h5 class="text-light text-center text-monospace">report bugs,peça ajuda,...</h5>
        <form action="" id="form-contacto" method="post" enctype="multipart/form-data">
        <div class="row">
        <div class="col-12">
        <label class="form-check-label text-white text-monospace" for="validationDefaulnome"></label>
        <input class="form-control" id="validationDefaultnome" name="nome" placeholder="nome" type="text" aria-describedby="inputGroupPrepend2" required>
       </div>
       </div>
       <div class="row">
        <div class="col-12">
        <label class="form-check-label text-white text-monospace" for="validationDefaulemail"></label>
        <input class="form-control" id="validationDefaultemail" name="email" placeholder="email" type="email" aria-describedby="inputGroupPrepend2" required>
       </div>
       </div>
       <div class="row">
        <div class="col-12">
        <label class="form-check-label text-white text-monospace" for="validationDefaulobservacoes"></label>
        <textarea class="form-control" aria-describedby="inputGroupPrepend2"  id="validationDefaultobservacoes" name="observacoes" placeholder="observações" rows="2" required></textarea>
       </div>
       </div>
        <div class="row py-2">
            <div class="col-12">
            <input class="btn btn-primary btn-sm" name="contacto" type="submit" value="Contacto">
            </div>
        </div> 
        </form>
        <br><span class="text-danger"><?php echo $error;?></span>
        </div>
     <?php
      break;
      default:
      } 
     }
     else
     {
     ?>
      <!-- LOGIN USER -->
      
     <div class="form-group rounded mx-auto d-block" style="width:330px;margin-top:150px;">
      <form action="" id="form-login" method="post" enctype="multipart/form-data">
       <div class="row">
        <div class="col-12">
        <label class="form-check-label text-white text-monospace" for="validationDefaultUsername"></label>
        <input class="form-control" id="validationDefaultUsername" name="username" placeholder="username" type="text" aria-describedby="inputGroupPrepend2" required>
     </div>
     </div>
     <div class="row">
     <div class="col-12">
      <label class="form-check-label text-white text-monospace" for="validationDefaultPassword"></label>
      <input class="form-control"  id="validationDefaultPassword" name="password"placeholder="**********" type="password" aria-describedby="inputGroupPrepend2" required>
     </div>
     </div>
     <div class="row py-3">
     <div class="col-3 m-auto">
        <img src="catcha.php" class="border border-info rounded">
     </div>
     <div class="col-9 m-auto">
     <input class="form-control" placeholder="captcha"  type="text" name="codigo">
     </div>
     </div>
     <div class="row">
        <div class="col-12">
        <input class="btn btn-primary btn-sm" name="submit" type="submit" value=" Login ">
        </div>
     </div> 
      <div class="row py-3">
      <div class="col-12"><span class="text-danger"><?php echo $error;?></span></div>
     </div>
    <div class="row">
    <div class="col-12 text-center m-auto"><a class="text-light" href="?p=<?php echo md5('1');?>">Aderir ao MY DNM</a></div>
    </div>
    <div class="row">
    <div class="col-12 text-center m-auto"><small class="text-light"><a class="text-light" href="?p=<?php echo md5('3');?>">Recuperar password</a></small></div>
     </div>
     <div class="row">
    <div class="col-12 text-center m-auto"><small class="text-light"><a class="text-light" href="?p=<?php echo md5('4');?>">Contactar admin</a></small></div>
     </div>
     <?php 
     }
     ?>
  </form>
  </div>
  </section>
   <!-- FOOTER -->
   <footer class="footer" id="footer">
    <div class="container m-auto">
      <div class="row">
        <div class="col-8">
        <a class="text-light" href="./" target="_blank"><img class="rounded" width="20px" height="20px" src="img/logo.png"></a><small class="text-light">&nbsp;Copyright &copy; <a class="text-light" href="mailto:jaab@designewmarkets.com">jaab@designewmarkets.com</a> 2019</small>
         </div>
         <div class="col-4 text-right">
         <a href="https://facebook.com" class="btn btn-social-icon btn-facebook rounded-circle"><span class="fa fa-facebook"></span></a>
         <a href="https://linkedin.com" class="btn btn-social-icon btn-linkedin rounded-circle"><span class="fa fa-linkedin"></span></a>
         <a href="https://twitter.com" class="btn btn-social-icon btn-twitter rounded-circle"><span class="fa fa-twitter"></span></a>
        </div>
      </div>
    </div>
  </footer>
  </body>
</html>

