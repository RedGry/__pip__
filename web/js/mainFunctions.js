// TODO: find and fix hardcode(default sending request)

var simple_img = '<img id="b357_1m6_1" src="img/g-1.jpg"><br><br><img id="pic18" class="centered" src="img/18+.png" onclick="changeAnimeImg()">';
var not_simple_img = '<img id="b357_1m6_2" src="img/g-2.jpeg"><br><br><input type="button" id="goback" class="centered" value="w0w.. g0 b4ck" onclick="changeAnimeImg()">';
function init() {
    createGraphic('canvas', r_out.value);

    // document.getElementsByTagName('form')[0].submit();
    //
    // let loadValue = document.getElementById('load');
    // loadValue.value = 0;
}

function error(message) {
    alert(message);
}

function clickCanvas(R) {
    console.log("Click on canvas");
    let canvas = document.getElementById("canvas");

    if (canvas.is_default_graphic){
        console.log('error: R is not set');
        createGraphic('canvas', 0);
        let canvas = document.getElementById("canvas"), context = canvas.getContext("2d");
        context.strokeStyle = "#000000";
        context.fillStyle = "#ff0014";
        context.font = '20px Arial';
        context.fillText(  'You have to set ', 20, 50);
        context.fillText(  'R parameter', 20, 70);
        return;

    }

    let br = canvas.getBoundingClientRect();
    let left = br.left;
    let top = br.top;

    let event = window.event;
    let x = event.clientX - left;
    let y = event.clientY - top;

    markPointFromServer((x - 150) / 130 * R, (-y + 150) / 130 * R, R);
}

async function markPointFromServer(x, y, r) {

    let response = await fetch("./hit?hit=true&x_h=" + x + "&y_h=" + y + "&r_h=" + r, {
        method: 'GET',
        headers: {
            'Content-Type': 'text/plain;charset=UTF-8'
        }
    });
    let hit = await response.text();
    markPoint(x, y, r, hit);
}

function markPoint(x, y, r, hit) {
    console.log('Marking point ' + x + ', ' + y + ', ' + r + ', ' + hit);
    createGraphic('canvas', r);
    let canvas = document.getElementById("canvas"), context = canvas.getContext("2d");

    context.beginPath();
    context.rect(Math.round(150 + ((x / r) * 130)) - 3, Math.round(150 - ((y / r) * 130)) - 3, 6, 6);
    context.closePath();
    context.strokeStyle = 'black';

    let color = 'red';
    hit = hit.toString();

    if (hit.trim() === "true") {
        color = 'lime';
    }

    context.fillStyle = color;
    context.fill();
    context.stroke();
}

function ban() {
    document.body.style.textAlign = 'center';
    document.body.style.backgroundColor = 'black';
    let tmp = document.createElement('div');
    tmp.innerHTML = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
    document.head.append(tmp.children[0]);
    document.body.innerHTML = '<div style=\"margin-top: 60px;\"><span class=\"main-text\">先輩、私に優しくしてください。</span></div>' +
        '<div class=\"auto-margin\">' +
        '<img src=\"./img/eyes.gif\">' +
        '</div>';
}

function egg() {
    let canvas = document.getElementById("canvas"),
        context = canvas.getContext("2d");
    let img = new Image();

    img.src = "./img/angryMushroom.jpg";

    context.drawImage(img, 25, 97);

    let currentAngle = 0.1;
    let vx = 0;
    let vy = 0;

    let int = setInterval(function () {
        vx = Math.cos(currentAngle) * 100 - 100;

        // считаем синус текущего значения угла
        // и умножаем на значение радиуса
        vy = Math.sin(currentAngle) * 100;

        createGraphic("canvas", 1);
        context.drawImage(img, 25 - vx, 97 - vy);
        currentAngle += 0.05;
        if (currentAngle > 3.1) {
            clearInterval(int);
            createGraphic("canvas", 1);
        }
    }, 25);
}

