<?php
    include "conectar.php";
    session_start();
    if(isset($_REQUEST["txtestado"])){
    $estado=$_REQUEST["txtestado"];
    }
    if(isset($_REQUEST["txtcidade"])){
    $cidade=$_REQUEST["txtcidade"];
    }
    if(isset($_REQUEST["txtrua"])){
    $rua=$_REQUEST["txtrua"];
    }
    if(isset($_REQUEST["txtnumero"])){
    $numero=$_REQUEST["txtnumero"];
    }
    if(isset($_REQUEST["txtcomplemento"])){
    $complemento=$_REQUEST["txtcomplemento"];
    }
    if(!isset($estado)){
    }else{
    $sql="update login set estado='$estado' where codigo=".$_SESSION['codigo'];
    $res=$mysqli->query($sql);
    }
    if(!isset($cidade)){
    }else{
    $sql="update login set cidade='$cidade' where codigo=".$_SESSION['codigo'];
    $res=$mysqli->query($sql);
    }
    if(!isset($rua)){
    }else{
    $sql="update login set endereco='$rua' where codigo=".$_SESSION['codigo'];
    $res=$mysqli->query($sql);
    }
    if(!isset($numero)){
    }else{
    $sql="update login set numero='$numero' where codigo=".$_SESSION['codigo'];
    $res=$mysqli->query($sql);
    }
    if(!isset($complemento)){
    }else{
    $sql="update login set complemento='$complemento' where codigo=".$_SESSION['codigo'];
    $res=$mysqli->query($sql);
    }
    echo '<script>alert("Alterado com sucesso!");window.location.href="perfil.php";</script>';
?>