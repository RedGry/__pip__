package Lab_2;

import javax.ejb.Remote;
import java.util.List;

@Remote
public interface PointsTable {
    void addPoint(Point point);
    List getPoints();
    int getN();
}
