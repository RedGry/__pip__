package Lab_2;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.PrintWriter;
import java.io.IOException;


public class ControllerServlet extends HttpServlet {

    protected void doPost(HttpServletRequest request, HttpServletResponse response)
     throws ServletException, IOException {
		request.getServletContext().getRequestDispatcher("index.jsp").forward(request, response);
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response)
      throws ServletException, IOException {
		String xString=request.getParameter("x_h");
		String yString=request.getParameter("y_h");
		String RString=request.getParameter("r_h");
		if(xString == null || yString == null || RString == null){
			request.getServletContext().getRequestDispatcher("/index.jsp").forward(request, response);
		} else {
			request.getServletContext().getRequestDispatcher("/check").forward(request, response);
		}
    }

}
