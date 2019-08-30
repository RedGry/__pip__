<?php
    include 'utils.php';
    echo $pageHeader;

    $parameters = parseParameters($_GET);
    $x = $_GET["X"];
    $yArray = $parameters[0];
    $rArray = $parameters[1];

    //there will be a generation of several tables
    echo generetResultTable($x, $yArray, $rArray, '1');
    //...
    echo generetResultTable($x, $yArray, $rArray, 'n');

    echo $pageButtom;
?>

