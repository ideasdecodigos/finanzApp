<!--
            	DESARROLLADOR: JUAN CARLOS PANIAGUA
            	VERSION: 0001
            	FECHA: DAY MONTH 2019
            	
            	PAGINA DE :DESCRIPCION
            -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="author" content="Juan C. Paniagua R.">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="../src/imgs/growth.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="../src/imgs/growth.png" type="image/x-icon">
    <title>usuarios</title>
    <link rel="stylesheet" href="../src/sweetAlert2/sweetalert2.min.css">
    <script src="../src/sweetAlert2/sweetalert2.all.min.js"> </script>
    <script src="../js/jquery-3.3.1.min.js"></script>
</head>

<body>

    <datalist id="moneda">
        <option value="DOP">Peso Dominicano</option>
        <option value="USD">Dólar estadounidenses</option>
        <option value="EUR">Euro</option>
        <option value="MXN">Peso mexicanoo</option>
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

    <?php 

include("connection.php"); 

//SAVE USER
if(isset($_POST["registrar"])){
     $user = mysqli_real_escape_string($con_users,$_POST["nombre"]);
     $phone = mysqli_real_escape_string($con_users,$_POST["telefono"]);       
     $pass = mysqli_real_escape_string($con_users,$_POST["pass"]);
     $mail = mysqli_real_escape_string($con_users,$_POST["correo"]);
     $pass = password_hash($pass, PASSWORD_DEFAULT);  //SIFRA EL PASS
   
    if(mysqli_num_rows(mysqli_query($con_users, "SELECT u_mail FROM table_users WHERE u_mail='$mail'")) > 0 ){ //SI EL CORREO YA EXISTE, SE LE NOTIFICA EL USUARIO
        echo "<body>
                <script>  
                    Swal.fire('Alerta','El correo: ($mail) ya existe!!','warning').then((result) => {
                        if(result.isConfirmed || Swal.DismissReason.timer){ 
                            window.history.back();
                        }
                    });
                </script>
            </body>";
    }
    elseif(mysqli_num_rows(mysqli_query($con_users, "SELECT u_phone FROM table_users WHERE u_phone='$phone'")) > 0 ){ //SI EL CORREO YA EXISTE, SE LE NOTIFICA EL USUARIO
        echo "<body>
                <script>
                    Swal.fire('Alerta','El correo: ($phone) ya existe!!','warning').then((result) => {
                        if(result.isConfirmed || Swal.DismissReason.timer){ 
                            window.history.back();
                        }
                    });
                </script>
            </body>";
    }else{  				
            //INGRESA LOS DATOS A LA DB
        $exitosa = mysqli_query($con_users, "INSERT INTO table_users(u_name,u_mail,u_phone,u_pass)VALUES('$user','$mail','$phone','$pass')") 
        or die("<body>
                    <script>
                        Swal.fire('Alerta','Error al insertar!!','warning').then((result) => {
                        if(result.isConfirmed || Swal.DismissReason.timer){ 
                            window.history.back();
                        }
                    });
                </script>
            </body>");

        if($exitosa){    
            if(session_id() ===""){ session_start();}
            $res = mysqli_query($con_users, "SELECT * FROM table_users WHERE u_mail='$mail'");

            if( mysqli_num_rows($res) > 0 ){   
                while($fila=mysqli_fetch_array($res)){
                    $_SESSION['iduser']=$fila['u_code']; 
                    $_SESSION['name']=$fila['u_name']; 
                    $_SESSION['email']=$fila['u_mail'];
                    $_SESSION['phone']=$fila['u_phone'];
                    $_SESSION['userdate']=$fila['u_date']; 

                    completarRegistro($fila['u_code']);
                } 
            }
        } else{
            if(!isset($_SESSION['iduser'])){    
                echo "<body><script>Swal.fire({
                      title: 'Alerta',
                      text: '¡Datos incorrectos!',
                      icon: 'error'
                    }).then((result) => {
                      if(result.isConfirmed || Swal.DismissReason.timer){ 
                        window.history.back();
                      }
                    }); </script></body>";
            }   
        }
    }
} 
//LOGIN USER
elseif(isset($_POST["acceder"])){ 
        $user = mysqli_real_escape_string($con_users,$_POST["user"]);
        $pass = mysqli_real_escape_string($con_users,$_POST["pass"]);        

    //	EL USUARIO DEBE PODER INICIAR SECCION CON SU CORREO O TELEFONO Y SU CONTRASENA
		$res = mysqli_query($con_users, "SELECT * FROM table_users WHERE u_mail='$user' OR u_phone='$user'");
		while($fila=mysqli_fetch_array($res)){ 
			if(password_verify($pass,$fila['u_pass']) and (strcasecmp($user,$fila['u_mail'])==0  or strcasecmp($user,$fila['u_phone'])==0 )){ //SI EL USER Y EL PASS SON VALIDOS, SE INICIA LA SECSION
                if(session_id() ===""){ session_start();}
				$_SESSION['iduser']=$fila['u_code']; 
                $_SESSION['name']=$fila['u_name'];
                $_SESSION['email']=$fila['u_mail'];
                $_SESSION['phone']=$fila['u_phone'];
                $_SESSION['userdate']=$fila['u_date']; 
                
                if(isset($_POST['cookie']) && $_POST['cookie']=="Olvídame"){  
                    setcookie("user",$user,time()+2592000,"/");
                    setcookie("pass",$pass,time()+2592000,"/");
                } 
                
                completarRegistro($fila['u_code']);
                 
                 
			}
		} 
       
        if(!isset($_SESSION['iduser'])){    
            echo "<body><script>Swal.fire({
                  title: 'Alerta',
                  text: '¡Datos incorrectos!',
                  icon: 'warning'
                }).then((result) => {
                  if(result.isConfirmed || Swal.DismissReason.timer){ 
                    window.history.back();
                  }
                }); </script></body>";
        }
}
//EDITA LOS USUARIOS
elseif(isset($_POST["editar"])){ 

     $iduser = mysqli_real_escape_string($con_app,$_POST["iduser"]);    
     $moneda = mysqli_real_escape_string($con_app,$_POST["moneda"]);    
     $periodo = mysqli_real_escape_string($con_app,$_POST["periodo"]);    
     $nombre = mysqli_real_escape_string($con_app,$_POST["nombre"]);    
     $tel = mysqli_real_escape_string($con_app,$_POST["tel"]);    
     $email = mysqli_real_escape_string($con_app,$_POST["email"]);    
     $pass = mysqli_real_escape_string($con_app,$_POST["pass"]); 
    $pass = password_hash($pass, PASSWORD_DEFAULT); 
      
	    //INGRESA LOS DATOS A LA DB
    	$main= mysqli_query($con_users, "UPDATE table_users SET u_name='$nombre', u_phone='$tel', u_mail='$email', u_pass='$pass' WHERE u_code='$iduser'");
    	
        if($main){
            $app= mysqli_query($con_app, "UPDATE usuarios SET moneda='$moneda', periodo='$periodo' WHERE idusuario='$iduser'");
            if($app){
                //	EL USUARIO DEBE PODER INICIAR SECCION CON SU CORREO O TELEFONO Y SU CONTRASENA
		$users = mysqli_query($con_users, "SELECT * FROM table_users WHERE u_code='$iduser'");
		$subusers = mysqli_query($con_app, "SELECT * FROM usuarios WHERE idusuario='$iduser'");
                if(session_id() ===""){ session_start();}
		while($fila=mysqli_fetch_array($users)){                 
				$_SESSION['iduser']=$fila['u_code']; 
                $_SESSION['name']=$fila['u_name'];
                $_SESSION['email']=$fila['u_mail'];
                $_SESSION['phone']=$fila['u_phone'];              
			}
		   while($fila=mysqli_fetch_array($subusers)){ 
                $_SESSION['moneda']=$fila['moneda'];              
                $_SESSION['periodo']=$fila['periodo'];              
			}
		          mysqli_free_result($users);
		          mysqli_free_result($subusers);
                echo " <script>
                    swal.fire({
                        icon: 'success',
                        title: 'Editado correctamente.',
                        timer: 5000            
                     }).then((result) => {
                        if(result.isConfirmed || Swal.DismissReason.timer){ location.reload(); }
                    });
                </script>";
            }else{
                echo " <script>
                    swal.fire({
                        icon: 'error',
                        title: 'Error al editar.',
                        timer: 5000            
                     }).then((result) => {
                        if(result.isConfirmed || Swal.DismissReason.timer){ location.reload(); }
                    });
                </script>";
                
            }
        }
}

