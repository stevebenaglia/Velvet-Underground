<?php
    session_start();
    include "conectar.php";
    $codigo=$_REQUEST["codigo"];
    $coddisco=$_REQUEST["coddisco"];
    $sql="delete from carrinho where codigo=".$codigo." and coddisco=".$coddisco;
    $res=$mysqli->query($sql);
    $sql2="select * from discos where codigo=".$coddisco;
    $res2=$mysqli->query($sql2);
    $dados=mysqli_fetch_object($res2);
    $quantnova=$dados->quantidade+1;
    $sql3="update discos set quantidade=".$quantnova." where codigo=".$coddisco;
    $res3=$mysqli->query($sql3);
    echo '<script>alert("Removido com sucesso!");window.location.href=window.history.back();</script>';
?>