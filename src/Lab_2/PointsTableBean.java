package Lab_2;

import javax.annotation.PostConstruct;
import javax.ejb.Stateful;
import javax.ejb.StatefulTimeout;
import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.TimeUnit;

@Stateful(mappedName = "myBean")
//@StatefulTimeout(unit = TimeUnit.SECONDS, value = 20)
public class PointsTableBean implements PointsTable {

    private int n = 1;
    private List<Point> points;

    public PointsTableBean() {
        points = new ArrayList<>();
    }

    @Override
    public int getN() {
        return n;
    }

    @Override
    public void addPoint(Point point) {
        n++;
        points.add(point);
    }

    @Override
    public List getPoints() {
        return points;
    }
}
