import { Component, OnInit } from '@angular/core';
import { DataService } from '../services/data.service'; // Service

@Component({
  selector: 'app-index',
  templateUrl: './index.component.html',
  styleUrls: ['./index.component.css']
})
export class IndexComponent implements OnInit {
   // Variables
   ing: any;
   ings: any;
  constructor(private data: DataService) { }

  ngOnInit(): void {
    this.getIngredients();
  }
  // GET Products
  getIngredients(): void{
    this.data.getData('ingredients').subscribe((res)=>{
      this.ings = res;
      this.ing = this.ings.payload;
      console.log(this.ing);
    });
  }
}
