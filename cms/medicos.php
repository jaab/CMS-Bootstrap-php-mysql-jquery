<?php 
//VARIAVEL PARA GUARDAR MSG ERRO
$error=''; 

//VARIAVEIS PARA GUARDAR AS PÁGINAS
$_p1=md5('1');

// ATIVAR, DESATIVAR MEDICO
if (isset($_POST['desativar'])) 
{
  $pag=$_POST['p'];
  $id_medico=$_POST['id_medico'];
  $_ESTADO=$_POST['desativar'];
  $query = "UPDATE medicos SET estado='$_ESTADO' WHERE id_medico=$id_medico";
  if(mysqli_query($_CONNECTION,$query)){
  }else{
    $error = "Error: " . $query . "<br>" . $_CONNECTION->error;
  }
}

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

//APAGAR  MEDICO
if (isset($_POST['apagar']))
{
  $pag=$_POST['p'];
  $id_medico=$_POST['id_medico'];

  $query_0 = mysqli_query($_CONNECTION,"select * from med_esp where id_medico='$id_medico'");
  $rows2 = mysqli_num_rows($query_0);
 
    if ($rows2!=0) 
    {
      echo" <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>
      <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js\"></script>
     <div class=\"container\"><div class=\"alert alert-danger alert-dismissible\">
      <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
     <strong>Não pode apagar este medico,sem apagar primeiro $rows2 especialidades associadas.</strong>
     </div></div>";
    }
    else
    {
      $query  = "DELETE FROM medicos WHERE id_medico = $id_medico";
      if (mysqli_query($_CONNECTION,$query)) {
        echo" <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>
        <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js\"></script>
       <div class=\"container\"><div class=\"alert alert-success alert-dismissible\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
       <strong>Medico apagado com sucesso!</strong>
       </div></div>";
      } else {
      echo "Error: " . $query . "<br>" . $_CONNECTION->error;
      }
    }
}

//UPDATE CONSULTA
if (isset($_POST['submit5_c'])) 
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
     <strong>Consulta atualizada com sucesso! - Foi enviado um email ao Paciente a avisar</strong>
     </div></div>";

     // Envio de email ao paciente
     $headers =  'MIME-Version: 1.0' . "\r\n"; 
     $headers .= 'From: Clinica Admin <player@viseu.tv>' . "\r\n";
     $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
     mail("$email","Alteração de consulta - $username",$msg,$headers);

     }else{
       $error = "Error: " . $query_c . "<br>" . $_CONNECTION->error;
     }
}