//COMPLETAR REGISTRO
elseif(isset($_POST["completar"])){ 
    if(session_id() ===""){ session_start();}

     $iduser = mysqli_real_escape_string($con_app,$_POST["iduser"]);    
     $moneda = mysqli_real_escape_string($con_app,$_POST["moneda"]);    
     $periodo = mysqli_real_escape_string($con_app,$_POST["periodo"]);    
      
   	if(mysqli_num_rows(mysqli_query($con_app,"SELECT * FROM usuarios WHERE idusuario='$iduser'")) == 0){
	    //INGRESA LOS DATOS A LA DB
    	$ex= mysqli_query($con_app, "INSERT INTO usuarios (idusuario,moneda,periodo)VALUES('$iduser','$moneda','$periodo')");
        if($ex){
            $respuesta = mysqli_query($con_app, "SELECT * FROM usuarios WHERE idusuario='$iduser'");
            if(mysqli_num_rows($respuesta) > 0){ 
                    while($fil=mysqli_fetch_array($respuesta)){
                        $_SESSION['moneda']=$fil['moneda'];
                        $_SESSION['periodo']=$fil['periodo'];
                            
                        echo " <script>
                                    swal.fire({
                                        icon: 'success',
                                        title: '¡Bienvenid@ ".ucwords($_SESSION['name'])." a FinanzApp!',
                                        text: 'Registrado correctamente.',
                                        confirmButtonText: 'Finalizar',
                                        timer: 5000            
                                     }).then((result) => {
                                        if(result.isConfirmed || Swal.DismissReason.timer){ location.href='../app/app.php'; }
                                    });
                                </script>";
                    }
            }
        }else{
             echo " <script>
                    swal.fire({
                        icon: 'Error',
                        title: 'Error al completar registro.',
                        confirmButtonText: 'Volver',
                        timer: 5000            
                     }).then((result) => {
                        if(result.isConfirmed || Swal.DismissReason.timer){ location.href='logout.php'; }
                    });
                </script>";
        }        
    }
}

