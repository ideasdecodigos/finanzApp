
<!--
  
            <script src="../js/jquery-3.3.1.min.js"></script>
            <link rel="stylesheet" href="../src/sweetAlert2/sweetalert2.min.css">
            <script src="../src/sweetAlert2/sweetalert2.all.min.js"></script>
-->
<?php	 //INICIA SESION SINO EXISTE
if(session_id() ===""){ session_start();}

//INICIA SESION AUTOMATICAMENTE SI EXITEN COOKIES
if(isset($_COOKIE['user']) and isset($_COOKIE['pass'])){ ?>
    <script>//ENVIA EL USER Y EL PASS AL CONTROL DE ACCESO
        $(function() {
            $.ajax({
                type: 'POST',
                url: 'svr/usuarios.php',
                data: {
                    user: '<?php echo $_COOKIE['user'] ?>',
                    pass: '<?php echo $_COOKIE['pass'] ?>',
                    acceder: ''
                },
                success: function(data) {
                    $("body").append(data);
                }
            });
            return false;
        });
    </script>
<?php    }//**************************************FIN DE LAS COOKIES
elseif(isset($_SESSION['iduser'])){//INICIA SESION AUTOMATICAMENTE SI EXISTE UN SESION ABIERTA    
        $iduser=$_SESSION['iduser'];        
        include ("svr/connection.php");
    //	EL USUARIO DEBE PODER INICIAR SECCION CON SU CORREO O TELEFONO Y SU CONTRASENA
		$users = mysqli_query($con_users, "SELECT * FROM  table_users WHERE u_code='$iduser'");
        if(mysqli_num_rows($users) > 0){
            session_unset();
		    session_destroy();
            
            while($fila=mysqli_fetch_array($res)){                
                    $mail=$fila['u_mail'];
                    $phone=$fila['u_phone']; 
                    $pass=$fila['u_pass']; 
            }
      ?>
            <script>
                $(function() {
                    $.ajax({
                        type: 'POST',
                        url: 'svr/usuarios.php',
                        data: {
                            user: '<?php echo ($mail != "" ? $mail : $phone ); ?>',
                            pass: '<?php echo $pass ?>',
                            acceder: ''
                        },
                        success: function(data) {
                            $("body").append(data);
                        }
                    });
                    return false;
                });
            </script>
<?php                 
			mysqli_free_result($users);
			mysqli_close($con_users);
			mysqli_close($con_app);
        }
}
