<?php 

 function fill_brand($_CONNECTION)  
 {  
    $output='';
    $query_4 = "SELECT distinct id_esp FROM med_esp";
    $result_4 = mysqli_query($_CONNECTION,$query_4) or die('Query falhou: ' . mysqli_error());
    while ($linha = mysqli_fetch_array($result_4, MYSQL_ASSOC)) 
    {
    $id_esp = $linha['id_esp'];
    $query_3 = "SELECT descricao FROM especialidades  where id_esp='$id_esp'";
    $result_3 = mysqli_query($_CONNECTION,$query_3) or die('Query falhou: ' . mysqli_error());
    $row_3 = mysqli_fetch_array($result_3);
    $descricao = $row_3['descricao'];

    $output .="<option class='form-control' value='$id_esp'>$descricao</option>";
    }
    return $output;  

     
 }  
 function fill_product($_CONNECTION)  
 {  
    $output = '';  
    $sql = "SELECT * FROM medicos order by nome_medico ASC";  
    $result = mysqli_query($_CONNECTION, $sql);  
    while($row = mysqli_fetch_array($result))  
    {  
         $output .= '<option value="'.$row["id_medico"].'">'.$row["nome_medico"].'</option>';  
    }  
    return $output;  
 }  
?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<div class="form-row">
    <div class="col-6">
        <label class="form-check-label text-light">
            <h6>Especialidade :</h6>
        </label>
        <select class="form-control custom-select mr-sm-2" name="id_esp" id="especialidade" required>
            <option value="" disabled selected>Selecionar especialidade</option>
            <?php echo fill_brand($_CONNECTION); ?>
        </select>
    </div>
    <div class="col-6"  id="show_product">

    </div>
</div>
<div class="form-row">
         <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
          <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
          <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
      <div class="col-12" id="show_idmedico">
      
     </div>
</div>
<!--Passa aqui a variavel para ir buscar os medicos correspondentes à especialdiade selecionada-->
<script>
    $(document).ready(function() {
        $('#especialidade').change(function() {
            var id_esp = $(this).val();
            //alert(id_esp);
            $.ajax({
                url: "load_data.php",
                method: "POST",
                data: {
                    id_esp: id_esp
                },
                success: function(data) {
                    $('#show_product').html(data);
                   
                }
            });
        });
    });

   /*
   $(document).ready(function() {
        $('#especialidade').change(function() {
            var id_esp = $(this).val();
             alert(id_esp);
            $.ajax({
                url: "data.php",
                method: "POST",
                data: {
                    id_esp: id_esp
                },
                success: function(data) {
                    $('#show_idmedico').html(data);
                   
                }
            });
        });
    });*/
</script>
