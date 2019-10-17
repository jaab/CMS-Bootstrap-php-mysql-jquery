
        <?php 
         include('bd/acesso_bd.php'); 
      if(isset($_POST["id_medico"]))  
      { 
        $id_medico=$_POST["id_medico"];
        
        $today = date("n-j-Y"); 
           // fazer um count das horas disponiveis no query para cada medico
          $query_pick = "SELECT data_consulta,hora_consulta FROM consultas WHERE id_medico='$id_medico' and data_consulta>'$today'"; 
          $result_pick = mysqli_query($_CONNECTION,$query_pick) or die('Query falhou: ' . mysqli_error());
          $d=0;
          while ($linha_pick = mysqli_fetch_array($result_pick, MYSQL_ASSOC)) 
          {
          $data_consulta[$d] = '"'.$linha_pick['data_consulta'].'",';
          $hora_consulta[$d] = $linha_pick['hora_consulta'];
           
         // $query2_pick = "SELECT hora_consulta FROM consultas WHERE data_consulta='".$linha_pick['data_consulta']."'";   
         // $result2_pick = mysqli_query($_CONNECTION,$query2_pick) or die('Query falhou: ' . mysqli_error());
         // $row2_pick=$linha2_pick = mysqli_fetch_array($result2_pick, MYSQL_ASSOC);

          //$hora_consulta[$d] = $row2_pick['hora_consulta'];

          $d++;
          $str = implode("", $data_consulta);
          $str2 = implode("", $hora_consulta);
            
          $dd[$d]  =$linha_pick['data_consulta']."|".$linha_pick['hora_consulta'];
         
          } 
         //$dd =$str.$str2;
        // echo "$dd<br>";
       // print_r($dd);
          echo "<br>";
          if(!empty($str)){
          
            $str_d=$str;
            
           }else{
            $str_d='';
           }
           
           if(!empty($str)){
           //$horas=array('10:00','11:00');
            $horas=array('8:00','9:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00','22:00');
            $horas_d = array_diff($horas, $hora_consulta);
          // echo "horas:$str2<br>";
           // print_r($horas_d);

          // echo "<br>datas:$str_d";
           }
       }
          ?>
          
          <script>
          /** Dias que já tem marcações */
          var disableddates = [];
          function DisableSpecificDates(date) {
          var m = date.getMonth();
          var d = date.getDate();
          var y = date.getFullYear();

          // converte a data no formato mm-dd-yyyy
          // incremente o contador do mes em + 1
          var currentdate = (m + 1) + '-' + d + '-' + y ;
          // verifica se as datas estão no array para serem desativadas
          for (var i = 0; i < disableddates.length; i++) {
          // verifica se a data corrente esta no array de datas a serem desativadas 
          if ($.inArray(currentdate, disableddates) != -1 ) {
          return [false];
          } 
          }
          // se a data não estiver no array, verifica se esta nos fins de semana. 
          // então utiliza a função noWeekends
          var weekenddate = $.datepicker.noWeekends(date);
          return weekenddate; 
          }
          $(function() {
          $( "#datepicker" ).datepicker(
          {
          beforeShowDay: DisableSpecificDates , minDate: 0 , dateFormat: 'm-dd-yy'
          });
          });
          </script> 
          <table class="table-sm w-100">
            <tr><td>
            <label class="form-check-label text-light">
            <h6>Data :</h6>
        </label>
          <input class="form-control" type="text" id="datepicker" placeholder="Datas disponiveis"  name="data_consulta" required> 
          </td>
          <td>
        <label class="form-check-label text-light">
            <h6>Hora :</h6>
        </label>
        <select class="form-control custom-select mr-sm-2" name="hora_consulta" id="hora_consulta" required>
            <option value="" disabled selected>Horas Disponiveis</option>
            <option class="form-control" value="8:00">8:00</option>
            <option class="form-control" value="9:00">9:00</option>
            <option class="form-control" value="10:00">10:00</option>
            <option class="form-control" value="11:00">11:00</option>
            <option class="form-control" value="12:00">12:00</option>
            <option class="form-control" value="13:00">13:00</option>
            <option class="form-control" value="14:00">14:00</option>
            <option class="form-control" value="15:00">15:00</option>
            <option class="form-control" value="16:00">16:00</option>
            <option class="form-control" value="17:00">17:00</option>
            <option class="form-control" value="18:00">18:00</option>
            <option class="form-control" value="19:00">19:00</option>
            <option class="form-control" value="20:00">20:00</option>
            <option class="form-control" value="21:00">21:00</option>
            <option class="form-control" value="22:00">22:00</option>
        </select>
        </td></tr></table>
   
