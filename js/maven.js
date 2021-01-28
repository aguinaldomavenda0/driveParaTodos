window.load = initJs();

function initJs(){
    var largura = Number(window.innerWidth)
    var altura = Number(window.innerHeight)
    var l = document.querySelector('.ficheiroPorCima');
}

function abrirPastaJsSemNome(id){
    pastasPreparadas(id)
}
function abrirPastaJs(id,nome="maven"){
    pastasPreparadas(id)
    document.getElementById('navegacao').innerHTML += `<a href="#!" onclick="abrirPastaJsSemNome(${id})"><span class="navega white-tex t">${nome}/</span></a>`
}



$(".ficheiroPorCima").mouseover(function(){
    $(this).attr("class","col s4 center ficheiroPorCima blue")
})
$(".ficheiroPorCima").mouseout(function(){
    $(this).attr("class","col s4 center ficheiroPorCima white")
})

$(".navega").mouseover(function(){
    $(this).attr("class","navega blue-text")
})
$(".navega").mouseout(function(){
    $(this).attr("class","navega white-text")
})

function reiniciar(){
    document.getElementById('navegacao').innerHTML = `<a href="#!" onclick="reiniciar()"><span class="navega white-tex t">maven/</span></a>`
    pastasPreparadas(0)
}


function ReajustaJanelaPastas(altura,largura){
    var elemento = document.getElementById('JanelaDeFicheiros');
    elemento.setAttribute("style","height:"+altura+"px;width:"+largura+"px; z-index:2");
    //console.log(elemento)
}

function pastasPreparadas(id){
    document.getElementById('pastasSelecionada').innerHTML = id;
    $.ajax({url:'php/json/action.php',async:true,data:{
        getPastas:id,
        before:function(){
        document.getElementById('carregaNinguemPodeNegare').innerHTML='<div class="progress "><div class="indeterminate blue"></div></div>'
        }}}).done(function(dados){
            document.getElementById('carregaNinguemPodeNegare').innerHTML=''   
            //console.log(dados)
            //console.log(dados)
            var conteudo = JSON.parse(dados)
            var composicao = ''
            conteudo.forEach(function(elemento){
            //console.log(composicao)
                composicao += `<a href="#!" onclick="abrirPastaJs(${elemento.codigo},'${elemento.nome}')" data-maveType="P"><div class="col s4 center ficheiroPorCima" style="margin:0px;padding:5px; border-radius:10px; height:100%;">
            <i class="material-icons teal-text large">folder</i><br>
                <span>${elemento.nome} </span>
            </div></a>`
            })
            document.querySelector('.conteudo').innerHTML = composicao
            ficheiroPreparadas(id)
            
          
        })
}

function abrirFicheiroJS(val){
    document.getElementById("down"+val).innerHTML = `<a href="#!" onclick="downloadFile(${val})" class="btn-floating pulse" style="position: relative;left: 1px;bottom: 85px;"><i class="material-icons">cloud_download</i></a>`
}

function downloadFile(id){
    $.ajax({url:'php/json/action.php',async:true,data:{
        getDownFile:id,
        before:function(){
        document.getElementById('carregaNinguemPodeNegare').innerHTML='<div class="progress "><div class="indeterminate blue"></div></div>'
        }}}).done(function(dados){
            document.getElementById('carregaNinguemPodeNegare').innerHTML=''   
            console.log(dados)
            var conteudo = JSON.parse(dados)
            window.location = conteudo.localizacao
            
        })
}

function ficheiroPreparadas(idpasta){
    $.ajax({url:'php/json/action.php',async:true,data:{
        getFiles:idpasta,
        before:function(){
        document.getElementById('carregaNinguemPodeNegare').innerHTML='<div class="progress "><div class="indeterminate blue"></div></div>'
        }}}).done(function(dados){
            document.getElementById('carregaNinguemPodeNegare').innerHTML=''   
            //console.log(dados)
            var conteudo = JSON.parse(dados)
            var composicao = ''
            conteudo.forEach(function(elemento){
            //console.log(composicao)
                composicao += `<a href="#!" onclick="abrirFicheiroJS(${elemento.codigo})" data-maveType="F"><div class="col s4 center ficheiroPorCima" style="margin:0px;padding:5px; border-radius:10px; height:100%;">
            <i class="material-icons teal-text large">insert_drive_file</i><br>
                <span>${elemento.nome}</span>
                <div>
                    <a href="ficheiros/${elemento.localizacao}" class="btn-floating red"><i class="material-icons">cloud_download</i></a>
                    <a href="preview.html?id=${elemento.codigo}" class="btn-floating blue"><i class="material-icons">visibility</i></a>
                </div>
    
    
            </div></a>`
            })
            document.querySelector('.conteudo').innerHTML += composicao
            
          
        })
}

