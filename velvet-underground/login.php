<?php
    include "conectar.php";
    $atualizacaocor="red";
    if(isset($_REQUEST["atualizacao"])){
        $atualizacao=$_REQUEST["atualizacao"];
        $atualizacaomostra="inline";
        if(isset($_REQUEST["atualizacaocor"])){
            $atualizacaocor=$_REQUEST["atualizacaocor"];
        }
    }else{
    $atualizacao="";
    $atualizacaomostra="none";
    }
    $email="";
    if(isset($_POST["txtemail"])){
        if($_POST["txtemail"]==""){
            $atualizacao="Digite um email";
            $atualizacaocor="red";
            $atualizacaomostra="inline";
        }else{
        $email=$_POST["txtemail"];
        $sql = "SELECT * FROM login WHERE email='$email'";
        $res = $mysqli->query($sql);
        $dados=mysqli_fetch_object($res);
        if($res->num_rows>0){
            if(isset($_POST["txtsenha"])){
                if($_POST["txtsenha"]==""){
                    $atualizacao="Digite uma Senha";
                    $atualizacaocor="red";
                    $atualizacaomostra="inline";
                }else{
                    $senha=md5($_POST["txtsenha"]);
                    $sql2="SELECT * FROM login WHERE email='$email' and senha='$senha'";
                    $res2=$mysqli->query($sql2);
                    if($res2->num_rows>0){
                        session_start();
                        $_SESSION["codigo"]=$dados->codigo;
                        Header("location:index.php");
                    }else{
                        $atualizacao="Senha Incorreta";
                        $atualizacaocor="red";
                        $atualizacaomostra="inline";
                    }
                }
            }
        }else{
            $atualizacao="Email Incorreto";
            $atualizacaocor="red";
            $atualizacaomostra="inline";
            $email="";
        }
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
            if(isset($_SESSION["login"])){
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
                        <span>Login</span><br>
                        <span class="atualizacao" style="color:<?php echo $atualizacaocor; ?>"display=<?php echo $atualizacaomostra.'>'.$atualizacao ?></span><br>
                        <input type="text" name="txtemail" placeholder="Endereço de Email" value="<?php echo $email ?>"><br>
                        <input type="password" name="txtsenha" placeholder="Senha"><br>
                        <input type="submit" value="Entrar">
                        <span class="esqueceu" onclick="window.location.href='esqueceu.php'">Esqueceu sua senha?</span>
                </div>
            </center>
        </div>
    </body>
</html>