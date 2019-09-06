<?php
    $pageHeader = '<html>
                    <head>
	                    <title> %20RESULT</title>
                    </head>
                    <body vlink="#000000" text="#ff0000" link="#000000" bgcolor="#0000ff" background="http://wwwww.jodi.org/100/hqx/00/45stt.gif" alink="#ff0000">
	                    <font xface="Geneva" size="4">
		                    <kbd>';

    $tableHeader = '<b><pre><dir>
                        <table bgcolor="#000000">
                            <caption style="color: blue; background-color: deeppink; font-size: larger">
                                %R35Ul7% #[n]
                            </caption>
                            <tbody><font size="2" color="#ffffff"><pre><b><xblink>
                                <th>X:</th><td>[x]</td>';

    $tableButtom = '</xblink></b></pre></font></tbody></table></dir></pre></b></kbd>';
    $pageButtom = '</font></body></html>';

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

    function generateResultTable($x, $yArray, $rArray, $tableName = ""){
        global $tableHeader, $tableButtom;
        $table = str_replace('[x]', $x, $tableHeader);
        $table = str_replace('[n]', $tableName, $table);
        foreach ($rArray as $rIndex => $r) {
            if ($rIndex === 0) {
                $table = $table . "<tr><th>Y\R</th>";
            }
            $table = $table . "<th>$r</th>";
            if ($rIndex === count($rArray) - 1) {
                $table = $table . "</tr>";
            }
        }
        foreach ($yArray as $yIndex => $y) {
            foreach ($rArray as $rIndex => $r) {
                if ($rIndex === 0) {
                    $table = $table . "<tr><th>$y</th>";
                }
                $table = $table . "<td>" . (check($x, $y, $r)?'true':'false') . "</td>";
                if ($rIndex === count($rArray) - 1) {
                    $table = $table . "</tr>";
                }
            }
        }
        return $table . $tableButtom;
    }

    class Point{
        var $x;
        var $y;
        var $r;
        var $is_in_area;
        function Point($x, $y, $r){
            $this->x = $x;
            $this->y = $y;
            $this->r = $r;
            $this->is_in_area = check($x, $y, $r);
        }
    }

?>