"use strict";

const yValues = [-4, -3, -2, -1, 0, 1, 2, 3, 4];
const rValues = [1, 1.5, 2, 2.5, 3];
const xMax = 3;
const xMin = -5;

function checkXValue(xInput) {
    return (isNaN(Number(xInput.value)) || xInput.value < xMin || xInput.value > xMax);
}

function checkArrayValues(currentValues, correctValues) {
    for (var line in currentValues) {
        for (var cell in line.children) {
            if (!cell.children[0].checked)
                continue
            let v = cell.children[0].name;
            v = Number(v.substring(1));
            if (!(v in correctValues))
                return true
        }
    }
    return false;
}

function resetResult() {
    Array.from(document.body.children).forEach(function (node){node.remove()});
    document.body.innerHTML = '<img id="areas-img" style="" src="static/areas.png">';
}

function onEditX() {
    var xInput = document.getElementById("x-input");
    if (checkXValue(xInput))
        xInput.style.backgroundColor = "red";
    else
        xInput.style.backgroundColor = "white";
}

function onSubmitForm() {
    var xInput = document.getElementById("x-input");
    var yArray = Array.from(document.getElementById("y-table").children);
    var rArray = Array.from(document.getElementById("r-table").children);
    yArray.shift();
    rArray.shift();
    var err = checkArrayValues(yArray, yValues) || checkArrayValues(rArray, rValues) || checkXValue(xInput);
    if (err) {
        event.preventDefault();
        alert("wrong parameters!");
    }
    return !err;
}
