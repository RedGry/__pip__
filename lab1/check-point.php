<?php
include 'utils.php';
session_start();
if (!isset($_SESSION['results'])) {
    $_SESSION['results'] = [];
}

$needAreasImage = $_GET['needAreasImage'] == 'true' and count($_GET) == 1;
$resultIndexInHistory = $_GET['resultIndex'];
$getResultFromHistory = $_GET['needResultFromHistory'] == 'true' and $resultIndexInHistory and count($_GET) == 2;
// TODO: check params here

if ($needAreasImage)
    echo bodyWrapper($areaImg);
elseif ($getResultFromHistory){
    if (count($_SESSION['results'])>0)
        echo str_replace('<html>', '<html style="margin: -16% -3%;">', $_SESSION['results'][$resultIndexInHistory % ]);
}
else {
    $parameters = parseParameters($_GET);
    $x = $_GET["X"];
    $yArray = $parameters[0];
    $rArray = $parameters[1];

    $table = generateResultTable($x, $yArray, $rArray);
    $result = bodyWrapper(toСenter($table, '', $closeButton));
    $_SESSION['results'][] = $result;
    echo $result;
}
?>

