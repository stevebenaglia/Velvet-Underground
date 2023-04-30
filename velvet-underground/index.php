<?php
    include "conectar.php";
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Velvet Underground</title>
        <link rel=stylesheet href="style.css">
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <style>         
            ::-webkit-scrollbar {
                height:0;
                width: 0.3vw;
            }
            ::-webkit-scrollbar-thumb{
                height:0;
                width:0.3vw;
                background:#A9A9A9;
            }
            ::-webkit-scrollbar-track{
                height:0;
                background:white;
                width:0.3vw;
            } 
            div::-webkit-scrollbar {
                height:0;
                width: 0vw;
            }
            div::-webkit-scrollbar-thumb{
                height:0;
                width:0vw;
                background:#A9A9A9;
            }
            div::-webkit-scrollbar-track{
                height:0;
                background:white;
                width:0vw;
            }
        </style>
    </head>
    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <?php
            include "json.php";
            if(isset($_SESSION["codigo"])){
                $sql6="SELECT * FROM login WHERE codigo=".$_SESSION["codigo"];
                $res6=$mysqli->query($sql6);
                $dados6=mysqli_fetch_object($res6);
                echo '<div class=header style="animation:none;" id=header>
                <span style="margin-left:2vw;cursor:default;">VELVET UNDERGROUND</span>
                <span class="icones" style="width:1vw"></span>';
                if($dados6->admin>0){
                    echo '
                    <span class="icones"><img id="adicionarcd" onclick=window.location.href="cadastrodiscos.php" class="lupa" src="adicionacd.png" alt="Adicionar CD"></span>';
                    if($dados6->admin>998){
                        echo '<span class="icones"><img id="adicionarfuncionario" class="lupa" onclick=window.location.href="cadastrofuncionarios.php" src="adicionafuncionario.png" alt="Adicionar Funcionário"></span>';
                    }
                }
                echo '<span class="icones"><img id="usuario" class="lupa" src="usuario.png" alt="Usuário"></span>
                <span class="icones"><img id="carrinho" class="lupa" src="carrinho.png" alt="Carrinho"></span>
                <input type="text" id="barrapesquisa" placeholder="PESQUISA" class="barrapesquisa" name="contpesquisa">                 
                <div class="pesquisaResultados"></div>
                <div class="logincont"><div class="botaoLogin" onclick=window.location.href="perfil.php">Perfil</div><div class="botaoLogin" onclick=window.location.href="pedidos.php">Pedidos</div><div class="botaoLogin" onclick=window.location.href="logout.php">Logout</div></div>
                </div>';
            }else{
                echo '<div class=header style="animation:none;" id=header>
                <span style="margin-left:2vw;cursor:default;">VELVET UNDERGROUND</span>
                <span class="icones" style="width:1vw"></span>
                <span class="icones"><img id="usuario" class="lupa" src="usuario.png" alt="Usuário"></span>
                <span class="icones"><img class="lupa" onclick=carrinhosemlogin() src="carrinho.png" alt="Carrinho"></span>
                <input type="text" id="barrapesquisa" placeholder="PESQUISA" class="barrapesquisa" name="contpesquisa">
                <div class="pesquisaResultados"></div>
                <div class="logincont"><div class="botaoLogin" onclick=window.location.href="login.php">Login</div><div class="botaoLogin" onclick=window.location.href="cadastro.php">Cadastro</div></div>
                </div>';
            }
        ?>
        <div class=content>
            <div class=banner id=banner>
                <img class=imgbanner onclick=window.location.href="pagcd.php?codigo=49" id="imagemdobanner4" style="display:none" src="Banner4.png">
                <img class=imgbanner onclick=window.location.href="pagcd.php?codigo=34" id="imagemdobanner3" style="display:none"  src="Banner3.png">
                <img class=imgbanner onclick=window.location.href="pagcd.php?codigo=7" id="imagemdobanner2" style="display:none"  src="Banner2.png">
                <img class=imgbanner onclick=window.location.href="pagcd.php?codigo=35" id="imagemdobanner1" src="Banner1.png">
                <svg class="circuloindex4" style="position:absolute; z-index:9999999999;height:2.5vh;width:2.5vh;top: 96.5vh;left: 44.6vw;cursor:pointer" onclick="mudabanner(1)">
                    <circle id="circulo1" cx="1.25vh" cy="1.25vh" r="1vh" stroke="white" stroke-width="0.1vw" fill="white" />
                </svg>
                <svg class="circuloindex3" style="position:absolute; z-index:9999999999;height:2.5vh;width:2.5vh;top: 96.5vh;left: 46.6vw;cursor:pointer" onclick="mudabanner(2)">
                    <circle id="circulo2" cx="1.25vh" cy="1.25vh" r="1vh" stroke="white" stroke-width="0.1vw" fill="none" />
                </svg>
                <svg class="circuloindex2" style="position:absolute; z-index:9999999999;height:2.5vh;width:2.5vh;top: 96.5vh;left: 48.6vw;cursor:pointer" onclick="mudabanner(3)">
                    <circle id="circulo3" cx="1.25vh" cy="1.25vh" r="1vh" stroke="white" stroke-width="0.1vw" fill="none" />
                </svg>
                <svg class="circuloindex1" style="position:absolute; z-index:9999999999;height:2.5vh;width:2.5vh;top: 96.5vh;left: 50.6vw;cursor:pointer" onclick="mudabanner(4)">
                    <circle id="circulo4" cx="1.25vh" cy="1.25vh" r="1vh" stroke="white" stroke-width="0.1vw" fill="none" />
                </svg>
            </div>
            <div id="cont" style="width:1vw"></div>
            <div class="carousels">
                <?php
                    $contlista=0;
                    $sql3="SELECT DISTINCT genero FROM discos";
                    $res3=$mysqli->query($sql3);
                    $contcd=0;
                    while($dados3=mysqli_fetch_object($res3)){
                        $contlista++;
                        echo '
                        <div class="wrapper" id="wrap'.$contlista.'">
                            <div class=titulo>
                            <span class=genero>'.$dados3->genero.'</span>
                            </div>
                        <div class="dragger carousel1" id="cds'.$contlista.'">
                            <div id="listacds'.$contlista.'">';
                                $sql="select * from discos where genero='$dados3->genero'";
                                $res=$mysqli->query($sql);
                                while($dados=mysqli_fetch_object($res)){
                                    if($dados->quantidade>0){
                                        echo '
                                            <div class="cd" id="cd">
                                                <a href="pagcd.php?codigo='.$dados->codigo.'" class="linkcd" id="'.$contcd.'">
                                                <div style="background:linear-gradient(rgba(0,0,0,0),rgba(0,0,0,0),black),url('.$dados->capa.');
                                                background-size: cover;" class="cdimg">
                                                    <span class="nomealbum">'.$dados->nome.'</span><br>
                                                    <span class="nomeartista">'.$dados->artista.'</span>
                                                </div>
                                                </a>
                                            </div>';
                                    }else{
                                        echo '
                                        <div class="cd" id="cd">
                                            <div onclick=window.location.href="pagcd.php?codigo='.$dados->codigo.'" style="background-image:linear-gradient(rgba(0,0,0,0),rgba(0,0,0,0),black),url('.$dados->capa.'); background-size:cover;" class="cdimg">
                                                <span class="nomealbum">'.$dados->nome.'</span><br>
                                                <span class="nomeartista">'.$dados->artista.'</span>
                                                <div onclick=window.location.href="pagcd.php?codigo='.$dados->codigo.'" class="esgotado">[ESGOTADO]</div>
                                            </div>
                                        </div>';
                                    }
                                    $contcd++;
                                }
                                $res=$mysqli->query($sql);
                                $res->free();
                            echo '</div>
                            </div>
                        </div>
                        <br><br>';
                    }
                    ?>
            </div>
            <hr>
            <div class="rodape">
                <center>
                    Este site é apenas um projeto, não é um site de vendas real<br>
                    Feito por José Roberto Benaglia Filho
                </center>
            </div>
        </div>
        <script src="script.js"></script>
        <script>
            $(window).scroll(function() {mudaHeader()});
        </script>
    </body>
</html>