<?php
    session_start();
    include "conectar.php";
    $codigo=$_REQUEST["codigo"];
    if(isset($_POST["nomecdtxt"])){
        $nomenovo=$_POST["nomecdtxt"];
        $artistanovo=$_POST["artistacdtxt"];
        $generonovo=$_POST["generoscd"];
        $descricaonovo=$_POST["descricaocdtxt"];
        $preconovo=$_POST["precocd"];
        $quantidadenovo=$_POST["quantidadecd"];
        $sql4='UPDATE discos SET nome="'.$nomenovo.'", artista="'.$artistanovo.'",genero="'.$generonovo.'",descricao="'.$descricaonovo.'",preco="'.$preconovo.'",quantidade='.$quantidadenovo.' WHERE codigo='.$codigo;
        $res4=$mysqli->query($sql4);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Velvet Underground</title>
        <link rel=stylesheet href="style.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <meta name="viewport" content="width=device-width, initial-scale=1."/>
        <style>        
            ::-webkit-scrollbar {
                width: 0.3vw;
                height:0px;
            }
            ::-webkit-scrollbar-thumb{
                width:0.3vw;
                background:#A9A9A9;
            }
            ::-webkit-scrollbar-track{
                background:rgba(0,0,0,0);
                width:0.3vw;
            }
        </style>
    </head>
    <body style="overflow:hidden;">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="script.js"></script>
        <?php
            include "json.php";
            if(isset($_SESSION["codigo"])){
                $sql6="SELECT * FROM login WHERE codigo=".$_SESSION["codigo"];
                $res6=$mysqli->query($sql6);
                $dados6=mysqli_fetch_object($res6);
                echo '<div class=header2 id=header>';
                echo     '<span style="padding-left:2vw;cursor:pointer;" onclick=window.location.href="index.php">VELVET UNDERGROUND</span>';
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
                echo     '<form method="post" action="pesquisa.php"><input type="text" id="barrapesquisa" placeholder="PESQUISA" class="barrapesquisa" name="contpesquisa"></form><div class="pesquisaResultados"></div>';
                echo     '<div class="logincont"><div class="botaoLogin" onclick=window.location.href="perfil.php">Perfil</div><div class="botaoLogin" onclick=window.location.href="pedidos.php">Pedidos</div><div class="botaoLogin" onclick=window.location.href="logout.php">Logout</div></div>';
                echo '</div>';
            }else{
                echo '<div class=header2 id=header>';
                echo     '<span style="padding-left:2vw;cursor:pointer;" onclick=window.location.href="index.php">VELVET UNDERGROUND</span>';
                echo     '<span class="icones" style="width:1vw"></span>';
                echo     '<span class="icones"><img id="usuario" class="lupa" src="usuario.png" alt="Usuário"></span>';
                echo     '<span class="icones"><img class="lupa" onclick=carrinhosemlogin() src="carrinho.png" alt="Carrinho"></span>';
                echo     '<form method="post" action="pesquisa.php"><input type="text" id="barrapesquisa" placeholder="PESQUISA" class="barrapesquisa" name="contpesquisa"></form><div class="pesquisaResultados"></div>';
                echo     '<div class="logincont"><div class="botaoLogin" onclick=window.location.href="login.php">Login</div><div class="botaoLogin" onclick=window.location.href="cadastro.php">Cadastro</div></div>';
                echo '</div>';
            }
        ?>
        <div class=content style="white-space:nowrap">
            <div class=esquerda>
                <?php
                    $sql="select * from discos where codigo='$codigo'";
                    $res=$mysqli->query($sql);
                    while($dados=mysqli_fetch_object($res)){
                        if(isset($_SESSION['codigo'])){
                            $sql5='SELECT * FROM login WHERE codigo='.$_SESSION["codigo"];
                            $res5=$mysqli->query($sql5);
                            $dados5=mysqli_fetch_object($res5);
                            if($dados5->admin>0){
                                echo '
                                <i id="iconeditar" class="material-icons editar">edit</i>
                                <span class="titulo">'.$dados->nome.'</span>
                                <form name="editarcd" method="post" action"" id="editarcd">
                                <i id="iconesalvar" class="material-icons editar" style="margin-left:2.9vw">save</i>
                                <input type=text name="nomecdtxt" placeholder="Nome do Disco" style="margin-top: 0vh; margin-left:0; display:inline;" value="'.$dados->nome.'"><br>
                                <i id="iconefechar" class="material-icons editar" style="margin-left:2.9vw;margin-top: 0vh">close</i>
                                <input type=text placeholder="Artista do Disco" name="artistacdtxt" style="margin-left:0; display: inline;" value="'.$dados->artista.'"><br>
                                <select form="editarcd" id="editargeneros" name="generoscd">
                                <option value='.$dados->genero.'>'.$dados->genero.'</option>';
                                $sql3="SELECT DISTINCT genero FROM discos";
                                $res3=$mysqli->query($sql3);
                                while($dados3=mysqli_fetch_object($res3)){
                                    if($dados3->genero==$dados->genero){                                        
                                    }else{
                                    echo '<option value='.$dados3->genero.'>'.$dados3->genero.'</option>';
                                    }
                                }
                                echo '</select>
                                <textarea form="editarcd" placeholder="Descrição do Disco" name="descricaocdtxt" style="height:25vh; display:block;">'.$dados->descricao.'</textarea>
                                <input type=number name="precocd" placeholder="Preço em Reais. Ex:129.90" step=0.01 value="'.$dados->preco.'">
                                <input type=number name="quantidadecd" placeholder="Quantidade" value="'.$dados->quantidade.'">
                                </form>';
                            }else{
                                echo '
                                <h1 class="titulo">'.$dados->nome.'</h1>';
                            }
                        }else{
                            echo '
                            <h1 class="titulo">'.$dados->nome.'</h1>';
                        }
                        if($dados->quantidade>0){
                            echo '
                            <h2 class="artista">'.$dados->artista.'</h2>
                            <div class="genero">'.$dados->genero.'</div>
                            <div class="descricao">'.$dados->descricao.'</div>
                            <div class="comprar" onclick=window.location.href="adicionarcarrinho.php?codigo='.$dados->codigo.'">COMPRAR</div>
                            <div class="preco">R$'.$dados->preco.'</div>';
                        }else{
                            echo '
                            <h2 class="artista">'.$dados->artista.'</h2>
                            <div class="genero">'.$dados->genero.'</div>
                            <div class="descricao">'.$dados->descricao.'</div>
                            <div class="comprar" style="cursor:default">ESGOTADO</div>
                            <div class="preco">R$'.$dados->preco.'</div>';
                        }
                    }
                    $res->free();
                ?>
                <span class="pccompra">Só é possível comprar pelo computador</span>
            </div>
            <div class=direita>
                <?php
                    $sql="select * from discos where codigo='$codigo'";
                    $res=$mysqli->query($sql);
                    while($dados=mysqli_fetch_object($res)){
                        echo '<div class="fundodireita" style="background-image:url('.$dados->capa.')"></div>
                        <img class="imgdireita" src="'.$dados->capa.'">';
                    }
                    $res->free();
                ?>
            </div>
        </div>
        <script>
            var generoscont=0;
            $("#editargeneros").click(function(){
                event.stopPropagation();
                if(generoscont==0){
                    $(this).attr('style','border-bottom-left-radius:0;border-bottom-right-radius:0;');
                    generoscont++;
                }else{
                    $(this).attr('style','');
                    generoscont--;
                }
            })
            $(document).click(function(event){
                generoscont=0;
                $("#editargeneros").attr('style','');
            })
            $(document).ready(function(){
                $("#editarcd").hide();
            })
            $("#iconeditar").click(function(){
                $(".esquerda").children().hide();
                $("#editarcd").show();
            })
            $("#iconesalvar").click(function(){
                $("#editarcd").submit();
            })
            $("#iconefechar").click(function(){
                $(".esquerda").children().show();
                $("#editarcd").hide();
                $(".pccompra").hide();
            })
        </script>
    </body>
</html>