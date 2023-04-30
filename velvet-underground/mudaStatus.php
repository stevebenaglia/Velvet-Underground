<?php
    include "conectar.php";
    session_start();
    $acao=$_REQUEST["acao"];
    $codigo=$_REQUEST["codigo"];
    $status=$_REQUEST["status"];
    if($acao=='pedidos'){
        $sql='UPDATE '.$acao.' SET status='.$status.' WHERE codigo='.$codigo;
    }else{
        $sql='UPDATE '.$acao.' SET status='.$status.' WHERE codpedido='.$codigo;
    }
    if($acao=='pedidos'&$status==2){
        $sql3="SELECT * FROM pedidos WHERE codigo=$codigo";
        $res3=$mysqli->query($sql3);
        $dados3=mysqli_fetch_object($res3);
        $codusuario=$dados3->codusuario;
        $valor=$dados3->valorfinal;
        $dia=date("d");
        $mes=date("m");
        $ano=date("Y");
        $hora=date("H");
        $minutos=date("i");
        $segundos=date("s");
        $sql2="insert into reembolso(codpedido,codusuario,descricao,ano,mes,dia,hora,minutos,segundos,status,valor) values($codigo,$codusuario,'Alterado por Administrador',$ano,$mes,$dia,$hora,$minutos,$segundos,0,$valor)";
        $res3=$mysqli->query($sql3);
    }
    if($acao=='pedidos'&$status!=2){
        $sql2="DELETE FROM reembolso WHERE codpedido=$codigo";
    }
    $res=$mysqli->query($sql);
    $res2=$mysqli->query($sql2);
    Header('location:pedidos.php');
?>