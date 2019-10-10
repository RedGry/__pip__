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
import java.util.Collections;
import java.util.List;

@WebServlet(name = "AreaCheckServlet", urlPatterns = "/check")
public class AreaCheckServlet extends HttpServlet {

    private ServletConfig config;

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

        bean = (PointsTableBean) request.getSession().getAttribute("pointsBean");

        String reset = request.getParameter("reset");

        boolean load;

        try {
            load = request.getParameter("load").equals("1");
        } catch (NullPointerException e) {
            load = false;
        }

        if (!load) {
            try {
                int x = Integer.parseInt(request.getParameter("x_h").trim());
                double y = Double.parseDouble(request.getParameter("y_h"));
                double r = Double.parseDouble(request.getParameter("r_h"));

                Point p = new Point(x, y, r, bean.getN());

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
                "\t<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\">\n" +
                "\t<link rel=\"stylesheet\" type=\"text/css\" href=\"css/handler.css\">\n" +
                "</head>\n" +
                "<body>");
        if (bean.getPoints().size() > 0)
            formTable(htmlResponse, reset);

        htmlResponse.append("</body> </html>");
        out.println(htmlResponse);

        out.close();

    }

    @SuppressWarnings("unchecked")
    private void formTable(StringBuilder htmlResponse, String reset) {
        htmlResponse.append("<table class=\"results block centered\">");
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
                htmlResponse.append("<tr> <td colspan='6'><b>Неверные аргументы</b></td> </tr>");
            }
        }

        htmlResponse.append("</table>");
    }

}
