<?php include("connection.php"); 
    //GUARDA LOS REGISTROS
if(isset($_POST["guardar"])){ 
        //DATOS PARA EL SMS POR EMAIL
        $valor = mysqli_real_escape_string($con_app,$_POST["valor"]); 
        $categoria = mysqli_real_escape_string($con_app,$_POST["categoria"]); 
        $concepto = mysqli_real_escape_string($con_app,$_POST["concepto"]); 
        $tipo = mysqli_real_escape_string($con_app,$_POST["tipo"]); 
        $usuario = mysqli_real_escape_string($con_app,$_POST["usuario"]); 
        $fecha = mysqli_real_escape_string($con_app,$_POST["fecha"]); 
    
        $truefalse = mysqli_query($con_app, "INSERT INTO registros(valor,categoria,tipo,concepto,usuario,fecha)
        VALUES('$valor','$categoria','$tipo','$concepto','$usuario','$fecha')");
        
        if($truefalse){  
         echo " <script>
                    swal.fire({ 
                        icon: 'success',
                        title: 'Guardada!',
                        text: 'Guardado correctamente.',
                        timer: 4000            
                     });
                </script>";    
        }else{ 
            echo " <script>
                    swal.fire({
                        icon: 'warning',
                        title: 'Error!',
                        text: 'Error al guradar.',
                        timer: 5000            
                     });
                </script>";
        }
    
 } 
    //EDITA LOS REGISTROS
if(isset($_POST["editar"])){ 
        //DATOS PARA EL SMS POR EMAIL
        $valor = mysqli_real_escape_string($con_app,$_POST["valor"]); 
        $categoria = mysqli_real_escape_string($con_app,$_POST["categoria"]); 
        $concepto = mysqli_real_escape_string($con_app,$_POST["concepto"]); 
        $tipo = mysqli_real_escape_string($con_app,$_POST["tipo"]); 
        $idregistro = mysqli_real_escape_string($con_app,$_POST["idregistro"]); 
        $fecha = mysqli_real_escape_string($con_app,$_POST["fecha"]); 
    
        $truefalse = mysqli_query($con_app, "UPDATE registros SET valor='$valor',categoria='$categoria',tipo='$tipo',concepto='$concepto',fecha='$fecha' WHERE idregistro='$idregistro'");
        
        if($truefalse){ 
         echo " <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Editado!',
                        text: 'Editado correctamente.',
                        timer: 5000            
                     }).then((result) => {
                        if(result.isConfirmed || Swal.DismissReason.timer){ showRegistros(); }
                    });
                </script>";    
        }else{ 
            echo " <script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Error!',
                        text: 'Error al editar.',
                        showConfirmButton: true,
                        timer: 5000            
                     }).then((result) => {
                        if(result.isConfirmed || Swal.DismissReason.timer){ showRegistros(); }
                    });
                </script>";
        }
    
 } 
//ELIMINA UN REGISTRO
elseif(isset($_POST["delete"])){
        $id = mysqli_real_escape_string($con_app,$_POST["delete"]);

        if(mysqli_query($con_app, "DELETE FROM registros WHERE idregistro=$id")){
             echo "<script>
                    swal.fire({
                        icon: 'success',
                        text: 'Eliminado correctamente.',
                        timer: 5000            
                     }).then((result) => {
                        if(result.isConfirmed || Swal.DismissReason.timer){ showRegistros(); }
                    });
                </script>"; 
        }else{
             echo "<body> <script>
                    swal.fire({
                        icon: 'error',
                        text: 'Error al eliminar.',
                        timer: 5000            
                     });
                </script></body>"; 
        }
    } 

    mysqli_close($con_app); 

 ?>