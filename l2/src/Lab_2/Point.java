package Lab_2;

import java.io.Serializable;

public class Point implements Serializable {
    private int x;
    private double y;
    private double R;
    private boolean hit;
    private int n;

    Point (int x, double y, double r, int n){
        this.x = x;
        this.y = y;
        this.R = r;
        this.n = n;
        hit = checkArea(x, y, R);
    }

    public int getX() {
        return x;
    }

    public double getY() {
        return y;
    }

    public double getR() {
        return R;
    }

    public boolean isHit() {
        return hit;
    }

    public int getN() {
        return n;
    }

    static boolean checkArea(double x, double y, double r){

        boolean circle = ((Math.pow(x, 2) + Math.pow(y, 2) <= (Math.pow(r / 2, 2))) && y >= 0 && x >= 0);
        boolean square = (x >= (-r) && y >= (-r) && y <= 0 && x <= 0);
        boolean triangle = (y <= (x + r) && y >= 0 && x <= 0 && x >= -r);

        return square || triangle || circle;
    }
}
