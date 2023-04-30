//Variáveis
var bannerCont=1;
var contimg=1;
var quantvolta=["",0,0,0,0,0];
//Volta ao começo da página quando recarrega
window.onbeforeunload = function () {
    window.scrollTo(0, 0);
}
function replaceElementTag(targetSelector, newTagString) {
	$(targetSelector).each(function(){
		var newElem = $(newTagString, {html: $(this).html()});
		$.each(this.attributes, function() {
			newElem.attr(this.name, this.value);
		});
		$(this).replaceWith(newElem);
	});
}
//Ao terminar de carregar a página esconde elementos
$(document).ready(function(){
    $(".pesquisaResultados").scroll(function(){
        var valor=$(".pesquisaResultados").scrollLeft;
        console.log(valor);
        $(".pesquisaLogo").css('bottom',"-"+valor+"px");
    })
    $(".pesquisaResultados").hide();
    $("#barrapesquisa").keyup(function(){
        // $(".pesquisaResultados").html('<img src="logo2.png" class="pesquisaLogo">');
        var burg;
        if($("#barrapesquisa").val()!=""){
            burg="";
            $(".pesquisaResultados").html("");
            for(i=0;i<Banco.Discos.length;i++){
                burg=Banco.Discos[i].Nome.slice(0,$("#barrapesquisa").val().length);
                if($("#barrapesquisa").val().toLowerCase()==burg.toLowerCase()){
                    console.log(Banco.Discos[i].Nome);
                    $(".pesquisaResultados").append("<a href='pagcd.php?codigo="+Banco.Discos[i].Codigo+"' class='pesquisaResultadosCont'><img src="+Banco.Discos[i].Capa+" class='pesquisaResultadoImg'><span class='pesquisaResultadoTexto'>"+Banco.Discos[i].Nome+"<br><i>"+Banco.Discos[i].Artista+"</i></span><span class='pesquisaResultadoSeta'>></span></a>");
                }
                burg=Banco.Discos[i].Artista.slice(0,$("#barrapesquisa").val().length);
                if($("#barrapesquisa").val().toLowerCase()==burg.toLowerCase()){
                    console.log(Banco.Discos[i].Artista);
                    $(".pesquisaResultados").append("<a href='pagcd.php?codigo="+Banco.Discos[i].Codigo+"' class='pesquisaResultadosCont'><img src="+Banco.Discos[i].Capa+" class='pesquisaResultadoImg'><span class='pesquisaResultadoTexto'>"+Banco.Discos[i].Nome+"<br><i>"+Banco.Discos[i].Artista+"</i></span><span class='pesquisaResultadoSeta'>></span></a>");
                }
            }
            if($("#barrapesquisa").val().toLowerCase()=='aleatorio'){
                $(".pesquisaResultados").append("<a href='aleatorio.php'>Aleatório</a>");
            }
            if($(".pesquisaResultados").html()!=""){
                if($(".pesquisaResultados").is(":hidden")){
                    $(".pesquisaResultados").animate({
                        height:'show'
                    })
                }
                $("#barrapesquisa").css("border-bottom-left-radius","0vw");
                $("#barrapesquisa").css("border-bottom-right-radius","0vw");
            }else{
                $(".pesquisaResultados").html("<center><span style='color:black; font-size:0.5em'>Não há resultados</span></center");
            }
        }else{
            $("#barrapesquisa").css("border-bottom-left-radius","2vw");
            $("#barrapesquisa").css("border-bottom-right-radius","2vw");
            $(".pesquisaResultados").hide();
        }
        if($(".pesquisaResultados").html()==""){
            $(".pesquisaResultados").show();
        }
    })
    $("#usuario").click(function(){
        $(".logincont").animate({
            height:"toggle"
        })
        $(".carrinho").animate({
            height:"hide"
        })
        $(".setacarrinho").animate({
            top:'hide',
            opacity:'hide'
        })
        $(".finalcompra").animate({
            top:'hide',
            opacity:'hide'
        },300)
    })
    if($("#adicionarcd").length){
        $(".barrapesquisa").css("right","19.9vw");
        $(".pesquisaResultados").css("right","19.9vw");
        $(".logincont").css("right","7.6vw");
        // $(".pesquisaResultados").attr("style","right:24.6vw");
        setTimeout(function(){
            if($("#adicionarfuncionario").length){
                $(".pesquisaResultados").css("right","24.6vw");
                $(".logincont").css("right","12.3vw")
                $(".barrapesquisa").css("right","24.6vw");
            }
        },10);
    }
    $(".carrinho").hide();
    $(".logincont").hide();
    $(".finalcompra").hide();
    $(".setacarrinho").hide();
    $("#formendereco").hide();
    //Quando clica no ícone de pesquisa a barra aparece
    $("#carrinho").click(function(){
        window.location.href="finalcompra.php";
    })
    function escondetudo(){
        $("#barrapesquisa")
        .css("border-bottom-left-radius",'2vw')
        .css("border-bottom-right-radius",'2vw')
        $(".pesquisaResultados").hide();
        $(".logincont").animate({
            height:"hide"
        })
        $(".carrinho").animate({
            height:"hide"
        })
        $(".setacarrinho").animate({
            top:'hide',
            opacity:'hide'
        })
        $(".finalcompra").animate({
            top:'hide',
            opacity:'hide'
        },300)
    }
    $('.content').click(function() {
        escondetudo();
    });
    $('#header').click(function() {
        escondetudo();
    });
    $('.finalcompra').click(function(event){
        event.stopPropagation();
    })
    $('.setacarrinho').click(function(event){
        event.stopPropagation();
    })
    $('.carrinho').click(function(event){
        event.stopPropagation();
    })
    $('#barrapesquisa').click(function(event){
        event.stopPropagation();
    })
    $('.logincont').click(function(event){
        event.stopPropagation();
    })
    $('#usuario').click(function(event){
        event.stopPropagation();
    })
    $('#pesquisa').click(function(event){
        event.stopPropagation();
    })
    $('#carrinho').click(function(event){
        event.stopPropagation();
    })
    $(window).scroll(function(){escondetudo()});
    $(".botoes").click(function(event){
        var botao=$(this);
        var idbotao=$(this).attr('id');
        $(botao).attr('value','SALVAR');
        $(".desativar"+idbotao).prop('disabled',false);
        setTimeout(function(){
        $(botao).attr('type','submit');
        $(botao).attr('style','background-color:rgb(0,168,255);color:white');
        },15);
    })
    $("input").click(function(event){
        event.stopPropagation();
    })
    $(window).click(function(){
        $(".desativar").prop('disabled',true);
        $(".botoes").removeAttr('style');
        $(".botoes").attr('value','EDITAR');
        $(".botoes").attr('type','button')
    })
    $('#mudaperfil1').click(function(){
        $("#formperfil").animate({
            width:'toggle'
        },350)
        setTimeout(function(){
            $("#formendereco").animate({
                width:'toggle'
            },350)
        },350)
    })
    $('#mudaperfil2').click(function(){
        $("#formendereco").animate({
            width:'toggle'
        },350)
        setTimeout(function(){
            $("#formperfil").animate({
                width:'toggle'
            },350)
        },350)
    })
    $('.mudaendereco').click(function(){
        $("#formperfil").animate({
            width:'toggle'
        })
        $("#formendereco").animate({
            width:'toggle'
        })
        $("#divperfil").removeClass('formendereco');
        $("#divperfil").addClass('formperfil')
    });
    var posX=[];
    $('.imgbanner')
    .mousedown(function(event){
        var n=1;
        setInterval(function(){
            posX[n]=event.clientX;
            n++;
        },1);
    }).mouseup(function(event){
        if(posX[1]>posX[3]){
            mudabanner();
        }
    })
    var arrastando;
    var arrastando2;
    $('.dragger').mousedown(function (event) {
        arrastando=$(this);
        arrastando2=this;
        setTimeout(function(){
            replaceElementTag($(".linkcd"), '<div></div>');
        },150);
        $(arrastando)
            .data('down', true)
            .data('x', event.clientX)
            .data('scrollLeft', arrastando2.scrollLeft)
            .addClass("dragging");
        return false;
    }).mouseleave(function(event){
        setTimeout(function(){
            replaceElementTag($(".linkcd"), '<a></a>');
        },80);
        $(this)
           .data('down', false)
           .removeClass("dragging");
    })
    .mouseup(function (event) {
        setTimeout(function(){
            replaceElementTag($(".linkcd"), '<a></a>');
        },30);
        $(arrastando)
           .data('down', false)
           .removeClass("dragging");
    }).mousemove(function (event) {
        if ($(arrastando).data('down') == true) {
            arrastando2.scrollLeft = $(arrastando).data('scrollLeft') + $(arrastando).data('x') - event.clientX;
        }
    }).mousewheel(function (event, delta) {
        this.scrollLeft -= (delta * 30);
    });
});
//A cada 2500ms muda o banner
function mudabann(){
    if(contimg==4){
        contimg=1;
        $("#imagemdobanner"+"4").fadeOut();
        $("#imagemdobanner1").fadeIn();
        $("#circulo"+"4").attr("fill","none");
        $("#circulo1").attr("fill","white");
    }else{
        $("#imagemdobanner"+contimg).fadeOut();
        $("#imagemdobanner"+(contimg+1)).fadeIn();
        $("#circulo"+contimg).attr("fill","none");
        $("#circulo"+(contimg+1)).attr("fill","white");
        contimg++;
    }
}
var timerBanner=setInterval(function(){mudabann()},3000);
function mudabanner(n){
    clearInterval(timerBanner);
    timerBanner=setInterval(function(){mudabann()},3000);
    $("#imagemdobanner"+contimg).fadeOut();
    $("#imagemdobanner"+n).fadeIn();
    $("#circulo"+contimg).attr("fill","none");
    $("#circulo"+n).attr("fill","white");
    contimg=n;
}
function carrinhosemlogin(){
    window.location.href="login.php?atualizacao=Faça o login para ver o carrinho&atualizacaocor=red"
}
//Muda o Header depois de passar o banner
function mudaHeader() {
    var tamanhoScroll=$("#banner").height();
    if ($(window).scrollTop > tamanhoScroll || document.documentElement.scrollTop > tamanhoScroll) {
        $("#header").attr('class','header2');
        $("#header").attr('style','');
    } else {
        $("#header").attr("class","header");
    }
}