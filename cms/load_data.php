<label class="form-check-label text-light">
<h6>Medico :</h6>
</label>
<select class="form-control custom-select mr-sm-2" name="id_medico" id="id_medico" required>
<option value="">Selecionar medico</option>
 <?php  
 //INCLUSÃO DA LIGAÇÃO À BASE DADOS
 include('bd/acesso_bd.php'); 
 //$output = '';  
 if(isset($_POST["id_esp"]))  
 {  
      if($_POST["id_esp"] != '')  
      {  
        
      $sql = "SELECT id_medico FROM med_esp WHERE id_esp = '".$_POST["id_esp"]."'";  
          
      }  
      else  
      {  
           $sql = "SELECT * FROM med_esp";  
      }  
      $result = mysqli_query($_CONNECTION, $sql);  
      while($row = mysqli_fetch_array($result))  
      {  
       $id_medico=$row["id_medico"];

       $query_3 = "SELECT nome_medico FROM medicos  where id_medico='$id_medico'";
       $result_3 = mysqli_query($_CONNECTION,$query_3) or die('Query falhou: ' . mysqli_error());
       $row_3 = mysqli_fetch_array($result_3);
       $medico = $row_3['nome_medico'];

       $output .="<option class=\"form-control\" value=\"$id_medico\">$medico</option>";
      }  
      echo $output;  
 }  
 ?> 
  </select>

  <script>
     $(document).ready(function() {
        $('#id_medico').change(function() {
            var id_medico = $(this).val();
             //alert(id_medico);
            $.ajax({
                url: "data.php",
                method: "POST",
                data: {
                    id_medico: id_medico
                },
                success: function(data) {
                    $('#show_idmedico').html(data);
                   
                }
            });
        });
    });
</script>

