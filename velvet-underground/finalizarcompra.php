<?php
    include "conectar.php";
    $codusuario=$_REQUEST["codigo"];
    $sql="SELECT * FROM carrinho where codusuario=".$codusuario;
    $res=$mysqli->query($sql);
    if($res->num_rows>0){
        $valorfin=$_REQUEST["valorfinal"];
        $n=0;
        $ano=date("Y");
        $mes=date("m");
        $dia=date("d");
        $hora=date("H");
        $minutos=date("i");
        $segundos=date("s");
        $cds=array(0,0,0,0,0,0,0,0,0,0);
        $quantidade=0;
        while($dados=mysqli_fetch_object($res)){
            $cds[$n]=$dados->coddisco;
            $n++;
        }
        $sql5="insert into pedidos(codusuario,cod1,cod2,cod3,cod4,cod5,cod6,cod7,cod8,cod9,cod10,valorfinal, ano, mes, dia, hora, minutos, segundos, quantidade, status) values(".$codusuario.",".$cds[0].",".$cds[1].",".$cds[2].",".$cds[3].",".$cds[4].",".$cds[5].",".$cds[6].",".$cds[7].",".$cds[8].",".$cds[9].",".$valorfin.",'".$ano."','".$mes."','".$dia."','".$hora."','".$minutos."','".$segundos."', ".$n.", 0)";
        $res5=$mysqli->query($sql5);
        $sql4="DELETE FROM carrinho where codusuario=".$codusuario; 
        $res4=$mysqli->query($sql4);
        echo "<script>alert('Pedido feito com sucesso!');window.location.href='index.php'</script>";
    }else{
        echo "<script>alert('Adicione discos ao carrinho antes!');window.location.href='index.php'</script>";
    }
?>