<?php
include 'utils.php';

$needAreaImage = $_GET['needAreasImage'];

if ($needAreaImage and $needAreaImage == 'true')
    echo bodyWrapper($areaImg);
else {
    $parameters = parseParameters($_GET);
    $x = $_GET["X"];
    $yArray = $parameters[0];
    $rArray = $parameters[1];

    $table = generateResultTable($x, $yArray, $rArray, '1');
    echo bodyWrapper(toСenter($table));
}
?>