function createGraphic(id, r) {
    let is_default_graphic = false;
    if (r === 0 || r === '_') {
        is_default_graphic = true;
        r = 1;
    }
    let canvas = document.getElementById(id), context = canvas.getContext("2d");
    canvas.is_default_graphic = is_default_graphic;
    //очистка
    context.clearRect(0, 0, canvas.width, canvas.height);

    //прямоугольник
    context.beginPath();
    context.rect(20, 150, 130, 130);
    context.closePath();
    context.strokeStyle = "#2f9aff";
    context.fillStyle = "#2f9aff";
    context.fill();
    context.stroke();

    // сектор
    context.beginPath();
    context.moveTo(150, 150);
    context.arc(150, 150, 65, -Math.PI / 2, 0, false);
    context.closePath();
    context.strokeStyle = "#2f9aff";
    context.fillStyle = "#2f9aff";
    context.fill();
    context.stroke();

    //треугольник
    context.beginPath();
    context.moveTo(150, 150);
    context.lineTo(20, 150);
    context.lineTo(150, 20);
    context.lineTo(150, 150);
    context.closePath();
    context.strokeStyle = "#2f9aff";
    context.fillStyle = "#2f9aff";
    context.fill();
    context.stroke();

    //отрисовка осей
    context.beginPath();
    context.font = "10px Verdana";
    context.strokeStyle = "black";
    context.fillStyle = "black";
    context.moveTo(150, 0);
    context.lineTo(150, 300);
    context.moveTo(150, 0);
    context.lineTo(145, 15);
    context.moveTo(150, 0);
    context.lineTo(155, 15);
    context.fillText("Y", 160, 10);
    context.moveTo(0, 150);
    context.lineTo(300, 150);
    context.moveTo(300, 150);
    context.lineTo(285, 145);
    context.moveTo(300, 150);
    context.lineTo(285, 155);
    context.fillText("X", 290, 130);

    // деления Y
    context.moveTo(145, 20);
    context.lineTo(155, 20);
    context.fillText(is_default_graphic ? 'R' : String(r), 160, 20);
    context.moveTo(145, 85);
    context.lineTo(155, 85);
    context.fillText(is_default_graphic ? 'R/2' : String(r / 2), 160, 78);
    context.moveTo(145, 215);
    context.lineTo(155, 215);
    context.fillText(is_default_graphic ? '-R/2' : String(-(r / 2)), 160, 215);
    context.moveTo(145, 280);
    context.lineTo(155, 280);
    context.fillText(is_default_graphic ? '-R' : String(-r), 160, 280);
    // деления X
    context.moveTo(20, 145);
    context.lineTo(20, 155);
    context.fillText(is_default_graphic ? '-R' : String(-r), 15, 140);
    context.moveTo(85, 145);
    context.lineTo(85, 155);
    context.fillText(is_default_graphic ? '-R/2' : String(-(r / 2)), 70, 140);
    context.moveTo(215, 145);
    context.lineTo(215, 155);
    context.fillText(is_default_graphic ? 'R/2' : String(r / 2), 215, 140);
    context.moveTo(280, 145);
    context.lineTo(280, 155);
    context.fillText(is_default_graphic ? 'R' : String(r), 280, 140);

    context.closePath();
    context.strokeStyle = "black";
    context.fillStyle = "black";
    context.stroke();
}

let prev_y = 0;

function setRadius(r) {
    let checked = document.getElementsByClassName('rb');
    r = 0;
    for (let el = 0; checked[el]; el++) {
        if (checked[el].checked) {
            r += Number(checked[el].value);
        }
    }

    console.log('setting radius: ' + r);

    r_h_id.value = r;
    r_out.value = r > 0?r:'_';
    createGraphic('canvas', r);
}

let res = 0;
let count = 0;

function setX(x) {
    if (count < 2) {
        count++;
        res = Number(res) + Number(x);
    } else {
        res = Number(res) + Number(x);
        count = 0;
        if (Number(res) === 2)
            egg();
        res = 0;
    }
    x_h_id.value = x;
    x_out.value = x;
}

function verifyY(y) {
    let y1 = parseFloat(y.value.replace(/,/, '.'));
    let elem = document.getElementById("y_in");
    if (y.value != '' && y.value != '-') {
        if (!isNumber(y.value.replace(/,/, '.')) || y1 <= -5 || y1 >= 3) {
            y.focus();
            elem.style.backgroundColor = "red";
            y.value = prev_y;
            return false;
        }
        prev_y = y1;
        y_h_id.value = y1;
        y_out.value = y1;
        elem.style.backgroundColor = "#E0FFFF";
        return true;
    }
    elem.style.backgroundColor = "#E0FFFF";
    prev_y = y.value;
    return true;
}

function isNumber(n) {
    return !isNaN(parseFloat(n)) && !isNaN(n - 0)
}

function doYouLikeAnImE() {
    let animeBlock = document.getElementById('DOYOULIKEANIME');
    if (animeBlock === null){
        animeBlock = document.createElement('div');
        animeBlock.id = 'DOYOULIKEANIME';
        animeBlock.classList.add('block', 'auto-margin', 'flex');
        document.body.append(animeBlock);
        animeBlock.innerHTML = '<div id="anime-form" class="centered">' +
                                    '<p id="anime-question">what is her name?</p>' +
                                    '<input id="gname" type="text" value="afanas"><br><br>' +
                                    '<input type="submit" value="check my orientation" onclick="checkOrientation()">' +
                                '</div>' +
                                '<div class="centered">' +
                                    simple_img +
                                '</div>';
    }
    // let audio = document.createElement('audio');
}

function checkOrientation() {
    console.log('point1');
    let gname = document.getElementById('gname');
    if (gname === null || gname.value === '' || gname.value === 'afanas') {
        markAsWrong(gname);
        return;
    }
    console.log('point2');
    fetch(`checkOrientation?gname=${gname.value}`)
        .then(resp=>resp.text())
        .then(text=>hiddenFunction(text));
}

function markAsWrong(node) {
    node.style.backgroundColor = "red";
    node.value = '';
    setTimeout(()=>node.style.backgroundColor = "white", 120);
}

// DONT WATCH THIS CODE
function hiddenFunction(text) {
    if (text.includes('Good, you rEallY like anime')){
        if (document.getElementsByTagName('audio').length !== 0)
            return;
        document.getElementById('anime-question').innerText = 'You win!';
        let audio = new Audio('sound/altima_fight_4_real.ogg');
        audio.autoplay=true;
        audio.play().catch(err=>console.log(err.message));
    }else{
        let gname = document.getElementById('gname');
        markAsWrong(gname);
    }

}

function changeAnimeImg() {
    let img = document.getElementById('b357_1m6_1');
    if (img === null)
        img = document.getElementById('b357_1m6_2');
    if (img === null)
        return "ban";
    img.parentNode.innerHTML = img.id === 'b357_1m6_1'?not_simple_img:simple_img;
}