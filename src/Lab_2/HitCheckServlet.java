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

    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws IOException {

        double x = Double.parseDouble(request.getParameter("x_h").trim());
        double y = Double.parseDouble(request.getParameter("y_h"));
        double r = Double.parseDouble(request.getParameter("r_h"));

        response.getWriter().println(Point.checkArea(x, y, r));

        response.getWriter().close();
    }

}