function abrirFicheiroLoaded(idfiel){
    $.ajax({url:'php/json/action.php',async:true,data:{
        getDownFile:idfiel,
        before:function(){
        document.getElementById('carregaNinguemPodeNegare').innerHTML='<div class="progress "><div class="indeterminate blue"></div></div>'
        }}}).done(function(dados){
            document.getElementById('carregaNinguemPodeNegare').innerHTML=''   
            var conteudo = JSON.parse(dados)
            //console.log(dados)
            if (conteudo) {                

                if (conteudo.tipo.toLocaleUpperCase() == "POWER POINT") {
                    //Materialize.toast("<span class='yellow-text'>Sem suporte para document POWER POINT!</span>",1500);
                    //setTimeout(window.location="index.html",1500)
                    var link = window.location.href+"";
                    var atributo = link.split("/")
                    $("#previsualiza").attr("src","https://view.officeapps.live.com/op/embed.aspx?src="+atributo[0]+"//"+atributo[2]+"/ficheiros/"+conteudo.localizacao)
                    //alert()
                    Materialize.toast("<span class='green-text'><i class='material-icons left'>forward_10</i>Ficheiro a carregar!</span>",1500);

                }else {
                    $("#previsualiza").attr("src","ficheiros/"+conteudo.localizacao)
                    Materialize.toast("<span class='green-text'><i class='material-icons left'>forward_10</i>Ficheiro a carregar!</span>",1500);
                }
            }else{
                Materialize.toast("<span class='red-text'><i class='material-icons left'>do_not_disturb</i>Ficheiro a carregar!</span>",1500);
                setTimeout(window.location="index.html",1500)
            }
            //document.querySelector('.conteudo').innerHTML += composicao
            
          
        })

}

function filtraFicheiro(id){
    var extensaoAceites = ['PDF','PPTX']
    var nome = document.getElementById("ficheiroSelecionado").value+""
    var nomeFileArray = nome.split('\\');
    var nomeFile = nomeFileArray[nomeFileArray.length - 1].split('.')[0];
    document.querySelector('#nome').value = nomeFile
    //console.log(nomeFile)

    var c = 0;
    var extensao
    extensao = nome.split('.')[1];
    
    for (var i = extensaoAceites.length - 1; i >= 0; i--) {
        if(extensaoAceites[i].toLocaleUpperCase() == extensao.toLocaleUpperCase()){
            c++;
        }
    }
    //console.log(nome+":"+extensao)
    
    if (c > 0) {
        console.log(tipo(extensao.toLocaleUpperCase()))
        document.querySelector('#tipo').innerHTML = tipo(extensao.toLocaleUpperCase());
        document.getElementById('formulario').setAttribute("action","a.php?tipo="+tipo(extensao.toLocaleUpperCase())+"&pasta="+document.querySelector("#pastasSelecionada").innerHTML)
        document.querySelector('#tipo').setAttribute("data-maven",""+extensao);

    }else{
        Materialize.toast("<span class='red-text'>Formato não suportado!</span>",1500)
        document.querySelector("#impossivel").innerHTML = 1;
    }
}

function tipo(tipoFile){
    if (tipoFile == 'PDF') {
        return "PDF"
    }
    else if(tipoFile == 'PPTX'){
        return "POWER POINT"
    }
}

/*$("#formulario").submit(function(){
    //if (Number(document.querySelector("#impossivel").innerHTML )!=1) {
        var formularioDados = new FormData(this);
        //formularioDados.append('tipo', document.querySelector('#tipo').getAttribute("data-maven"))
        console.log(formularioDados)
        
        $.ajax({url: "php/json/a.php", type: 'POST',data: formularioDados, cache: false,
            success: function(data) {
                console.log(data)
                return false
            }

        })
    //}

    return false;
})*/

function permicao(){
    var p = document.querySelector('#pastasSelecionada').innerHTML
    p = Number(p)
    if (p == 0) {
        setTimeout(document.querySelector('#fechar').click(),3000)
        Materialize.toast('<span class=\'yellow-text\'><i class=\'material-icons left\'>do_not_disturb</i>Não tem permição para criar pastas</span>',1500)

    }else{
        document.querySelector("#formularioPasta").setAttribute("action","a.php?pasta="+p);
    }
}