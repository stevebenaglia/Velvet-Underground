<?php
    include "conectar.php";
    session_start();
    if(isset($_REQUEST["txtnome"])){
    $nome=$_REQUEST["txtnome"];
    }
    if(isset($_REQUEST["txtemail"])){
    $email=$_REQUEST["txtemail"];
    }
    if(isset($_REQUEST["txtsenha"])){
    $senha=md5($_REQUEST["txtsenha"]);
    }
    if(!isset($nome)){
    }else{
    $sql="update login set nome='$nome' where codigo=".$_SESSION['codigo'];
    $res=$mysqli->query($sql);
    }
    if(!isset($email)){
    }else{
    $sql="update login set email='$email' where codigo=".$_SESSION['codigo'];
    $res=$mysqli->query($sql);
    }
    if(!isset($senha)){
    }else{
    $sql="update login set senha='$senha' where codigo=".$_SESSION['codigo'];
    $res=$mysqli->query($sql);
    }
    echo '<script>alert("Alterado com sucesso!");window.location.href="perfil.php";</script>';
?>