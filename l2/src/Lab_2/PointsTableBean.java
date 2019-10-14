package Lab_2;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.List;

public class PointsTableBean implements Serializable {

    private int n = 1;
    private List<Point> points;

    public PointsTableBean() {
        points = new ArrayList<>();
    }

    int getN() {
        return n;
    }

    void addPoint(Point point) {
        n++;
        points.add(point);
    }

    public List getPoints() {
        return points;
    }
}
