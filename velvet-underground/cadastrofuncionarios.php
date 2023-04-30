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
                                    if($_POST["txtafinidade"]==""){
                                        $atualizacao="Digite uma afinidade";
                                        $atualizacaomostra="inline";
                                    }else{
                                        $afinidade=$_POST["txtafinidade"];
                                        $sql2="select * from login";
                                        $res2=$mysqli->query($sql2);
                                        while($dados=mysqli_fetch_object($res2)){
                                            if($email==$dados->email){
                                                $atualizacao="Endereço de email já existe";
                                                $atualizacaomostra="inline";
                                                $email="";
                                            }
                                        }
                                    }
                                    if($email!=""){
                                    $sql="INSERT INTO login(email,senha,nome,idade,estado,cidade,endereco,numero,complemento,admin) values('$email','$senha','$nome',$idade,'$estado','$cidade','$rua',$numero,'$complemento',$afinidade)";
                                    $res=$mysqli->query($sql);   
                                    $sucesso="Registrado com sucesso!";
                                    echo '<script>window.location.href="index.php?";</script>';
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
                $sql6="SELECT * FROM login WHERE codigo=".$_SESSION["codigo"];
                $res6=$mysqli->query($sql6);
                $dados6=mysqli_fetch_object($res6);
                if($dados6->admin>0){
                    echo '<div class=header style="animation:none;" id=header>
                    <span style="margin-left:2vw;cursor:default;">VELVET UNDERGROUND</span>
                    <span class="icones" style="width:1vw"></span>';
                    echo '
                    <span class="icones"><img id="adicionarcd" onclick=window.location.href="cadastrodiscos.php" class="lupa" src="adicionacd.png" alt="Adicionar CD"></span>';
                    if($dados6->admin>998){
                        echo '<span class="icones"><img id="adicionarfuncionario" class="lupa" onclick=window.location.href="cadastrofuncionarios.php" src="adicionafuncionario.png" alt="Adicionar Funcionário"></span>';
                    }
                    echo '<span class="icones"><img id="usuario" class="lupa" src="usuario.png" alt="Usuário"></span>
                    <span class="icones"><img id="carrinho" class="lupa" src="carrinho.png" alt="Carrinho"></span> 
                    <input type="text" id="barrapesquisa" placeholder="PESQUISA" class="barrapesquisa" name="contpesquisa"> <div class="pesquisaResultados"></div>
                    <div class="logincont"><div class="botaoLogin" onclick=window.location.href="perfil.php">Perfil</div><div class="botaoLogin" onclick=window.location.href="pedidos.php">Pedidos</div><div class="botaoLogin" onclick=window.location.href="logout.php">Logout</div></div>
                    <div id="carrinhoaberto" class="carrinho">';
                    $sql="select * from carrinho where codusuario =".$_SESSION["codigo"];
                    $res=$mysqli->query($sql);
                    while($dados=mysqli_fetch_object($res)){
                        $sql2="select * from discos where codigo=".$dados->coddisco;
                        $res2=$mysqli->query($sql2);
                        while($dados2=mysqli_fetch_object($res2)){
                            echo    '<div class="carrinhocont" id="carrinhocont"><img src="'.$dados2->capa.'" class="capa"><span class="preco">R$'.$dados2->preco.'</span><div class="remover" onclick=window.location.href="remover.php?codigo='.$dados->codigo.'&coddisco='.$dados2->codigo.'">X</div></div>';
                        }
                    }
                    echo     '<div style="height:4vh"></div>
                    <div class="setacarrinho" onclick=scrollcarrinho()>V</div>
                    <div class="finalcompra" onclick=window.location.href="finalcompra.php">Finalizar</div>
                    </div>
                    </div>';
                }else{
                    echo '<script>alert("Você não tem acesso à esta página");window.location.href="index.php";</script>';
                }
            }else{
                echo '<script>alert("Faça o login para acessar");window.location.href="index.php";</script>';
                die();
            }
        ?>
        <img src="fundocadastro.png" class=banner style="position:absolute; width:100vw; z-index:-1">
        <div class=content style="white-space:nowrap">
            <div class="textocadastro">
                <h1>Cadastro de Funcionários</h1>
                O nosso site, Velvet Underground é um site feito com o objetivo de vender discos de modo simples e eficiente. Faça o seu cadastro para poder realizar seus pedidos!
            </div>
            <div class="formcadastro" style="bottom:40vh">
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
                    <input type="number" name="txtafinidade" maxlength="30" value="<?php if(isset($afinidade)){echo $afinidade;} ?>" placeholder="Afinidade do funcionário"><br>
                    <span class="atualizacao" display=<?php echo $atualizacaomostra . '>' . $atualizacao ?></span>
                    <input type="submit" value="ENVIAR">
                </form>
            </div>
        </div>
    </body>
</html>