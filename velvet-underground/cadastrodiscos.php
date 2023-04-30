<?php
    session_start();
    include "conectar.php";
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
                $sql="select * from login where codigo=".$_SESSION["codigo"];
                $res=$mysqli->query($sql);
                $dados=mysqli_fetch_object($res);
                if($dados->admin==0){
                    echo '<script>alert("Você não tem permissão para acessar essa página");window.location.href="index.php";</script>';
                }else{
                    $sql6="SELECT * FROM login WHERE codigo=".$_SESSION["codigo"];
                    $res6=$mysqli->query($sql6);
                    $dados6=mysqli_fetch_object($res6);
                    echo '<div class=header id=header>';
                    echo     '<span onclick=window.location.href="index.php" style="margin-left:2vw;cursor:pointer;">VELVET UNDERGROUND</span>';
                    echo     '<span class="icones" style="width:1vw"></span>';
                    if($dados6->admin>0){
                        echo '
                        <span class="icones"><img id="adicionarcd" onclick=window.location.href="cadastrodiscos.php" class="lupa" src="adicionacd.png" alt="Adicionar CD"></span>';
                        if($dados6->admin>998){
                            echo '<span class="icones"><img id="adicionarfuncionario" class="lupa" onclick=window.location.href="cadastrofuncionarios.php" src="adicionafuncionario.png" alt="Adicionar Funcionário"></span>';
                        }
                    }
                    echo     '<span class="icones"><img id="usuario" class="lupa" src="usuario.png" alt="Usuário"></span>';
                    echo     '<span class="icones"><img id="carrinho" class="lupa" src="carrinho.png" alt="Carrinho"></span>'; 
                    echo     '<input type="text" id="barrapesquisa" placeholder="PESQUISA" class="barrapesquisa" name="contpesquisa"> <div class="pesquisaResultados"></div>';
                    echo     '<div class="logincont"><div class="botaoLogin" onclick=window.location.href="perfil.php">Perfil</div><div class="botaoLogin" onclick=window.location.href="pedidos.php">Pedidos</div><div class="botaoLogin" onclick=window.location.href="logout.php">Logout</div></div>';
                    echo     '<div id="carrinhoaberto" class="carrinho">';
                    $sql="select * from carrinho where codusuario =".$_SESSION["codigo"];
                    $res=$mysqli->query($sql);
                    while($dados=mysqli_fetch_object($res)){
                        $sql2="select * from discos where codigo=".$dados->coddisco;
                        $res2=$mysqli->query($sql2);
                        while($dados2=mysqli_fetch_object($res2)){
                            echo    '<div class="carrinhocont" id="carrinhocont"><img src="'.$dados2->capa.'" class="capa"><span class="preco">R$'.$dados2->preco.'</span><div class="remover" onclick=window.location.href="remover.php?codigo='.$dados->codigo.'">X</div></div>';
                        }
                    }
                    echo     '<div style="height:4vh"></div>';
                    echo     '<div class="setacarrinho" onclick=scrollcarrinho()>V</div>';
                    echo     '<div class="finalcompra" onclick=window.location.href="finalcompra.php">Finalizar</div>';
                    echo     '</div>';
                    echo '</div>';
                }
            }else{
                echo '<script>alert("Faça o login primeiro");window.location.href="login.php";</script>';
                die();
            }
        ?>
        <img src="fundocadastro.png" class=banner style="position:absolute; width:100vw; z-index:-1">
        <div class=content style="white-space:nowrap">
            <div class="textocadastro">
                <h1>Discos</h1>
                Cadastre discos ao lado utilizando as informações que foram lhe passadas para preencher TODOS os campos do formulário como é pedido.
            </div>
            <div class="formcadastro" style="bottom:22vh;">
                <form method="post" action="cadastrardisco.php">
                    <input type="text" name="txtnome" required maxlength="50" placeholder="Nome" style="margin-top:5vh"><br>
                    <input type="text" name="txtartista" required maxlength="50" placeholder="Artista"><br>
                    <input type="text" name="txtgenero" required maxlength="30" placeholder="Gênero"><br>
                    <input type="text" name="txtcapa" required maxlenght="200" placeholder="Caminho para a capa do álbum. Ex:humbug.png"><br>
                    <input type="text" name="txtdescricao" required maxlength="1000" placeholder="Descrição"><br>
                    <input type="number" name="txtpreco" required step="0.01" placeholder="Preço em reais. Ex:129.90" style="width:36vw;">
                    <input type="number" name="txtquantidade" required placeholder="Quantidade" style="width:12vw;"><br>
                    <input type="submit" value="ENVIAR">
                </form>
            </div>
        </div>
    </body>
</html>