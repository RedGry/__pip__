package Lab_2;

import javax.servlet.*;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.Arrays;

public class AreaCheckFilter implements Filter {

    private int[] xValues = {-3, -2, -1, 0, 1, 2, 3, 4, 5};
    private double[] rValues = {0, 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5.5, 6, 6.5, 7.5, 8, 8.5, 9, 9.5, 10};

    public void init(FilterConfig arg0) {}

    public void doFilter(ServletRequest req, ServletResponse resp,
                         FilterChain chain) throws IOException, ServletException {

        resp.setContentType("text/html; charset=UTF-8");

        PrintWriter out = resp.getWriter();

        int x = Integer.parseInt(req.getParameter("x_h").trim());
        double y = Double.parseDouble(req.getParameter("y_h"));
        double r = Double.parseDouble(req.getParameter("r_h"));

        if (validate(x, y, r))
            chain.doFilter(req, resp);
        else {
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

    private boolean validate(int x, double y, double r) {
        boolean checkX = Arrays.binarySearch(xValues, x) > -1;
        boolean checkY = y >= -3 && y <= 5;
        boolean checkR = Arrays.binarySearch(rValues, r) > -1;
        return checkX && checkY && checkR;
    }

    public void destroy() {}

}

