<?php
    session_start();
    include "conectar.php";
    $atualizacaomostra='none';
    $atualizacaocor='black';
    $atualizacao="";
    if(isset($_REQUEST['atualizacao'])){
        $atualizacao=$_REQUEST['atualizacao'];
        $atualizacaocor=$_REQUEST['atualizacaocor'];
        $atualizacaomostra='inline';
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
                $sql="select * from carrinho where codusuario=".$_SESSION['codigo'];
                $res=$mysqli->query($sql);
                if($res->num_rows<1){
                    echo '<script>alert("Adicione produtos ao carrinho antes!");window.location.href="index.php"</script>';
                    die();
                }
                echo '<div class=header2 id=header>';
                echo     '<span style="margin-left:2vw;cursor:pointer;" onclick=window.location.href="index.php">VELVET UNDERGROUND</span>';
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
                $sql="select * from carrinho where codusuario =".$_SESSION['codigo'];
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
                echo '<script>alert("Faça o login para acessar esta página");window.location.href="login.php";</script>';
                die();
            }
        ?>
        <div class=content style="white-space:nowrap">
            <div class=carrinhocompleto id="carrinhocompleto">
                <span display="<?php echo $atualizacaomostra ?>" style="color:<?php echo $atualizacaocor ?>;font-size:2vw;margin-left:5vw"><?php echo $atualizacao ?></span>
                <center>
                <table border=1>
                <tr>
                    <td style="width: 12vw;padding-left:0;padding-right:0; height:10vh;font-weight:bold">Capa</td>
                    <td style="height:10vh;font-weight:bold">Preço</td>
                    <td style="width:28vw; height:10vh;font-weight:bold">Nome</td>
                    <td style="width:28vw; height:10vh;font-weight:bold">Artista</td>
                </tr>
                <?php
                    $valorfinal=0.00;
                    $sql="select * from carrinho where codusuario=".$_SESSION['codigo'];
                    $res=$mysqli->query($sql);
                    while($dados=mysqli_fetch_object($res)){
                        $sql2="select * from discos where codigo=".$dados->coddisco;
                        $res2=$mysqli->query($sql2);
                        while($dados2=mysqli_fetch_object($res2)){
                            echo '<tr>';
                            echo '<td style="width: 12vw;padding-left:0;padding-right:0;"><div class="remover" onclick=window.location.href="remover.php?codigo='.$dados->codigo.'&coddisco='.$dados2->codigo.'" style="margin:0;">X</div><img class="capatd" src="'.$dados2->capa.'"></td><td><span class="precotd">R$'.$dados2->preco.'</span></td>';
                            $valorfinal=$valorfinal+$dados2->preco;
                            if(mb_strlen($dados2->nome)>27){
                                echo '<td style="width: 28vw;"><span class="nometd">'.$dados2->nome.'</span></td>';
                            }else{
                            echo '<td style="width: 28vw;"><span class="nometd">'.$dados2->nome.'</span></td>';
                            }
                            if(mb_strlen($dados2->artista)>27){
                                echo '<td style="width: 28vw;"><span class="nometd">'.$dados2->artista.'</span></td>';
                            }else{
                              echo '<td style="width: 28vw;;"><span class="nometd">'.$dados2->artista.'</span></td>';
                            }
                            echo '</tr>';
                        }
                    }
                ?>
                </table>
                </center>
                <?php
                    echo '<span style="position:relative;margin-top:1vw;margin-right:5vw;font-family:circular-medium;float: right;font-size: 2vw;">Valor final:R$'.number_format((float)$valorfinal, 2, '.', '').'</span>';
                    echo '<br><div class="finalizarcompra" onclick=window.location.href="finalizarcompra.php?codigo='.$_SESSION["codigo"].'&valorfinal='.$valorfinal.'">Finalizar Compra</div>';
                ?>
        </div>
        </div>
    </body>
</html>