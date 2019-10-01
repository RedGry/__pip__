package Lab_2;

import javax.naming.InitialContext;
import javax.naming.NamingException;
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
    private double[] rValues = {1, 1.5, 2, 2.5, 3};
    private PointsTable bean;
    private static final String SESSION_KEY = "points";

    @Override
    public void init (ServletConfig config) {
        this.config = config;
    }

    @Override
    public void destroy() {}

    @Override
    public ServletConfig getServletConfig()
    {
        return config;
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        try {
            bean = (PointsTable) request.getSession().getAttribute(SESSION_KEY);

            if (bean == null) {
                try {
                    InitialContext ic = new InitialContext();
                    bean = (PointsTable) ic.lookup("myBean");

                    request.getSession().setAttribute(SESSION_KEY, bean);
                } catch (NamingException e) {
                    throw new ServletException(e);
                }
            }

            boolean load = request.getParameter("load").equals("1");

            if (!load) {
                try {
                    int x = Integer.parseInt(request.getParameter("x_h"));
                    double y = Double.parseDouble(request.getParameter("y_h"));
                    double r = Double.parseDouble(request.getParameter("r_h"));

                    Point p = null;

                    if (validate(x, y, r))
                        p = new Point(x, y, r, bean.getN());

                    bean.addPoint(p);
                } catch (Exception e) {
                    throw e;
                    //request.getServletContext().getRequestDispatcher("/index.jsp").forward(request, response);
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

            if (formTable(htmlResponse)) {
                htmlResponse.append("</body> </html>");
                out.println(htmlResponse);
            } else
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

        } catch (Exception e) {
            throw e;
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

    private boolean formTable(StringBuilder htmlResponse) {
        htmlResponse.append("<table class=\"results\">");
        htmlResponse.append("<tr> <th>N</th> <th>X</th> <th>Y</th> <th>R</th> <th><b>Результат</b></th> <th>Показать </th> </tr>");

        List<Point> list = bean.getPoints();

        while (list.size() > 10) {
            list.remove(0);
        }

        List<Point> reversed = new ArrayList<>(list);
        Collections.reverse(reversed);

        for (int i = 0; i < reversed.size(); i++) {

            Point point = reversed.get(i);

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
