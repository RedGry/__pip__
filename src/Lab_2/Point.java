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

    private boolean checkArea(int x, double y, double r){

        boolean circle = ((Math.pow(x, 2) + Math.pow(y, 2) <= (Math.pow(r / 2, 2))) && y >= 0 && x >= 0);
        boolean square = (x >= (-r) && y >= (-r) && y <= 0 && x <= 0);
        boolean triangle = (y <= (x + r) && y >= 0 && x <= 0 && x >= -r);

        return square || triangle || circle;
    }

    @Override
    public String toString() {
        String res = hit ? "Попадание ＼(￣▽￣)／" : "Промах (╯︵╰,)";
        return String.format("<tr> <td>%s</td>" +
                        " <td>%s</td>" +
                        " <td>%s</td>" +
                        " <td>%s</td>" +
                        " <td><b>%s</b></td>" +
                        "  <td><button onclick='parent.markPoint(%s, %s, %s)'>+</button></td></tr>",
                n, x, y, R, res, x, y, R);
    }
}
