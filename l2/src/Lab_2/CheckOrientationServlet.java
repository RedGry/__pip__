package Lab_2;

import javax.servlet.ServletConfig;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.io.PrintWriter;

public class CheckOrientationServlet extends HttpServlet {

    private int hash = -719496019;

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

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws IOException {
        String name = request.getParameter("gname");

        PrintWriter writer = response.getWriter();

        if (name != null && name.hashCode() == hash)
            writer.println("Good, you rEallY like anime");
        else
            writer.println("Wrong");

        writer.close();
    }
}
