<?php 
//VARIAVEL PARA GUARDAR MSG ERRO
$error=''; 

//VARIAVEIS PARA GUARDAR AS PÁGINAS
$_p1=md5('1');

  

//INSERIR  ESPECIALIDADE
if (isset($_POST['submit'])) 
{
  if (empty($_POST['descricao'])) 
  {
  $error = "Tem de preencher a descricao";
  }
  else
  {
    $descricao=$_POST['descricao'];
   
    $query0 = "SELECT descricao FROM especialidades where descricao='$descricao'";
    $result = mysqli_query($_CONNECTION,$query0) or die('Query falhou: ' . mysqli_error());
    $row = mysqli_fetch_array($result);
    if(!empty($row['descricao']))
    {
      $error = " Essa especialidade já existe.";
    }
    else
    {
      $query  = "INSERT INTO especialidades(descricao, estado) VALUES ('$descricao', 'S')";
      if(mysqli_query($_CONNECTION,$query)){
      }else{
        $error = "Error: " . $query . "<br>" . $_CONNECTION->error;
      }
    }
  }
}

// ATIVAR, DESATIVAR ESPECIALIDADE
if (isset($_POST['desativar'])) 
{
  $id_esp=$_POST['id_esp'];
  $_ESTADO=$_POST['desativar'];
  $query = "UPDATE especialidades SET estado='$_ESTADO' WHERE id_esp=$id_esp";
  if(mysqli_query($_CONNECTION,$query)){
  }else{
    $error = "Error: " . $query . "<br>" . $_CONNECTION->error;
  }
}

//APAGAR ESPECIALIDADE
if (isset($_POST['apagar']))
{
  $id_esp=$_POST['id_esp'];
  $query  = "DELETE FROM especialidades WHERE id_esp = $id_esp";
  if (mysqli_query($_CONNECTION,$query)) {
  } else {
  echo "Error: " . $query . "<br>" . $_CONNECTION->error;
  }
}

//UPDATE ESPECIALIDADE
if (isset($_POST['reset'])) 
{
  if (isset($_POST['submit2'])) 
  {
          $id_esp=$_POST['id_esp'];
          $descricao=$_POST['descricao'];
          $_ACESSO=$_POST['acesso'];
     
          $query = "UPDATE especialidades SET descricao='$descricao' , acesso='$_ACESSO' WHERE id_esp=$id_esp";
          if(mysqli_query($_CONNECTION,$query)){
          }
          else
          {
            $error = "Error: " . $query . "<br>" . $_CONNECTION->error;
          }
   
  }
}
?>

<section class="page-section">
  <?php
if (isset($_GET['p'])) 
{
//LISTAR  ESPECIALIDADE
$query = 'SELECT id_esp,descricao,estado FROM especialidades order by id_esp asc';
$result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());

     echo "<div class=\"container text-light\"><div class=\"row\"><div class=\"col text-primary\">Id</div><div class=\"col-2 mx-auto text-primary\">Especialidade</div><div class=\"col-9 text-primary\"></div></div>";
     while ($linha = mysqli_fetch_array($result, MYSQL_ASSOC)) 
     {
      $id_esp = $linha['id_esp'];
      echo "<div class=\"row py-2\">";
       foreach ($linha as $col_valor) 
       { 
        if($col_valor!=$linha['estado'])
        {
          if($col_valor==$linha['descricao'])
         {
           echo "<div class=\"col-2\">$col_valor</div>";
         }else{
          echo "<div class=\"col\">$col_valor</div>"; 
         }
        } 
       }
       // LINKS COM VARIAVEIS HIDDEN
        if ($linha['estado']=='S') //BOTÃO ON OFF
        {
         $_DESATIVAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_esp\" value=\"$id_esp\"><input type=\"hidden\" name=\"desativar\" value=\"N\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-success btn-sm\" onClick=\"submit();\">On</button></form>"; 
        }
        else
        {
         $_DESATIVAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_esp\" value=\"$id_esp\"><input type=\"hidden\" name=\"desativar\" value=\"S\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-danger btn-sm\" onClick=\"submit();\">Off</button></form>";  
        }
       $_APAGAR="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_esp\" value=\"$id_esp\"><input type=\"hidden\" name=\"apagar\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-danger btn-sm\" onClick=\"submit();\">Del</button></form>";
       $_RESET="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_esp\" value=\"$id_esp\"><input type=\"hidden\" name=\"reset\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit2();\">Update</button></form>";
       $_VER="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_esp\" value=\"$id_esp\"><input type=\"hidden\" name=\"ver\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit();\">Ver</button></form>";
       echo "<div class=\"col-sm\"></div><div class=\"col-2\">$_DESATIVAR</div><div class=\"col-2\">$_APAGAR</div><div class=\"col-2\">$_RESET</div><div class=\"col-2\">$_VER</div></div>";
     }
     echo "</div>";  
     //LIBERTAR MEMÓRIA
     mysqli_free_result($result);
     }
?>

</section>
<!--VISUALIZAR ESPECIALIDADE-->
<?php 
if (isset($_POST['ver'])) 
{
  $id_esp=$_POST['id_esp'];
  $query = "SELECT * FROM especialidades where id_esp = '$id_esp'";
  $result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
  $row = mysqli_fetch_array($result);
?>
<div class="container form-group rounded mx-auto d-block border border-light">
  <h5 class="text-primary text-center">Visualizar Especialidade</h5>
  <div class="container">
    <div class="row">
      <div class="col text-white">
        <h6>Id:</h6>
      </div>
      <div class="col text-warning float-right"><?php echo $row['id_esp'];?></div>
    </div>
    <div class="row">
      <div class="col text-white">
        <h6>Especialidade:</h6>
      </div>
      <div class="col  text-warning float-right "><?php echo $row['descricao'];?></div>
    </div>
    <div class="row">
      <div class="col text-white">
        <h6>Estado:</h6>
      </div>
      <div class="col text-warning float-right"><?php echo $row['estado'];?></div>
    </div>

  </div>
</div>

<!-- FORMULARIO UPDATE ESPECIALIDADE-->
<?php
}
else if(isset($_POST['reset']))
{
$id_esp=$_POST['id_esp'];
$query = "SELECT * FROM especialidades where id_esp = '$id_esp'";
$result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
$row = mysqli_fetch_array($result);
?>

<div class="container form-group rounded mx-auto d-block border border-light">
  <h5 class="text-primary text-center">Update Especialidade</h5>
  <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_esp" value="<?php echo $row['id_esp'];?>">
    <input type="hidden" name="reset" value="1">
    <input type="hidden" name="p" value="<?php echo $_p1;?>">
    <div class="form-row">
      <div class="col-12">
        <label class="form-check-label text-light">
          <h6>Utilizador :</h6>
        </label>
        <input class="form-control" name="descricao" type="text" value="<?php echo $row['descricao'];?>">
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

<!-- FORMULARIO CRIAR ESPECIALIDADE-->
<?php
}else{
?>
<div class="container form-group rounded mx-auto d-block border border-light">
  <h5 class="text-primary text-center">Criar Especialidade</h5>
  <form action="" method="post" enctype="multipart/form-data">
    <div class="form-row">
      <div class="col-12">
        <label class="form-check-label text-light" for="validationDefaultUsername">
          <h6>Especialidade :</h6>
        </label>
        <input class="form-control" id="validationDefaultUsername" name="descricao" type="text"
          aria-describedby="inputGroupPrepend2" required>
      </div>
    </div>
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