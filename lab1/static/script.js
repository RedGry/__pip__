"use strict";

const yValues = [-4, -3, -2, -1, 0, 1, 2, 3, 4];
const rValues = [1, 1.5, 2, 2.5, 3];
const xMax = 3;
const xMin = -5;

function isWrongXValue(xInput) {
    return (isNaN(Number(xInput.value.replace(',', '.'))) || xInput.value.replace(',', '.') <= xMin || xInput.value.replace(',', '.') >= xMax);
}

function isWrongArrayValues(currentValues, correctValues) {
    for (var i = 0;i<currentValues.length;i++) {
        var line = Array.from(currentValues[i].children);
        for (var j = 0; j<line.length; j++) {
            var v = line[j].children[0].name;
            v = Number(v.substring(1).replace(',', '.'));
            if (!(correctValues.includes(v)))
                return true;
        }
    }
    return false;
}

function onEditX() {
    var xInput = document.getElementById("x-input");
    if (isWrongXValue(xInput))
        xInput.style.backgroundColor = "red";
    else
        xInput.style.backgroundColor = "white";
}

function onSubmitForm() {
    // return true;
    var xInput = document.getElementById("x-input");
    var yArray = Array.from(document.getElementById("y-table").children);
    var rArray = Array.from(document.getElementById("r-table").children);
    yArray.shift();
    rArray.shift();
    var err = isWrongArrayValues(yArray, yValues) || isWrongArrayValues(rArray, rValues) || isWrongXValue(xInput);
    if (err) {
        event.preventDefault();
        alert("wrong parameters!");
    }
    return !err;
}
