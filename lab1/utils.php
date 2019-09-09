<?php
$areaImg = '<img id="areas-img" style="" src="static/areas.png">';
$closeButton = '<button onclick="resetResult()" style="margin-bottom: 390%;margin-left: 30%;">reset</button>';

function resultTableWrapper($x, $html){
    return '<pre>
                <table bgcolor="#000000">
                    <caption style="color: blue; background-color: deeppink; font-size: larger">
                        %R35Ul7%
                    </caption>
                    <tbody>
                        <th>X:</th><td>' . $x . '</td>'
                        . $html .
                    '</tbody>
                </table>
            </pre>';
}

function toСenter($html, $leftCellHtml='', $rightCellHtml=''){
    return '<table  width="100%">
                <tbody>
                    <tr>
                        <td width="20%">' . $leftCellHtml . '</td>
                        <td width="60%" style="padding: 7% 0%">'
                            . $html .
                        '</td>
                        <td width="20%">' . $rightCellHtml . '</td>
                    </tr>
                </tbody>
            </table>';
}

function bodyWrapper($html){
    return '<html>
                <head>
                    <title> %20RESULT</title>
                    <script src="static/script.js"></script>
                </head>
                <body style="max-width: 420px; overflow: hidden; max-height: 320px; margin: 0px;" text="#ff0000" background="static/strange-bg.gif">'
                    . $html .
                '</body>
            </html>';
}

function parseParameters($get){
    $yArray = array();
    $rArray = array();
    foreach ($get as $key => $value) {
        if (substr($key, 0, 1) === "y" && $value === "on") {
            $yArray[] = substr($key, 1);
        } elseif (substr($key, 0, 1) === "r" && $value === "on") {
            $rArray[] = substr($key, 1);
        }
    }
    return [$yArray, $rArray];
}

function check($x, $y, $r){
    if ($x < 0 and $y < 0) {
        return false;
    } elseif ($x >= 0 and $y >= 0) {
        if ($x <= $r and $y <= $r)
            return true;
    } elseif ($x <= 0 and $y >= 0)
        return pow($x, 2) + pow($y, 2) <= pow($r, 2);
    elseif ($x <= ((int)$r) / 2 and $y >= $r)
        return true;
    return false;
}

function generateResultTable($x, $yArray, $rArray){
    $tmpTable = '';
    foreach ($rArray as $rIndex => $r) {
        if ($rIndex === 0) {
            $tmpTable = $tmpTable . "<tr><th>Y\R</th>";
        }
        $tmpTable = $tmpTable . "<th>$r</th>";
        if ($rIndex === count($rArray) - 1) {
            $tmpTable = $tmpTable . "</tr>";
        }
    }
    foreach ($yArray as $yIndex => $y) {
        foreach ($rArray as $rIndex => $r) {
            if ($rIndex === 0) {
                $tmpTable = $tmpTable . "<tr><th>$y</th>";
            }
            $tmpTable = $tmpTable . "<td>" . (check($x, $y, $r) ? 'true' : 'false') . "</td>";
            if ($rIndex === count($rArray) - 1) {
                $tmpTable = $tmpTable . "</tr>";
            }
        }
    }
    return $table = resultTableWrapper($x, $tmpTable);
}

function checkParameters($get){
    foreach ($get as $key => $value) {
        if (substr($key, 0, 1) === "y" && $value === "on") {
            $yArray[] = substr($key, 1);
        } elseif (substr($key, 0, 1) === "r" && $value === "on") {
            $rArray[] = substr($key, 1);
        }
    }
}

//class Point
//{
//    var $x;
//    var $y;
//    var $r;
//    var $is_in_area;
//
//    function Point($x, $y, $r)
//    {
//        $this->x = $x;
//        $this->y = $y;
//        $this->r = $r;
//        $this->is_in_area = check($x, $y, $r);
//    }
//}
?>