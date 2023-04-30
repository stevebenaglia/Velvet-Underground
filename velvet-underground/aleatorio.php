<?php
    include('conectar.php');
    $sql="SELECT * FROM discos";
    $res=$mysqli->query($sql);
    $array=array();
    while($dados=mysqli_fetch_object($res)){
        array_push($array,$dados->codigo);
    }
    $aleatorio=rand(1,sizeof($array));
    Header('location:pagcd.php?codigo='.$aleatorio);
?>