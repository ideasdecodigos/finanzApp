 <?php 
    if(isset($_GET["code"])){
        $iduser=base64_decode($_GET["code"]);
 ?>
 <!--
	DESARROLLADOR: JUAN CARLOS PANIAGUA
	VERSION: 20122019
	FECHA: 20 dec 2019
	
	PAGINA DE : inicio de secsion
-->
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="utf-8">
     <meta name="description" content="A web for make appointments">
     <meta name="keywords" content="appointements, carlos, nails, saint thomas, virgin iliands">
     <meta http-equiv="X-UA-Compatible" content="IE=Edge">
     <meta name="author" content="Juan C. Paniagua R.">
     <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
     <link rel="shortcut icon" href="../src/logoIcon.ico" type="image/x-icon">
     <link rel="apple-touch-icon" href="../src/logoIcon.ico" type="image/x-icon">
     <title>reset</title>
     <link rel="stylesheet" href="../src/icons/styles.css">
     <link rel="stylesheet" href="../css/styles.css">
     <script src="../js/jquery-3.3.1.min.js"></script>
     <script src="../js/script.js"></script>
 </head>


 <body>
     <!--  DIV BOTONES PRINCIPALES-->
     <div class="divbtn">
         <button class="btn icon-home" onclick="location.href='../index.php';"></button>
         <button class="btn icon-confi" id="default" onclick="openwindows(this, '#recup');"></button>
     </div>

     <div class="welcome">
         <img src="../src/imgclear.png" alt="Logo">
         <h1>Welcome</h1>
         <i>to Account Manager.</i>
     </div> 
     <hr>

 
     <div class="divtab" id="recup">
         <h2>RESTABLECER CONTRASEÑA</h2>
         <form id="formRecup" action="javascript:void(0);">
            <?php include("../svr/connection.php"); 
      
            $res = mysqli_query($con_users, "SELECT * FROM table_users WHERE u_code=$iduser");
            while($rs=mysqli_fetch_array($res)){ ?>
                 <font color='red'>Si esta cuenta no le pertenece, favor no haga ningun cambio y de clic <a href="../index.php">aqui.</a></font><br><br>
                 <label>Admin: <?php echo $rs['u_name']; ?></label><br>
                 <label>Mail: <?php echo $rs['u_mail']; ?></label>
             <?php 
            }                         
            mysqli_close($con);
            mysqli_free_result($res); ?>

             <input type="hidden" name="iduser" value="<?php echo $iduser; ?>">
             <input type="password" name="pass1" id="spass1" placeholder="Nueva Contraseña" required>
             <input type="password" name="pass2" id="spass2" placeholder="Repita Contraseña" required>
             <button type="submit">Cambiar</button>
             <input type="checkbox" onchange="showpass('spass1','#spw');showpass('spass2','#spw');" style="width:15px; margin-right:3px;">
             <span id="spw">Mostrar contraseña</span>
             <br>
             <br>
             <div id="answer"></div>
             <div id="mnj"> </div>
         </form>
     </div>
     
     <br><br><br><br><br><br>
     
     <script>
                 
         $('#formRecup button').click(function() {

             if ($('#spass1').val() == $('#spass2').val()) {

                 $("#mnj").show();
                 $("#mnj").attr('class', 'icon-smile');
                 $("#mnj").text(' Done!');
                 $("#mnj").css({
                     'color': 'darkgreen'
                 });
                 setTimeout(function() {
                     $("#mnj").hide()
                 }, 8000);

                 $('#formRecup').submit(function() {
                     $.ajax({
                         type: 'POST',
                         url: '../svr/usuarios.php',
                         data: $(this).serialize(),
                         success: function(data) {
                             $("#answer").html(data);
                         }
                     });
                     return false;
                 });

             } else {
                
                 $("#mnj").show();
                 $("#mnj").attr('class', 'icon-care');
                 $("#mnj").text(' Las contraseñas no coinciden.!');
                 $("#mnj").css({
                     'color': 'red'
                 });
                 setTimeout(function() {
                     $("#mnj").hide()
                 }, 8000);
             }
         });



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

     </script>
     <footer>

         <div class="redes">
             <a href="https://www.facebook.com/ideas.decodigos.3" target="_blank" title="Follow me in FaceBook"><img src="../src/facebook.png" alt="facebook"></a>
             <a href="https://www.instagram.com/ideasdcodigos/" target="_blank" title="Follow me in Instagram"><img src="../src/instagram.png" alt="instagram"></a>
             <a href="https://twitter.com/de_ideas" target="_blank" title="Follow me in Twitter"><img src="../src/twitter.png" alt="twitter"></a>
             <a href="https://www.youtube.com/channel/UCwN59VLiuiL_GMX3fHTOf_A" target="_blank" title="Follow me in YouTube"><img src="../src/youtube.png" alt="youtube"></a>
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
             <!--
        <a href="app/terms.php" target="_blank">Terms</a> |
        <a href="app/privacy.php" target="_blank">Privacy</a> | 
-->
             <a href="help.php" target="_blank">FAQs</a> |
             <a lang="en" translate="no" target="_blank" href="https://es.wikipedia.org/wiki/Cookie_(inform%C3%A1tica)">Cookies</a>
         </p>
         <br>
         <br>
     </footer>
     <script src="../js/script.js"></script>
 </body>

 </html>
 <?php }else{ header("../index.php"); } ?>