//DESMARCAR  CONSULTA
if (isset($_POST['apagar_c']))
{
  $pag=$_POST['p'];
  $id_consulta=$_POST['id_consulta'];
  $nif=$_POST['nif'];

  $query_0 = "SELECT username,email_user FROM login  where nif='$nif'";
  $result2 = mysqli_query($_CONNECTION,$query_0) or die('Query falhou: ' . mysqli_error());
   $row2 = mysqli_fetch_array($result2);
   $email = $row2['email_user'];
   $username = $row2['username'];
   $msg = "Caro $username,\n\n\t<br> a sua consulta foi desmarcada como solicitado\n\n\t<br> Bem haja";


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

//UPDATE PERFIL MEDICO
if (isset($_POST['reset'])) 
{
  $pag=$_POST['p'];
  if (isset($_POST['submit2'])) 
  {
      $id_medico=$_POST['id_medico'];
      $nome_medico=$_POST['nome_medico'];
      $morada=$_POST['morada'];
      $telefone=$_POST['telefone'];
      $data_nascimento=$_POST['data_nascimento'];
      $sexo=$_POST['sexo'];
      $nif=$_POST['nif'];
      $imagename=$_FILES["foto"]["name"];

      $query_up = "SELECT username FROM login where nif = '$nif'";
      $result_up = mysqli_query($_CONNECTION,$query_up) or die('Query falhou: ' . mysqli_error());
      $row_up = mysqli_fetch_array($result_up);

      //UPLOAD IMAGEM
      if(!empty($imagename)) 
      {
        //RETIRA A EXTENSAO DA IMAGEM
        $ext = strtolower(strrchr($imagename,"."));
        //ATRIBUI NOVO NOVO NOME À IMAGEM E ADICIONA A EXTENSÃO
        $imagename = md5(uniqid(time())).$ext;
        
        //SEPARA O NOME COMPLETO DO MEDICO
        $nome= explode(" ",$nome_medico); 
        $nome_up=$row_up['username'];
        //$dir = "$_PATH_UPLOADS_MED.$nome[0]";
        $dir = "$_PATH_UPLOADS_MED$nome_up";

        //VERIFICA SE EXISTE O DIRECTORIO
        if (!is_dir($dir)) {
          //CRIA O DIRECTORIA SE AINDA NÃO EXISTIR
          mkdir($dir);
         }

        $target_dir = "$dir/";

        $target_file = $target_dir . basename($imagename);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   
          // VERIFICA SE É UMA IMAGEM VERDADEIRA
            $check = getimagesize($_FILES["foto"]["tmp_name"]);
            if($check !== false) {
              $error = "O ficheiro é uma imagem - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                $error = "O ficheiro não é uma imagem.";
                $uploadOk = 0;
            }
          
            // VERIFICA SE O A IMAGEM JÁ EXISTE
            if (file_exists($target_file)) {
                $error =  "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // VERIFICA O TAMANHO DA IMAGEM
            if ($_FILES["foto"]["size"] > 500000) {
                $error =  "Tamanho da imagem muito grande.";
                $uploadOk = 0;
            }

            // PERMISSÃO SÓ PARA ALGUNS TIPOS DE IMAGENS
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo "Só são aceites JPG, JPEG, PNG & GIF.";
                $uploadOk = 0;
            }

      // VERIFICA SE HOUVE UPLOAD
      if ($uploadOk == 0) 
      {
        //$error = "A sua imagem não foi uploaded.";
      } 
      else 
      {
     // SE TUDO ESTIVER BEM É FEITO O UPLOAD DA IMAGEM
     if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) 
     {
         $query = "UPDATE medicos SET nome_medico='$nome_medico' , morada='$morada' , telefone='$telefone' , foto='$imagename' , nif='$nif' , data_nascimento='$data_nascimento' , sexo='$sexo'  WHERE id_medico=$id_medico";
         if(mysqli_query($_CONNECTION,$query)){
          echo" <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>
          <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js\"></script>
          <div class=\"container\"><div class=\"alert alert-success alert-dismissible\">
            <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
          <strong>Medico atualizado com sucesso!</strong>
          </div></div>";
         }else
         {
         $error = "Error: " . $query . "<br>" . $_CONNECTION->error;
         }

         $error = "O ficheiro ". basename($imagename). " foi uploaded.";

     } 
     else 
     {
     $error = "Houve um erro ao fazer o upload.";
     }
  }

}
else
{
    $query = "UPDATE medicos SET nome_medico='$nome_medico' , morada='$morada' , telefone='$telefone' , nif='$nif' , data_nascimento='$data_nascimento' , sexo='$sexo'  WHERE id_medico=$id_medico";
    if(mysqli_query($_CONNECTION,$query)){
      echo" <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>
          <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js\"></script>
          <div class=\"container\"><div class=\"alert alert-success alert-dismissible\">
            <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
          <strong>Medico atualizado com sucesso!</strong>
          </div></div>";
     }else{
       $error = "Error: " . $query . "<br>" . $_CONNECTION->error;
     } 
}
}
}

