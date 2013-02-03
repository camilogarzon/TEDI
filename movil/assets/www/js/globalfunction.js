var query = '';

function isEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

function callAjax(ladata, callBackFn){
    $.ajax({
        data: ladata , 
        type: "GET", 
        dataType: "json", 
        url: "http://qsystems.com.co/tediws/ws.php", 
//        url: "http://localhost/github/TEDI/tediws/ws.php", 
        success: callBackFn
    });
}

function setLSO(key, value){
    window.localStorage.setItem(key, JSON.stringify(value));
}

function getLSO(key){
    return JSON.parse(window.localStorage.getItem(key));
}

function setLSS(key, value){
    window.localStorage.setItem(key, value);
}

function getLSS(key){
    return window.localStorage.getItem(key);
}

function logout(){
    localStorage.clear();
}
            
function roundNumber(number, digits) {
    var multiple = Math.pow(10, digits);
    var rndedNum = Math.round(number * multiple) / multiple;
    return rndedNum;
}
            
function calcIMC(pesoKg, alturacmt){
    var calc = 0;
    if(pesoKg > 0 && alturacmt > 0){
        var alturaMts = alturacmt/100;
        var altDiv = roundNumber((alturaMts*alturaMts), 2);
        calc = pesoKg / altDiv;
    }
    return roundNumber(calc, 2);
}
            
function calcPesoIdeal(genero, pesoActualKg, alturacmt){
    var indiceMC = calcIMC(pesoActualKg, alturacmt);
    var calc = 0;
    if(genero == "hombre"){
        calc = 25 * pesoActualKg / indiceMC;
    } else if(genero == "mujer"){
        calc = 22 * pesoActualKg / indiceMC;
    }
    return roundNumber(calc, 2);
}
            
function calcTMB(genero, peso, alturacmt, edad){
    var calc = 0;
    var alturaMts = alturacmt/100;
    if(genero == "hombre"){
        calc = (10*peso) + (6.25*alturaMts) - (5*edad) + 5;
    } else if(genero == "mujer"){
        calc = (10*peso) + (6.25*alturaMts) - (5*edad) - 161;
    }
    return roundNumber(calc, 2);
}
            
function calcCaloriaDiaria(genero, peso, altura, edad, nivelActividad){
    var TMB = calcTMB(genero, peso, altura, edad);
    return roundNumber((TMB * nivelActividad), 2);
}
