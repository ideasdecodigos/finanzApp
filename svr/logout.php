<?php 
		session_start();
		session_unset();
		session_destroy();
        setcookie("user",$user,time()-2592000,"/");
        setcookie("pass",$pass,time()-2592000,"/");

header("location: ../index.php");     