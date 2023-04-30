<?php
    include "conectar.php";
    $nome=$_REQUEST["txtnome"];
    $artista=$_REQUEST["txtartista"];
    $genero=$_REQUEST["txtgenero"];
    $capa=$_REQUEST["txtcapa"];
    $descricao=$_REQUEST["txtdescricao"];
    $preco=$_REQUEST["txtpreco"];
    $quantidade=$_REQUEST["txtquantidade"];
    $sql="INSERT INTO discos(nome,artista,genero,capa,descricao,preco,quantidade) values('$nome','$artista','$genero','$capa','$descricao',$preco,$quantidade)";
    $res=$mysqli->query($sql);
    echo '<script>alert("Registrado com sucesso!");window.location.href="index.php";</script>';
?>