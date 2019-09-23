"use strict";

const yValues = [-4, -3, -2, -1, 0, 1, 2, 3, 4];
const rValues = [1, 1.5, 2, 2.5, 3];
const xMax = 3;
const xMin = -5;

const kittyUpdateRate = 1488 * 5;

function message(msg) {
    var node = document.getElementById('message');
    node.innerText = msg;
    node.style.visibility = 'visible';
}

function isWrongXValue(xInput) {
    var is_god_mod = xInput.value.substr(0, 5) === '#VT#:';
    if (isNaN(Number(xInput.value.replace(',', '.'))) && !is_god_mod && xInput.value !== '-' && xInput.value !== '+' && xInput.value !== '.' || xInput.value.includes(' ')) {
        message('Write only number');
        return true;
    } else if (xInput.value.replace(',', '.') <= xMin) {
        message('Min x value is ' + (xMin + 1));
        return true;
    } else if (xInput.value.replace(',', '.') >= xMax) {
        message('Max x value is ' + (xMax - 1));
        return true;
    } else if (xInput.value.length > 5 && !is_god_mod) {
        message('Max x value length is 5 numerals');
        return true;
    }
    return false;
}

function isWrongArrayValues(currentValues, correctValues) {
    var haveNotValue = true;
    for (var i = 0; i < currentValues.length; i++) {
        var line = Array.from(currentValues[i].children);
        for (var j = 0; j < line.length; j++) {
            if (line[j].children[0].checked)
                haveNotValue = false;
            var v = line[j].children[0].name;
            v = Number(v.substring(1).replace(',', '.'));
            if (!(correctValues.includes(v)))
                return true;
        }
    }
    return haveNotValue;
}

function onEditX() {
    onEditParameters();
    var xInput = document.getElementById("x-input");
    if (isWrongXValue(xInput)) {
        xInput.style.backgroundColor = "red";
        xInput.value = '';
        setTimeout(function () {
            xInput.style.backgroundColor = "white";
        }, 80);
    }
}

function onEditParameters() {
    document.getElementById('message').style.visibility = 'hidden';
}

function onSubmitForm() {
    var xInput = document.getElementById("x-input");
    if (xInput.value.substr(0, 5) === '#VT#:') {
        setStrangePage(xInput.value.substr(5));
        event.preventDefault();
        return false;
    }
    var yArray = Array.from(document.getElementById("y-table").children);
    var rArray = Array.from(document.getElementById("r-table").children);
    yArray.shift();
    rArray.shift();
    var err = isWrongArrayValues(yArray, yValues) ||
        isWrongArrayValues(rArray, rValues) ||
        xInput.value === '' ||
        isWrongXValue(xInput);
    if (err) {
        event.preventDefault();
        message("Wrong parameters!");
    }
    return !err;
}

function clock() {
    var date = new Date(),
        hours = (date.getHours() < 10) ? '0' + date.getHours() : date.getHours(),
        minutes = (date.getMinutes() < 10) ? '0' + date.getMinutes() : date.getMinutes(),
        seconds = (date.getSeconds() < 10) ? '0' + date.getSeconds() : date.getSeconds();
    document.getElementById('now').innerHTML = 'now: ' + hours + ':' + minutes + ':' + seconds;
}

function setDataToIframe(html) {
    let iframe = document.getElementById('result-iframe');
    let tmpElem = document.createElement('div');
    tmpElem.innerHTML = html;
    let paths = Array.from(tmpElem.getElementsByClassName('cataloguePath'));
    iframe.innerHTML = '<table class="max-size"><tbody><tr><td class="to-center-side-cell"></td><td class="to-center-main-cell"></td><td class="to-center-side-cell"></td></tr></tbody></table>'
    let container = iframe.getElementsByClassName('to-center-main-cell')[0];
    for (var path in paths) {
        container.append('<a class="cataloguePath" href="http://mboxjodi.org/catalogue/' + path.textContent + '">path.textContent</a>');
    }
}

function setStrangePage(query) {
    let iframe = document.getElementById('result-iframe');
    iframe.src = 'script.php?query=' + query;
}

function loadImage(url) {
    return new Promise(resolve => {
        let img = new Image();
        img.src = url;
        img.onload = () => resolve(img);
    });
}

const Kitty = function (queryUrl) {
    this.url = queryUrl;
};

Kitty.prototype.show = image => {
    let cell = document.getElementById('kitty-cell');
    Array.from(cell.children).forEach(value => value.remove());
    let height = getComputedStyle(document.getElementById('header')).height;
    height = height.substring(0, height.length - 2);
    let k =  height / image.height;
    image.width = image.width * k;
    image.height = image.height * k;
    cell.href = image.src;
    cell.appendChild(image);
}

Kitty.prototype.load = function () {
    return fetch(this.url)
        .then(response => response.json())
        .then(kittyJSON => loadImage(kittyJSON[0].url)
        );
}

function onLoadIndex() {
    let kitty = new Kitty('http://api.thecatapi.com/v1/images/search?mime_types=gif');
    kitty.load().then(kitty.show)
    setInterval(() => kitty.load().then(kitty.show), kittyUpdateRate);
}