//RESET PASS
elseif(isset($_POST["pass1"]) && isset($_POST["pass2"])){
        $iduser = mysqli_real_escape_string($con_users,$_POST["iduser"]);
        $pass = mysqli_real_escape_string($con_users,$_POST["pass2"]);
        $pass = password_hash($pass, PASSWORD_DEFAULT);  //SIFRA EL PASS     

	    //INGRESA LOS DATOS A LA DB
    	$exitosa = mysqli_query($con_users, "UPDATE table_users SET u_pass='$pass' WHERE u_code=$iduser") ;
        mysqli_close($con);
        if($exitosa){  
            echo "<body><script>Swal.fire({
                  title: 'Alerta',
                  text: '¡Contraseña cambiada exitosamente!',
                  icon: 'success'
                }).then((result) => {
                  if(result.isConfirmed || Swal.DismissReason.timer){ 
                    location.href=../index.php;
                  }
                }); </script></body>";
			echo "Contraseña cambiada exitosamente! <br><br><br>Ir a la página de acceso <a href='../index.php'>AQUI</a>.";
    		}else{echo "Error al editar!";} 
    }
//DELETE USER
elseif(isset($_POST["delete"])){
        $id = mysqli_real_escape_string($con_users,$_POST["delete"]);

        mysqli_query($con_users, "DELETE FROM users WHERE iduser=$id") ;
        mysqli_close($con);
    }  
