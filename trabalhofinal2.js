//TrabalhoFinal
const palavras = [
    "amor", "chuva", "abraço", "trabalho", "sol", "lua", "estrela", "céu", "terra", "mar", 
    "montanha", "floresta", "rio", "oceano", "ventania", "tempestade", "neve", "fogo", 
    "areia", "pedra", "flor", "árvore", "pássaro", "borboleta", "gato", "cachorro", "leão", 
    "elefante", "tigre", "girafa", "zebra", "macaco", "baleia", "golfinho", "peixe", 
    "abacaxi", "morango", "banana", "maçã", "uva", "laranja", "limão", "abóbora", "batata", 
    "cenoura", "tomate", "cebola", "brócolis", "espinafre", "cadeira"
];

// Cronometro
let hour = 0;
let minute = 0;
let second = 0;
let millisecond = 0;

let cron;

function start() {
    pause();
    cron = setInterval(() => { timer()}, 10);
}

function pause() {
    clearInterval(cron);
}

function reset(){
    hour = 0;
    minute = 0;
    second = 0;
    millisecond = 0;
    document.getElementById("hour").innerHTML = '00';
    document.getElementById("minute").innerHTML = '00';
    document.getElementById("second").innerHTML = '00';
    document.getElementById("millisecond").innerHTML = '000';

    acertos = 0;
    erros = 0;
    pontos = 0;
    document.getElementById("acertos").innerHTML = '0';
    document.getElementById("erros").innerHTML = '0';
    document.getElementById("pontos").innerHTML = '0';
}

function timer(){
    if ((millisecond += 10) == 1000 ){
        millisecond = 0;
        second++;
    }
    if (second == 60){
        second = 0;
        minute++;
    }
    if (minute == 60){
        minute = 0;
        hour++;
    }

    document.getElementById('hour').innerText = returnData(hour);
    document.getElementById('minute').innerText = returnData(minute);
    document.getElementById('second').innerText = returnData(second);
    document.getElementById('millisecond').innerText = returnData(millisecond);
}

function returnData(input){
    return input > 10 ? input : `0${input}`  
}
// Fim cronometro

let palavra = document.getElementById("palavra").value;
let botao = document.getElementById("botao");
var velocidade;
var valor;

const kvArray = [
    ["nivel1", 300000], //5min 300000
    ["nivel2", 150000], // 2,5min 150000
    ["nivel3", 60000], // 1min 60000
    ["nivel4", 30000], // 30s 30000
];
        
const niveis = new Map(kvArray);

function resposta(){
    elemento = palavras[Math.floor(Math.random() * palavras.length)];
    document.getElementById("palavra").innerHTML = elemento;
}

var acertos = 0;
var erros = 0;
var pontos = 0;

function comeca() {    
    reset();
    resposta(); 
    clearTimeout(velocidade);

    let nivel = document.getElementById("nivel").value;
    valor = niveis.get(nivel);
 
    setTimeout(function() {
        clearInterval(velocidade);
        alert("Jogo encerrado. Pontuação final:\nAcertos: " + acertos + "\nErros: " + erros + "\nPontuação: " + pontos);
        reset();
    }, valor);
        
    velocidade = setInterval(timer, 10);
}

botao.addEventListener("click", comeca);

digitoUsuario.addEventListener('keydown', (event) => {
    var valorDigitado = digitoUsuario.value;
    let palavra = document.getElementById("palavra").textContent; 
    if(event.key === 'Enter'){
        digitoUsuario.value = '';
        if(palavra == valorDigitado){
            pontos = parseInt(document.getElementById("pontos").textContent) +1;
            acertos = parseInt(document.getElementById("acertos").textContent) + 1;
            document.getElementById("acertos").textContent = acertos; 
            document.getElementById("pontos").textContent = pontos;          
            resposta();
        }
        else {
            pontos = parseInt(document.getElementById("pontos").textContent) - 1;
            erros = parseInt(document.getElementById("erros").textContent) + 1;
            document.getElementById("erros").textContent = erros;
            document.getElementById("pontos").textContent = pontos;
            resposta();
        }
    }
  });