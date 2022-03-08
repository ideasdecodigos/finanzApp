<?php 
   //    CONECTA CON LA BASE DE DATOS USUARIOS
    $con_users = mysqli_connect('localhost','u795806260_main_users','Juan4544642','u795806260_main_users','3307') or die("Error de Conexion!");
    mysqli_query($con_users,"SET NAMES 'utf8'"); //Para que se inserten las tildes correctamente

    //CONECTA CON LA BASE DE DATOS FINANZAS
    $con_app = mysqli_connect('localhost','u795806260_finanzas','Juan4544642','u795806260_finanzas','3307') or die("Error de Conexion!");
    mysqli_query($con_app,"SET NAMES 'utf8'"); //Para que se inserten las tildes correctamente

