<?php 
    
 if(isset($_POST['graficos'])){
   
     include ("../svr/connection.php");
     $fecha1= mysqli_real_escape_string($con_app,date("Y-m-d 00:00:00",strtotime($_POST['fecha1'])));    
     $fecha2= mysqli_real_escape_string($con_app,date("Y-m-d 23:59:59",strtotime($_POST['fecha2'])));    
     $moneda = mysqli_real_escape_string($con_app,$_POST["moneda"]);    
     $iduser = mysqli_real_escape_string($con_app,$_POST["idusuario"]); 
      
    $textoX="Days";
    $ingresos=array();
    $gastos=array();
    $ing_fijo=array();
    $ing_corriente=array();
    $gst_fijo=array();
    $gst_corriente=array();
    $inversiones=array();
    $creditos=array();
    $registros=array();
      while($fecha1 <= $fecha2){ 
    $res = mysqli_query($con_app,"SELECT COUNT(idregistro) AS registros,
    (SELECT COUNT(tipo) FROM registros WHERE usuario='$iduser' AND categoria='ingreso' AND tipo='credito' AND fecha LIKE '$fecha1%')AS creditos,
    (SELECT COUNT(tipo) FROM registros WHERE usuario='$iduser' AND categoria='gasto' AND tipo='activo' AND fecha LIKE '$fecha1%')AS inversiones,
    (SELECT COUNT(tipo) FROM registros WHERE usuario='$iduser' AND categoria='ingreso' AND tipo='fijo' AND fecha LIKE '$fecha1%')AS ingresoFijo,
    (SELECT COUNT(tipo) FROM registros WHERE usuario='$iduser' AND categoria='ingreso' AND tipo='corriente' AND fecha LIKE '$fecha1%')AS ingresoCorriente,
    (SELECT COUNT(tipo) FROM registros WHERE usuario='$iduser' AND categoria='gasto' AND tipo='fijo')AS gastoFijo,
    (SELECT COUNT(tipo) FROM registros WHERE usuario='$iduser' AND categoria='gasto' AND tipo='corriente' AND fecha LIKE '$fecha1%')AS gastoCorriente,
    (SELECT SUM(valor) FROM registros WHERE usuario='$iduser' AND categoria='ingreso' AND fecha LIKE '$fecha1%')AS ingresos,
    (SELECT SUM(valor) FROM registros WHERE usuario='$iduser' AND categoria='gasto' AND fecha LIKE '$fecha1%')AS gastos
    FROM registros WHERE usuario='$iduser' AND fecha LIKE '$fecha1%'"); 
    $textoX=date("D d",strtotime($fecha1)); 
   
    if(mysqli_num_rows($res) > 0 ){   
        while($fila=mysqli_fetch_array($res)){   
            $ingresos[]=($fila['ingresos']==0 ? 0: $fila['ingresos']);          
            $gastos[]=($fila['gastos']==0 ? 0 : $fila['gastos']);          
            $inversiones[]=$fila['inversiones'];          
            $creditos[]=$fila['creditos']; 
            $registros[]=$fila['registros'];
            $ing_fijo[]=$fila['ingresoFijo'];
            $ing_corriente[]=$fila['ingresoCorriente'];
            $gst_fijo[]=$fila['gastoFijo'];
            $gst_corriente[]=$fila['gastoCorriente'];                
        }

    } 
      
                 $datoXfecha[]=$textoX;
            $fecha1 = date("Y-m-d",strtotime($fecha1.'+1 days'));  
      }
        $datosXfechas=json_encode($datoXfecha);
        $ingreso=json_encode($ingresos);     
        $gasto=json_encode($gastos);     
        $inversion=json_encode($inversiones);     
        $credito=json_encode($creditos);     
        $registro=json_encode($registros);     
        $ingfijo=json_encode($ing_fijo);     
        $ingcorriente=json_encode($ing_corriente);     
        $gstfijo=json_encode($gst_corriente);     
        $gstcorriente=json_encode($gst_fijo); 

        mysqli_free_result($res);  mysqli_close($con_app);  
           ?>

<script src="../js/plotly-latest.min.js"></script>
<center style="overflow-x: scroll; max-width:1220px;margin:auto;">
    <div id="myGraficas"></div>
</center>
<br><br>
<a id="bottom" class="icon-up flechasUp" href="#btnTotales"></a>
<br><br>
<br><br>
<script>
    //COMBIERTE LOS ARRAY DE PHP A JAVASCRIPT 
    function obtener(json) {
        var parsed = JSON.parse(json);
        var arr = [];
        for (var x in parsed) {
            arr.push(parsed[x]);
        }
        return arr;
    }

    datosXfechas = obtener('<?php echo $datosXfechas; ?>');
    ingresos = obtener('<?php echo $ingreso; ?>');
    gastos = obtener('<?php echo $gasto; ?>');
    inversiones = obtener('<?php echo $inversion; ?>');
    creditos = obtener('<?php echo $credito; ?>');
    registros = obtener('<?php echo $registro; ?>');
    ingresosfijos = obtener('<?php echo $ingfijo; ?>');
    ingresoscorrientes = obtener('<?php echo $ingcorriente; ?>');
    gastosfijos = obtener('<?php echo $gstfijo; ?>');
    gastoscorrientes = obtener('<?php echo $gstcorriente; ?>');


    var ingreso = {
        x: datosXfechas,
        y: ingresos,
        type: 'scatter',
        name: 'Ingresos',
        marker: {
            color: 'blue'
        }
    };
    var gasto = {
        x: datosXfechas,
        y: gastos,
        type: 'scatter',
        name: 'Gastos',
        marker: {
            color: 'red'
        }
    };
    var ingfijo = {
        x: datosXfechas,
        y: ingresosfijos,
        type: 'scatter',
        name: 'Ingresos Fijo',
        visible: 'legendonly',
        marker: {
            color: 'dodgerblue'
        }
    };
    var ingcorrt = {
        x: datosXfechas,
        y: ingresoscorrientes,
        type: 'scatter',
        name: 'Ingresos Corriente',
        visible: 'legendonly',
        marker: {
            color: 'deepskyblue'
        }
    };
    var gstfijo = {
        x: datosXfechas,
        y: gastosfijos,
        type: 'scatter',
        name: 'Gastos Fijo',
        visible: 'legendonly',
        marker: {
            color: 'orangered'
        }
    };
    var gstcorrt = {
        x: datosXfechas,
        y: gastoscorrientes,
        type: 'scatter',
        name: 'Gastos Corriente',
        visible: 'legendonly',
        marker: {
            color: 'darkred'
        }
    };
     var inversiones = {
        x: datosXfechas,
        y: inversiones,
        type: 'scatter',
        name: 'Activos',
        visible: 'legendonly',
        marker: {
            color: 'green'
        }
    };

     var creditos = {
        x: datosXfechas,
        y: creditos,
        type: 'scatter',
        name: 'Créditos',
        visible: 'legendonly',
        marker: {
            color: 'darkorange'
        }
    };

    var layout = {
        title: "CRECIMIENTO ECONÓMICO",

        legend: {
            x: 0,
            y: -1.5
        },
        xaxis: {
            title: '<?php echo date("F",strtotime($fecha1)) ?>',
            showline: false

        },
        yaxis: {
            title: 'Totales',
            showline: false
        }
    };
    var config = {
        displayModeBar: true,
        //        modeBarButtonsToAdd:['drawLine'],
        modeBarButtonsToRemove: ['hoverCompareCartesian', 'hoverClosestCartesian', 'pan2d', 'select2d', 'lasso2d', 'resetScale2d', 'toggleSpikelines', 'zoom2d', 'sendDataToCloud', 'resetViowMapbox', 'togglehover', 'hoverClosestPie'],
        displaylogo: false,
        responsive: true
        //        showEditInChartStudio:true,
        //        showLink: true,
        //        plotlyServerURL: 'https://en4es.com',
        //        linkText: 'Sitio Ofical'
    };

    var data = [ingreso, gasto, ingfijo, ingcorrt, gstfijo, gstcorrt, inversiones, creditos];
    Plotly.newPlot("myGraficas", data, layout, config);

</script>
<?php  }else{echo "<center><font color='red' class='icon-stop'>Sin resultados gráficos!</font></center>;<br><br><br>"; }?>
