<?php
    include "conectar.php";
    session_start();
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
                echo     '<form method="post" action="pesquisa.php"><input type="text" id="barrapesquisa" placeholder="PESQUISA" class="barrapesquisa" name="contpesquisa"></form> <div class="pesquisaResultados"></div>';
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
            }else{
                echo '<script>alert("Faça o login primeiro");window.location.href="login.php";</script>';
                die();
            }
        ?>
        <img src="fundoperfil.png" class=banner style="position:absolute; width:100vw; z-index:-1">
        <div class=content style="white-space:nowrap">
            <center>
                <div class="formperfil">
                <div class="titulo">Informações de cadastro</div><br>
                    <?php
                    $sql3="select * from login where codigo=".$_SESSION['codigo'];
                    $res3=$mysqli->query($sql3);
                    $dados3=mysqli_fetch_object($res3);
                    echo '<div id="formperfil" style="height:42vh;">';
                    echo '<form method="post" action="alterarperfil.php">';
                        echo '<input type="text" name="txtnome" class="desativar1 desativar" placeholder="Nome" value="'.$dados3->nome.'" disabled><input type="button" id="1" value="EDITAR" class="botoes"><br>';
                        echo '<input type="email" name="txtemail" class="desativar2 desativar" placeholder="Email" value="'.$dados3->email.'" disabled><input type="button" id="2"  value="EDITAR" class="botoes"><br>';
                        echo '<input type="password" name="txtsenha" class="desativar3 desativar" placeholder="Senha" disabled><input type="button" id="3" value="EDITAR" class="botoes"><br>';
                        echo '<div class="mudaperfil" id="mudaperfil1">Alterar Endereço</div>';
                    echo '</form>';
                    echo '</div>';
                    echo '<div id="formendereco" style="float:right;margin-right:6vw;height:44vh;padding-left:6vw;">';
                    echo '<form method="post" action="alterarendereco.php">';
                        echo '<input type="text" name="txtestado" class="desativar4 desativar" placeholder="Estado" style="width:14.5vw;" value="'.$dados3->estado.'" disabled><input type="button" id="4" value="EDITAR" class="botoes">';
                        echo '<input type="text" name="txtcidade" class="desativar5 desativar" placeholder="Cidade" style="width:14.5vw;" value="'.$dados3->cidade.'" disabled><input type="button" id="5" value="EDITAR" class="botoes"><br>';
                        echo '<input type="text" name="txtrua" class="desativar6 desativar" placeholder="Email" value="'.$dados3->endereco.'" disabled><input type="button" id="6"  value="EDITAR" class="botoes"><br>';
                        echo '<input type="number" name="txtnumero" class="desativar7 desativar" style="width:5vw;" placeholder="Email" value="'.$dados3->numero.'" disabled><input type="button" id="7"  value="EDITAR" class="botoes">';
                        echo '<input type="text" name="txtcomplemento" class="desativar8 desativar" style="width:24.3vw;" placeholder="Senha" value="'.$dados3->complemento.'" disabled><input type="button" id="8" value="EDITAR" class="botoes"><br>';
                        echo '<div class="mudaperfil" id="mudaperfil2">Alterar Perfil</div>';
                    echo '</form>';
                    echo '</div>';
                    ?>
                    <span class="aviso">*Altere mais de um dado de uma vez clicando em "EDITAR" em mais de um</span>
                </div>
            </center>
        </div>
    </body>
</html>