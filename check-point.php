<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>pip-1</title>
</head>
<body>
<center style="padding-top: 15%; font-size: large">
    <table border="1" style="text-align: center; font-size: larger">
        <caption>result</caption>
        <tr>
            <th>X</th>
            <th>Y</th>
            <th>R</th>
            <th>fall into</th>
        </tr>
        <tr>
            <?php
              $x = $_GET['X'];
              $y = $_GET['Y'];
              $r = $_GET['R'];
              $result = 1>2;
              echo "<td>$x</td>";
              echo "<td>$y</td>";
              echo "<td>$r</td>";
              if ($result)
                  echo "<td>true</td>";
              else
                  echo "<td>false</td>";
            ?>
        </tr>
    </table>
</center>
</body>
</html>