//RECUPERAR CONTRASEÑA
elseif(isset($_POST["resetPass"])){
    
    $destino = mysqli_real_escape_string($con_users,$_POST['mailCell']);
    $url = mysqli_real_escape_string($con_users,$_POST['url']);
    $resetPass = mysqli_real_escape_string($con_users,$_POST['resetPass']);
    
           
//	VERIFICA QUE EL CORREO	NO EXISTA
	$existe = mysqli_query($con_users, "SELECT * FROM table_users WHERE u_mail='$destino' OR u_phone='$destino'");

	if(mysqli_num_rows($existe) > 0 ){ //SI EL CORREO YA EXISTE, SE LE NOTIFICA EL USUARIO
        while($fila=mysqli_fetch_array($existe)){
            $iduser=$fila['u_code']; 
            $user=$fila['u_name']; 
        }
        
                   
       if(strpos($url,"index.php")){
          $newurl=str_replace("index.php","app/resetPassword.php",$url);
       }else{
          $newurl=$url."app/resetPassword.php";
       }
           
            
            
             $mail = new PHPMailer(true);
            
                //Server settings
                $mail->SMTPDebug = 0;                                       // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.hostinger.com';                   // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'news@en4es.com';                    // SMTP username
                $mail->Password   = 'Juan4544642';                          // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                //Recipients
                $mail->setFrom('news@en4es.com', 'Reset Password');
                
        //ENVIAR UN SMS
         if($resetPass=='cell'){ 
                //Destinatarios
                $mail->addAddress("$destino@mms.att.net", "client");      //ATT MMS
//                $mail->addBCC("$destino@mms.alltelwireless.com");         //Alltel  MMS
//                $mail->addBCC("$destino@myboostmobile.com");              //Boost Mobile  MMS y SMS
//                $mail->addBCC("$destino@mms.cricketwireless.net");        //Cricket Wireless  MMS
//                $mail->addBCC("$destino@msg.fi.google.com");              //Project Fi  MMS y SMS
//                $mail->addBCC("$destino@pm.sprint.com");                  //Sprint  MMS
//                $mail->addBCC("$destino@tmomail.net");                    //T-Mobile  MMS y SMS
//                $mail->addBCC("$destino@mms.uscc.net");                   //U.S. Cellular  MMS
//                $mail->addBCC("$destino@vzwpix.com");                     //Verizon MMS
//                $mail->addBCC("$destino@vmpix.com");                      //VIRGIN MOBILE MMS
//                $mail->addBCC("$destino@text.republicwireless.com");      //Republic Wireless SMS

                // Contenido del mensaje
                $mail->Body    = "Para recuperar contraseña, haz clic en el siguiente link: $newurl?code=$iduser";
            try {
                $mail->send();
                //AQUI VAL EL MENSAJE EXITOSO
                echo " SMS enviado correctamente!";
            } catch (Exception $e) {
               //QUI VA EL MENSAJE DE ERROR 
                echo "Error al enviar SMS.";
            }
        $mail->clearAddresses();

            
         }else{//ENVIAR UN MAIL
             //Recipients
                $mail->addAddress($destino, "Client");     // Add a recipient
             
                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Recuperar cuenta.';
                $mail->Body    = "<h3><font color='red'>¿Solicitaste cambiar la contraseña?</font></h3><br><br>
                <p>Si no has sido tú, has clic en este <a href='$url'>enlace</a> e ingresa a tu cuenta, y verifica que todo este marchando bien. </p>
                <p>Para cambiar contraseña has clic en este <a href='$newurl?code=".base64_encode($iduser)."'>enlace</a> e ingresa una nueva contraseña. </a>";
             try {

                $mail->send();
                echo "Enviamos un enlace al siguente correo: <a href='mailto:".$_POST['email']."'> ".$_POST['email']."</a>, revísalo  y da clic en el enlace cambiar contraseña."; 
            } catch (Exception $e) {
                echo "Error al solicitar cambio de contraseña.\n\n Intente más tarde.";
                echo " {$mail->ErrorInfo}";
            }
        }
    }else{
        echo " <script>  alert('Este destino ($destino), no está vinculado a ningun usuario en nuestra base de datos.'); </script>";
    }
}