//ATRIBUIR ESPECIALIDADES AO MEDICO
if (isset($_POST['submit5'])) 
{
  $pag=$_POST['p'];
  $id_medico=$_POST['id_medico'];
  $id_esp=$_POST['id_esp'];
  //echo"$id_medico";
 
 $query3 = "SELECT * FROM med_esp where id_esp='$id_esp' and id_medico ='$id_medico'";
 $result3 = mysqli_query($_CONNECTION,$query3) or die('Query falhou: ' . mysqli_error());
 $row3 = mysqli_fetch_array($result3);
 if(!empty($row3['id_esp']))
 {
  echo" <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>
  <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js\"></script>
  <div class=\"container\"><div class=\"alert alert-danger alert-dismissible\">
    <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
  <strong>Este Medico já tem esta especialidade!</strong>
  </div></div>";
 }
 else
 {
   $query_3 = "INSERT INTO med_esp(id_medico, id_esp) VALUES ('$id_medico', '$id_esp')";
   if(mysqli_query($_CONNECTION,$query_3)){
    echo" <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>
          <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js\"></script>
          <div class=\"container\"><div class=\"alert alert-success alert-dismissible\">
            <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
          <strong>Especialidade ($id_esp) adicionada com sucesso!</strong>
          </div></div>";
   }else{
     $error = "Error: " . $query_3 . "<br>" . $_CONNECTION->error;
   }
 }
}

//RETIRAR ESPECIALIDADES AO MEDICO
if (isset($_POST['submit6']))
{
  $pag=$_POST['p'];
  $id_medico=$_POST['id_medico'];
  $id_esp=$_POST['id_esp'];
 
      $query  = "DELETE FROM med_esp WHERE id_esp = $id_esp and id_medico = $id_medico";
      if (mysqli_query($_CONNECTION,$query)) {
        echo" <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>
        <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js\"></script>
        <div class=\"container\"><div class=\"alert alert-success alert-dismissible\">
          <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
        <strong>Especialidade ($id_esp) retirada cpm sucesso!</strong>
        </div></div>";
      } else {
      echo "Error: " . $query . "<br>" . $_CONNECTION->error;
      } 
}
?>

<section class="page-section">
<!-- LISTAR MEDICOS -->
<?php
if (isset($_GET['p'])) 
{
$query = 'SELECT id_medico,nome_medico,sexo,nif,estado FROM medicos  order by id_medico desc';
$result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());

     echo "<div class=\"container text-light\"><div class=\"row\"><div class=\"col text-primary\">Id</div><div class=\"col-3 text-primary\">Médico</div><div class=\"col text-primary\">Sexo</div><div class=\"col text-primary\">Nif</div><div class=\"col-6 text-primary\"></div></div>";
     while ($linha = mysqli_fetch_array($result, MYSQL_ASSOC)) 
     {
      $id_medico = $linha['id_medico'];
      $nome_medico = $linha['nome_medico'];
      $sexo = $linha['sexo'];
      $nif = $linha['nif'];
      echo "<div class=\"row py-2\">";
       foreach ($linha as $col_valor) 
       { 
        if($col_valor!=$linha['estado'])
        {
          if($col_valor!=$linha['nome_medico'])
          {
          echo "<div class=\"col\">$col_valor</div>";
          }else{
          echo "<div class=\"col-3\">$col_valor</div>"; 
          }
        } 
       }
       // LINKS COM VARIAVEIS HIDDEN
        if ($linha['estado']=='S') //BOTÃO ON OFF
        {
         $_DESATIVAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_medico\" value=\"$id_medico\"><input type=\"hidden\" name=\"nif\" value=\"$nif\"><input type=\"hidden\" name=\"desativar\" value=\"N\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-success btn-sm\" onClick=\"submit();\">On</button></form>"; 
        }
        else
        {
         $_DESATIVAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_medico\" value=\"$id_medico\"><input type=\"hidden\" name=\"nif\" value=\"$nif\"><input type=\"hidden\" name=\"desativar\" value=\"S\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-danger btn-sm\" onClick=\"submit();\">Off</button></form>";  
        }
       $_APAGAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_medico\" value=\"$id_medico\"><input type=\"hidden\" name=\"nif\" value=\"$nif\"><input type=\"hidden\" name=\"apagar\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-danger btn-sm\" onClick=\"submit();\">Del</button></form>";
       $_RESET="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_medico\" value=\"$id_medico\"><input type=\"hidden\" name=\"nif\" value=\"$nif\"><input type=\"hidden\" name=\"ver\" value=\"2\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit2();\">Update</button></form>";
       $_VER="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_medico\" value=\"$id_medico\"><input type=\"hidden\" name=\"nif\" value=\"$nif\"><input type=\"hidden\" name=\"ver\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit();\">Perfil</button></form>";
       $_CONSULTA="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_medico\" value=\"$id_medico\"><input type=\"hidden\" name=\"nif\" value=\"$nif\"><input type=\"hidden\" name=\"ver\" value=\"3\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit();\">Consultas</button></form>";
       echo "<div class=\"col-sm\"></div><div class=\"col\">$_DESATIVAR</div><div class=\"col\">$_APAGAR</div><div class=\"col\">$_RESET</div><div class=\"col\">$_VER</div><div class=\"col\">$_CONSULTA</div></div>";
     }
     echo "</div>";
     //LIBERTAR MEMÓRIA
    mysqli_free_result($result);
}
?>

