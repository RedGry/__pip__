import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { Point } from "../../model/model.point";
import { PointsService } from "../../services/points.service";

@Component({
  selector: 'app-history',
  templateUrl: './history.component.html',
  styleUrls: ['./history.component.css'],
  encapsulation: ViewEncapsulation.None
})
export class HistoryComponent implements OnInit {
  public points: Point[];

  constructor(private service: PointsService) { }

  ngOnInit() {
    this.service.getPoints().subscribe(data => this.points = data as Point[]);
  }

}
