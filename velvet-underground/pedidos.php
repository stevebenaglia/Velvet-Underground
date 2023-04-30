<?php
    include "conectar.php";
    session_start();
    function marretinha($data1){
        $data2=new DateTime(date('Y-m-d H:i:s'));
        $diferenca=$data1->diff($data2);
        $GLOBALS['dias']=$diferenca->format("%a");
        $GLOBALS['horas']=$GLOBALS['dias']*24;
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
                echo '<div class=header2 id=header>';
                echo     '<span style="margin-left:2vw;cursor:pointer;" onclick=window.location.href="index.php">VELVET UNDERGROUND</span>';
                echo     '<span class="icones" style="width:1vw"></span>';
                if($dados6->admin>0){
                    $sql="select * from pedidos ORDER BY codigo DESC";
                    $sql3="select * from reembolso order by codigo desc";
                    echo '
                    <span class="icones"><img id="adicionarcd" onclick=window.location.href="cadastrodiscos.php" class="lupa" src="adicionacd.png" alt="Adicionar CD"></span>';
                    if($dados6->admin>998){
                        echo '<span class="icones"><img id="adicionarfuncionario" class="lupa" onclick=window.location.href="cadastrofuncionarios.php" src="adicionafuncionario.png" alt="Adicionar Funcionário"></span>';
                    }
                }else{
                    $sql3="select * from reembolso where codusuario=".$_SESSION["codigo"]." order by codigo desc";
                    $sql="select * from pedidos where codusuario=".$_SESSION["codigo"]." ORDER BY codigo DESC";
                }
                echo     '<span class="icones"><img id="usuario" class="lupa" src="usuario.png" alt="Usuário"></span>';
                echo     '<span class="icones"><img id="carrinho" class="lupa" src="carrinho.png" alt="Carrinho"></span>'; 
                echo     '<input type="text" id="barrapesquisa" placeholder="PESQUISA" class="barrapesquisa" name="contpesquisa"> <div class="pesquisaResultados"></div>';
                echo     '<div class="logincont"><div class="botaoLogin" onclick=window.location.href="perfil.php">Perfil</div><div class="botaoLogin" onclick=window.location.href="pedidos.php">Pedidos</div><div class="botaoLogin" onclick=window.location.href="logout.php">Logout</div></div>';
                echo '</div>';
            }else{
                echo '<script>alert("Faça o login para acessar esta página");window.location.href="login.php";</script>';
                die();
            }
        ?>
        <div class=content style="white-space:nowrap">
                <div style="display:none" class="fundopreto">
                </div>
                <?php
                    $sql4='select * from login where codigo='.$_SESSION["codigo"];
                    $res4=$mysqli->query($sql4);
                    $dados4=mysqli_fetch_object($res4);
                    $res=$mysqli->query($sql);
                    $i=1;
                    while($dados=mysqli_fetch_object($res)){
                        $i=$dados->codigo;
                        echo '<div style="display:none" class="pedidos" id="pedidos'.$i.'">
                        <center><span class="titulo">Pedido n°'.$dados->codigo.'</span>';
                        $cod=array($dados->cod1,$dados->cod2,$dados->cod3,$dados->cod4,$dados->cod5,$dados->cod6,$dados->cod7,$dados->cod8,$dados->cod9,$dados->cod10);
                        echo '<table border=1 style="border-bottom:1px;border-bottom: 1px;border-bottom-color: rgb(214, 214, 214); border-bottom-style: groove;">';
                            for($n=0;$n<9;$n++){
                                if($cod[$n]>0){
                                    $sql2="select * from discos where codigo=".$cod[$n];
                                    $res2=$mysqli->query($sql2);
                                    $dados2=mysqli_fetch_object($res2);
                                    echo '<tr class="pedidoscont"><td style="width:6.6vw"><img class="capa" src="'.$dados2->capa.'"></td><td style="width:28vw;"><span class="titulo" style="font-size:5vh;">'.$dados2->nome.'</span></td><td style="width:12vw; justify-content:flex-end;"><span class="preco">R$'.$dados2->preco.'</span></td></div>';
                                }
                            }
                            $sql5="select * from login where codigo='$dados->codusuario'";
                            $res5=$mysqli->query($sql5);
                            $dados5=mysqli_fetch_object($res5);
                            echo '<tr style="border-top:1px;height:5vh;margin-top:3vh">
                            <td style="height:5vh;width:34.6vw;align-content:center;margin-top:3vh;"><span class="preco">Total</span></td>
                            <td style="height:5vh;width:12vw; justify-content:flex-end;"><span class="preco">R$'.$dados->valorfinal.'</span></td>
                            </tr><tr style="height:1vh"><td style="height:1vh;"></td></tr>
                        </table></center>
                        <table border=1 style="margin-top:3vh;margin-left:3vw;">
                            <tr style="height:6.7vh;width:48vw">
                                <td style="height:5vh;width:auto;font-family:circular-book">Cliente:</td>
                                <td style="height:5vh;font-family:circular-book">&nbsp'.$dados5->nome.'</td>
                            </tr>
                            <tr style="height:6.7vh;width:48vw">
                                <td style="height:5vh;width:auto;font-family:circular-book">Data:</td>
                                <td style="height:5vh;font-family:circular-book">&nbsp'.$dados->dia.'/'.$dados->mes.'/'.$dados->ano.'</td>
                            </tr>
                            <tr style="height:6.7vh;width:48vw">
                                <td style="height:5vh;width:auto;font-family:circular-book;">Horário:</td>
                                <td style="height:5vh;font-family:circular-book">&nbsp'.$dados->hora.':'.$dados->minutos.':'.$dados->segundos.'</td>
                            </tr>
                        </table>';
                        $data1=new DateTime($dados->ano.'-'.$dados->mes.'-'.$dados->dia.' '.$dados->hora.':'.$dados->minutos.':'.$dados->segundos);
                        $data2=new DateTime(date('Y-m-d H:i:s'));
                        marretinha($data1);
                        if($dias<=3&$dados->status!=2){
                            echo '<form method="post" action="rembolsa.php?codigo='.$dados->codigo.'&valor='.$dados->valorfinal.'">
                                        <input type="button" value="Reembolso" id=1 class="reembolso">
                                        <input type="text" name="txtdescricao" class="motivo" required placeholder="Motivo">
                                        </form>';
                        }
                        if($dados6->admin>0){
                            $codigo=$dados->codigo;
                            echo '<hr style="width: 47vw;background-color: #828282;border-radius: 0;">
                            <center>
                            <span class=titulo>Administrador</span>
                            <br>
                            <span class=status>Status</span>
                            <div class="mudaStatus">';
                            if($dados->status==0){
                                echo '<div class="aguardando" style="cursor:default;color:#7b7b7b;background-color:rgb(158,158,158);">Aguardando</div>
                                <div class="confirmado" onclick=window.location.href="mudaStatus.php?acao=pedidos&codigo='.$codigo.'&status=1">Confirmado</div>
                                <div class="rejeitado" onclick=window.location.href="mudaStatus.php?acao=pedidos&codigo='.$codigo.'&status=2">Reembolsado</div>';
                            }
                            if($dados->status==1){
                                echo '<div class="aguardando" onclick=window.location.href="mudaStatus.php?acao=pedidos&codigo='.$codigo.'&status=0">Aguardando</div>
                                <div class="confirmado" style="cursor:default;color:#7b7b7b;background-color:rgb(158,158,158);">Confirmado</div>
                                <div class="rejeitado" onclick=window.location.href="mudaStatus.php?acao=pedidos&codigo='.$codigo.'&status=2">Reembolsado</div>';
                            }
                            if($dados->status==2){
                                echo '<div class="aguardando" onclick=window.location.href="mudaStatus.php?acao=pedidos&codigo='.$codigo.'&status=0">Aguardando</div>
                                <div class="confirmado" onclick=window.location.href="mudaStatus.php?acao=pedidos&codigo='.$codigo.'&status=1">Confirmado</div>
                                <div class="rejeitado" style="cursor:default;color:#7b7b7b;background-color:rgb(158,158,158);">Reembolsado</div>
                                </div>
                                <br>';
                                $sql7='SELECT * FROM reembolso WHERE codpedido='.$dados->codigo;
                                $res7=$mysqli->query($sql7);
                                $dados7=mysqli_fetch_object($res7);
                                echo '<div class="reembolso" id=2>Motivo</div>';
                            }
                            echo '</center>
                            <div style="height:3vh;"></div>';
                        }
                        echo '</div>';
                        $i++;
                        if(isset($dados7)){
                            echo '<div class="reembolsoConfirmacao" style="display:none">
                            <center>
                            <div class="reembolsoMotivo">
                                <div class="reembolsoTitulo">Motivo</div>
                                '.$dados7->descricao.'
                            </div>
                            <div class="mudaStatus">';
                            if($dados7->status==0){
                                echo '<div class="aguardando" style="cursor:default;color:#7b7b7b;background-color:rgb(158,158,158);">Aguardando</div>
                                <div class="confirmado" onclick=window.location.href="mudaStatus.php?acao=reembolso&codigo='.$codigo.'&status=1">Confirmado</div>
                                <div class="rejeitado" onclick=window.location.href="mudaStatus.php?acao=reembolso&codigo='.$codigo.'&status=2">Rejeitado</div>';
                            }
                            if($dados7->status==1){
                                echo '<div class="aguardando" onclick=window.location.href="mudaStatus.php?acao=reembolso&codigo='.$codigo.'&status=0">Aguardando</div>
                                <div class="confirmado" style="cursor:default;color:#7b7b7b;background-color:rgb(158,158,158);">Confirmado</div>
                                <div class="rejeitado" onclick=window.location.href="mudaStatus.php?acao=reembolso&codigo='.$codigo.'&status=2>Rejeitado</div>';
                            }
                            if($dados7->status==2){
                                echo '<div class="aguardando" onclick=window.location.href="mudaStatus.php?acao=reembolso&codigo='.$codigo.'&status=0">Aguardando</div>
                                <div class="confirmado" onclick=window.location.href="mudaStatus.php?acao=reembolso&codigo='.$codigo.'&status=1">Confirmado</div>
                                <div class="rejeitado" style="cursor:default;color:#7b7b7b;background-color:rgb(158,158,158);">Rejeitado</div>';
                            }
                            echo '</center>
                            </div>';
                        }
                    }
                ?>
            <div class=carrinhocompleto style="padding-top:5vh;" id="pedidoscompleto">
                <div class="reembolsos" id="botaoreembolsos">Reembolsos</div>
                <span style="margin-left:8vw;">Pedidos</span>
                <center>
                <table border=1 style="margin-left:1vw; margin-top:3vh;">
                <tr>
                    <td style="width: 12vw;padding-left:0;padding-right:0; height:10vh;font-weight:bold">Número</td>
                    <td style="width:8vw;height:10vh;font-weight:bold">Data</td>
                    <td style="width:22vw; height:10vh;font-weight:bold">Quantidade de Discos</td>
                    <td style="width:8vw; height:10vh;font-weight:bold">Total</td>
                    <td style="width:18vw; height:10vh;font-size:1vw;display:inline-block;font-family:circular-book;"><svg width=15 height=15><rect width=15 height=15 style="fill:black;stroke:none"></svg>Aguardando Confirmação<br><svg width=15 height=15><rect width=15 height=15 style="fill:#00e200;stroke:none"></svg>Confirmado<br><svg width=15 height=15><rect width=15 height=15 style="fill:#9e9e9e;stroke:none"></svg>Reembolsado</td>
                </tr>
                <?php
                    $res=$mysqli->query($sql);
                    $i=1; 
                    while($dados=mysqli_fetch_object($res)){
                        $i=$dados->codigo;
                        if($dados->status==0){
                            $cor="black";
                        }
                        if($dados->status==1){
                            $cor="#00e200";
                        }
                        if($dados->status==2){
                            $cor="#9e9e9e";
                        }
                        echo '<tr class="pedido" id="pedido" style="color:'.$cor.';">
                        <td style="width: 12vw;padding-left:0;padding-right:0; height:10vh">'.$dados->codigo.'</td>
                        <td style="width:8vw;height:10vh;font-size:1.5vw;">'.$dados->dia.'/'.$dados->mes.'/'.$dados->ano.'<br>&nbsp'.$dados->hora.':'.$dados->minutos.':'.$dados->segundos.'</td>
                        <td style="width:22vw; height:10vh">'.$dados->quantidade.'</td>
                        <td style="width:8vw; height:10vh">R$'.$dados->valorfinal.'</td>
                        <td style="width:18vw; height:10vh;"><span onclick="pedidos('.$i.')" style="cursor:pointer">Ver mais</span></td>
                        </tr>
                        <script>
                        var i='.$i.'
                        </script>';
                    }
                ?>
                </table>
                </center>
            </div>
            <div class=carrinhocompleto style="padding-top:5vh; display:none;float:right;" id="reembolsoscompleto">
                <div class="reembolsos" id="botaopedidos" style="width:12vw;">Pedidos</div>
                <span style="margin-left:8vw;">Reembolsos</span>
                <center>
                <table border=1 style="margin-left:1vw; margin-top:3vh;">
                <tr>
                    <td style="width: 12vw;padding-left:0;padding-right:0; height:10vh;font-weight:bold">Número</td>
                    <td style="width:8vw;height:10vh;font-weight:bold">Data</td>
                    <td style="width:22vw; height:10vh;font-weight:bold">Número do Pedido</td>
                    <td style="width:8vw; height:10vh;font-weight:bold">Total</td>
                    <td style="width:18vw; height:10vh;font-weight:bold">Status</td>
                </tr>
                <?php
                    $res3=$mysqli->query($sql3);
                    $i2=1; 
                    while($dados3=mysqli_fetch_object($res3)){
                        $i2=$dados3->codpedido;
                        if($dados3->status==0){
                            $status="Em andamento";
                            $cor="black";
                        }
                        if($dados3->status==1){
                            $status="Confirmado";
                            $cor="#00e200";
                        }
                        if($dados3->status==2){
                            $status="Recusado";
                            $cor="rgb(255,0,0)";
                        }
                        echo '<tr class="pedido" style="color:'.$cor.';cursor:pointer" onclick="pedidos('.$i2.')">
                        <td style="width: 12vw;padding-left:0;padding-right:0; height:10vh">'.$dados3->codigo.'</td>
                        <td style="width:8vw;height:10vh;font-size:1.5vw;">'.$dados3->dia.'/'.$dados3->mes.'/'.$dados3->ano.'<br>&nbsp'.$dados3->hora.':'.$dados3->minutos.':'.$dados3->segundos.'</td>
                        <td style="width:22vw; height:10vh">'.$dados3->codpedido.'</td>
                        <td style="width:8vw; height:10vh">R$'.$dados3->valor.'</td>
                        <td style="width:18vw; height:10vh;"><span>'.$status.'</span></td>
                        </tr>';
                    }
                ?>
                </table>
                </center>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                    $(".motivo").hide();
                $(".fundopreto").click(function(){
                    $(".fundopreto").hide();
                    $(".pedidos").hide();
                    $(".reembolsoConfirmacao").hide();
                })
                $("#botaoreembolsos").click(function(){
                    $("#pedidoscompleto").animate({
                        width:"hide"
                    },350);
                    setTimeout(function(){
                        $("#reembolsoscompleto").animate({
                            width:"show"
                        },350)
                    },350)
                })
                $("#botaopedidos").click(function(){
                    $("#reembolsoscompleto").animate({
                        width:"hide"
                    },350);
                    setTimeout(function(){
                        $("#pedidoscompleto").animate({
                            width:"show"
                        },350)
                    },350)
                })
                $("#2").click(function(){
                    $(".reembolsoConfirmacao").animate({
                        top:"show"
                    },350);
                    $(".pedidos").hide();
                })
                $("form .reembolso").click(function(event){
                    event.stopPropagation();
                    var botao=$(this);
                    $("form .reembolso").attr("style","border-bottom-left-radius: 0;border-top-left-radius: 0;");
                    setTimeout(function(){
                        $(botao).attr("type","submit");
                        $(botao).attr("value","Enviar");
                    },15);
                    $(".motivo").animate({
                        width:"show"
                    })
                })
                $(".motivo").click(function(event){
                    event.stopPropagation();
                })
                $(window).click(function(){
                    $(".reembolso").attr("type","button");
                    $(".reembolso").attr("class","reembolso");
                    $(".reembolso").attr("value","Reembolso");
                    $(".motivo").animate({
                        width:"hide"
                    })
                    setTimeout(function(){
                        $(".reembolso").removeAttr("style");
                    },400)
                })
            })
            function pedidos(y){
                $(".fundopreto").show();
                $("#pedidos"+y).animate({
                    height:'show'
                });
            }
        </script>
    </body>
</html>