"use strict";

const yValues = [-4, -3, -2, -1, 0, 1, 2, 3, 4];
const rValues = [1, 1.5, 2, 2.5, 3];
const xMax = 3;
const xMin = -5;

// function onPageLoad() {
//     var xInput = document.getElementById("x-input");
//     xInput.style.backgroundColor = "white";
//
//     var yTable = document.getElementById("y-table");
//     var rTable = document.getElementById("r-table");
//     var yLine = document.createElement("tr");
//
//     var yResult = [];
//     var rResult = [];
//
//     for (var i = 0; i < Math.max(yValues.length, rValues.length); i++) {
//         if (i < yValues.length) {
//             yLine.innerHTML += "<td>" + yValues[i] + "<input type='checkbox' name='y" + yValues[i] + "'></td>";
//             if ((i + 1) % 3 === 0) {
//                 yResult.push(yLine);
//                 yLine = document.createElement("tr");
//             }
//         }
//         if (i < rValues.length) {
//             var tmpElem = document.createElement("tr");
//             tmpElem.innerHTML = "<td>" + rValues[i] + "<input type='checkbox' name='r" + rValues[i] + "'></td>";
//             rResult.push(tmpElem);
//         }
//     }
//
//     yResult.forEach(function (value) {
//         yTable.append(value)
//     });
//     rResult.forEach(function (value) {
//         rTable.append(value)
//     });
//     document.getElementById("main").style.visibility = "visible";
// }

function checkXValue(xInput) {
    return (isNaN(Number(xInput.value)) || xInput.value < xMin || xInput.value > xMax);
}

function checkFormValues(lineArray, correctValues) {
    for (var line in lineArray) {
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
    var err = checkFormValues(yArray, yValues) || checkFormValues(rArray, rValues) || checkXValue(xInput);
    if (err) {
        event.preventDefault();
        alert("wrong parameters!");
    }
    return !err;
}