<?php 
//VARIAVEL PARA GUARDAR MSG ERRO
$error=''; 

//VARIAVEIS PARA GUARDAR AS PÁGINAS
$_p1=md5('1');



?>
<section  class="page-section">

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


              $query_1 = "SELECT nome_paciente,nif ,foto FROM pacientes  where id_paciente='$id_paciente'";
              $result_1 = mysqli_query($_CONNECTION,$query_1) or die('Query falhou: ' . mysqli_error());
              $row_1 = mysqli_fetch_array($result_1);
              $nome_paciente=$row_1['nome_paciente'];
              $foto=$row_1['foto'];
              $nif=$row_1['nif'];
              $query_n = "SELECT username FROM login where nif='$nif'";
              $result_n = mysqli_query($_CONNECTION,$query_n) or die('Query falhou: ' . mysqli_error());
              $row_n = mysqli_fetch_array($result_n);
              $username=$row_n['username'];


              $dir = "$_PATH_UPLOADS_PACIENTES$username";
              if(!empty($row_1['foto'])){
              $foto=$dir.'/'.$row_1['foto'];
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
            <?php
            $query_0c = mysqli_query($_CONNECTION,"select * from prescricao where id_consulta='$id_consulta'");
            $rows2c = mysqli_num_rows($query_0c);
            
            if ($rows2c!=0) 
            {
            ?>
            <div class="row">
              <div class="col-2 text-white">
                <h6>Prescrição:</h6>
              </div>
              <div class="col-5  text-warning float-right"><?php echo "$prescricao - $observacoes;"?></div>
              <div class="col-5  text-info float-right">&nbsp;</div>
            </div>
            <?php 
            }
            ?>
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
  $query_0 = "SELECT nif FROM login where username='$login_session'";
  $result_0 = mysqli_query($_CONNECTION,$query_0) or die('Query falhou: ' . mysqli_error());
  $row_0 = mysqli_fetch_array($result_0);

    $nif=$row_0['nif'];

    $query = "SELECT * FROM pacientes where nif = '$nif'";
    $result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
    $row = mysqli_fetch_array($result);
    $id_paciente=$row['id_paciente'];
    $nome_paciente=$row['nome_paciente'];

      // MOSTRAR PRESCRICAO
      if (isset($_POST['prescricao2'])) 
      {
        $prescricao=$_POST['prescricao_p'];
        $observacoes=$_POST['observacoes'];
        
        echo" <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>
        <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js\"></script>
       <div class=\"container\"><div class=\"alert alert-success alert-dismissible\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
       <strong> Prescrição:&nbsp;$prescricao <br> Observações:&nbsp;$observacoes</strong>
       </div></div>";
      }

?>

    <div class="container form-group rounded mx-auto d-block border border-light">
    <h5 class="text-light text-center">Histórico de Consultas</h5>
      <div class="form-row">
      <div class="col-12">
        
        <?php 
        $horaagora= date("H:i");
        //echo $horaagora;
        $today = date("n-j-Y"); 
        //echo $today;
         $query = "SELECT * FROM  consultas  where id_paciente='$id_paciente' and data_consulta<'$today' order by data_consulta desc";
         $result = mysqli_query($_CONNECTION,$query) or die('Query falhou: ' . mysqli_error());
         echo "<div class=\"container text-light\"><div class=\"row\"><div class=\"col text-primary\">Id</div><div class=\"col-3 text-primary\">Médico</div><div class=\"col-2 text-primary\">Especialidade</div><div class=\"col-2 text-primary\">Data</div><div class=\"col text-primary\">Hora</div><div class=\"col text-primary\"></div><div class=\"col text-primary\"></div><div class=\"col text-primary\"></div></div>";
      
         // IMPRIME AS CONSULTAS PARA PACIENTE
       while ($linha = mysqli_fetch_array($result, MYSQL_ASSOC)) 
       {
        $id_consulta = $linha['id_consulta'];
        $id_medico = $linha['id_medico'];
        $data_consulta = $linha['data_consulta'];
        $hora_consulta = $linha['hora_consulta'];
        $id_esp=$linha['id_esp'];
        $internamento = $linha['internamento'];

        $query_0 = "SELECT descricao FROM especialidades  where id_esp='$id_esp'";
        $result2 = mysqli_query($_CONNECTION,$query_0) or die('Query falhou: ' . mysqli_error());
         $row2 = mysqli_fetch_array($result2);
         $descricao = $row2['descricao'];

         $query_1 = "SELECT nome_medico FROM medicos  where id_medico='$id_medico'";
         $result_1 = mysqli_query($_CONNECTION,$query_1) or die('Query falhou: ' . mysqli_error());
          $row_1 = mysqli_fetch_array($result_1);
          $nome_medico = $row_1['nome_medico'];

          $query_2 = "SELECT * FROM prescricao  where id_consulta='$id_consulta'";
          $result_2 = mysqli_query($_CONNECTION,$query_2) or die('Query falhou: ' . mysqli_error());
          $row_2 = mysqli_fetch_array($result_2);
          $prescricao = $row_2['prescricao'];
          $observacoes = $row_2['observacoes'];


        echo "<div class=\"row py-2\">";
        echo "<div class=\"col\">$id_consulta</div><div class=\"col-3\">$nome_medico</div><div class=\"col-2\">$descricao</div><div class=\"col-2\">$data_consulta</div><div class=\"col\">$hora_consulta</div>";

        // LINKS COM VARIAVEIS HIDDEN
        $_PRESCRICAO="<form action=\"\" method=\"post\"><button class=\"btn btn-danger btn-sm\" onClick=\"submit();\">Pre</button></form>"; 
        $_PRESCRICAO2="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"prescricao_p\" value=\"$prescricao\"><input type=\"hidden\" name=\"observacoes\" value=\"$observacoes\"><input type=\"hidden\" name=\"prescricao2\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-success btn-sm\" onClick=\"submit();\">Pre</button></form>"; 
        $_VER="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"descricao\" value=\"$descricao\"><input type=\"hidden\" name=\"nome_medico\" value=\"$nome_medico\"><input type=\"hidden\" name=\"ver_c\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit2();\">Ver</button></form>";
        $_INTERNAMENTO="<form action=\"\" method=\"post\"><input type=\"hidden\" name=\"id_consulta\" value=\"$id_consulta\"><input type=\"hidden\" name=\"internamento\" value=\"1\"><input type=\"hidden\" name=\"p\" value=\"$_p1\"><button class=\"btn btn-primary btn-sm\" onClick=\"submit2();\">Int</button></form>";
        
        echo "<div class=\"col\">$_VER</div>";
        if(empty($prescricao))
        {
          echo " <div class=\"col\">$_PRESCRICAO</div>";
          switch($internamento)
          {
            case 'N':
            echo "<div class=\"col-2\"><div class=\"progress\"><div class=\"progress-bar bg-secondary\" role=\"progressbar\" style=\"width:100%\" aria-valuenow=\"100\" aria-valuemin=\"0\" aria-valuemax=\"100\">S/Int</div></div></div></div>"; 
            break;
            case 'S':
            echo "<div class=\"col-2\"><div class=\"progress\"><div class=\"progress-bar bg-danger\" role=\"progressbar\" style=\"width:100%\" aria-valuenow=\"100\" aria-valuemin=\"0\" aria-valuemax=\"100\">Int</div></div></div></div>"; 
            break;
            case 'A':
            echo "<div class=\"col-2\"><div class=\"progress\"><div class=\"progress-bar bg-success\" role=\"progressbar\" style=\"width:100%\" aria-valuenow=\"100\" aria-valuemin=\"0\" aria-valuemax=\"100\">Alta</div></div></div></div>"; 
            break;
            default:
          }
          
        }else{
          echo "<div class=\"col\">$_PRESCRICAO2</div>";
          switch($internamento)
          {
            case 'N':
            echo "<div class=\"col-2\"><div class=\"progress\"><div class=\"progress-bar bg-secondary\" role=\"progressbar\" style=\"width:100%\" aria-valuenow=\"100\" aria-valuemin=\"0\" aria-valuemax=\"100\">S/Int</div></div></div></div>"; 
            break;
            case 'S':
            echo "<div class=\"col-2\"><div class=\"progress\"><div class=\"progress-bar bg-danger\" role=\"progressbar\" style=\"width:100%\" aria-valuenow=\"100\" aria-valuemin=\"0\" aria-valuemax=\"100\">Int</div></div></div></div>"; 
            break;
            case 'A':
            echo "<div class=\"col-2\"><div class=\"progress\"><div class=\"progress-bar bg-success\" role=\"progressbar\" style=\"width:100%\" aria-valuenow=\"100\" aria-valuemin=\"0\" aria-valuemax=\"100\">Alta</div></div></div></div>"; 
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


           
   

