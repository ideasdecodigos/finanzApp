
    <script src="../js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="../src/sweetAlert2/sweetalert2.min.css">
    <script src="../src/sweetAlert2/sweetalert2.all.min.js"></script> 
    <?php $information="";
    
 if(isset($_POST['registros'])){
     include ("../svr/connection.php");
     $date1= mysqli_real_escape_string($con_app,date("Y-m-d 00:00:00",strtotime($_POST['fecha1'])));    
     $date2= mysqli_real_escape_string($con_app,date("Y-m-d 23:59:59",strtotime($_POST['fecha2'])));    
     $moneda = mysqli_real_escape_string($con_app,$_POST["moneda"]);    
     $iduser = mysqli_real_escape_string($con_app,$_POST["idusuario"]); 
      
     date_default_timezone_set('America/St_Thomas');
     $fechaAuxiliar=date("l, M j",strtotime("08-04-2010 22:15:00"));//SE UTILIZA PARA AGRUPAR LAS REGISTROS POR FECHAS

  
     $res = mysqli_query($con_app,"SELECT * FROM registros WHERE fecha>='$date1' AND fecha<='$date2' AND usuario='$iduser' ORDER BY fecha");
     
//      $res = mysqli_query($con_app,"SELECT COUNT(idregistro) AS registros,
//    (SELECT COUNT(tipo) FROM registros WHERE usuario='$iduser' AND categoria='ingreso' AND tipo='credito' AND fecha LIKE '$fecha1%')AS creditos,
//    (SELECT COUNT(tipo) FROM registros WHERE usuario='$iduser' AND categoria='gasto' AND tipo='inversiones' AND fecha LIKE '$fecha1%')AS inversiones,
//    (SELECT COUNT(tipo) FROM registros WHERE usuario='$iduser' AND categoria='ingreso' AND tipo='fijo' AND fecha LIKE '$fecha1%')AS ingresoFijo,
//    (SELECT COUNT(tipo) FROM registros WHERE usuario='$iduser' AND categoria='ingreso' AND tipo='corriente' AND fecha LIKE '$fecha1%')AS ingresoCorriente,
//    (SELECT COUNT(tipo) FROM registros WHERE usuario='$iduser' AND categoria='gasto' AND tipo='fijo')AS gastoFijo,
//    (SELECT COUNT(tipo) FROM registros WHERE usuario='$iduser' AND categoria='gasto' AND tipo='corriente' AND fecha LIKE '$fecha1%')AS gastoCorriente,
//    (SELECT SUM(valor) FROM registros WHERE usuario='$iduser' AND categoria='ingreso' AND fecha LIKE '$fecha1%')AS ingresos,
//    (SELECT SUM(valor) FROM registros WHERE usuario='$iduser' AND categoria='gasto' AND fecha LIKE '$fecha1%')AS gastos
//    FROM registros WHERE usuario='$iduser' AND fecha LIKE '$fecha1%'"); 
     
     if(mysqli_num_rows($res) > 0 ){    ?>
<div id="divInforme">
    <table>
        <thead>
            <tr>
                <th>Concepto</th>
                <th> Ingresos </th>
                <th> Gastos </th>
                <th class="icon-information"></th>
            </tr>
        </thead>

        <tbody>
            <?php     
         $ingresos=0; $gastos=0; $creditos=0; $inversiones=0; $cantidad_inversiones=0; $cantidad_creditos=0; 
         $ing_fijo=0; $ing_corrt=0; $gst_fijo=0; $gst_corrt=0;
            while($fila=mysqli_fetch_array($res)){
                          
             $information = "<span>".ucfirst($fila['categoria'])."-".$fila['tipo']."</span><br><span>Concepto: ".$fila['concepto']."</span><br><span>".date("l, M j, Y H:ma",strtotime($fila['fecha']))."</span><br>"; 
            
                //FORMATE LA FECHA, EJEMPLO: SUNDAY 5 DEC*****************************
        $fechasGrabadas=date("l, M j",strtotime($fila['fecha']));
            //MUESTRA UNA UNICA FECHA POR DIAS            
         if($fechasGrabadas != $fechaAuxiliar){ 
             echo "<tr> 
                    <th colspan='4' class='th icon-calendar' style='text-align:center'> 
                        <font color=''>$fechasGrabadas</font>
                    </th>
                  </tr>"; 
            $fechaAuxiliar=$fechasGrabadas; 
         }    ?>  
                         
            <tr>
                <?php 
                $editDate = date("Y-m-d",strtotime($fila['fecha']))."T".date("H:i",strtotime($fila['fecha']));
                               
                //MUESTRA LOS INGRESOS
                if($fila['categoria']=="ingreso"){
                    echo "<td>".$fila['concepto']."</td>"; 
                    echo "<td style='color:".($fila['tipo']=="credito" ? "dodgerblue" : "darkgreen")."'>".$fila['valor']." $moneda</td>";
                    echo "<td></td>";
                    echo "<td><span onclick=\"info('$information','".$fila['idregistro']."','".$fila['valor']."','".$fila['categoria']."','".$fila['tipo']."','".$fila['concepto']."','$editDate');\" class='icon-confi'></span></td>";
                    //SUMA LOS INGRESOS
                    $ingresos += $fila['valor'];
                    //CUENTA LOS TIPOS DE INGRESOS 
                    if($fila['tipo']=="fijo"){
                        $ing_fijo++;
                    }elseif($fila['tipo']=="corriente"){
                        $ing_corrt++;
                    }
                }
                //MUESTRA LOS GASTOS
                if($fila['categoria']=="gasto"){
                    echo "<td>".$fila['concepto']."</td>";
                    echo "<td></td>";
                    echo "<td style='color:".($fila['tipo']=="inversiones" ? "darkorange" : "red")."'>".$fila['valor']." $moneda</td>";
                    echo "<td><span  class='icon-confi' onclick=\"info('$information','".$fila['idregistro']."','".$fila['valor']."','".$fila['categoria']."','".$fila['tipo']."','".$fila['concepto']."','$editDate');\"></span></td>";
                    //SUMA LOS GASTOS
                    $gastos += $fila['valor'];
                    //CUENTA LOS TIPOS DE GASTOS
                    if($fila['tipo']=="fijo"){
                        $gst_fijo++;
                    }elseif($fila['tipo']=="corriente"){
                        $gst_corrt++;
                    }
               
            } 
                //MUESTRA LOS ACTIVOS
                if($fila['tipo']=="inversiones"){
                    $inversiones += $fila['valor'];//SUMA LOS ACTIVOS
                    $cantidad_inversiones++; //CUENTA LOS ACTIVOS
                }
                //MUESTRA LOS CREDITOS
                if($fila['tipo']=="credito"){
                    $creditos += $fila['valor'];  //SUMA LOS CREDITOS   
                    $cantidad_creditos++;        //CUENTA LOS CEDITOS
                }   ?> 
            </tr>

            <?php } ?>
        </tbody>
    </table>
      <br><br>
       <table>
        <tfoot>
          
            <tr> 
                <th colspan='4'>Sub-Totales</th>
            </tr>
                <?php 
//                echo "<tr><th colspan='2'>Ingresos:</th> <th colspan='2'>Gastos: </th></tr>";
                echo "<tr><td colspan='2'>Ingresos: $ingresos $moneda</td> <td colspan='2' style='color:red'>Gastos: $gastos $moneda</td></tr>";
                echo "<tr><td colspan='2'>($ing_corrt)Corrientes</td> <td colspan='2' style='color:red'>($gst_corrt)Corrientes</td></tr>";
                echo "<tr><td colspan='2'>($ing_fijo)Fijos</td> <td colspan='2' style='color:red'>($gst_fijo)Fijos</td></tr>";  
         
        ?>
           
             <tr>
                <td colspan='4'></td>
            </tr>
               <tr>
                <th colspan='4'>Totales</th>
            </tr>
                <?php 
                echo "<tr><td colspan='4'>($cantidad_inversiones)Inverciones: $inversiones $moneda</td></tr>";
                echo "<tr><td colspan='4' style='color:red'>($cantidad_creditos)Deudas: $creditos $moneda</td></tr>";
                
                $capital = $ingresos - $gastos;
                $patrimonio = $capital + $inversiones - $creditos;
                $ahorros = ($capital) + $creditos + $creditos;                   
                
            ?> 
                
           <tr>
                <th colspan='4'>Totales Neto</th>
            </tr>
               <?php
                echo "<tr><td colspan='4'>Presuspuesto: $ahorros $moneda</td></tr>";                
                echo "<tr><td colspan='4'>Patrimonio: $patrimonio $moneda</td></tr>";
                echo "<tr><td colspan='4' style='font-weight:bold'>Capital: $capital $moneda</td></tr>";
            ?>
           
        </tfoot>
    </table>
</div>

<div id="alertas"></div>
<br><br><br><br><br><br><br><br><br><br>
<script>
    function info(data, id,valor,categoria,tipo,concepto,fecha) {
        let style='display:grid;gap:3px;text-align:left;color:blue;width:80%;margin:auto;';
        Swal.fire({
            title: "ID"+id,
            html: data,
            icon: 'info',
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: 'Editar',
            denyButtonText: 'Eliminar',
            cancelButtonText: 'Cerrar'
        }).then((result) => {
            if (result.isConfirmed) {//BOTON EDITAR
                Swal.fire({
                    title: 'Editar',
                    html: '<form id="editRegistro" style="'+style+'"><input type="hidden" name="idregistro" value="'+id+'"><label>Valor</label><input type="number" name="valor" value="'+valor+'" placeholder="Valor" required> <label>Categoria</label><select name="categoria"><option value="'+categoria+'">'+categoria+'</option><option value="ingreso">ingreso</option><option value="gasto">gasto</option></select> <label>Tipo</label><select name="tipo"><option value="'+tipo+'">'+tipo+'</option><option value="fijo">fijo</option><option value="corriente">corriente</option><option value="inversiones">inversiones</option><option value="credito">credito</option></select> <label>Concepto</label><input type="text" name="concepto" value="'+concepto+'" placeholder="Concepto" required> <label>Fecha</label><input type="datetime-local" name="fecha" value="'+fecha+'" required><input type="hidden" name="editar"></form>',
                    icon: 'warning', 
                    showCancelButton: true,
                    confirmButtonText: 'Editar',
                    cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {//ENVIAR LOS DATOS A EDITAR
                    $.ajax({
                        type: 'post',
                        url: '../svr/entradas.php',
                        data: $('#editRegistro').serialize(),
                        success: function(data) {
                            $('#alertas').html(data);
                        }
                    });
                }
        });
            }else if (result.isDenied) {//BOTON ELIMINAR
                delRegistro(id);
            }
        });
    }
//ELIMINA LOS REGISTROS
    function delRegistro(id) {
        Swal.fire({
            title: '',
            text: 'Al hacer clic en aceptar, se eliminará el registro seleccionado. ¿Seguro que deseas eliminarlo?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: '../svr/entradas.php',
                    data: {
                        delete: id
                    },
                    success: function(data) {
                        $('#alertas').html(data);
                    }
                });
            }
        });
    }
</script>
<?php 
 }}
  ?>
