<html>
<head>
	<title> %20RESULT </title>
</head>
<body vlink="#000000" text="#ff0000" link="#000000" bgcolor="#0000ff" background="http://wwwww.jodi.org/100/hqx/00/45stt.gif" alink="#ff0000">
	<font xface="Geneva" size="4">
		<kbd><b><pre><dir>
		<table bgcolor="#000000">
            <caption style="color: blue; background-color: deeppink; font-size: larger">%R35Ul7%</caption>
			<tbody><font size="2" color="#ffffff"><pre><b><xblink>
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
			</xblink></b></pre></font></tbody>
		</table>
		</dir></pre></b></kbd>
	</font>
</body>
</html>