<!--VISUALIZAR MEDICO-->
<?php 
if (isset($_POST['ver'])) 
{
  $_VERI=$_POST['ver'];
switch ($_VERI) 
{
case 1:
    $id_medico=$_POST['id_medico'];
    $query = "SELECT * FROM medicos where id_medico = '$id_medico'";
    $result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
    $row = mysqli_fetch_array($result);
    $nome_medico=$row['nome_medico'];
    $nif=$row['nif'];
    $nome= explode(" ",$nome_medico); 

    $query_up = "SELECT username FROM login where nif = '$nif'";
    $result_up = mysqli_query($_CONNECTION,$query_up) or die('Query falhou: ' . mysqli_error());
    $row_up = mysqli_fetch_array($result_up);
    $nome_up=$row_up['username'];

    $dir = "$_PATH_UPLOADS_MED$nome_up";


    if(!empty($row['foto'])){
      $foto=$dir.'/'.$row['foto'];
    }else{
      $foto="img/user.png";
    }
?>

   <div class="container form-group rounded mx-auto d-block border border-light">
   <h5 class="text-primary text-center">Visualizar Médico</h5>
   <div class="container">
    <div class="row">
      <div class="col-2 text-white">
        <h6>Id:</h6>
      </div>
      <div class="col-5 text-warning float-right"><?php echo $row['id_medico'];?></div>
      <div class="col text-white">
        <h6>Foto:</h6>
      </div>
      <div class="col-4  text-warning float-right">
        <img class="rounded-circle" width="120px" height="120px" src="<?php echo $foto;?>">
        <div class="col text-white py-4">
          <h6>Especialidades:</h6>
        </div>
        <?php
       $query = "SELECT id_esp FROM med_esp  where id_medico='$id_medico' order by id_esp desc";
       $result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
    
     // LISTA AS ESPECIALIDADES DO MEDICO DA TABELA ESPECIALIDADES
     while ($linha = mysqli_fetch_array($result, MYSQL_ASSOC)) 
     {
      $id_esp = $linha['id_esp'];
      $query_0 = "SELECT descricao FROM especialidades  where id_esp='$id_esp'";
      $result2 = mysqli_query($_CONNECTION,$query_0) or die('Query falhou: ' . mysqli_error());
      $row2 = mysqli_fetch_array($result2);
      $descricao = $row2['descricao'];

       echo "<div class=\"col text-warning\">$descricao</div>";
      }
      ?>
      </div>
    </div>
    <div class="row">
      <div class="col-2 text-white">
        <h6>Sexo:</h6>
      </div>
      <div class="col-5  text-warning float-right"><?php echo $row['sexo'];?></div>
      <div class="col-5  text-info float-right">&nbsp;</div>
    </div>
    <div class="row">
      <div class="col-2 text-white">
        <h6>Nome Completo:</h6>
      </div>
      <div class="col-5  text-warning float-right "><?php echo $row['nome_medico'];?></div>
      <div class="col-5  text-info float-right">&nbsp;</div>
    </div>
    <div class="row">
      <div class="col-2 text-white">
        <h6>Nif:</h6>
      </div>
      <div class="col-5  text-warning float-right"><?php echo $row['nif'];?></div>
      <div class="col-5  text-info float-right">&nbsp;</div>
    </div>
    <div class="row">
      <div class="col-2 text-white">
        <h6>Data Nascimento:</h6>
      </div>
      <div class="col-5  text-warning float-right"><?php echo $row['data_nascimento'];?></div>
      <div class="col-5  text-info float-right">&nbsp;</div>
    </div>
    <div class="row">
      <div class="col-2 text-white">
        <h6>Morada:</h6>
      </div>
      <div class="col-5  text-warning float-right"><?php echo $row['morada'];?></div>
      <div class="col-5  text-info float-right">&nbsp;</div>
    </div>
    <div class="row">
      <div class="col-2 text-white">
        <h6>Telefone:</h6>
      </div>
      <div class="col-5  text-warning float-right"><?php echo $row['telefone'];?></div>
      <div class="col-5  text-info float-right">&nbsp;</div>
    </div>
    <div class="row">
      <div class="col-2 text-white">
        <h6>Estado:</h6>
      </div>
      <div class="col-5 text-warning float-right"><?php echo $row['estado'];?></div>
      <div class="col-5  text-info float-right">&nbsp;</div>
    </div>
  </div>

<!--FORMULÁRIO UPDATE MEDICO-->
<?php
break;
case 2:
    $id_medico=$_POST['id_medico'];
    $nif=$_POST['nif'];

    $query = "SELECT * FROM medicos where nif = '$nif'";
    $result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
    $row = mysqli_fetch_array($result);
?>
   <div class="container form-group rounded mx-auto d-block border border-light">
    <h5 class="text-primary text-center">Update Médico</h5>
    <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id_medico" value="<?php echo $row['id_medico'];?>">
      <input type="hidden" name="reset" value="1">
      <input type="hidden" name="p" value="$_p1">
      <div class="form-row">
        <div class="col-12">
          <label class="form-check-label text-light">
            <h6>Nome Completo :</h6>
          </label>
          <input class="form-control" name="nome_medico" type="text" value="<?php echo $row['nome_medico'];?>">
        </div>
      </div>
      <div class="form-row">
        <div class="col-12">
          <label class="form-check-label text-light">
            <h6>Morada :</h6>
          </label>
          <input class="form-control" name="morada" type="text" value="<?php echo $row['morada'];?>">
        </div>
      </div>
      <div class="form-row">
        <div class="col-6">
          <label class="form-check-label text-light">
            <h6>Telefone :</h6>
          </label>
          <input class="form-control" name="telefone" type="text" value="<?php echo $row['telefone'];?>">
        </div>
        <div class="col-6">
          <label class="form-check-label text-light">
            <h6>Nif :</h6>
          </label>
          <input class="form-control" name="nif" type="text" value="<?php echo $row['nif'];?>">
        </div>
      </div>
      <div class="form-row">
        <div class="col-6">
          <label class="form-check-label text-light">
            <h6>Data Nascimento :</h6>
          </label>
          <input class="form-control" name="data_nascimento" type="text" value="<?php echo $row['data_nascimento'];?>">
        </div>
        <div class="col-6">
          <label class="form-check-label text-light">
            <h6>Sexo :</h6>
          </label>
          <select class="form-control custom-select mr-sm-2" name="sexo" id="sexo" required>
            <option value="">Escolher sexo</option>
            <option class="form-control" value="Masculino">Masculino</option>
            <option class="form-control" value="Feminino">Feminino</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="col-12">
          <label class="form-check-label text-light">
            <h6>Foto :</h6>
          </label>
          <input class="form-control" name="foto" id="foto" type="file">
        </div>

      </div>
      <div class="form-row">
        <div class="col-12 py-3">
          <input class="btn btn-primary btn-sm" name="submit2" type="submit" value="Update">
          <input class="btn btn-primary btn-sm" name="limpar" type="button" value="Limpar">
        </div>
      </div>
    </form>
    <div class="text-danger">&nbsp;<?php echo $error;?></div>
  </div>

<!--CONSULTAS DO MEDICO-->
<?php
break;
case 3:
?>
  <!--CONSULTAS DO DIA DO MEDICO-->
  <div class="container form-group rounded mx-auto d-block border border-light">
    <h5 class="text-primary  text-center">Consultas do Dia</h5>
    <div class="form-row">
      <div class="col-12">

        <?php 
        if (isset($_POST['id_medico'])) 
        {

        $today = date("n-j-Y"); 
        $id_medico=$_POST['id_medico'];
        
         $query_m = "SELECT * FROM  consultas  where id_medico='$id_medico' and data_consulta='$today' order by data_consulta ASC";
         $result_m = mysqli_query($_CONNECTION,$query_m) or die('Query falhou: ' . mysqli_error());
         echo "<div class=\"container text-light\"><div class=\"row\"><div class=\"col text-primary\">Id</div><div class=\"col-3 text-primary\">Paciente</div><div class=\"col text-primary\">Especialidade</div><div class=\"col-2 text-primary\">Data</div><div class=\"col text-primary\">Hora</div><div class=\"col text-primary\"></div><div class=\"col text-primary\"></div><div class=\"col text-primary\"></div><div class=\"col text-primary\"></div></div>";
       while ($linha_m = mysqli_fetch_array($result_m)) 
       {
        $estado = $linha_m['estado'];
        $id_consulta = $linha_m['id_consulta'];
        $id_paciente = $linha_m['id_paciente'];
        $data_consulta = $linha_m['data_consulta'];
        $hora_consulta = $linha_m['hora_consulta'];
        $id_esp=$linha_m['id_esp'];
      

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
        echo "<div class=\"col\">$id_consulta</div><div class=\"col-3\">$nome_paciente</div><div class=\"col\">$descricao</div><div class=\"col-2\">$data_consulta</div><div class=\"col\">$hora_consulta</div>";

        // LINKS COM VARIAVEIS HIDDEN
        if ($estado=='S') //BOTÃO ON OFF
        {
         $_DESATIVAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"ver\" value=\"3\"><input type=\"hidden\" name=\"id_medico\" value=\"$id_medico\"><input type=\"hidden\" name=\"nif\" value=\"$nif\"><input type=\"hidden\" name=\"consulta\" value=\"1\"><input type=\"hidden\" name=\"desativar_c\" value=\"N\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-success btn-sm\" onClick=\"submit();\">On</button></form>"; 
        }
        else
        {
         $_DESATIVAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"ver\" value=\"3\"><input type=\"hidden\" name=\"id_medico\" value=\"$id_medico\"><input type=\"hidden\" name=\"nif\" value=\"$nif\"><input type=\"hidden\" name=\"consulta\" value=\"1\"><input type=\"hidden\" name=\"desativar_c\" value=\"S\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-danger btn-sm\" onClick=\"submit();\">Off</button></form>";  
        }
        $_APAGAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"nif\" value=\"$nif\"><input type=\"hidden\" name=\"apagar_c\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-danger btn-sm\" onClick=\"submit();\">Des</button></form>";
        $_RESET="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"id_medico\" value=\"$id_medico\"><input type=\"hidden\" name=\"nif\" value=\"$nif\"><input type=\"hidden\" name=\"reset_c\" value=\"1\"><input type=\"hidden\" name=\"ver\" value=\"3\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit2();\">Update</button></form>";
        $_VER="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"id_medico\" value=\"$id_medico\"><input type=\"hidden\" name=\"descricao\" value=\"$descricao\"><input type=\"hidden\" name=\"nome_medico\" value=\"$nome_medico\"><input type=\"hidden\" name=\"ver\" value=\"3\"><input type=\"hidden\" name=\"ver_c\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit2();\">Ver</button></form>";
        echo "<div class=\"col\">$_DESATIVAR</div><div class=\"col\">$_APAGAR</div><div class=\"col text\">$_RESET</div><div class=\"col text\">$_VER</div></div>";
       }
       echo "</div>";
       //LIBERTAR MEMÓRIA
       mysqli_free_result($result_m);  
        }
        ?>
      </div>
     </div>
   </div>

  <!-- CONSULTAS FUTURAS DO MEDICO-->
  <div class="container form-group rounded mx-auto d-block border border-light">
    <h5 class="text-primary  text-center">Próximas Consultas</h5>
    <div class="form-row">
      <div class="col-12">

        <?php 
         if (isset($_POST['id_medico'])) 
         {
        $horaagora= date("H:i");
        $id_medico=$_POST['id_medico'];
        
         $query_m = "SELECT * FROM  consultas  where id_medico='$id_medico' and data_consulta>'$today' order by data_consulta desc";
         $result_m = mysqli_query($_CONNECTION,$query_m) or die('Query falhou: ' . mysqli_error());
         echo "<div class=\"container text-light\"><div class=\"row\"><div class=\"col text-primary\">Id</div><div class=\"col-3 text-primary\">Paciente</div><div class=\"col text-primary\">Especialidade</div><div class=\"col-2 text-primary\">Data</div><div class=\"col text-primary\">Hora</div><div class=\"col text-primary\"></div><div class=\"col text-primary\"></div><div class=\"col text-primary\"></div><div class=\"col text-primary\"></div></div>";
        while ($linha_m = mysqli_fetch_array($result_m)) 
        {
        $estado = $linha_m['estado'];
        $id_consulta = $linha_m['id_consulta'];
        $id_paciente = $linha_m['id_paciente'];
        $data_consulta = $linha_m['data_consulta'];
        $hora_consulta = $linha_m['hora_consulta'];
        $id_esp=$linha_m['id_esp'];
       

        $query_0 = "SELECT descricao FROM especialidades  where id_esp='$id_esp'";
        $result2 = mysqli_query($_CONNECTION,$query_0) or die('Query falhou: ' . mysqli_error());
         $row2 = mysqli_fetch_array($result2);
         $descricao = $row2['descricao'];

         $query_1 = "SELECT nome_paciente,nif FROM pacientes  where id_paciente='$id_paciente'";
         $result_1 = mysqli_query($_CONNECTION,$query_1) or die('Query falhou: ' . mysqli_error());
          $row_1 = mysqli_fetch_array($result_1);
          $nome_paciente = $row_1['nome_paciente'];
          $nif2 = $row_1['nif'];

          $query_2 = "SELECT * FROM prescricao  where id_consulta='$id_consulta'";
          $result_2 = mysqli_query($_CONNECTION,$query_2) or die('Query falhou: ' . mysqli_error());
          $row_2 = mysqli_fetch_array($result_2);
          $prescricao = $row_2['prescricao'];
          $observacoes = $row_2['observacoes'];

        echo "<div class=\"row py-2\">";
        echo "<div class=\"col\">$id_consulta</div><div class=\"col-3\">$nome_paciente</div><div class=\"col\">$descricao</div><div class=\"col-2\">$data_consulta</div><div class=\"col\">$hora_consulta</div>";

        // LINKS COM VARIAVEIS HIDDEN
        if ($estado=='S') //BOTÃO ON OFF
        {
         $_DESATIVAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"ver\" value=\"3\"><input type=\"hidden\" name=\"id_medico\" value=\"$id_medico\"><input type=\"hidden\" name=\"nif\" value=\"$nif2\"><input type=\"hidden\" name=\"consulta\" value=\"1\"><input type=\"hidden\" name=\"desativar_c\" value=\"N\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-success btn-sm\" onClick=\"submit();\">On</button></form>"; 
        }
        else
        {
         $_DESATIVAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"ver\" value=\"3\"><input type=\"hidden\" name=\"id_medico\" value=\"$id_medico\"><input type=\"hidden\" name=\"nif\" value=\"$nif2\"><input type=\"hidden\" name=\"consulta\" value=\"1\"><input type=\"hidden\" name=\"desativar_c\" value=\"S\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-danger btn-sm\" onClick=\"submit();\">Off</button></form>";  
        }
        $_APAGAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"nif\" value=\"$nif2\"><input type=\"hidden\" name=\"apagar_c\" value=\"1\"><input type=\"hidden\" name=\"ver\" value=\"3\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-danger btn-sm\" onClick=\"submit();\">Des</button></form>";
        $_RESET="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"id_medico\" value=\"$id_medico\"><input type=\"hidden\" name=\"nif\" value=\"$nif2\"><input type=\"hidden\" name=\"reset_c\" value=\"1\"><input type=\"hidden\" name=\"ver\" value=\"3\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit2();\">Update</button></form>";
        $_VER="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"id_medico\" value=\"$id_medico\"><input type=\"hidden\" name=\"descricao\" value=\"$descricao\"><input type=\"hidden\" name=\"nome_medico\" value=\"$nome_medico\"><input type=\"hidden\" name=\"ver_c\" value=\"1\"><input type=\"hidden\" name=\"ver\" value=\"3\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit2();\">Ver</button></form>";
        echo "<div class=\"col\">$_DESATIVAR</div><div class=\"col\">$_APAGAR</div><div class=\"col text\">$_RESET</div><div class=\"col text\">$_VER</div></div>";
       }
       echo "</div>";
       //LIBERTAR MEMÓRIA
       mysqli_free_result($result_m); 
      }  
        ?>
      </div>
     </div>
    </div>

    <!--FORMULÁRIO UPDATE CONSULTA -->
    <?php
    if(isset($_POST['reset_c']))
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
    <input type="hidden" name="p" value="$_p7">
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
        <input class="btn btn-primary btn-sm" name="submit5_c" type="submit" value="Update">
        <input class="btn btn-primary btn-sm" name="limpar" type="button" value="Limpar">
      </div>
    </div>
    </form>
    <div class="text-danger">&nbsp;<?php echo $error;?></div>
    </div>
    <?php
    }
    ?>

    <!--VISUALIZAR CONSULTA-->
    <?php 
    if(isset($_POST['ver_c']))
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
      $alta = $row_2['estado'];
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
    <?php
   }
   ?>
   </div>
   </div>

