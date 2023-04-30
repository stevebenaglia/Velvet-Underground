<?php
    session_start();
    include "conectar.php";
    $atualizacao="";
    $atualizacaomostra="none";
    if(isset($_POST["txtnome"])){
        if($_POST["txtnome"]==""){
            $atualizacao="Digite um nome";
            $atualizacaomostra="inline";
        }else{
            $nome=$_REQUEST["txtnome"];
            if($_POST["txtemail"]==""){
                $atualizacao="Digite um email";
                $atualizacaomostra="inline";
            }else{
                $email=$_REQUEST["txtemail"];
                if($_POST["txtsenha"]==""){
                    $atualizacao="Digite uma senha";
                    $atualizacaomostra="inline";
                }else{
                    $senha=md5($_REQUEST["txtsenha"]);  
                    if($_POST["txtidade"]==""){
                        $atualizacao="Digite uma idade";
                        $atualizacaomostra="inline";
                    }else{
                        $idade=$_REQUEST["txtidade"];
                        if($_POST["txtestado"]==""){
                            $atualizacao="Digite um Estado";
                            $atualizacaomostra="inline";
                        }else{
                            $estado=$_REQUEST["txtestado"];
                            if($_POST["txtcidade"]==""){
                                $atualizacao="Digite uma cidade";
                                $atualizacaomostra="inline";
                            }else{
                                $cidade=$_REQUEST["txtcidade"];
                                if($_POST["txtrua"]==""){
                                    $atualizacao="Digite uma rua";
                                    $atualizacaomostra="inline";
                                }else{
                                    $rua=$_REQUEST["txtrua"];
                                    if($_POST["txtnumero"]==""){
                                        $numero=000;
                                    }else{
                                    $numero=$_REQUEST["txtnumero"];
                                    }
                                    if($_POST["txtcomplemento"]==""){
                                        $complemento="S/Complemento";
                                    }else{
                                    $complemento=$_REQUEST["txtcomplemento"];
                                    }
                                    $sql2="select * from login";
                                    $res2=$mysqli->query($sql2);
                                    while($dados=mysqli_fetch_object($res2)){
                                        if($email==$dados->email){
                                            $atualizacao="Endereço de email já existe";
                                            $atualizacaomostra="inline";
                                            $email="";
                                        }
                                    }
                                    if($email!=""){
                                    $sql="INSERT INTO login(email,senha,nome,idade,estado,cidade,endereco,numero,complemento,admin) values('$email','$senha','$nome',$idade,'$estado','$cidade','$rua',$numero,'$complemento',0)";
                                    $res=$mysqli->query($sql);   
                                    $sucesso="Registrado com sucesso!";
                                    echo '<script>window.location.href="login.php?atualizacao='.$sucesso.'&atualizacaocor=rgb(0,255,0)";</script>';
                                    }
                                }
                            }
                        }
                    }
                }
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
            <div class="textocadastro">
                <h1>Cadastre-se</h1>
                O nosso site, Velvet Underground é um site feito com o objetivo de vender discos de modo simples e eficiente. Faça o seu cadastro para poder realizar seus pedidos!
            </div>
            <div class="formcadastro" style="bottom:25vh">
                <form method="post" action="">
                    <input type="text" name="txtnome" maxlength="50" value="<?php if(isset($nome)){echo $nome;} ?>" placeholder="Nome Completo" style="margin-top:5vh"><br>
                    <input type="email" name="txtemail" maxlength="40" value="<?php if(isset($email)){echo $email;} ?>" placeholder="E-mail"><br>
                    <input type="password" name="txtsenha" maxlength="20" placeholder="Senha" style="width:24vw;">
                    <input type="number" name="txtidade" placeholder="Idade" min="0" value="<?php if(isset($idade)){echo $idade;} ?>" style="width:24vw;"><br>
                    <input type="text" name="txtestado" maxlength="2" style="width:24vw;" value="<?php if(isset($estado)){echo $estado;} ?>" placeholder="Estado">
                    <input type="text" name="txtcidade" maxlength="50" style="width:24vw;" value="<?php if(isset($cidade)){echo $cidade;} ?>" placeholder="Cidade"><br>
                    <input type="text" name="txtrua" placeholder="Rua" value="<?php if(isset($rua)){echo $rua;} ?>" style="width:39vw;">
                    <input type="number" name="txtnumero" placeholder="Número" min="0" value="<?php if(isset($numero)){echo $numero;} ?>" style="width:9vw;"><br>
                    <input type="text" name="txtcomplemento" maxlength="30" value="<?php if(isset($complemento)){echo $complemento;} ?>" placeholder="Complemento"><br>
                    <span class="atualizacao" display=<?php echo $atualizacaomostra . '>' . $atualizacao ?></span>
                    <input type="submit" value="ENVIAR">
                </form>
            </div>
        </div>
    </body>
</html>