package Lab_2;

import javax.servlet.*;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.Arrays;

public class AreaCheckFilter implements Filter {

    private int[] xValues = {-3, -2, -1, 0, 1, 2, 3, 4, 5};
    private double[] rValues = {0, 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5.5, 6, 6.5, 7.5, 8, 8.5, 9, 9.5, 10};

    public void init(FilterConfig arg0) {}

    public void doFilter(ServletRequest req, ServletResponse resp, FilterChain chain)
            throws IOException {

        resp.setContentType("text/html; charset=UTF-8");

        PrintWriter out = resp.getWriter();

        try {
            int x = Integer.parseInt(req.getParameter("x_h").trim());
            double y = Double.parseDouble(req.getParameter("y_h"));
            double r = Double.parseDouble(req.getParameter("r_h"));

            if (validate(x, y, r))
                chain.doFilter(req, resp);
            else
                throw new Exception("validation failed");
        } catch (Exception e) {
            out.println(("<!DOCTYPE html>\n" +
                    "<html>\n" +
                    "<head>\n" +
                    "\t<title>Тупо бан</title>\n" +
                    "\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n" +
                    "\t<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\">\n" +
                    "\t<link rel=\"stylesheet\" type=\"text/css\" href=\"css/handler.css\">\n" +
                    "</head>\n" +
                    "<body style=\"text-align: center; background-color: black; background-image: none;\">" +
                    "<div style=\"margin-top: 60px;\"><span class=\"main-text\">先輩、私に優しくしてください。</span></div>" +
                    "<div class=\"centered\">" +
                    "<img src=\"./img/eyes.gif\">" +
                    "<script>" +
                    "parent.ban();" +
                    "</script>" +
                    "</div>" +
                    "</body> </html>"));
        }

    }

    private boolean validate(int x, double y, double r) {
        boolean checkX = Arrays.binarySearch(xValues, x) > -1;
        boolean checkY = y >= -5 && y <= 3;
        boolean checkR = Arrays.binarySearch(rValues, r) > -1;
        return checkX && checkY && checkR;
    }

    public void destroy() {}

}

