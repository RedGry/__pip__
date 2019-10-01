package Lab_2;

import javax.annotation.PostConstruct;
import javax.ejb.Stateful;
import javax.ejb.StatefulTimeout;
import java.io.Serializable;
import java.util.ArrayList;
import java.util.List;
import javax.faces.bean.ApplicationScoped;
import javax.faces.bean.ManagedBean;
import javax.faces.bean.SessionScoped;
import java.util.concurrent.TimeUnit;

@ManagedBean(name = "myBean", eager = true)
@SessionScoped
public class PointsTableBean implements Serializable {

    private int n = 1;
    private List<Point> points;

    public PointsTableBean() {
        init();
    }

    public void check() {}

    @PostConstruct
    public void init() {
        points = new ArrayList<>();
    }

    public int getN() {
        return n;
    }

    public void addPoint(Point point) {
        n++;
        points.add(point);
    }

    public List getPoints() {
        return points;
    }
}
