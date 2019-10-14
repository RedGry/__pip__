<%@page contentType="text/html" pageEncoding="UTF-8" %>

<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Lab2-Web</title>
    <%--    <style> <%@include file='css/main.css' %> </style>--%>
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript"> <%@include file='js/script.js' %> </script>
</head>
<body areYouLoveAnime="true" onload="init()">
<jsp:useBean id="pointsBean" class="Lab_2.PointsTableBean" scope="session"/>
<div class="block auto-margin" id="head">
    Agababyan_Karlen & Gosha_Sawin<br>
    Group: P3202; Option: 202000/813992<br>
    <a href="//github.com/SunnyCapt/Lab2-Web">Source of AK</a>/<a href="//github.com/DeltaThreeEight/Lab2-Web">Source of
    GS</a>
</div>
<div class="block auto-margin flex">
    <div class="centered">
        <div class="auto-margin" id="xblock">
            <p>X:
                <output name="x_output" id="x_out" class="output">_</output>
            </p>

            <table>
                <tr>
                    <td><input type="button" name="x11" id="x_11" value="-3" autocomplete="off" onclick="setX(x_11.value)"></td>
                    <td><input type="button" name="x12" id="x_12" value="-2" autocomplete="off" onclick="setX(x_12.value)"></td>
                    <td><input type="button" name="x13" id="x_13" value="-1" autocomplete="off" onclick="setX(x_13.value)"></td>
                </tr>
                <tr>
                    <td><input type="button" name="x21" id="x_21" value=" 0" autocomplete="off" onclick="setX(x_21.value)"></td>
                    <td><input type="button" name="x22" id="x_22" value=" 1" autocomplete="off" onclick="setX(x_22.value)"></td>
                    <td><input type="button" name="x23" id="x_23" value=" 2" autocomplete="off" onclick="setX(x_23.value)"></td>
                </tr>
                <tr>
                    <td><input type="button" name="x31" id="x_31" value=" 3" autocomplete="off" onclick="setX(x_31.value)"></td>
                    <td><input type="button" name="x32" id="x_32" value=" 4" autocomplete="off" onclick="setX(x_32.value)"></td>
                    <td><input type="button" name="x33" id="x_33" value=" 5" autocomplete="off" onclick="setX(x_33.value)"></td>
                </tr>
            </table>
        </div>
        <div class="auto-margin" id="yblock">
            <p>Y:
                <output name="y_output" id="y_out" class="output">_</output>
            </p>

            <span class="tooltip">
                    <input type="text" name="y_input" autocomplete="off" maxlength="5" x id="y_in" value="0"
                           onblur="return verifyY(this);" oninput="return verifyY(this);">
            </span>
            <p>
                <span>[-5 ... 3]</span>
            </p>
        </div>
        <div class="auto-margin" id="rblock">
            <p>R:
                <output name="r_output" id="r_out" class="output">_</output>
            </p>

            <p>
            <table class="no-letter-spacing">
                <tr>
                    <td>
                        1
                        <input type="checkbox" name="radius" autocomplete="off" class="rb" id="r_1" value="1" my-title="1"
                               onclick="setRadius(r_1.value)">
                    </td>
                    <td>
                        1.5
                        <input type="checkbox" name="radius" class="rb" autocomplete="off" id="r_1_5" value="1.5" my-title="1.5"
                               onclick="setRadius(r_1_5.value)">
                    </td>
                    <td>
                        2
                        <input type="checkbox" name="radius" class="rb" id="r_2" autocomplete="off" value="2" my-title="2"
                               onclick="setRadius(r_2.value)">
                    </td>
                    <td>
                        2.5
                        <input type="checkbox" name="radius" class="rb" id="r_2_5" value="2.5" autocomplete="off" my-title="2.5"
                               onclick="setRadius(r_2_5.value)">
                    </td>
                    <td>
                        3
                        <input type="checkbox" name="radius" class="rb" id="r_3" value="3" autocomplete="off" my-title="3"
                               onclick="setRadius(r_3.value)">
                    </td>
                </tr>
            </table>
            </p>
            <div id="formblock">
                <form method="GET" action="check" target="result">
                    <input type="hidden" autocomplete="off" name="x_h" id="x_h_id" value="0">
                    <input type="hidden" autocomplete="off" name="r_h" id="r_h_id" value="0">
                    <input type="hidden" autocomplete="off" name="y_h" id="y_h_id" value="0">
                    <input type="hidden" autocomplete="off" name="load" id="load" value="0">
                    <p><input type="submit" value="Проверить" onclick="return markPointFromServer(x_out.value, y_out.value, r_out.value)"></p>
                </form>
            </div>
        </div>
    </div>
    <p class="centered" id="error"></p>
    <div class="graphic centered">
        <canvas id="canvas" onclick="clickCanvas(r_out.value)" width="300" height="300"></canvas>
    </div>
</div>
<div class="block auto-margin">
    <iframe name="result" src="check?x_h=1&r_h=2&y_h=1&load=1"></iframe>
</div>
    <img src="img/iwannasleep.gif" id="iwannasleep" onclick="doYouLikeAnImE()">
</body>