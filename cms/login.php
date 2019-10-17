<?php

// INICIO DE SESSÃO
session_start();

//setcookie('contador','$total_visitas', time() +3600);

//VARIAVEL PARA GUARDAR MSG ERRO
$error=''; 
$error2=''; 

//INCLUSÃO DA LIGAÇÃO À BASE DADOS
include('bd/acesso_bd.php'); 

//LOGIN
if (isset($_POST['submit'])) 
{
    if (empty($_POST['username']) || empty($_POST['password'])) 
    {
    $error = "Username ou Password invalidos";
    }
    else
    {
      $captcha2=$_SESSION['codigo'];
//echo $captcha2 ;
    $username=$_POST['username'];
    $password=$_POST['password'];
    $captcha=$_POST['codigo'];

    // PROTECÇÃO CONTRA MYSQL INJECTION
    $username = stripslashes($username);
    $password = stripslashes($password);
    $username = mysqli_real_escape_string($_CONNECTION,$username);
    $password = mysqli_real_escape_string($_CONNECTION,$password);
    // INCRIPTA A PASSWORD
    $password = md5($password);

 
        //verificar se captcha esta correcto
    if($captcha==$captcha2)
     {
    // SQL QUERY PARA LISTAR UTILIZADORES REGISTADOS ATIVOS E ENCONTRAR CORRESPONDENCIA
    $query = mysqli_query($_CONNECTION,"select * from login where password='$password' AND username='$username' AND estado='S'");
    $rows = mysqli_num_rows($query);
        if ($rows == 1) 
        {
        //INICIO DE SESSÃO 
        $_SESSION['login_user']=$username; 
        // REDIRECCIONA PARA A PAGINA PROFILE.PHP
        $_pag=md5('1');
        header("location: profile.php?p=$_pag");
        } 
      
        else 
        {
        $error = "Username ou Password invalidos ou utilizador suspenso";
        }
      }
    // FECHA LIGAÇÃO À BASE DADOS
    mysqli_close($_CONNECTION );
    }
}



//REGISTAR UTILIZADOR
if (isset($_POST['submit2'])) 
{
    
    $username=$_POST['username'];
    $password=$_POST['password'];
    $_NIF=$_POST['nif'];
    $_EMAIL_USER=$_POST['email_user'];
    $_TERMOS=$_POST['termos'];

    // PROTECÇÃO CONTRA MYSQL INJECTION
    $username = stripslashes($username);
    $password = stripslashes($password);
    $username = mysqli_real_escape_string($_CONNECTION,$username);
    $password = mysqli_real_escape_string($_CONNECTION,$password);
    // INCRIPTA A PASSWORD
    $password = md5($password);

    $query0 = "SELECT username,email_user FROM login where username='$username' or email_user='$_EMAIL_USER'";
    $result = mysqli_query($_CONNECTION,$query0) or die('Query falhou: ' . mysqli_error());
    $row = mysqli_fetch_array($result);
    if(!empty($row['username'] || $row['email_user']))
    {
      $error = " Esse utilizador já existe ou email já registado.";
    }
    else
    {
        //SQL QUERY PARA REGISTAR UTILIZADORES
        $query_1= "INSERT INTO pacientes(nif, estado) VALUES ('$_NIF', 'S')";
        mysqli_query($_CONNECTION,$query_1);
        $query  = "INSERT INTO login(username, password, acesso, estado, email_user, nif,termos) VALUES ('$username', '$password', '2', 'S', '$_EMAIL_USER', '$_NIF', '$_TERMOS')";
      
      //INICIO DE SESSÃO 
       $_SESSION['login_user']=$username; 
       // REDIRECCIONA PARA A PAGINA PROFILE.PHP
       $_pag=md5('1');
       header("location: profile.php?p=$_pag");
      if(mysqli_query($_CONNECTION,$query)){
      }else{
        $error = "Error: " . $query . "<br>" . $_CONNECTION->error;
      }
    }

    // FECHA LIGAÇÃO À BASE DADOS
    mysqli_close($_CONNECTION );
  
}

