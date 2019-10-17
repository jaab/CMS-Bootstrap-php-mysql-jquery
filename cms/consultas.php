<?php 
//VARIAVEL PARA GUARDAR MSG ERRO
$error=''; 

//VARIAVEIS PARA GUARDAR AS PÁGINAS
$_p1=md5('1');


// ATIVAR, DESATIVAR CONSULTA
if (isset($_POST['desativar_c'])) 
{
  $pag=$_POST['p'];
  $id_consulta=$_POST['id_consulta'];
  $_ESTADO=$_POST['desativar_c'];
  $query = "UPDATE consultas SET estado='$_ESTADO' WHERE id_consulta=$id_consulta";
  if(mysqli_query($_CONNECTION,$query)){
  }else{
    $error = "Error: " . $query . "<br>" . $_CONNECTION->error;
  }
}

//UPDATE CONSULTA
if (isset($_POST['submit'])) 
{
    $id_consulta=$_POST['id_consulta'];
    $id_medico=$_POST['id_medico'];
    $id_paciente=$_POST['id_paciente'];
    $id_esp=$_POST['id_esp'];
    $data_consulta=$_POST['data_consulta'];
    $hora_consulta=$_POST['hora_consulta'];
    $nif=$_POST['nif'];

    $query_0 = "SELECT username,email_user FROM login  where nif='$nif'";
    $result2 = mysqli_query($_CONNECTION,$query_0) or die('Query falhou: ' . mysqli_error());
    $row2 = mysqli_fetch_array($result2);
    $email = $row2['email_user'];
    $username = $row2['username'];
    $msg = "Caro $username,\n\n\t<br> a sua consulta foi alterada como solicitado ,consulte o seu DNM \n\n\t<br> Bem haja";


    $query_c = "UPDATE consultas SET id_medico='$id_medico' , id_esp='$id_esp' , data_consulta='$data_consulta' ,hora_consulta='$hora_consulta', estado='N'  WHERE id_consulta='$id_consulta'";
     
    if(mysqli_query($_CONNECTION,$query_c)){
      echo" <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>
      <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js\"></script>
     <div class=\"container\"><div class=\"alert alert-success alert-dismissible\">
      <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
     <strong>Consulta atualizada com sucesso!</strong>
     </div></div>";
    
     // Envio de email ao paciente
     $headers =  'MIME-Version: 1.0' . "\r\n"; 
     $headers .= 'From: Clinica Admin <player@viseu.tv>' . "\r\n";
     $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
     mail("$email","Alteração de consulta - $username",$msg,$headers);
     }else{
       $error = "Error: " . $query_c . "<br>" . $_CONNECTION->error;
       echo"$error";
     }
}

//DESMARCAR CONSULTA
if (isset($_POST['apagar']))
{
  $pag=$_POST['p'];
  $id_consulta=$_POST['id_consulta'];
  $nif=$_POST['nif'];

  $query_0 = "SELECT username,email_user FROM login  where nif='$nif'";
  $result2 = mysqli_query($_CONNECTION,$query_0) or die('Query falhou: ' . mysqli_error());
   $row2 = mysqli_fetch_array($result2);
   $email = $row2['email_user'];
   $username = $row2['username'];
   $msg = "Caro $username,\n\n\t<br> a sua consulta foi desmarcada \n\n\t<br> Bem haja";

      $query  = "DELETE FROM consultas WHERE id_consulta = $id_consulta";
      if (mysqli_query($_CONNECTION,$query)) {
        echo" <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>
        <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js\"></script>
       <div class=\"container\"><div class=\"alert alert-success alert-dismissible\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
       <strong>Consulta desmarcada com sucesso! Foi enviado email para o paciente $username a avisar que a consulta foi desmarcada</strong>
       </div></div>";
  
        // Envio de email ao paciente
        $headers =  'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'From: Clinica Admin <player@viseu.tv>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        mail("$email","Desmarcação de consulta - $username",$msg,$headers);
      } else {
      echo "Error: " . $query . "<br>" . $_CONNECTION->error;
      }  
}

?>
<section class="page-section">
  <!-- LISTAR CONSULTAS DO DIA -->
  <?php
