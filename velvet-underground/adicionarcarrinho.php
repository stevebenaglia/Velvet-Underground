<?php
    include 'conectar.php';
    session_start();
    $sql4="select * from carrinho where codusuario=".$_SESSION["codigo"];
    $res4=$mysqli->query($sql4);
    if($res4->num_rows>9){
        Header('location:finalcompra.php?atualizacao=Limite de itens no carrinho atingido&atualizacaocor=red');
    }else{
        $coddisco=$_REQUEST["codigo"];
        if(isset($_SESSION['codigo'])){
            $sql="SELECT * FROM discos where codigo=".$coddisco;
            $res=$mysqli->query($sql);
            $dados=mysqli_fetch_object($res);
            if($dados->quantidade>0){
                $sql2="INSERT INTO carrinho(coddisco,codusuario) values('".$coddisco."','".$_SESSION['codigo']."')";
                $res2=$mysqli->query($sql2);
                $quantnova=$dados->quantidade-1;
                $sql3="UPDATE discos set quantidade=".$quantnova." where codigo=$coddisco";
                $res3=$mysqli->query($sql3);
                Header('location:finalcompra.php?atualizacao=Adicionado ao carrinho com sucesso!&atualizacaocor=rgb(0,255,0)');
            }else{
                echo '<script>alert("O disco selecionado está esgotado");window.location.href="pagcd.php?codigo='.$coddisco.'";</script>';
            }
        }else{
            Header('location:login.php?atualizacao=Faça o login para adicionar ao carrinho&atualizacaocor=red');
        }
    }
?>