<!--
	DESARROLLADOR: JUAN CARLOS PANIAGUA
	VERSION: 0001
	FECHA: DAY MONTH 2019
	
	PAGINA DE :DESCRIPCION
-->
<?php 
    if(session_id() ===""){ session_start();}
    
    date_default_timezone_set('America/St_Thomas');
    if(isset($_SESSION['iduser'])){
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Control y educacion financiera.">
    <meta name="keywords" content="finanzas, dinero, liberta financiera, educacion finaciera">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="author" content="Juan C. Paniagua R.">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="../src/imgs/growth.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="../src/imgs/growth.png" type="image/x-icon">
    <title>finanzas</title>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="../src/sweetAlert2/sweetalert2.min.css">
    <script src="../src/sweetAlert2/sweetalert2.all.min.js"></script>

    <link href="https://file.myfontastic.com/bHYeF5KBR8AGncvq5v2Xw8/icons.css" rel="stylesheet">
    <script src="../js/script.js"></script>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/formGuardar.css"> 

</head>

<body>
    <!--USUARIOS EN MODO ROOT-->
    <div class="menu">
        <font color="white"><img src="../src/imgs/imgclear.png"><a href="../../">IDCSchool</a></font>
        <span  onclick="openwindows('', '#divEditar');">Hola <?php echo ucwords($_SESSION['name']); ?></span> |
        <button onclick="window.location.href='../svr/logout.php'" class="icon-logout"></button>
    </div>

    <!--  DIV BOTONES PRINCIPALES-->
    <div class="divbtn">
        <button class="btn icon-wallet" id="default" onclick="openwindows(this, '#divGuardar');"></button>
        <button class="btn icon-percent"  onclick="openwindows(this, '#divRegistros');showRegistros();"></button>
        <button class="btn icon-line-chart"  onclick="openwindows(this, '#divGraficos');showGraficos();"></button>

    </div>
    
<!--    EDITAR USUARIO-->
    <div id="divEditar" class="divtab">
        <form id="formEditar">
           <h1>ID<?php echo $_SESSION['iduser']; ?></h1>
            <label>Nombre</label>
            <input type="text" name="nombre" required value="<?php echo $_SESSION['name']; ?>">
            <label>Teléfono</label>
            <input type="text" name="tel" required value="<?php echo $_SESSION['phone']; ?>">
            <label>Moneda</label>
            <input type="text" list="moneda" name="moneda" value="<?php echo $_SESSION['moneda']; ?>" required maxlength="3">
            <datalist id="moneda">
                <option value="DOP">Peso Dominicano</option>
                <option value="USD">Dólar estadounidense</option>
                <option value="EUR">Euro</option>
                <option value="MXN">Peso mexicano</option>
                <option value="GBP">Libra esterlina</option>
                <option value="CHF">Franco suizo</option>
                <option value="JPY">Yen japonés</option>
                <option value="HKD">Dólar hongkonés</option>
                <option value="CAD">Dólar canadiense</option>
                <option value="CNY">Yuan chino</option>
                <option value="AUD">Dólar australiano</option>
                <option value="BRL">Real brasileño</option>
                <option value="RUB">Rublo ruso</option>
            </datalist>
            <label>Periodo</label> 
            <select name="periodo" required>
                <option value="<?php echo $_SESSION['periodo']; ?>"><?php echo $_SESSION['periodo']; ?></option>
                <option value="Diario">Diario</option>
                <option value="Semanal">Semanal</option>
                <option value="Quincenal">Quincenal</option>
                <option value="Mensual">Mensual</option>
                <option value="Anual">Anual</option>
            </select>

            <label>Correo</label>
            <input type="text" name="email" required value="<?php echo $_SESSION['email']; ?>">
            <input type="hidden" name="iduser" required value="<?php echo $_SESSION['iduser']; ?>">
            <label for=""></label>
            <input type="password" name="pass" required id="lpass" placeholder="Contraseña">
            <input type="hidden" name="editar">

            <input type="checkbox" onchange="showpass('lpass','#lpw');">
            <span id="lpw">Mostrar contraseña</span><br>
            <button type="submit">Editar</button>
        </form>
        <div id="infoEdit"></div>
        <script>
        
         //MUESTRA Y OCULTA EL PASSWORD
         function showpass(input, tag) {
             var pass = document.getElementById(input);
             if (pass.type === "password") {
                 pass.setAttribute("type", "text");
                 $(tag).text("Ocultar contraseña");
             } else {
                 pass.setAttribute("type", "password");
                 $(tag).text("Mostrar contraseña");
             }
         }

 $('#formEditar').submit(function() {
            $.ajax({
                type: 'POST', 
                url: '../svr/usuarios.php',
                data: $(this).serialize(),
                success: function(data) {
                    $("#infoEdit").html(data);
                    document.getElementById("formEditar").reset();
                    openwindows('', '#divGuardar');
                }
            });
            return false;
        });

        </script>
    </div>

    <!--   DIV GUARDAR REGISTROS-->
    <div id="divGuardar" class="divtab">
        <form id="formEntradas"> 
            <input type="datetime-local" name="fecha" required value="<?php echo date("Y-m-d")."T".date("H:i"); ?>">

           
            <fieldset class="fieldsetaccion">
                <label><input type="radio" name="categoria" id="ingreso" value="ingreso" required><span>Ingreso <a href="info.html#ingresos">?</a></span></label>
                <label> <input type="radio" name="categoria" id="gasto" value="gasto" required><span>Gasto <a href="info.html#gastos">?</a></span></label>
            </fieldset>
            
            <fieldset id="fieldtipo">
                <label><input type="radio">Seleccionar una acción</label>
            </fieldset>

            <input type="text" name="concepto" id="concepto" list="" required>
            <label for="nme"><span>Concepto</span></label>
            
             <input type="number" name="valor"  required min="0.1" step="any" class="question">
            <label for="nme"><span>Valor</span></label>
            
            <div id="listas">
                <datalist id="ingresos_fijos">
                    <option value="Sueldo">
                    <option value="Cuentas por cobrar">
                    <option value="Renta">
                    <option value="Remesa">
                    <option value="Becas">
                    <option value="Otros">
                </datalist>

                <datalist id="ingresos_corrientes">
                    <option value="Servicios prestados">
                    <option value="Comisiones">
                    <option value="Cuentas por cobrar">
                    <option value="Ventas">
                    <option value="Remesa">
                    <option value="Regalos">
                    <option value="Otros">
                </datalist>

                <datalist id="creditos">
                    <option value="crédito bancario">
                    <option value="crédito personal">
                    <option value="Otros">
                </datalist>

                <datalist id="gastos_fijos">
                    <option value="Gasto personal">
                    <option value="Gastos del hogar">
                    <option value="Gastos familiar">
                    <option value="Cuentas por pagar">
                    <option value="Arrendamientos">
                    <option value="Gastos médicos">
                    <option value="Publicidad">
                    <option value="Seguros">
                    <option value="Inpuestos">
                    <option value="Otros">
                </datalist>

                <datalist id="gastos_corrientes">
                    <option value="Gasto personal">
                    <option value="Gasto del hogar">
                    <option value="Gasto familiar">
                    <option value="Cuentas por pagar">
                    <option value="Arrendamientos">
                    <option value="Gastos médicos">
                    <option value="Publicidad">
                    <option value="Seguros">
                    <option value="Reparaciones">
                    <option value="Inpuestos">
                    <option value="Accidentes">
                    <option value="Otros">
                </datalist>

                <datalist id="activos">
                    <option value="Inmuebles">
                    <option value="Negocios">
                    <option value="Divisas">
                    <option value="Productos">
                    <option value="Maquinarias">
                    <option value="Otras">
                </datalist>
            </div>
            <input type="hidden" name="usuario" value="<?php echo $_SESSION['iduser'] ?>">
            <input type="hidden" name="guardar">
            <button class="button" type="submit">
			<div class="submit">Guardar</div>
			<div class="arrow">
				<div class="top line" ></div>
				<div class="bottom line"></div>
			</div>
		</button>
        </form>
        <div id="info"></div>
        
        <script>
function hover() {
  $(".button").on("mouseenter", function() {
    return $(this).addClass("hover");
  });
}

function hoverOff() {
  $(".button").on("mouseleave", function() {
    return $(this).removeClass("hover");
  });
}

function active() { 
  $(".button").on("click", function() {
     $(this).addClass("active");   
      setTimeout(function(){
    $('.button').removeClass("active"); },2000);     
  });
} 

hover(); 
hoverOff();
active();</script>
    </div>

    <!--   DIV HISTORY DE CUENTA-->
    <div id="divRegistros" class="divtab">

        <form id="formRegistros">
            <?php  //ESTABLECE LA FECHA POR DEFECTO DE CADA INVENTARIO
            function firstDate(){
                if($_SESSION['periodo']=="Diario"){
                    return date("Y-m-d");
                }elseif($_SESSION['periodo']=="Semanal"){//MUESTRA LA FECHA DEL PASADO DOMINGO
                    return date('Y-m-d',strtotime('sunday last week'));
                }elseif($_SESSION['periodo']=="Quincenal"){
                    return (date("d")<=15 ? date("Y-m-01") :  date("Y-m-16"));
                }elseif($_SESSION['periodo']=="Mensual"){
                    return date("Y-m-01");
                 }elseif($_SESSION['periodo']=="Anual"){
                    return date("Y-01-01");
                }else{
                    return (date("d")<=15 ? date("Y-m-01") :  date("Y-m-16") );
                }
            } 
            ?>
            <fieldset align='center'>
                <legend>Desde <span class="icon-random"></span> Hasta</legend>

                <input type="date" id="fecha01" onchange="showRegistros();" value="<?php echo firstDate(); ?>">
                <input type="date" id="fecha02" onchange="showRegistros();" value="<?php echo date("Y-m-d"); ?>">

                <!--                LOS SIGUIENTES CAMPOS SONN SOLO PARA LAS GRAFICAS-->
                <input type="hidden" id="idusuario01" value="<?php echo $_SESSION['iduser'] ?>">
                <input type="hidden" id="moneda01" value="<?php echo $_SESSION['moneda'] ?>">
            </fieldset>
        </form>
        <div id="showRegistros"> </div>
    </div>

    <!--   DIV HISTORY DE CUENTA-->
    <div id="divGraficos" class="divtab">
        <?php  
            function fechaInicial(){
                if($_SESSION['periodo']=="Diario"){
                    return date("Y-m-d");
                }elseif($_SESSION['periodo']=="Semanal"){//MUESTRA LA FECHA DEL SABADO PASADO
                    return date('Y-m-d',strtotime('saturday last week'));
                }elseif($_SESSION['periodo']=="Quincenal"){
                    return (date("d")<=15 ? date("Y-m-01") :  date("Y-m-16") );
                }elseif($_SESSION['periodo']=="Mensual"){
                    return date("Y-m-01");
                }else{
                    return (date("d")<=15 ? date("Y-m-01") :  date("Y-m-16") );
                }
            }?>
        <form>
            <fieldset>
                <legend>Desde <span class="icon-random" style="margin:0 15px"></span> Hasta</legend>

                <input type="date" id="fecha1" onchange="showGraficos();" value="<?php echo fechaInicial(); ?>">
                <input type="date" id="fecha2" onchange="showGraficos();" value="<?php echo date("Y-m-d"); ?>">

                <!--                LOS SIGUIENTES CAMPOS SONN SOLO PARA LAS GRAFICAS-->
                <input type="hidden" id="idusuario" value="<?php echo $_SESSION['iduser'] ?>">
                <input type="hidden" id="moneda" value="<?php echo $_SESSION['moneda'] ?>">
                <input type="hidden" id="graficos">
            </fieldset>
        </form>
        <div id="showGraficos"> </div>
    </div>
    
     <div id="checklistIngresos" style="display:none"> 
         <input id="fijo" type="radio" name="tipo" required value="fijo" onclick="setDataList('ingfijo');">
         <label for="fijo">Fijo</label>
         <input id="corriente" type="radio" name="tipo" required value="corriente" onclick="setDataList('ingcorrt');">
         <label for="corriente">Corriente</label>
         <input id="credito" type="radio" name="tipo" required value="credito" onclick="setDataList('ingcredito');">
         <label for="credito">Crédito</label>
     </div>

    <div id="checklistGastos" style="display:none;"> 
         <input id="fijo" type="radio" name="tipo" required value="fijo" onclick="setDataList('gastofijo');">
         <label for="fijo">Fijo</label>
         <input id="corriente" type="radio" name="tipo" required value="corriente" onclick="setDataList('gastocrrt');">
         <label for="corriente">Corriente</label>
         <input id="inversion" type="radio" name="tipo" required value="inversion" onclick="setDataList('gastocredito');">
         <label for="inversion">Inversión</label>
     </div>

    <script>  
        $('#ingreso').click(function() {
            if ($(this).is(':checked')) {
                $('#fieldtipo').html($('#checklistIngresos').html());
            }
        });

        $('#gasto').click(function() {
            if ($(this).is(':checked')) {
                $('#fieldtipo').html($('#checklistGastos').html());
            }
        });

        function setDataList(radiobtn) {
            $('#concepto').val('');
            if (radiobtn == "ingfijo") {
                $('#concepto').attr('list', 'ingresos_fijos');

            } else if (radiobtn == "ingcorrt") {
                $('#concepto').attr('list', 'ingresos_corrientes');

            } else if (radiobtn == "ingcredito") {
                $('#concepto').attr('list', 'creditos');

            } else if (radiobtn == "gastofijo") {
                $('#concepto').attr('list', 'gastos_fijos');

            } else if (radiobtn == "gastocrrt") {
                $('#concepto').attr('list', 'gastos_corrientes');

            } else if (radiobtn == "gastocredito") {
                $('#concepto').attr('list', 'activos');
            }
        }

        $('#formEntradas').submit(function() {
            $.ajax({
                type: 'POST',
                url: '../svr/entradas.php',
                data: $(this).serialize(),
                success: function(data) {
                    $("#info").html(data);
                    document.getElementById("formEntradas").reset();
                    $('#fieldtipo').html("<legend>Tipo</legend><label><input type='radio'>Seleccionar una acción</label>");
                }
            });
            return false;
        });

        function showRegistros() {
            $.ajax({
                type: 'POST',
                url: '../svr/salidas.php',
                data: {
                    fecha1: $('#fecha01').val(),
                    fecha2: $('#fecha02').val(),
                    moneda: $('#moneda01').val(),
                    idusuario: $('#idusuario01').val(),
                    registros: ''
                },
                success: function(data) {
                    $("#showRegistros").html(data);
                }
            });
            return false;
        }


        function showGraficos() {
            $.ajax({
                type: 'POST',
                url: '../svr/graficos.php',
                data: {
                    fecha1: $('#fecha1').val(),
                    fecha2: $('#fecha2').val(),
                    moneda: $('#moneda').val(),
                    idusuario: $('#idusuario').val(),
                    graficos: ''
                },
                success: function(data) {
                    $("#showGraficos").html(data);
                }
            });
            return false;
        }

    </script>

</body>

</html>
<?php }else{  header("location: ../index.php");   } ?>
