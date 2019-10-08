package Lab_2;

import javax.servlet.ServletConfig;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;

@WebServlet(name = "HitCheckServlet", urlPatterns = "/hit")
public class HitCheckServlet extends HttpServlet {

    private ServletConfig config;

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
        double x = Double.parseDouble(request.getParameter("x_h").trim());
        double y = Double.parseDouble(request.getParameter("y_h"));
        double r = Double.parseDouble(request.getParameter("r_h"));

        response.getWriter().println(checkArea(x, y, r));

        response.getWriter().close();
    }

    private boolean checkArea(double x, double y, double r){

        boolean circle = ((Math.pow(x, 2) + Math.pow(y, 2) <= (Math.pow(r / 2, 2))) && y >= 0 && x >= 0);
        boolean square = (x >= (-r) && y >= (-r) && y <= 0 && x <= 0);
        boolean triangle = (y <= (x + r) && y >= 0 && x <= 0 && x >= -r);

        return square || triangle || circle;
    }
}
