const opcoes = document.querySelector(".opções");
const opcoes_lista = document.querySelector(".lista_menu");
const botao_opcoes = document.querySelector("#opções_menu");

document.addEventListener('click', e=>{
    if(opcoes.contains(e.target)){
        botao_opcoes.checked = !botao_opcoes.checked;
    }
    if(!opcoes.contains(e.target)){
        botao_opcoes.checked = false;
    }
})

const sobre = document.querySelector(".pagina_sobre");

if(sobre!=null && window.innerWidth>900){
    let sobreHeight = sobre.offsetHeight;
    if(sobreHeight<window.innerHeight-300){
        document.querySelector("#footer").style.position = "fixed";
        document.querySelector("#footer").style.bottom = "0px";
        document.querySelector("#footer").style.width = "100%";
    }
}

