 
 <!--
	DESARROLLADOR: JUAN CARLOS PANIAGUA
	VERSION: 20122019
	FECHA: 20 dec 2019
	
	PAGINA DE : inicio de secsion
-->
 <!DOCTYPE html>
 <html lang="es"> 
 
 <head> 
     <meta charset="utf-8"> 
     <meta name="description" content="A web for make appointments">
     <meta name="keywords" content="appointements, carlos, nails, saint thomas, virgin iliands">
     <meta http-equiv="X-UA-Compatible" content="IE=Edge">
     <meta name="author" content="Juan C. Paniagua R.">
     <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
     <link rel="shortcut icon" href="src/imgs/imgclear.png" type="image/x-icon">
     <link rel="apple-touch-icon" href="src/imgs/logoIcon.ico" type="image/x-icon">
     <title>acceso</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="src/sweetAlert2/sweetalert2.min.css">
    <script src="src/sweetAlert2/sweetalert2.all.min.js"></script>
    <link href="https://file.myfontastic.com/bHYeF5KBR8AGncvq5v2Xw8/icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
 </head>
  
 <body>
    <?php 
        include("svr/autentication.php");         
   ?>
     <div class="divbtn">
         <button class="btn icon-login" id="default" onclick="openwindows(this, '#divlogin');"></button>
         <button class="btn icon-adduser" onclick="openwindows(this, '#divsignup');"></button>
     </div>
     <div class="welcome">
         <img src="src/imgs/frio.png" alt="Logo" onclick="location.href='../'">
         <h1>Bienvenidos</h1>
         <i>a FinanzApp.</i>
     </div>
     <hr>

     <div class="divtab" id="divlogin">
         <h2>ACCEDER</h2>
         <form action="svr/usuarios.php" method="post">
             <input type="text" name="user" required placeholder="Usuario o Correo" value="<?php echo (isset($_COOKIE['user']) ? $_COOKIE['user'] : ''); ?>">
             <input type="password" name="pass" id="lpass" placeholder="Contraseña" value="<?php echo (isset($_COOKIE['pass']) ? $_COOKIE['pass'] : ''); ?>">
             <input type="hidden" name="acceder">

             <input type="checkbox" onchange="showpass('lpass','#lpw');">
             <span id="lpw">Mostrar contraseña</span><br>
             <input type="checkbox" name="cookie" id="cookie" value="Olvídame" checked>
             <span id="ckinfo">Olvídame</span>
             <button type="submit">Entrar</button>
             <br>
             <p> <span onclick="location.href='app/reset.html';">Olvide mi contrseña. </span> |
                 <span onclick="openwindows('button.icon-adduser', '#divsignup');">Crear una cuenta.</span>
             </p>
         </form>

     </div>

     <div class="divtab" id="divsignup" >
         <h2>REGISTRARSE</h2>
         <form action="svr/usuarios.php" method="post">
             <input type="text" name="nombre" required placeholder="Nombre">             
             <input type="tel" name="telefono" required placeholder="Teléfono">
             <input type="email" name="correo" required placeholder="Correo">
             <input type="password" name="pass" id="spass" placeholder="Contraseña" required>
             <input type="hidden" name="registrar">
             <input type="checkbox" onchange="showpass('spass','#spw');" style="width:15px; margin-right:3px;">
             <span id="spw">Mostrar contraseña</span>  
             <button type="submit">Registrar</button>
             <br>
             <p>Ya tienes una cuenta? <span onclick="openwindows('button.icon-login', '#divlogin');">Acceder.</span></p>
            <p>Al hacer clic en el botón "Registrar", está creando una cuenta y acepta los Términos de servicio y la Política de privacidad de IDCSchools.</p>
         </form>
     </div>
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

         //RECORDAR PASSWORD
         $('#cookie').on('change', function() {
             if ($(this).is(':checked')) {
                 $(this).val("Olvídame");
                 $("#ckinfo").text("Olvídame");
             } else {
                 $(this).val("Recuérdame");
                 $("#ckinfo").text("Recuérdame");

             }
         });       
     </script> 
     <br><br>
     <center>
         <form action="https://www.paypal.com/donate" method="post" target="_top">
             <input type="hidden" name="hosted_button_id" value="2UUWMR9S7DMBS" />
             <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
<!--             <img alt="" border="0" src="https://www.paypal.com/en_DO/i/scr/pixel.gif" width="1" height="1" />-->
             <img alt="" border="0" src="src/imgs/paypal.png" width="1" height="1" />
         </form> 
     </center>

<div id="msm"></div>
    
     <br><br><br><br><br><br>
     <!--   ***********ALERTA DE COOKIES**************-->
     <style>
         #cajacookies a {
             text-decoration: none;
         }

         #cajacookies button {
             background: green;
             color: white;
             border: none;
             padding: 10px;
             display: inline;
             display: block;
             margin: 10px auto;
             cursor: pointer;

         }

         #cajacookies {
             padding: 10px 20px;
             position: fixed;
             bottom: 20px;
             z-index: 10;
             color: white;
             background: rgba(0,0,0,0.5);
             display: block;
             margin: auto;
             width: 80%;
             max-width: 250px;
             border-radius: 5px;
             right: 10px;
             /*            bottom: 80px*/
         }

     </style>
     <div id="cajacookies">
         <p>
             Usaremos cookies para guardar tu información de acceso en tu dispositivo y accedas automáticamente la próxima vez. Saber más sobre las <a lang="en" translate="no" target="_blank" href="https://es.wikipedia.org/wiki/Cookie_(inform%C3%A1tica)">Cookies aquí.</a> </p>
         <button onclick="aceptarCookies()">Continuar</button>
     </div>


     <footer>

         <div class="redes">
             <a href="https://www.facebook.com/ideas.decodigos.3" target="_blank" title="Follow me in FaceBook"><img src="src/imgs/facebook.png" alt="facebook"></a>
             <a href="https://www.instagram.com/ideasdcodigos/" target="_blank" title="Follow me in Instagram"><img src="src/imgs/instagram.png" alt="instagram"></a>
             <a href="https://twitter.com/de_ideas" target="_blank" title="Follow me in Twitter"><img src="src/imgs/twitter.png" alt="twitter"></a>
             <a href="https://www.youtube.com/channel/UCwN59VLiuiL_GMX3fHTOf_A" target="_blank" title="Follow me in YouTube"><img src="src/imgs/youtube.png" alt="youtube"></a>
         </div>

         <br>
         <p>Copy rights © 2021 | All rights reserved by IDCSchool</p>
         <i> Desarrollado por Juan C. Paniagua</i>
         <div id="subir">
             <a href="#top" class="icon-up" title="Back to top"></a>
         </div>

         <br>
         <hr>
         <br>
         <p>
             
        <a href="app/terms.php" target="_blank">Terms</a> |
        <a href="app/privacy.php" target="_blank">Privacy</a> | 

             <a href="app/help.php" target="_blank">FAQs</a> |
             <a lang="en" translate="no" target="_blank" href="https://es.wikipedia.org/wiki/Cookie_(inform%C3%A1tica)">Cookies</a>
         </p>
         <br>
         <br>
     </footer>
     <script src="js/script.js"></script>
 </body>

 </html>