//LOGIN WITH CODE
elseif(isset($_POST["recuperar_cuenta"])){
       
        $user = mysqli_real_escape_string($con_users,$_POST["info_user"]);
        $passCode = mysqli_real_escape_string($con_users,$_POST["code"]);        

    //	EL USUARIO DEBE PODER INICIAR SECCION CON SU CORREO O TELEFONO Y SU CONTRASENA
		$res = mysqli_query($con_users, "SELECT * FROM table_users WHERE (u_mail='$user' OR u_phone='$user') AND  u_passcode='$passCode'");
    if(mysqli_num_rows($res) > 0){
        if(session_id() ===""){ session_start();}
		while($fila=mysqli_fetch_array($res)){               
                //SI EL USER Y EL PASS SON VALIDOS, SE INICIA LA SECSION
                $_SESSION['iduser']=$fila['u_code']; 
                $_SESSION['name']=$fila['u_name'];
                $_SESSION['email']=$fila['u_mail'];
                $_SESSION['phone']=$fila['u_phone'];
                $_SESSION['userdate']=$fila['u_date'];
                
                completarRegistro($fila['u_code']);                         			
        } 
        }else{                
                echo "<body>
                        <script>
                               Swal.fire({
                                   icon: 'error',
                                   title: 'Oops!',
                                   text: 'La información de acceso proporcionada no concuerda.',
                                }).then((result) =>{
                                     if(result.isConfirmed || Swal.DismissReason.timer){ location.href='../app/reset.html'; }                                     
                                });
                        </script>  
                    </body>";  
        }
} 

				
 //SI EL USURIO NO EXSITE EN LA APP FINANZAS, ENTOCES QUE COMPLETE EL REGISTRO; SINO, MUESTRA UNA ALERTA 
function completarRegistro($iduser){
    include("connection.php");  
    $respuesta = mysqli_query($con_app, "SELECT * FROM usuarios WHERE idusuario='$iduser'");
    if(mysqli_num_rows($respuesta) > 0){ 
        if(session_id() ===""){ session_start();}
            while($fil=mysqli_fetch_array($respuesta)){
                $_SESSION['moneda']=$fil['moneda'];
                $_SESSION['periodo']=$fil['periodo'];
                header("location: ../app/app.php");
            }
    }else{ ?>

    <body>
        <script>
            Swal.fire({
                title: 'Completar registro',
                html: '<form id="formCompletar"><input type="text" placeholder="Moneda" name="moneda" list="moneda" required maxlength="3"><select name="periodo"><option value="Diario">Diario</option><option value="Semanal">Semanal</option><option value="Quincenal">Quincenal</option><option value="Mensual">Mensual</option><option value="Anual">Anual</option></select><input type="hidden" name="iduser" value="<?php echo $iduser ?>"><input type="hidden" name="completar"></form>',
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: 'Completar',
                denyButtonText: `Cancelar`,
            }).then((result) => {
                if(result.isConfirmed || Swal.DismissReason.timer){ 
                    $.ajax({
                        type: 'POST',
                        url: 'usuarios.php',
                        data: $('#formCompletar').serialize(),
                        success: function(data) {
                            $('body').append(data);
                        }
                    });
                    return false;
                } else if (result.isDenied) {
                    location.href = 'logout.php';
                }
            });

        </script>
    </body>
    <?php  }
}
mysqli_close($con_users); ?>


</body>

</html>
