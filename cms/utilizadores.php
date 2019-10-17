<?php 
//VARIAVEL PARA GUARDAR MSG ERRO
$error=''; 

//VARIAVEIS PARA GUARDAR AS PÁGINAS
$_p1=md5('1');
  

//INSERIR  UTILIZADOR
if (isset($_POST['submit'])) 
{
  if (empty($_POST['username']) || empty($_POST['password'])) 
  {
  $error = "Tem de preencher o username e a password";
  }
  else
  {
    $_ACESSO=$_POST['acesso'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    $_PASS_ENCRIPTADA = md5($password);
    $_EMAIL_USER=$_POST['email_user'];
    $_NIF=$_POST['nif'];

    if($_ACESSO!=1)
    {
      switch ($_ACESSO) 
     {
      case 2:
      $query_1= "INSERT INTO pacientes(nif, estado) VALUES ('$_NIF', 'S')";
      break;
      case 3:
      $query_1  = "INSERT INTO medicos(nif, estado) VALUES ('$_NIF', 'S')";
      break;
      case 4:
      $query_1  = "INSERT INTO funcionarios(nif, estado) VALUES ('$_NIF', 'S')";
      break;
      default:
     } 
    
      if(mysqli_query($_CONNECTION,$query_1)){
      }else{
        $error = "Error: " . $query_1 . "<br>" . $_CONNECTION->error;
      }
    }
   
   
    $query0 = "SELECT username FROM login where username='$username'";
    $result = mysqli_query($_CONNECTION,$query0) or die('Query falhou: ' . mysqli_error());
    $row = mysqli_fetch_array($result);
    if(!empty($row['username']))
    {
      $error = " Esse utilizador já existe.";
    }
    else
    {
      $query  = "INSERT INTO login(username, password, acesso, estado, email_user, nif) VALUES ('$username', '$_PASS_ENCRIPTADA', '$_ACESSO', 'S', '$_EMAIL_USER', '$_NIF')";
      if(mysqli_query($_CONNECTION,$query)){
      }else{
        $error = "Error: " . $query . "<br>" . $_CONNECTION->error;
      }
    }
  }
}

// ATIVAR, DESATIVAR UTILIZADOR
if (isset($_POST['desativar'])) 
{
  $id_user=$_POST['id_user'];
  $_ESTADO=$_POST['desativar'];
  $query = "UPDATE login SET estado='$_ESTADO' WHERE id=$id_user";
  if(mysqli_query($_CONNECTION,$query)){
  }else{
    $error = "Error: " . $query . "<br>" . $_CONNECTION->error;
  }
}

//APAGAR  UTILIZADOR
if (isset($_POST['apagar']))
{
  $id_user=$_POST['id_user'];
  $query  = "DELETE FROM login WHERE id = $id_user";
  if (mysqli_query($_CONNECTION,$query)) {
  } else {
  echo "Error: " . $query . "<br>" . $_CONNECTION->error;
  }
}

//UPDATE UTILIZADOR
if (isset($_POST['reset'])) 
{
  //$pag=$_POST['p'];
  if (isset($_POST['submit2'])) 
  {
    if (empty($_POST['password'])) 
    {
      $error = "Tem de preencher a password";
    }
    else
    {
        $id_user=$_POST['id_user'];
        //VERIFICA SE A PASSWORD FOI ALTERADA
        $password=$_POST['password'];
        $query0 = "SELECT password FROM login where password='$password'";
         $result = mysqli_query($_CONNECTION,$query0) or die('Query falhou: ' . mysqli_error());
         $row = mysqli_fetch_array($result);
          if(!empty($row['password']))
          {
            $_PASS_ENCRIPTADA = $_POST['password'];
          }
          else
          {
             $_PASS_ENCRIPTADA = md5($password);
          }

          $_ACESSO=$_POST['acesso'];
          $_EMAIL_USER=$_POST['email_user'];
          $_NIF=$_POST['nif'];
     
          $query = "UPDATE login SET password='$_PASS_ENCRIPTADA' , acesso='$_ACESSO' , email_user='$_EMAIL_USER', nif='$_NIF' WHERE id=$id_user";
          if(mysqli_query($_CONNECTION,$query)){
          }
          else
          {
            $error = "Error: " . $query . "<br>" . $_CONNECTION->error;
          }
   }
  }
}
?>

<section  class="page-section">
<?php
if (isset($_GET['p'])) 
{
//LISTAR  UTILIZADORES
$query = 'SELECT id,username,password,estado,acesso FROM login order by id desc';
$result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());

     echo "<div class=\"container text-light\"><div class=\"row\"><div class=\"col text-primary\">Id</div><div class=\"col text-primary\">Utilizador</div><div class=\"col text-primary\">Password</div><div class=\"col text-primary\">Acesso</div><div class=\"col-8 text-primary\"></div></div>";
     while ($linha = mysqli_fetch_array($result, MYSQL_ASSOC)) 
     {
      $id_user = $linha['id'];
      echo "<div class=\"row py-2\">";
       foreach ($linha as $col_valor) 
       { 
        if($col_valor!=$linha['estado'])
        {
          if($col_valor!=$linha['password']){
            if($col_valor!=$linha['acesso']){
             echo "<div class=\"col\">$col_valor</div>";
            }else{
              switch ($linha['acesso']) 
              {
                case 1:
                    echo"<div class=\"col\">Admin</div>";
                    break;
                case 2:
                   echo"<div class=\"col\">Paciente</div>";
                    break;
                case 3:
                   echo"<div class=\"col\">Medico</div>";;
                    break;
                case 4:
                  echo"<div class=\"col\">Funcionario</div>";
                break;
                default:
              }
            }
          }else{
            $col_valor=substr("$col_valor",0,8);
            echo "<div class=\"col\">$col_valor</div>"; 
          }
        } 
       }
       // LINKS COM VARIAVEIS HIDDEN
        if ($linha['estado']=='S') //BOTÃO ON OFF
        {
         $_DESATIVAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_user\" value=\"$id_user\"><input type=\"hidden\" name=\"desativar\" value=\"N\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-success btn-sm\" onClick=\"submit();\">On</button></form>"; 
        }
        else
        {
         $_DESATIVAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_user\" value=\"$id_user\"><input type=\"hidden\" name=\"desativar\" value=\"S\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-danger btn-sm\" onClick=\"submit();\">Off</button></form>";  
        }
       $_APAGAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_user\" value=\"$id_user\"><input type=\"hidden\" name=\"apagar\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-danger btn-sm\" onClick=\"submit();\">Del</button></form>";
       $_RESET="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_user\" value=\"$id_user\"><input type=\"hidden\" name=\"reset\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit2();\">Reset</button></form>";
       $_VER="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_user\" value=\"$id_user\"><input type=\"hidden\" name=\"ver\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit();\">Ver</button></form>";
       echo "<div class=\"col-sm\"></div><div class=\"col\">$_DESATIVAR</div><div class=\"col\">$_APAGAR</div><div class=\"col\">$_RESET</div><div class=\"col-3\">$_VER</div></div>";
     }
     echo "</div>";
     //LIBERTAR MEMÓRIA
     mysqli_free_result($result);
     }
