<?php
    session_start();
    include "conectar.php";
    $codpedido=$_REQUEST["codigo"];
    $sql3="SELECT * FROM pedidos WHERE codigo=$codpedido";
    $res3=$mysqli->query($sql3);
    $dados3=mysqli_fetch_object($res3);
    $codusuario=$dados3->codusuario;
    $descricao=$_REQUEST["txtdescricao"];
    $valor=$_REQUEST["valor"];
    $dia=date("d");
    $mes=date("m");
    $ano=date("Y");
    $hora=date("H");
    $minutos=date("i");
    $segundos=date("s");
    $sql="insert into reembolso(codpedido,codusuario,descricao,ano,mes,dia,hora,minutos,segundos,status,valor) values($codpedido,$codusuario,'$descricao',".$ano.",".$mes.",".$dia.",".$hora.",".$minutos.",".$segundos.",0,".$valor.")";
    $res=$mysqli->query($sql);
    $sql2="update pedidos set status=2 where codigo=".$codpedido;
    $res2=$mysqli->query($sql2);
    echo '<script>alert("Reembolso solicitado com sucesso!");window.location.href="pedidos.php";</script>'
?>