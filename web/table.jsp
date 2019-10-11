<%@ page import="Lab_2.Point" %>
<%@ page import="java.util.List" %>
<%@ page import="java.util.ArrayList" %>
<%@ page import="java.util.Collections" %><%--
  Created by IntelliJ IDEA.
  User: gosha
  Date: 11.10.2019
  Time: 10:18
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<jsp:useBean id="pointsBean" class="Lab_2.PointsTableBean" scope="session"/>
<html>
<head>
    <title>Результат проверки</title>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="utf-8">
</head>
<body>
<table class="results block centered">
    <tr> <th>N</th> <th>X</th> <th>Y</th> <th>R</th> <th><b>Результат</b></th> <th>Показать </th> </tr>
    <%
        StringBuilder answer1 = new StringBuilder();

    List<Point> list = pointsBean.getPoints();

        while (list.size() > 10) {
            list.remove(0);
        }

        List<Point> reversed = new ArrayList<>(list);
        Collections.reverse(reversed);

        for (Point point : reversed) {
            if (point != null) {
                answer1.append(point);
            } else {
                answer1.append("<tr> <td colspan='6'><b>Неверные аргументы</b></td> </tr>");
            }
        }

        out.println(answer1);

%>
</table>
</body>
</html>
