<?php
 // INCLUSÃO DA SESSÃO
  include('session.php');

  if (isset($login_session)) 
  {
    //VARIAVEIS PARA AS PAGINAS DO BODY
    $_PAG2 = $_GET['p'];
     $_p1=md5('1');
     $_p2=md5('2');
     $_p3=md5('3');
     $_p4=md5('4');
     $_p5=md5('5');
     $_p6=md5('6');
     $_p7=md5('7');
     $_p8=md5('8');
     $_p9=md5('9');
     $_p10=md5('10');
     $_p11=md5('11');
     $_p12=md5('12');
     $_p13=md5('13');
     $_p14=md5('14');
     $_p15=md5('15');
     
     //VAI BUSCAR O NIF E O NIVEL DOS UTILIZADORES 
     $query = "SELECT * FROM login where username='$login_session'";
     $result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
     $row = mysqli_fetch_array($result);
     $_nivel=$row['acesso'];
     $_nif=$row['nif'];

    //SABER DATA E HORA DO ULTIMO LOGIN
    date_default_timezone_set("Portugal");
    $_DATALOGIN=date("Y-m-d h:i:sa");
    $query2 = "UPDATE login SET data='$_DATALOGIN' WHERE username='$login_session'";
    if(mysqli_query($_CONNECTION,$query2)){
    }else{
      $error = "Error: " . $query2 . "<br>" . $_CONNECTION->error;
    }
  }

?>
<!DOCTYPE html>

<html lang="pt">

<head>
<title>GESTOR CONTEÚDOS CLINICA</title>
<!-- META TAGS -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- BOOTSTRAP CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!--BOOTSTRAP JS-->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<style>
  #corpo2 {
  background-color: #212529;
  background-image: url("img/bg_paginas.png");
  background-repeat: repeat;
  background-position: center;
}
#headerr {
  background-color: #212529;
  background-image: url("img/capcha.png");
  background-repeat: repeat;
  background-position: center;
}
</style>
</head>

