package Lab_2;

import javax.servlet.ServletConfig;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collections;
import java.util.List;

@WebServlet(name = "AreaCheckServlet", urlPatterns = "/check")
public class AreaCheckServlet extends HttpServlet {

    private ServletConfig config;
    private int[] xValues = {-3, -2, -1, 0, 1, 2, 3, 4, 5};
    private double[] rValues = {0, 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5.5, 6, 6.5, 7.5, 8, 8.5, 9, 9.5, 10};

    private PointsTableBean bean;

    @Override
    public void init(ServletConfig config) {
        this.config = config;
    }

    @Override
    public void destroy() {}

    @Override
    public ServletConfig getServletConfig()
    {
        return config;
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws IOException, ServletException {

        bean = (PointsTableBean) request.getSession().getAttribute("sessionBean");


        if (bean == null) {
            bean = new PointsTableBean();
            request.getSession().setAttribute("sessionBean", bean);
        }

        String reset = request.getParameter("reset");

        boolean load = request.getParameter("load").equals("1");

        if (!load) {
            try {
                int x = Integer.parseInt(request.getParameter("x_h").trim());
                double y = Double.parseDouble(request.getParameter("y_h"));
                double r = Double.parseDouble(request.getParameter("r_h"));

                Point p = null;

                if (validate(x, y, r))
                    p = new Point(x, y, r, bean.getN());

                bean.addPoint(p);
            } catch (Exception e) {
                //throw e;
                request.getServletContext().getRequestDispatcher("/index.jsp").forward(request, response);
            }
        }

        response.setContentType("text/html; charset=UTF-8");
        PrintWriter out = response.getWriter();

        StringBuilder htmlResponse = new StringBuilder();

        htmlResponse.append("<!DOCTYPE html>\n" +
                "<html>\n" +
                "<head>\n" +
                "\t<title>Результат проверки</title>\n" +
                "  \t<meta charset=\"utf-8\">\n" +
                "\t<link rel=\"stylesheet\" type=\"text/css\" href=\"css/handler_style.css\">\n" +
                "</head>\n" +
                "<body>");

        if (formTable(htmlResponse, reset)) {
            htmlResponse.append("</body> </html>");
            out.println(htmlResponse);
        } else {
            out.println(("<!DOCTYPE html>\n" +
                    "<html>\n" +
                    "<head>\n" +
                    "\t<title>Тупо бан</title>\n" +
                    "  \t<meta charset=\"utf-8\">\n" +
                    "\t<link rel=\"stylesheet\" type=\"text/css\" href=\"css/handler_style.css\">\n" +
                    "</head>\n" +
                    "<body>" +
                    "<img src=\"./img/ban.png\">" +
                    "<script>" +
                    "parent.ban();" +
                    "</script>" +
                    "</body> </html>"));
        }

    }

    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws IOException {
        response.sendRedirect("control");
    }

    private boolean validate(int x, double y, double r) {
        boolean checkX = Arrays.binarySearch(xValues, x) > -1;
        boolean checkY = y >= -3 && y <= 5;
        boolean checkR = Arrays.binarySearch(rValues, r) > -1;
        return checkX && checkY && checkR;
    }

    @SuppressWarnings("unchecked")
    private boolean formTable(StringBuilder htmlResponse, String reset) {
        htmlResponse.append("<table class=\"results\">");
        htmlResponse.append("<tr> <th>N</th> <th>X</th> <th>Y</th> <th>R</th> <th><b>Результат</b></th> <th>Показать </th> </tr>");

        List<Point> list = bean.getPoints();

        while (list.size() > 10) {
            list.remove(0);
        }

        if (reset != null && reset.equals("true"))
            while (list.size() > 0)
                list.remove(0);

        List<Point> reversed = new ArrayList<>(list);
        Collections.reverse(reversed);

        for (Point point : reversed) {
            if (point != null) {
                htmlResponse.append(point);
            } else {
                //htmlResponse.append("<tr> <td colspan='6'><b>Неверные аргументы</b></td> </tr>");
                return false;
            }
        }

        htmlResponse.append("</table>");
        return true;
    }

}
