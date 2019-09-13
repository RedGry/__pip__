"use strict";

const yValues = [-4, -3, -2, -1, 0, 1, 2, 3, 4];
const rValues = [1, 1.5, 2, 2.5, 3];
const xMax = 3;
const xMin = -5;

function error(message) {
    var node = document.getElementById('error-message');
    node.innerText = message;
    node.style.visibility = 'visible';
}

function isWrongXValue(xInput) {
    if (isNaN(Number(xInput.value.replace(',', '.'))) &&xInput.value !== '-' && xInput.value !== '+' && xInput.value !== '.' || xInput.value.includes(' ')) {
        error('Write only number');
        return true;
    } else if (xInput.value.replace(',', '.') <= xMin){
        error('Min x value is ' + (xMin + 1));
        return true;
    } else if (xInput.value.replace(',', '.') >= xMax){
        error('Max x value is ' + (xMax - 1));
        return true;
    } else if (xInput.value.length > 5) {
        error('Max x value length is 5 numerals');
        return true;
    }
    return false;
}

function isWrongArrayValues(currentValues, correctValues) {
    var haveNotValue = true;
    for (var i = 0;i<currentValues.length;i++) {
        var line = Array.from(currentValues[i].children);
        for (var j = 0; j<line.length; j++) {
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

function onEditParameters(){
    document.getElementById('error-message').style.visibility = 'hidden';
}

function onSubmitForm() {
    var xInput = document.getElementById("x-input");
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
        error("Wrong parameters!");
    }
    return !err;
}

function clock(){
    var date = new Date(),
        hours = (date.getHours() < 10) ? '0' + date.getHours() : date.getHours(),
        minutes = (date.getMinutes() < 10) ? '0' + date.getMinutes() : date.getMinutes(),
        seconds = (date.getSeconds() < 10) ? '0' + date.getSeconds() : date.getSeconds();
    document.getElementById('now').innerHTML = 'now: ' + hours + ':' + minutes + ':' + seconds;
}

function setRandomContent() {
    document.getElementById('result-iframe').src = "script.php";
}