?>

</section>

<!--VISUALIZAR UTILIZADOR-->
<?php 
if (isset($_POST['ver'])) 
{
  $id_user=$_POST['id_user'];
  $query = "SELECT * FROM login where id = '$id_user'";
  $result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
  $row = mysqli_fetch_array($result);
  $nif=$row['nif'];

  $query2 = "SELECT * FROM medicos where nif = '$nif'";
  $result2 = mysqli_query($_CONNECTION,$query2) or die('Query falhou: ' . mysqli_error());
  $row2 = mysqli_fetch_array($result2);
  $nome_medico=$row2['nome_medico'];
  $nome= explode(" ",$nome_medico); 
  $dir = "$_PATH_UPLOADS_MED.$nome[0]";
  if(!empty($row2['foto'])){
    $foto=$dir.'/'.$row2['foto'];
  }else{
    $foto="img/user.png";
  }
?>

<div class="container form-group rounded mx-auto d-block border border-light">
  <h5 class="text-primary text-center">Visualizar Utilizador</h5>
  <div class="container">
    <div class="row">
      <div class="col-2 text-white">
        <h6>Id:</h6>
      </div>
      <div class="col text-warning float-right"><?php echo $row['id'];?></div>
      <div class="col text-white">
        <h6>Foto:</h6>
      </div>
      <div class="col  text-warning float-right"><img class="rounded-circle" width="120px" height="120px"
          src="<?php echo $foto;?>"></div>
    </div>
    <div class="row">
      <div class="col-2 text-white">
        <h6>Uilizador:</h6>
      </div>
      <div class="col  text-warning float-right "><?php echo $row['username'];?></div>
    </div>
    <div class="row">
      <div class="col-2 text-white">
        <h6>Nif:</h6>
      </div>
      <div class="col  text-warning float-right "><?php echo $row['nif'];?></div>
    </div>
    <div class="row">
      <div class="col-2 text-white">
        <h6>Email:</h6>
      </div>
      <div class="col  text-warning float-right "><?php echo $row['email_user'];?></div>
    </div>
    <div class="row">
      <div class="col-2 text-white">
        <h6>Password:</h6>
      </div>
      <div class="col  text-warning float-right"><?php echo $row['password'];?></div>
    </div>
    <div class="row">
      <div class="col-2 text-white">
        <h6>Acesso:</h6>
      </div>
      <div class="col  text-warning float-right">
      <?php
      switch ($row['acesso']) 
              {
                case 1:
                    echo"Admin";
                    break;
                case 2:
                   echo"Paciente";
                    break;
                case 3:
                   echo"Medico";;
                    break;
                case 4:
                  echo"Funcionario";
                break;
                default:
              }
      ?>
      </div>
    </div>
    <div class="row">
      <div class="col-2 text-white">
        <h6>Estado:</h6>
      </div>
      <div class="col text-warning float-right"><?php echo $row['estado'];?></div>
    </div>
    <div class="row">
      <div class="col-2 text-white">
        <h6>Ultimo login:</h6>
      </div>
      <div class="col text-warning float-right"><?php echo $row['data'];?></div>
    </div>
  </div>

<!--FORMULÁRIO RESET UTILIZADOR-->
<?php
}
else if(isset($_POST['reset']))
{
$id_user=$_POST['id_user'];
$query = "SELECT * FROM login where id = '$id_user'";
$result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
$row = mysqli_fetch_array($result);
?>

  <div class="container form-group rounded mx-auto d-block border border-light">
    <h5 class="text-primary text-center">Reset Utilizador</h5>
    <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id_user" value="<?php echo $row['id'];?>">
      <input type="hidden" name="reset" value="1">
      <input type="hidden" name="p" value="<?php echo $_p1;?>">
      <div class="form-row">
        <div class="col-6">
          <label class="form-check-label text-light">
            <h6>Utilizador :</h6>
          </label>
          <input class="form-control" name="username" type="text" value="<?php echo $row['username'];?>" disabled>
        </div>
        <div class="col-6">
          <label class="form-check-label text-light">
            <h6>Password :</h6>
          </label>
          <input class="form-control" name="password" type="text" value="<?php echo $row['password'];?>">
        </div>
      </div>
      <div class="form-row">
        <div class="col-6">
          <label class="form-check-label text-light">
            <h6>Email :</h6>
          </label>
          <input class="form-control" name="email_user" type="email" value="<?php echo $row['email_user'];?>">
        </div>
        <div class="col-6">
          <label class="form-check-label text-light">
            <h6>Nif :</h6>
          </label>
          <input class="form-control" name="nif" type="text" value="<?php echo $row['nif'];?>">
        </div>
      </div>
      <div class="form-row">
        <div class="col-12">
          <label class="form-check-label text-light">
            <h6>Tipo Acesso :</h6>
          </label>
          <select class="form-control custom-select mr-sm-2" name="acesso" id="acesso" required>
          <option value="">Escolher tipo de acesso</option>
            <option class="form-control" value="1">Admin</option>
            <option class="form-control" value="2">Paciente</option>
            <option class="form-control" value="3">Medico</option>
            <option class="form-control" value="4">funcionario</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="col-12 py-3">
          <input class="btn btn-primary btn-sm" name="submit2" type="submit" value="Reset">
          <input class="btn btn-primary btn-sm" name="limpar" type="button" value="Limpar">
        </div>
      </div>
    </form>
    <div class="text-danger">&nbsp;<?php echo $error;?></div>
  </div>

  <!--FORMULÁRIO INSERIR UTILIZADOR-->
<?php
}else{
?>

  <div class="container form-group rounded mx-auto d-block border border-light">
    <h5 class="text-primary text-center">Criar Utilizador</h5>
    <form action="" method="post" enctype="multipart/form-data">
      <div class="form-row">
        <div class="col-6">
          <label class="form-check-label text-light" for="validationDefaultUsername">
            <h6>Utilizador :</h6>
          </label>
          <input class="form-control" id="validationDefaultUsername" name="username" type="text" aria-describedby="inputGroupPrepend2" required> 
        </div>
        <div class="col-6">
          <label class="form-check-label text-light" for="validationDefaultPassword">
            <h6>Password :</h6>
          </label>
          <input class="form-control" id="validationDefaultPassword"  name="password" type="password" aria-describedby="inputGroupPrepend2" required>
        </div>
      </div>
      <div class="form-row">
        <div class="col-6">
          <label class="form-check-label text-light" for="validationDefaultEmail">
            <h6>Email :</h6>
          </label>
          <input class="form-control" id="validationDefaultEmail"  name="email_user" type="email" aria-describedby="inputGroupPrepend2" required>
        </div>
        <div class="col-6">
          <label class="form-check-label text-light" for="validationDefaultNif">
            <h6>Nif :</h6>
          </label>
          <input class="form-control" id="validationDefaultNif"  name="nif" type="text" aria-describedby="inputGroupPrepend2" required>
        </div>
      </div>
      <div class="form-row">
        <div class="col-12">
          <label class="form-check-label text-light">
            <h6>Tipo Acesso :</h6>
          </label>
          <select class="form-control custom-select mr-sm-2" name="acesso" id="acesso" required>
          <option value="">Escolher tipo de acesso</option>
            <option class="form-control" value="1">Admin</option>
            <option class="form-control" value="2">Paciente</option>
            <option class="form-control" value="3">Medico</option>
            <option class="form-control" value="4">funcionario</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="col-12 py-3">
          <input class="btn btn-primary btn-sm" name="submit" type="submit" value="Inserir">
          <input class="btn btn-primary btn-sm" name="limpar" type="button" value="Limpar">
        </div>
      </div>
    </form>
    <div class="text-danger">&nbsp;<?php echo $error;?></div>
  </div>

<?php
}
?>