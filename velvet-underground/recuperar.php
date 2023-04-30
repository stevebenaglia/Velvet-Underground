<?php
    include "conectar.php";
    $atualizacaocor="";
    $atualizacao="";
    $atualizacaomostra="none";
    $trancado="";
    if(isset($_REQUEST["atualizacao"])){
        $atualizacao=$_REQUEST["atualizacao"];
        $atualizacaomostra="inline";
        if(isset($_REQUEST["atualizacaocor"])){
            $atualizacaocor=$_REQUEST["atualizacaocor"];
        }
    }
    if(isset($_REQUEST["token"])){
        $token=$_REQUEST["token"];
        $sql="SELECT * FROM recuperarSenha WHERE token='$token'";
        $res=$mysqli->query($sql);
        $dados=mysqli_fetch_object($res);
        if($res->num_rows>0){
            $data1=new DateTime($dados->data);
            $data2=new DateTime(date("Y-m-d H:i:s"));
            $diferenca=$data1->diff($data2);
            if($diferenca->i<30){
                if(isset($_POST["txtsenha"])){
                    if($_POST["txtsenha"]==$_POST["txtsenha2"]){
                        $senhanova=md5($_POST["txtsenha"]);
                        $sql2="UPDATE login set senha='$senhanova' WHERE codigo='$dados->codusuario'";
                        $res2=$mysqli->query($sql2);
                        Header("location:login.php?atualizacao=Senha alterada com sucesso!&atualizacaocor=rgb(0,255,0)");
                    }else{
                        $atualizacao="Confirme a senha novamente";
                        $atualizacaocor="red";
                        $atualizacaomostra="inline";
                    }
                }
            }else{
                $atualizacao="Link incorreto ou expirado";
                $atualizacaocor="red";
                $atualizacaomostra="inline";
                $trancado="disabled";
                $sql3="DELETE FROM recuperarSenha WHERE codusuario='$dados->codusuario'";
                $res3=$mysqli->query($sql3);
            }
        }else{
            $atualizacao="Link incorreto ou expirado";
            $atualizacaocor="red";
            $atualizacaomostra="inline";
            $trancado="disabled";
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Velvet Underground</title>
        <link rel=stylesheet href="style.css">
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <meta name="viewport" content="width=device-width, initial-scale=1."/>
        <style>          
            ::-webkit-scrollbar {
                width: 0vw;
                height:0px;
            }
            ::-webkit-scrollbar-thumb{
                width:0vw;
                background:#A9A9A9;
            }
            ::-webkit-scrollbar-track{
                background:white;
                width:0vw;
            }
            body,html{
                overflow:hidden;
            }
        </style>
    </head>
    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="script.js"></script>
        <?php
            include "json.php";
            if(isset($_SESSION["codigo"])){
                echo '<script>alert("Você já está logado");window.location.href="index.php";</script>';
                die();
            }else{
                echo '<div class=header style="animation:none;" id=header>';
                echo     '<span style="margin-left:2vw;cursor:pointer;" onclick=window.location.href="index.php">VELVET UNDERGROUND</span>';
                echo     '<span class="icones" style="width:1vw"></span>';
                echo     '<span class="icones"><img id="usuario" class="lupa" src="usuario.png" alt="Usuário"></span>';
                echo     '<span class="icones"><img class="lupa" onclick=carrinhosemlogin() src="carrinho.png" alt="Carrinho"></span>'; 
                echo     '<input type="text" id="barrapesquisa" placeholder="PESQUISA" class="barrapesquisa" name="contpesquisa"> <div class="pesquisaResultados"></div>';
                echo     '<div class="logincont"><div class="botaoLogin" onclick=window.location.href="login.php">Login</div><div class="botaoLogin" onclick=window.location.href="cadastro.php">Cadastro</div></div>';
                echo '</div>';
            }
        ?>
        <img src="fundocadastro.png" class=banner style="position:absolute; width:100vw; z-index:-1">
        <div class=content style="white-space:nowrap">
            <center>
                <div class="formlogin">
                    <form method="post" action="">
                        <span>Recuperar sua senha</span><br>
                        <span class="atualizacao" style="color:<?php echo $atualizacaocor; ?>" display=<?php echo $atualizacaomostra.'>'.$atualizacao ?></span><br>
                        <input type="password" name="txtsenha" <?php echo $trancado ?> placeholder="Digite sua nova senha"><br>
                        <input type="password" name="txtsenha2" <?php echo $trancado ?> placeholder="Confirme sua nova senha"><br>
                        <input type="submit" value="Enviar">
                        <span class="esqueceu" onclick="window.location.href='login.php'">Voltar</span>
                </div>
            </center>
        </div>
    </body>
</html>