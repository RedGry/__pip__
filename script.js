"use strict";

var yValues = [-4, -3, -2, -1, 0, 1, 2, 3, 4];
var rValues = [1, 1.5, 2, 2.5, 3];

var yLine = document.createElement("tr");

var yResult = [];
var rResult = [];

for (var i = 0; i < Math.max(yValues.length, rValues.length); i++) {
    if (i < yValues.length) {
        yLine.innerHTML += "<td>"+ yValues[i] +"<input type='checkbox' name='y" + yValues[i] + "'></td>";
        if ((i+1) % 3 === 0) {
            yResult.push(yLine);
            yLine = document.createElement("tr");
        }
    }
    if (i < rValues.length) {
        var tmpElem = document.createElement("tr");
        tmpElem.innerHTML = "<td>"+ rValues[i] +"<input type='checkbox' name='r" + rValues[i] + "'></td>";
        rResult.push(tmpElem);
    }
}

var yTable = document.getElementById("y-table");
var rTable = document.getElementById("r-table");

yResult.forEach(function (value) {
    yTable.append(value)
});
rResult.forEach(function (value) {
    rTable.append(value)
});
