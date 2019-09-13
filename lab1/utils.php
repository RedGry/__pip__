<?php
$yValues = [-4, -3, -2, -1, 0, 1, 2, 3, 4];
$rValues = [1, 1.5, 2, 2.5, 3];
$xMax = 3;
$xMin = -5;

$areaImg = '<img id="areas-img" src="static/images/areas.png">';


function calcDuration($start, $finish)
{
    $startCalcTime = explode(' ', $start);
    $finishCalcTime = explode(' ', $finish);

    $calcTimeSec = $finishCalcTime[1] - $startCalcTime[1];
    $calcTimeMsec = $finishCalcTime[0] - $startCalcTime[0];

    if ($calcTimeSec === 0)
        return round($calcTimeMsec, 10);
    else
        return $calcTimeSec + $calcTimeMsec;
}

function resultTableWrapper($x, $html, $procctime)
{
    return '<pre>
            <table><tbody><tr><td>
                <table class="blacked max-size">
                    <caption class="result">
                        %R35Ul7%
                        <br>
                        <span class="time" id="now"></span>|<span class="time">duration: ' . $procctime . '</span>
                    </caption>
                    <tbody>
                        <th>X:</th>
                        <td>' . $x . '</td>'
        . $html .
        '</tbody>
                </table>
            </td></tr></tbody></table>
            </pre>';
}

function toСenter($html, $leftCellHtml = '', $rightCellHtml = '')
{
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

function bodyWrapper($html, $class = '', $id = '', $attr = '')
{
    return '<html>
                <head>
                    <title> %20RESULT</title>
                    <meta http-equiv="Cache-Control" content="no-cache">
                    <link href="static/style.css" rel="stylesheet">
                    <script src="static/script.js"></script>
                </head>
                <body class="' . $class . '" id="' . $id . '" ' . $attr . ' >'
        . $html .
        '</body>
            </html>';
}

function parseParameters()
{
    $yArray = array();
    $rArray = array();
    foreach ($_GET as $key => $value) {
        if (substr($key, 0, 1) === "y" && $value === "on") {
            $yArray[] = str_replace('_', '.', substr($key, 1));
        } elseif (substr($key, 0, 1) === "r" && $value === "on") {
            $rArray[] = str_replace('_', '.', substr($key, 1));
        }
    }
    return [$yArray, $rArray];
}

function check($x, $y, $r)
{
    $startTime = microtime();
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

    $calcTime = calcDuration($startTime, microtime());

    $_SESSION['results'][] = array(
        'x' => $x,
        'y' => $y,
        'r' => $r,
        'result' => $result,
        'calcTime' => $calcTime
    );

    return $result;
}

function generateResultTable($x, $yArray, $rArray, $startTime)
{
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
    return $table = resultTableWrapper($x, $tmpTable, calcDuration($startTime, microtime()));
}

function isCorrectParameters()
{
    global $xMax, $xMin, $yValues, $rValues;
    $haveXValue = false;
    $haveRValue = false;
    $haveYValue = false;
    foreach ($_GET as $key => $value) {
        $param = substr($key, 0, 1);
        if ($param === 'y') {
            if ($value === 'on' || $value === 'off') {
                $v = str_replace(',', '.', substr($key, 1));
                if (substr($v, 0, 1) !== '_' && substr($v, strlen($v) - 1, 1) !== '_')
                    $v = str_replace('_', '.', $v);
                if (!in_array($v, $yValues) || !is_numeric($v)) {
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
        } elseif ($param === 'r') {
            if ($value === 'on' || $value === 'off') {
                $v = str_replace(',', '.', substr($key, 1));
                if (substr($v, 0, 1) !== '_' && substr($v, strlen($v) - 1, 1) !== '_') {
                    $v = str_replace('_', '.', $v);
                }
                if (!in_array($v, $rValues) || !is_numeric($v)) {
                    return array(
                        'result' => false,
                        'message' => 'wrong r value: ' . $v
                    );
                }
                $haveRValue = true;
            } else {
                return array(
                    'result' => false,
                    'message' => 'wrong r checkbox value: ' . $value
                );
            }
        } elseif ($param === 'x') {
            if ($key !== 'x') {
                return array(
                    'result' => false,
                    'message' => 'unknown parameter name: ' . $key
                );
            }
            $v = str_replace(',', '.', $value);
            if (!is_numeric($v) || $v <= $xMin || $v >= $xMax)
                return array(
                    'result' => false,
                    'message' => 'wrong x value: ' . $v
                );
            $haveXValue = true;
        } else {
            if ($key !== 'needResult' || $value !== 'true')
                return array(
                    'result' => false,
                    'message' => 'unknown parameter name: ' . $key
                );
        }

    }
    if (!($haveYValue && $haveRValue && $haveXValue))
        return array(
            'result' => false,
            'message' => 'not enough parameters'
        );
    return array(
        'result' => true,
        'message' => ''
    );

}

function renderError($message)
{
    echo bodyWrapper(toСenter($message), 'error-message');
}

function renderAreasImg()
{
    global $areaImg;
    echo bodyWrapper($areaImg, 'default-result');
}

function renderResultPage()
{
    $startTime = microtime();
    $isCorrect = isCorrectParameters();
    if (!$isCorrect['result'])
        renderError($isCorrect['message']);
    else {
        $parameters = parseParameters();
        $x = str_replace('_', '.', $_GET["x"]);
        $yArray = $parameters[0];
        $rArray = $parameters[1];

        $table = generateResultTable($x, $yArray, $rArray, $startTime);

        echo bodyWrapper(toСenter($table), 'result-page', '', 'onload="clock()"');
    }
}

function renderHistoryPage()
{
    $history = $_SESSION['results'];
    if (sizeof($history) > 100)
        $history = array_slice($history, -100, 100);
    $history = array_reverse($history);
    $result = '';
    foreach ($history as $point) {
        $result = $result . '<span class="history">|';
        foreach ($point as $key => $value) {
            if ($key === 'result')
                $value = $value ? 'true' : 'false';
            $result = $result . $key . '=' . $value . '|';
        }
        $result = $result . '</span><br><br>';
    }
    echo bodyWrapper(toСenter('<span class="caption">H1570RY</span><br><pre>' . $result . '</pre>'), 'history-page');
}

function renderSearchResp($query)
{
    $myCurl = curl_init();
    curl_setopt_array($myCurl, array(
        CURLOPT_URL => 'http://mboxjodi.org/search.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query(array('query' => $query))
    ));
    $response = curl_exec($myCurl);
    $respMass = array_slice(explode('class="cataloguePath">', $response), 1);
    $result = array();
    foreach ($respMass as $i => $v) {
        $ei = strpos($v, 'class="catalogueItem"');
        $path = substr($v, 0, $ei);
        $path = str_replace('</span></span><div ', '', $path);
        $result[] = '<a class="cataloguePath" href="http://mboxjodi.org/catalogue/' . $path . '">' . $path . '</a>';
    }
    echo '<div>' . join('', $result) . '</div>';
}

?>