if (isset($_GET['p'])) 
{
?>

  <div class="container form-group rounded mx-auto d-block border border-light">
    <h5 class="text-primary  text-center">Consultas do dia</h5>
    <div class="form-row">
      <div class="col-12">
        <?php 
      $today = date("n-j-Y"); 
       $query = "SELECT * FROM  consultas  where  data_consulta='$today'  order by data_consulta desc";
       $result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
       echo "<div class=\"container text-light\"><div class=\"row mx-auto\"><div class=\"col text-primary\">Id</div><div class=\"col-3 text-primary\">Paciente</div><div class=\"col text-primary\">Especialidade</div><div class=\"col-2 text-primary\">Data</div><div class=\"col text-primary\">Hora</div><div class=\"col  text-primary\"></div><div class=\"col text-primary\"></div><div class=\"col text-primary\"></div><div class=\"col text-primary\"></div></div>";
 
      while ($linha = mysqli_fetch_array($result)) 
      {
      $estado = $linha['estado'];
      $id_consulta = $linha['id_consulta'];
      $id_medico = $linha['id_medico'];
      $id_paciente = $linha['id_paciente'];
      $data_consulta = $linha['data_consulta'];
      $hora_consulta = $linha['hora_consulta'];
      $id_esp=$linha['id_esp'];

      $query_0 = "SELECT descricao FROM especialidades  where id_esp='$id_esp'";
      $result2 = mysqli_query($_CONNECTION,$query_0) or die('Query falhou: ' . mysqli_error());
       $row2 = mysqli_fetch_array($result2);
       $descricao = $row2['descricao'];

       $query_1 = "SELECT nome_paciente,nif FROM pacientes  where id_paciente='$id_paciente'";
       $result_1 = mysqli_query($_CONNECTION,$query_1) or die('Query falhou: ' . mysqli_error());
        $row_1 = mysqli_fetch_array($result_1);
        $nome_paciente = $row_1['nome_paciente'];
        $nif = $row_1['nif'];

        $query_2 = "SELECT * FROM prescricao  where id_consulta='$id_consulta'";
        $result_2 = mysqli_query($_CONNECTION,$query_2) or die('Query falhou: ' . mysqli_error());
        $row_2 = mysqli_fetch_array($result_2);
        $prescricao = $row_2['prescricao'];
        $observacoes = $row_2['observacoes'];

        $query_3 = "SELECT nome_medico FROM medicos  where id_medico='$id_medico'";
         $result_3 = mysqli_query($_CONNECTION,$query_3) or die('Query falhou: ' . mysqli_error());
          $row_3 = mysqli_fetch_array($result_3);
          $nome_medico = $row_3['nome_medico'];

      echo "<div class=\"row py-2 mx-auto\">";
      echo "<div class=\"col\">$id_consulta</div><div class=\"col-3\">$nome_paciente</div><div class=\"col\">$descricao</div><div class=\"col-2\">$data_consulta</div><div class=\"col\">$hora_consulta</div>";
      // LINKS COM VARIAVEIS HIDDEN
       if ($estado=='S') //BOTÃO ON OFF
       {
        $_DESATIVAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"consulta\" value=\"1\"><input type=\"hidden\" name=\"desativar_c\" value=\"N\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-success btn-sm\" onClick=\"submit();\">On</button></form>"; 
       }
       else
       {
        $_DESATIVAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"consulta\" value=\"1\"><input type=\"hidden\" name=\"desativar_c\" value=\"S\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-danger btn-sm\" onClick=\"submit();\">Off</button></form>";  
       }
      $_APAGAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"nif\" value=\"$nif\"><input type=\"hidden\" name=\"apagar\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-danger btn-sm\" onClick=\"submit();\">Des</button></form>";
      $_RESET="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"nif\" value=\"$nif\"><input type=\"hidden\" name=\"reset\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit2();\">Update</button></form>";
      $_VER="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"descricao\" value=\"$descricao\"><input type=\"hidden\" name=\"nome_medico\" value=\"$nome_medico\"><input type=\"hidden\" name=\"ver\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit2();\">Ver</button></form>";

      echo "<div class=\"col\">$_DESATIVAR</div><div class=\"col\">$_APAGAR</div><div class=\"col text\">$_RESET</div><div class=\"col text\">$_VER</div></div>";
     }
     echo "</div>";
     //LIBERTAR MEMÓRIA
     mysqli_free_result($result);   
      ?>
      </div>
    </div>
  </div>

  <!-- LISTAR PRÓXIMAS CONSULTAS -->
  <div class="container form-group rounded mx-auto d-block border border-light">
    <h5 class="text-primary  text-center">Próximas Consultas</h5>
    <div class="form-row">
      <div class="col-12">
        <?php 
      $today = date("n-j-Y"); 

       $query = "SELECT * FROM  consultas  where  data_consulta>'$today' order by data_consulta desc";
       $result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
       echo "<div class=\"container text-light\"><div class=\"row\"><div class=\"col text-primary\">Id</div><div class=\"col-3 text-primary\">Paciente</div><div class=\"col text-primary\">Especialidade</div><div class=\"col-2 text-primary\">Data</div><div class=\"col text-primary\">Hora</div><div class=\"col text-primary\"></div><div class=\"col text-primary\"></div><div class=\"col-2 text-primary\"></div></div>";

      while ($linha = mysqli_fetch_array($result)) 
      {
      $estado = $linha['estado'];
      $id_consulta = $linha['id_consulta'];
      $id_medico = $linha['id_medico'];
      $id_paciente = $linha['id_paciente'];
      $data_consulta = $linha['data_consulta'];
      $hora_consulta = $linha['hora_consulta'];
      $id_esp=$linha['id_esp'];

      $query_0 = "SELECT descricao FROM especialidades  where id_esp='$id_esp'";
      $result2 = mysqli_query($_CONNECTION,$query_0) or die('Query falhou: ' . mysqli_error());
       $row2 = mysqli_fetch_array($result2);
       $descricao = $row2['descricao'];

       $query_1 = "SELECT nome_paciente,nif FROM pacientes  where id_paciente='$id_paciente'";
       $result_1 = mysqli_query($_CONNECTION,$query_1) or die('Query falhou: ' . mysqli_error());
        $row_1 = mysqli_fetch_array($result_1);
        $nome_paciente = $row_1['nome_paciente'];
        $nif = $row_1['nif'];
        
        $query_2 = "SELECT * FROM prescricao  where id_consulta='$id_consulta'";
        $result_2 = mysqli_query($_CONNECTION,$query_2) or die('Query falhou: ' . mysqli_error());
        $row_2 = mysqli_fetch_array($result_2);
        $prescricao = $row_2['prescricao'];
        $observacoes = $row_2['observacoes'];

        
        $query_3 = "SELECT nome_medico FROM medicos  where id_medico='$id_medico'";
         $result_3 = mysqli_query($_CONNECTION,$query_3) or die('Query falhou: ' . mysqli_error());
          $row_3 = mysqli_fetch_array($result_3);
          $nome_medico = $row_3['nome_medico'];

      echo "<div class=\"row py-2\">";
      echo "<div class=\"col\">$id_consulta</div><div class=\"col-3\">$nome_paciente</div><div class=\"col\">$descricao</div><div class=\"col-2\">$data_consulta</div><div class=\"col\">$hora_consulta</div>";
      // LINKS COM VARIAVEIS HIDDEN
      if ($estado=='S') //BOTÃO ON OFF
      {
       $_DESATIVAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"consulta\" value=\"1\"><input type=\"hidden\" name=\"desativar_c\" value=\"N\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-success btn-sm\" onClick=\"submit();\">On</button></form>"; 
      }
      else
      {
        $_DESATIVAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"consulta\" value=\"1\"><input type=\"hidden\" name=\"desativar_c\" value=\"S\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-danger btn-sm\" onClick=\"submit();\">Off</button></form>";   
      }
      $_APAGAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"nif\" value=\"$nif\"><input type=\"hidden\" name=\"apagar\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-danger btn-sm\" onClick=\"submit();\">Des</button></form>";
      $_RESET="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"nif\" value=\"$nif\"><input type=\"hidden\" name=\"reset\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit2();\">Update</button></form>";
      $_VER="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"descricao\" value=\"$descricao\"><input type=\"hidden\" name=\"nome_medico\" value=\"$nome_medico\"><input type=\"hidden\" name=\"ver\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit2();\">Ver</button></form>";
      echo "<div class=\"col\">$_DESATIVAR</div><div class=\"col\">$_APAGAR</div><div class=\"col\">$_RESET</div><div class=\"col\">$_VER</div></div>";
    }
    echo "</div>";
    //LIBERTAR MEMÓRIA
    mysqli_free_result($result);   
    ?>
      </div>
    </div>
  </div>

  <!--VISUALIZAR CONSULTA-->
  <?php 
  if (isset($_POST['ver'])) 
  {

  $id_consulta=$_POST['id_consulta'];
  $descricao=$_POST['descricao'];
  $nome_medico=$_POST['nome_medico'];
  $query = "SELECT * FROM consultas where id_consulta = '$id_consulta'";
  $result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
  $linha = mysqli_fetch_array($result);

  $estado = $linha['estado'];
  $data_consulta = $linha['data_consulta'];
  $hora_consulta = $linha['hora_consulta'];
  $id_paciente = $linha['id_paciente'];
  $internamento = $linha['internamento'];


    $query_1 = "SELECT nome_paciente,foto FROM pacientes  where id_paciente='$id_paciente'";
    $result_1 = mysqli_query($_CONNECTION,$query_1) or die('Query falhou: ' . mysqli_error());
    $row_1 = mysqli_fetch_array($result_1);
    $nome_paciente=$row_1['nome_paciente'];
    $nome= explode(" ",$nome_paciente); 
    $dir = "$_PATH_UPLOADS_MED.$nome[0]";
    if(!empty($row['foto'])){
    $foto=$dir.'/'.$row['foto'];
    }else{
      $foto="img/user.png";
    }

    $query_2 = "SELECT * FROM prescricao  where id_consulta='$id_consulta'";
    $result_2 = mysqli_query($_CONNECTION,$query_2) or die('Query falhou: ' . mysqli_error());
    $row_2 = mysqli_fetch_array($result_2);
    $prescricao = $row_2['prescricao'];
    $observacoes = $row_2['observacoes'];
   
  ?>

  <div class="container form-group rounded mx-auto d-block border border-light">
    <h5 class="text-primary text-center">Visualizar Consulta</h5>
    <div class="container">
      <div class="row">
        <div class="col-2 text-white">
          <h6>Paciente:</h6>
        </div>
        <div class="col-5 text-warning float-right"><?php echo $nome_paciente;?></div>
        <div class="col text-white">
          <h6>Foto:</h6>
        </div>
        <div class="col-4  text-warning float-right">
          <img class="rounded-circle" width="120px" height="120px" src="<?php echo $foto;?>">
        </div>
      </div>
      <div class="row">
        <div class="col-2 text-white">
          <h6>Id Consulta:</h6>
        </div>
        <div class="col-5  text-warning float-right"><?php echo $id_consulta;?></div>
        <div class="col-5  text-info float-right">&nbsp;</div>
      </div>
      <div class="row">
        <div class="col-2 text-white">
          <h6>Especialidade:</h6>
        </div>
        <div class="col-5  text-warning float-right"><?php echo $descricao;?></div>
        <div class="col-5  text-info float-right">&nbsp;</div>
      </div>
      <div class="row">
        <div class="col-2 text-white">
          <h6>Medico:</h6>
        </div>
        <div class="col-5  text-warning float-right "><?php echo $nome_medico;?></div>
        <div class="col-5  text-info float-right">&nbsp;</div>
      </div>
      <div class="row">
        <div class="col-2 text-white">
          <h6>Data:</h6>
        </div>
        <div class="col-5  text-warning float-right"><?php echo $data_consulta;?></div>
        <div class="col-5  text-info float-right">&nbsp;</div>
      </div>
      <div class="row">
        <div class="col-2 text-white">
          <h6>Hora:</h6>
        </div>
        <div class="col-5  text-warning float-right"><?php echo $hora_consulta;?></div>
        <div class="col-5  text-info float-right">&nbsp;</div>
      </div>
      <div class="row">
        <div class="col-2 text-white">
          <h6>Estado:</h6>
        </div>
        <div class="col-5  text-warning float-right">
          <?php 
          if($estado=='S')
          {
        echo"<h6 class=\"text-success\">$estado - (Consulta validada)</h6>";
        }else{
          echo"<h6 class=\"text-danger\">$estado - (Consulta pendente validação)</h6>";
        }
        ?>
        </div>
        <div class="col-5  text-info float-right">&nbsp;</div>
      </div>
      <div class="row">
        <div class="col-2 text-white">
          <h6>Internamento:</h6>
        </div>
        <div class="col-5 text-warning float-right">
    <?php 
     if($internamento=='A')
     {
     echo"<div class=\"row\"> <div class=\"alert alert-success bg-success\" role=\"alert\">
     <h6 class=\"alert-heading\">Paciente teve alta!</h6>
     </div></div>";
     }else if($internamento=='S'){
     echo"<div class=\"row\"> <div class=\"alert alert-danger bg-danger\" role=\"alert\">
     <h6 class=\"alert-heading\">Paciente está Internado!</h6>
     </div></div>";
     }else{
       echo"<div class=\"row\"> <div class=\"alert alert-secondary bg-secondary\" role=\"alert\">
       <h6 class=\"alert-heading\">Paciente sem internamento!</h6>
       </div></div>"; 
     }
    ?>
     </div>
    <div class="col-5  text-info float-right">&nbsp;</div>
    </div>
  </div>
  </div>


  <!--FORMULÁRIO UPDATE CONSULTA -->
  <?php
  }
  else if(isset($_POST['reset']))
  {
    $id_consulta=$_POST['id_consulta'];
    $nif=$_POST['nif'];

    $query_3 = "SELECT * FROM pacientes where nif = '$nif'";
    $result_3 = mysqli_query($_CONNECTION,$query_3) or die('Query falhou: ' . mysqli_error());
    $row_3 = mysqli_fetch_array($result_3);

    $query = "SELECT * FROM consultas where id_consulta = '$id_consulta'";
    $result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
    $row = mysqli_fetch_array($result);
  ?>

  <div class="container form-group rounded mx-auto d-block border border-light">
    <h5 class="text-light text-center">Update Consulta</h5>
    <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id_consulta" value="<?php echo $id_consulta;?>">
      <input type="hidden" name="nif" value="<?php echo $nif;?>">
      <input type="hidden" name="id_paciente" value="<?php echo $row_3['id_paciente'];?>">
      <input type="hidden" name="p" value="$_p1">
      <div class="form-row">
        <div class="col-12">
          <label class="form-check-label text-light">
            <h6>Marcar Para :</h6>
          </label>
          <input class="form-control" name="nome_paciente" type="text" value="<?php echo $row_3['nome_paciente'];?>"
            disabled>
        </div>
      </div>
      <?php
    include('med_esp.php');
    ?>
      <div class="form-row">
        <div class="col-12 py-3">
          <input class="btn btn-primary btn-sm" name="submit" type="submit" value="Update">
          <input class="btn btn-primary btn-sm" name="limpar" type="button" value="Limpar">
        </div>
      </div>
    </form>
    <div class="text-danger">&nbsp;<?php echo $error;?></div>
  </div>
  <?php
  }
  ?>

  <!-- LISTAR HISTÓRICO CONSULTAS -->
  <div class="container form-group rounded mx-auto d-block border border-light">
    <h5 class="text-primary  text-center">Histórico Consultas</h5>
    <div class="form-row">
      <div class="col-12">
        <?php 
        $today = date("n-j-Y"); 

         $query = "SELECT * FROM  consultas  where data_consulta<'$today' order by data_consulta desc";
         $result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
         echo "<div class=\"container text-light\"><div class=\"row\"><div class=\"col text-primary\">Id</div><div class=\"col-3 text-primary\">Paciente</div><div class=\"col-2 text-primary\">Especialidade</div><div class=\"col-2 text-primary\">Data</div><div class=\"col text-primary\">Hora</div><div class=\"col text-primary\"></div><div class=\"col text-primary\">Pre</div><div class=\"col text-primary\">Int</div></div>";

        while ($linha = mysqli_fetch_array($result)) 
        {
        $estado = $linha['estado'];
        $id_consulta = $linha['id_consulta'];
        $id_paciente = $linha['id_paciente'];
        $id_medico = $linha['id_medico'];
        $data_consulta = $linha['data_consulta'];
        $hora_consulta = $linha['hora_consulta'];
        $id_esp=$linha['id_esp'];
        $internamento = $linha['internamento'];

        $query_0 = "SELECT descricao FROM especialidades  where id_esp='$id_esp'";
        $result2 = mysqli_query($_CONNECTION,$query_0) or die('Query falhou: ' . mysqli_error());
         $row2 = mysqli_fetch_array($result2);
         $descricao = $row2['descricao'];

         $query_1 = "SELECT nome_paciente,nif FROM pacientes  where id_paciente='$id_paciente'";
         $result_1 = mysqli_query($_CONNECTION,$query_1) or die('Query falhou: ' . mysqli_error());
          $row_1 = mysqli_fetch_array($result_1);
          $nome_paciente = $row_1['nome_paciente'];
          $nif = $row_1['nif'];
          
          $query_2 = "SELECT * FROM prescricao  where id_consulta='$id_consulta'";
          $result_2 = mysqli_query($_CONNECTION,$query_2) or die('Query falhou: ' . mysqli_error());
          $row_2 = mysqli_fetch_array($result_2);
          $prescricao = $row_2['prescricao'];
          $observacoes = $row_2['observacoes'];

        echo "<div class=\"row py-2\">";
        echo "<div class=\"col\">$id_consulta</div><div class=\"col-3\">$nome_paciente</div><div class=\"col-2\">$descricao</div><div class=\"col-2\">$data_consulta</div><div class=\"col\">$hora_consulta</div>";
       
        $_PRESCRICAO="<form action=\"\" method=\"post\"><button class=\"btn btn-danger btn-sm\" onClick=\"submit();\">Pre</button></form>"; 
        $_PRESCRICAO2="<form action=\"\" method=\"post\"><button class=\"btn btn-success btn-sm\" onClick=\"submit();\">Pre</button></form>"; 
         $_VER="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"descricao\" value=\"$descricao\"><input type=\"hidden\" name=\"nome_medico\" value=\"$nome_medico\"><input type=\"hidden\" name=\"ver\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit2();\">Ver</button></form>";
        $_INTERNAMENTO="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"internamento\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit2();\">Int</button></form>";
        
        echo "<div class=\"col\">$_VER</div>";
        if(empty($prescricao))
        {
          echo " <div class=\"col\">$_PRESCRICAO</div>";
          switch($internamento)
          {
            case 'N':
            echo "<div class=\"col\"><div class=\"progress\"><div class=\"progress-bar bg-secondary\" role=\"progressbar\" style=\"width:100%\" aria-valuenow=\"100\" aria-valuemin=\"0\" aria-valuemax=\"100\">S/Int</div></div></div></div>"; 
            break;
            case 'S':
            echo "<div class=\"col\"><div class=\"progress\"><div class=\"progress-bar bg-danger\" role=\"progressbar\" style=\"width:100%\" aria-valuenow=\"100\" aria-valuemin=\"0\" aria-valuemax=\"100\">Int</div></div></div></div>"; 
            break;
            case 'A':
            echo "<div class=\"col\"><div class=\"progress\"><div class=\"progress-bar bg-success\" role=\"progressbar\" style=\"width:100%\" aria-valuenow=\"100\" aria-valuemin=\"0\" aria-valuemax=\"100\">Alta</div></div></div></div>"; 
            break;
            default:
          }
          
        }else{
          echo "<div class=\"col\">$_PRESCRICAO2</div>";
          switch($internamento)
          {
            case 'N':
            echo "<div class=\"col\"><div class=\"progress\"><div class=\"progress-bar bg-secondary\" role=\"progressbar\" style=\"width:100%\" aria-valuenow=\"100\" aria-valuemin=\"0\" aria-valuemax=\"100\">S/Int</div></div></div></div>"; 
            break;
            case 'S':
            echo "<div class=\"col\"><div class=\"progress\"><div class=\"progress-bar bg-danger\" role=\"progressbar\" style=\"width:100%\" aria-valuenow=\"100\" aria-valuemin=\"0\" aria-valuemax=\"100\">Int</div></div></div></div>"; 
            break;
            case 'A':
            echo "<div class=\"col\"><div class=\"progress\"><div class=\"progress-bar bg-success\" role=\"progressbar\" style=\"width:100%\" aria-valuenow=\"100\" aria-valuemin=\"0\" aria-valuemax=\"100\">Alta</div></div></div></div>"; 
            break;
            default:
          }
          
        }
        

      }
      echo "</div>";
      //LIBERTAR MEMÓRIA
       mysqli_free_result($result);   
      ?>
      </div>
    </div>
  </div>

  <?php
}
?>

</section>