<body id="headerr">
    <!--MENU DE NAVEGAÇÃO-->
    <nav class="navbar navbar-expand-lg navbar-light  bg-primary" id="headerr">
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="profile.php?p=<?php echo $_p1;?>"><img class="rounded" src="img/logo.png"></a>
    </li>
      <?php
   
    if (isset($login_session)) 
    {
     switch ($_nivel) 
     {
      case 1://MENU ADMIN
         switch ($_PAG2) 
         {
          case md5('1'):
          echo"<li class=\"nav-item active\"><a class=\"nav-link\" href=\"?p=$_p1\">Utilizadores<span class=\"sr-only\">(current)</span></a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p2\">Especialidades</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p3\">Medicos</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p4\">Pacientes</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p5\">Consultas</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p6\">Funcionarios</a></li>";
          break;
          case md5('2'):
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p1\">Utilizadores</a></li>";
          echo"<li class=\"nav-item active\"><a class=\"nav-link\" href=\"?p=$_p2\">Especialidades<span class=\"sr-only\">(current)</span></a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p3\">Medicos</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p4\">Pacientes</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p5\">Consultas</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p6\">Funcionarios</a></li>";
          break;
          case md5('3'):
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p1\">Utilizadores</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p2\">Especialidades</a></li>";
          echo"<li class=\"nav-item active\"><a class=\"nav-link\" href=\"?p=$_p3\">Medicos<span class=\"sr-only\">(current)</span></a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p4\">Pacientes</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p5\">Consultas</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p6\">Funcionarios</a></li>";
          break;
          case md5('4'):
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p1\">Utilizadores</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p2\">Especialidades</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p3\">Medicos</a></li>";
          echo"<li class=\"nav-item active\"><a class=\"nav-link\" href=\"?p=$_p4\">Pacientes<span class=\"sr-only\">(current)</span></a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p5\">Consultas</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p6\">Funcionarios</a></li>";
          break;
          case md5('5'):
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p1\">Utilizadores</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p2\">Especialidades</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p3\">Medicos</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p4\">Pacientes</a></li>";
          echo"<li class=\"nav-item active\"><a class=\"nav-link\" href=\"?p=$_p5\">Consultas<span class=\"sr-only\">(current)</span></a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p6\">Funcionarios</a></li>";
          break;
          case md5('6'):
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p1\">Utilizadores</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p2\">Especialidades</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p3\">Medicos</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p4\">Pacientes</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p5\">Consultas</a></li>";
          echo"<li class=\"nav-item active\"><a class=\"nav-link\" href=\"?p=$_p6\">Funcionarios<span class=\"sr-only\">(current)</span></a></li>";
          break;
          default:
         }
      break;
      case 2://MENU PACIENTES
          switch ($_PAG2) 
          {
          case md5('7'):
          echo"<li class=\"nav-item active\"><a class=\"nav-link\" href=\"?p=$_p7\">Perfil</a><span class=\"sr-only\">(current)</span></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p11\">Medicos</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p12\">Historico </a></li>";
          break;
          case md5('11'):
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p7\">Perfil</a></li>";
          echo"<li class=\"nav-item active\"><a class=\"nav-link\" href=\"?p=$_p11\">Medicos</a><span class=\"sr-only\">(current)</span></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p12\">Historico </a></li>";
          break;
          case md5('12'):
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p7\">Perfil</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p11\">Medicos</a></li>";
          echo"<li class=\"nav-item active\"><a class=\"nav-link\" href=\"?p=$_p12\">Historico</a><span class=\"sr-only\">(current)</span></li>";
          break;
          default:
          echo"<li class=\"nav-item active\"><a class=\"nav-link\" href=\"?p=$_p7\">Perfil</a><span class=\"sr-only\">(current)</span></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p11\">Medicos</a></li>";
          echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p12\">Historico</a></li>";
         }
      break;
      case 3://MENU MEDICOS
            switch ($_PAG2) 
            {
            case md5('13'):
            echo"<li class=\"nav-item active\"><a class=\"nav-link\" href=\"?p=$_p13\">Inicio</a><span class=\"sr-only\">(current)</span></li>";
            echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p14\">Pacientes</a></li>";
            echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p15\">Histórico</a></li>";
            break;
            case md5('14'):
            echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p13\">Inicio</a></li>";
            echo"<li class=\"nav-item active\"><a class=\"nav-link\" href=\"?p=$_p14\">Pacientes</a><span class=\"sr-only\">(current)</span></li>";
            echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p15\">Histórico</a></li>";
            break;
            case md5('15'):
            echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p13\">Inicio</a></li>";
            echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p14\">Pacientes</a></li>";
            echo"<li class=\"nav-item active\"><a class=\"nav-link\" href=\"?p=$_p15\">Histórico</a><span class=\"sr-only\">(current)</span></li>";
            break;
            default:
            echo"<li class=\"nav-item active\"><a class=\"nav-link\" href=\"?p=$_p13\">Inicio</a><span class=\"sr-only\">(current)</span></li>";
            echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p14\">Pacientes</a></li>";
            echo"<li class=\"nav-item\"><a class=\"nav-link text-light\" href=\"?p=$_p15\">Histórico</a></li>";
            }
      break;
      case 4://MENU FUNCIONARIOS
      echo"<li class=\"nav-item\"><a class=\"nav-link\" href=\"?p=$_p16\">Inicio</a></li>";
      echo"<li class=\"nav-item\"><a class=\"nav-link\" href=\"?p=$_p17\">Perfil</a></li>";
      break;
      default:
     }
    }
    ?>
    </ul>
   
    <div class="container-fluid text-right"><span>
     <?php
     switch ($_nivel)  
     {
      case 1: //FOTOS UTILIZADORES 
      echo"<img width=\"25px\" height=\"25px\" class=\"rounded-circle mx-auto\" src=\"uploads/user/admin.jpg\">";
      break;
      case 3:
      $query = "SELECT foto,nome_medico FROM medicos where nif='$_nif'";
      $result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
      $row = mysqli_fetch_array($result);
      $_foto=$row['foto'];
      $nome_medico=$row['nome_medico'];
      $nome= explode(" ",$nome_medico); //$nome[0]
      $dir = "$_PATH_UPLOADS_MED$login_session";
      if(!empty($_foto))
      {
        $fotos=$dir.'/'.$row['foto'] ;
      }else{
        $fotos="img/user.png"; 
      }
      echo"<img width=\"25px\" height=\"25px\" class=\"rounded-circle mx-auto\" src=\"$fotos\">";
      break;
      case 2:
      $query = "SELECT foto,nome_paciente FROM pacientes where nif='$_nif'";
      $result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
      $row = mysqli_fetch_array($result);
      $_foto=$row['foto'];
      $dir = "$_PATH_UPLOADS_PACIENTES$login_session";
      if(!empty($_foto))
      {
        $fotos=$dir.'/'.$row['foto'] ;
      }else{
        $fotos="img/user.png"; 
      }
      $nome_paciente=$row['nome_paciente'];
      $nome= explode(" ",$nome_paciente); 
 
      
      echo"<img width=\"25px\" height=\"25px\" class=\"rounded-circle mx-auto\" src=\"$fotos\">";
      break;
      case 4:
      $query = "SELECT foto,nome_funcionario FROM funcionarios where nif='$_nif'";
      $result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
      $row = mysqli_fetch_array($result);
      $_foto=$row['foto'];
      $nome_funcionario=$row['nome_funcionario'];
      $nome= explode(" ",$nome_funcionario); 
      $dir = "$_PATH_UPLOADS_FUNCIONARIOS.$login_session";
      echo"<img width=\"25px\" height=\"25px\" class=\"rounded-circle mx-auto\" src=\"$dir/$_foto\">";
      break;
      default:
      }
     ?>
     <span>&nbsp;&nbsp;</span><span class="text-light"><?php echo $login_session; ?></span><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><a class="btn-sm btn-primary" href="logout.php">Logout</a></div>
   </div>
   </nav>

   <!--AQUI ENTRAM AS VÁRIAS PÁGINAS-->
   <section class="page-section" id="corpo2">
    <div class="container-fluid py-4">
    <?php
    if(isset($login_session))
    {
    $_PAG3 = $_GET['p'];
     switch ($_nivel) 
     {
      case 1: //PAGINAS MODULO ADMIN
        switch ($_PAG3) 
        {
          case md5('1'):
          include('utilizadores.php');
          break;
          case md5('2'):
          include('especialidades.php');
          break;
          case md5('3'):
          include('medicos.php');
          break;
          case md5('4'):
          include('pacientes.php');
          break;
          case md5('5'):
          include('consultas.php');
          break;
          case md5('6'):
          //include('funcionarios.php'); 
          echo"<h6 class=\"text-light text-center\">Em desemvolvimento...</h6>";
          break;
          default:
          include('utilizadores.php');
        }
      break;
      case 2: // PAGINAS MODULO PACIENTES
          switch ($_PAG3) 
          {
          case md5('7'):
          include('paciente.php');
          break;
          case md5('11'):
         // include('medicos_p.php');
         echo"<h6 class=\"text-light text-center\">Em desenvolvimento (pesquisa de medicos)...</h6>";
          break;
          case md5('12'):
          include('paciente_hist.php');
          break;
          default:
          include('paciente.php');
          }
      break;
      case 3:// PAGINAS MODULO MEDICOS
            switch ($_PAG3) 
            {
            case md5('13'):
            include('medico.php');
            break;
            case md5('14'):
            //include('pacientes_m.php');
            echo"<h6 class=\"text-light text-center\">Em desenvolvimento (pesquisa de pacientes)...</h6>";
            break;
            case md5('15'):
            include('medico_hist.php');
            break;
            default:
            include('medico.php');
            }
      break;
      case 4:// PAGINAS MODULO FUNCIONARIOS
      //include('funcionario.php');
      break;
      default:
     }
    }
    ?>
   </div>
   </section>

   <!-- FOOTER -->
   <footer class="footer">
     <div class="container-fluid">
     <?php
     if (isset($login_session)) 
     {
      switch ($_nivel) 
      {
      
           case 1:
           echo"<h1 class=\"text-light text-center text-monospace\">MY_DNM_CLINIC</h1>";
           break;
           case 2:
           echo"<h1 class=\"text-light text-center text-monospace\">MY_DNM_PACIENTE</h1>";
           break;
           case 3:
           echo"<h1 class=\"text-light text-center text-monospace\">MY_DNM_MEDICO</h1>";
           break;
           default:
          }
        }
     ?>
     </div>
   </footer>

</body>

</html>