//RECUPERAÇÃO DE PASSWORD
if (isset($_POST['submit3'])) 
{
    $_EMAIL_USER=$_POST['email_user'];

    // PROTECÇÃO CONTRA MYSQL INJECTION
    $_EMAIL_USER = stripslashes($_EMAIL_USER);
    $_EMAIL_USER = mysqli_real_escape_string($_CONNECTION,$_EMAIL_USER);
 

    $query0 = "SELECT username,password,email_user FROM login where email_user='$_EMAIL_USER'";
    $result = mysqli_query($_CONNECTION,$query0) or die('Query falhou: ' . mysqli_error());
    $row = mysqli_fetch_array($result);
    if(empty($row['email_user']))
    {
      $error = "O  email inserido não está registado.";
    }
    else
    {
        $_EMAIL=$row['email_user'];
        $_USERNAME=$row['username'];
        $_pag=md5('2');

     
        $msg = "Caro $_USERNAME,\n\n\t<br> Clique no link a seguir para fazer o reset à password: <a href=\"$_URL_CMS?p=$_pag&u=$_USERNAME\">reset password</a> \n\n\t<br> Bem haja \n\n\t<br>Username: $_USERNAME";
        
        // Envio de email
        $headers =  'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'From: Clinica Admin <player@viseu.tv>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        mail("$_EMAIL","Recuperação de Password - $_USERNAME",$msg,$headers);
     
        $error = "<span class=\"text-info\">Caro $_USERNAME verifique o $_EMAIL ,foi enviado um link de recuperação.</span>";
   
      if(mysqli_query($_CONNECTION,$query0)){
      }else{
        $error = "Error: " . $query . "<br>" . $_CONNECTION->error;
      }
    }

    // FECHA LIGAÇÃO À BASE DADOS
    mysqli_close($_CONNECTION );
  
}

//REGISTAR UTILIZADOR
if (isset($_POST['submit4'])) 
{
    
    $username=$_POST['username'];
    $password=$_POST['password'];
    

    // PROTECÇÃO CONTRA MYSQL INJECTION
    $username = stripslashes($username);
    $password = stripslashes($password);
    $username = mysqli_real_escape_string($_CONNECTION,$username);
    $password = mysqli_real_escape_string($_CONNECTION,$password);
    // INCRIPTA A PASSWORD
    $password = md5($password);

        //SQL QUERY PARA RECUPERAR PASSWORD
        $query = "UPDATE login SET password='$password'  WHERE username='$username'";
       //INICIO DE SESSÃO 
       $_SESSION['login_user']=$username; 

       echo "<script>$('#thankyouModal').modal('show');</script>";
       echo"<div class=\"modal fade\" id=\"thankyouModal\" tabindex=\"-1\" role=\"dialog\">";
       echo" <div class=\"modal-dialog\">";
       echo" <div class=\"modal-content\">";
       echo" <div class=\"modal-header\">";
       echo" <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>";
       echo"<h4 class=\"modal-title\" id=\"myModalLabel\">A sua password foi alterada com sucesso,vai ser rederecionado para o login!</h4>";
       echo"</div>";
      
       
       // REDIRECCIONA PARA A PAGINA INDEX.PHP
       header("location: index.php");
      if(mysqli_query($_CONNECTION,$query)){
      }else{
        $error = "Error: " . $query . "<br>" . $_CONNECTION->error;
      }

    // FECHA LIGAÇÃO À BASE DADOS
    mysqli_close($_CONNECTION );
  
}

//FORMULARIO CONTACTO
if (isset($_POST['contacto'])) 
{
    $_EMAIL=$_POST['email'];
    $_NOME=$_POST['nome'];
    $_OBSERVACOES=$_POST['observacoes'];

    $msg = "Nome:\t$_NOME\n\n\t<br>Email:\t$_EMAIL\n\n\t<br>Observações:\t$_OBSERVACOES";
    
    // Envio de email
    $headers =  'MIME-Version: 1.0' . "\r\n"; 
    $headers .= 'From: Clinica Admin <player@viseu.tv>' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    mail("jabatista@msn.com","MY DNM - CONTACTO",$msg,$headers);

    $error = "<span class=\"text-info\">Obrigado, brevemente entraremos em contacto!</span>";
}
?>
