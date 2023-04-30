<?php
    date_default_timezone_set("America/Sao_Paulo");
    header('Content-Type: text/html; charset=utf-8');
    $servidor="localhost";
    $usuario="root";
    //$senhabd="";
    $banco="velvetunderground";
    $mysqli  = new mysqli($servidor, $usuario, $senhabd, $banco);
	if ( mysqli_connect_errno() ) {
	    trigger_error( mysqli_connect_error() ) ;
    }
?>