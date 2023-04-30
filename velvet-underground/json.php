<script>
            var Banco={
                "Discos":[
                ]
            }
</script>
<?php
    $sql4="SELECT * FROM discos";
    $res4=$mysqli->query($sql4);
    while($dados4=mysqli_fetch_object($res4)){
        echo '<script>
                Banco.Discos.push({"Nome":"'.$dados4->nome.'","Codigo":"'.$dados4->codigo.'","Artista":"'.$dados4->artista.'","Capa":"'.$dados4->capa.'","Genero":"'.$dados4->genero.'"});
            </script>';
    }
    echo '
    <script>
    myJSON=JSON.stringify(Banco);
    localStorage.setItem("testeJSON",myJSON);
    console.log(Banco);
    </script>';
?>