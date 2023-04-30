<?php
    session_start();
    include "conectar.php";
    $email="";
    $atualizacao="";
    $atualizacaomostra="none";
    $atualizacaocor="red";
    if(isset($_POST['txtemail'])){
        $email=$_POST['txtemail'];
        $sql="SELECT * FROM login WHERE email='$email'";
        $res=$mysqli->query($sql);
        if($res->num_rows>0){
            $dados=mysqli_fetch_object($res);
            $n=0;
            while($n<1){
                $token=sha1(rand());
                $sql2="SELECT * FROM recuperarSenha WHERE token='$token'";
                $res2=$mysqli->query($sql2);
                if($res2->num_rows==0){
                    $n++;
                }
            }
            $data=date("Y-m-d H:i:s");
            $sql4="SELECT * FROM recuperarSenha WHERE codusuario='$dados->codigo'";
            $res4=$mysqli->query($sql4);
            if($res4->num_rows>0){
                $sql5="DELETE FROM recuperarSenha WHERE codusuario='$dados->codigo'";
                $res5=$mysqli->query($sql5);
                $sql3="INSERT INTO recuperarSenha(codusuario,token,data) VALUES('$dados->codigo','$token','$data')";
                /*ENVIA EMAIL*/
                $res3=$mysqli->query($sql3);
                Header('location:login.php?atualizacao=Enviado ao seu email!&atualizacaocor=rgb(0,255,0)');
            }else{
                $sql3="INSERT INTO recuperarSenha(codusuario,token,data) VALUES('$dados->codigo','$token','$data')";
                /*ENVIA EMAIL*/
                $res3=$mysqli->query($sql3);
                Header('location:login.php?atualizacao=Enviado ao seu email!&atualizacaocor=rgb(0,255,0)');
            }
        }else{
            $atualizacao="Email incorreto";
            $atualizacaomostra="inline";
            $atualizacaocor="red";
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
                <div class="formlogin" style="margin-top:40vh;">
                    <form method="post" action="">
                        <span>Esqueci minha senha</span><br>
                        <span class="atualizacao" style="color:<?php echo $atualizacaocor; ?>"display=<?php echo $atualizacaomostra.'>'.$atualizacao ?></span><br>
                        <input type="text" name="txtemail" placeholder="Endereço de Email" value="<?php echo $email ?>"><br>
                        <input type="submit" value="Enviar">
                        <span class="esqueceu" onclick="window.location.href='login.php'">Voltar</span>
                </div>
            </center>
        </div>
    </body>
</html>