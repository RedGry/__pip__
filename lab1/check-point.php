<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>pip-1</title>
</head>
<body style="background-color: darkslateblue">
<center style="padding-top: 15%; font-size: large">
    <table border="1" style="font-size: larger">
        <caption>result</caption>
        <tr>
            <table border="1" style="font-size: larger">
                <?php
                $x = $_GET['X'];
                echo "<th>X:</th><td>$x</td>";

                $parameters = array_keys($_GET);
                foreach ($_GET as $key => $value) {
                    if (substr($key, 0, 1) === "y") {
                        $yArray[] = substr($key, 1);
                    } elseif (substr($key, 0, 1) === "r") {
                        $rArray[] = substr($key, 1);
                    }
                }

                function check($x, $y, $r)
                {
                    if ($x<0 and $y<0){
                        return false;
                    }elseif ($x>=0 and $y>=0){
                        if ($x<=$r and $y<=$r)
                            return true;
                    }elseif ($x<=0 and $y>=0)
                        return pow($x, 2) + pow($y, 2) <= pow($r, 2);
                    elseif ($x<=((int)$r)/2 and $y>=$r)
                        return true;
                    return false;
                }

                foreach ($rArray as $rIndex => $r) {
                    if ($rIndex === 0) {
                        echo "<tr><th>Y\R</th>";
                    }
                    echo "<th>$r</th>";
                    if ($rIndex === count($rArray) - 1) {
                        echo "</tr>";
                    }
                }

                foreach ($yArray as $yIndex => $y) {
                    foreach ($rArray as $rIndex => $r) {
                        if ($rIndex === 0) {
                            echo "<tr><th>$y</th>";
                        }
                        echo "<td>" . (check($x, $y, $r)?'true':'false') . "</td>";
                        if ($rIndex === count($rArray) - 1) {
                            echo "</tr>";
                        }
                    }
                }
                ?>


            </table>
        </tr>
    </table>
</center>
</body>
</html>