<?php
break;
default:
}
}else{
?>
  <!--FORMULÁRIO ATRIBUIR ESPECIALIDADES AO MEDICO-->
  <div class="container form-group rounded mx-auto d-block border border-light">
    <h5 class="text-primary text-center">Atribuir-Retirar Especialdiade-Médico</h5>
    <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id_medico" value="<?php echo $row['id_medico'];?>">
      <input type="hidden" name="p" value="$_p1">
      <div class="form-row">
        <div class="col-6">
          <label class="form-check-label text-light">
            <h6>Especialidade :</h6>
          </label>
          <select class="form-control custom-select mr-sm-2" name="id_esp" id="id_esp" required>
            <option value="">Selecionar especialidade</option>
            <?php 
           $query = 'SELECT id_esp,descricao FROM especialidades order by id_esp asc';
           $result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
    
           while ($linha = mysqli_fetch_array($result)) 
            {
            $id_esp = $linha['id_esp'];
            $descricao = $linha['descricao'];
             echo"<option class=\"form-control\" value=\"$id_esp\">$id_esp - $descricao</option>";
            } 
            ?>
          </select>
        </div>
        <div class="col-6">
          <label class="form-check-label text-light">
            <h6>Médico :</h6>
          </label>
          <select class="form-control custom-select mr-sm-2" name="id_medico" id="id_medico" required>
            <option value="">Selecionar medico</option>
            <?php 
           $query2 = 'SELECT id_medico,nome_medico FROM medicos order by id_medico asc';
           $result2 = mysqli_query($_CONNECTION,$query2) or die('Query falhou: ' . mysqli_error());
    
           while ($linha2 = mysqli_fetch_array($result2)) 
            {
            $id_medico = $linha2['id_medico'];
            $nome_medico = $linha2['nome_medico'];
             echo"<option class=\"form-control\" value=\"$id_medico\">$nome_medico</option>";
            } 
            ?>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="col-12 py-3">
          <input class="btn btn-primary btn-sm" name="submit5" type="submit" value="Atribuir">
          <input class="btn btn-primary btn-sm" name="submit6" type="submit" value="Retirar">

        </div>
      </div>
    </form>
    <div class="text-danger">&nbsp;<?php echo $error;?></div>
  </div>
<?php
}
?>
</section>