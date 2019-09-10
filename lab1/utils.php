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
                        <td width="60%" style="padding: 7% 0%; text-align: center;">'
                            . $html .
                        '</td>
                        <td width="20%">' . $rightCellHtml . '</td>
                    </tr>
                </tbody>
            </table>';
}

function bodyWrapper($html, $class){
    return '<html>
                <head>
                    <title> %20RESULT</title>
                    <link href="static/style.css" rel="stylesheet">
                    <script src="static/script.js"></script>
                </head>
                <body class="' . $class . '" >'
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
    $result = false;
    if ($x < 0 and $y < 0) {
        $result = false;
    } elseif ($x >= 0 and $y >= 0) {
        if ($x <= $r and $y <= $r)
            $result = true;
    } elseif ($x <= 0 and $y >= 0)
        $result = pow($x, 2) + pow($y, 2) <= pow($r, 2);
    elseif ($x <= ((int)$r) / 2 and $y >= $r)
        $result = true;

    $_SESSION['results'][] = array(
        'x' => $x,
        'y' => $y,
        'r' => $r,
        'result' => $result
    );

    return $result;
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

function checkParameters(){
    foreach ($_GET as $key => $value) {
        if (substr($key, 0, 1) === "y" && $value === "on") {
            $yArray[] = substr($key, 1);
        } elseif (substr($key, 0, 1) === "r" && $value === "on") {
            $rArray[] = substr($key, 1);
        }
    }
}

function renderError($message) {
    return bodyWrapper(toСenter($message), 'error-message');
}

function renderAreasImg() {
    global $areaImg;
    echo bodyWrapper($areaImg);
}

function renderResultPage() {
    global $closeButton;

    $parameters = parseParameters($_GET);
    $x = $_GET["X"];
    $yArray = $parameters[0];
    $rArray = $parameters[1];

    $table = generateResultTable($x, $yArray, $rArray);

    echo bodyWrapper(toСenter($table, '', $closeButton), 'result-page');
}

function renderHistoryPage() {
    echo 'NotImplemented';
}
?>