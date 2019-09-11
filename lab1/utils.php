<?php
$yValues = [-4, -3, -2, -1, 0, 1, 2, 3, 4];
$rValues = [1, 1.5, 2, 2.5, 3];
$xMax = 3;
$xMin = -5;

$areaImg = '<img id="areas-img" src="static/images/areas.png">';

function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}

function resultTableWrapper($x, $html){
    return '<pre>
                <table bgcolor="#000000">
                    <caption class="result">
                        %R35Ul7%
                    </caption>
                    <tbody>
                        <th>X:</th><td>' . $x . '</td>'
        . $html .
        '</tbody>
                </table>
            </pre>';
}

function toСenter($html, $leftCellHtml = '', $rightCellHtml = ''){
    return '<table class="max-size">
                <tbody>
                    <tr>
                        <td class="to-center-side-cell">' . $leftCellHtml . '</td>
                        <td class="to-center-main-cell">'
                            . $html .
                        '</td>
                        <td class="to-center-side-cell">' . $rightCellHtml . '</td>
                    </tr>
                </tbody>
            </table>';
}

function bodyWrapper($html, $class = '', $id = ''){
    return '<html>
                <head>
                    <title> %20RESULT</title>
                    <link href="static/style.css" rel="stylesheet">
                </head>
                <body class="' . $class . '" id="' . $id . '" >'
                    . $html .
                '</body>
            </html>';
}

function parseParameters(){
    $yArray = array();
    $rArray = array();
    foreach ($_GET as $key => $value) {
        if (substr($key, 0, 1) === "y" && $value === "on") {
            $yArray[] = substr($key, 1);
        } elseif (substr($key, 0, 1) === "r" && $value === "on") {
            $rArray[] = substr($key, 1);
        }
    }
    return [$yArray, $rArray];
}

function check($x, $y, $r){
    $startCalcTime = explode(' ', microtime());
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

    $finishCalcTime = explode(' ', microtime());

    $calcTimeSec = $finishCalcTime[1] - $startCalcTime[1];
    $calcTimeMsec = $finishCalcTime[0] - $startCalcTime[0];

    if ($calcTimeSec === 0)
        $calcTime = $calcTimeMsec;
    else
        $calcTime = $calcTimeSec + $calcTimeMsec;

    $_SESSION['results'][] = array(
        'x' => $x,
        'y' => $y,
        'r' => $r,
        'result' => $result,
        'calcTime' => $calcTime
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

function isCorrectParameters(){
    global $xMax, $xMin, $yValues, $rValues;
    $haveXValue = false;
    $haveRValue = false;
    $haveYValue = false;
    foreach ($_GET as $key => $value) {
        $param = substr($key, 0, 1);
        if ($param === 'y') {
            if ($value === 'on' || $value === 'off') {
                $v = str_replace(',', '.', substr($key, 1));
                if (!in_array($v, $yValues)){
                    return array(
                        'result' => false,
                        'message' => 'wrong y value: ' . $v
                    );
                }
                $haveYValue = true;
            } else {
                return array(
                    'result' => false,
                    'message' => 'wrong y checkbox value: ' . $value
                );
            }
        }
        elseif ($param === 'r') {
            if ($value === 'on' || $value === 'off') {
                $v = str_replace(',', '.', substr($key, 1));
                if (!in_array($v, $rValues))
                    return array(
                        'result' => false,
                        'message' => 'wrong r value: ' . $v
                    );
                $haveRValue = true;
            } else {
                return array(
                    'result' => false,
                    'message' => 'wrong r checkbox value: ' . $value
                );
            }
        }
        elseif ($param === 'x') {
            if ($key !== 'x'){
                return array(
                    'result' => false,
                    'message' => 'unknown parameter name: ' . $key
                );}
            $v = str_replace(',', '.', $value);
            if ($v<=$xMin || $v>=$xMax)
                return array(
                'result' => false,
                'message' => 'wrong x value: ' . $v
            );
            $haveXValue = true;
        }
        else {
            if ($key !== 'needResult' || $value !== 'true')
                return array(
                    'result' => false,
                    'message' => 'unknown parameter name: ' . $key
                );
        }

    }
    if (! ($haveYValue && $haveRValue && $haveXValue))
        return array(
            'result' => false,
            'message' => 'not enough parameters'
        );
    return array(
        'result' => true,
        'message' => ''
    );

}

function renderError($message){
    echo bodyWrapper(toСenter($message), 'error-message');
}

function renderAreasImg(){
    global $areaImg;
    echo bodyWrapper($areaImg, 'default-result');
}

function renderResultPage(){
    $isCorrect = isCorrectParameters();
    if (! $isCorrect['result'])
        renderError($isCorrect['message']);
    else {
        $parameters = parseParameters();
        $x = $_GET["x"];
        $yArray = $parameters[0];
        $rArray = $parameters[1];

        $table = generateResultTable($x, $yArray, $rArray);

        echo bodyWrapper(toСenter($table), 'result-page');
    }
}

function renderHistoryPage(){
    $history = $_SESSION['results'];
    if (sizeof($history) > 10)
        $history = array_slice($history, -10, 10);
    $result = '';
    foreach ($history as $point){
        foreach ($point as $key => $value){
            $result = $result . $key . ': ' . $value . ' | ';
        }
        $result = $result . '<br><br>';
    }
    renderError('NotImplemented<br>H1570RY<br><br>' . $result);
}
?>