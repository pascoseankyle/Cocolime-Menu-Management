import { Component, OnInit } from '@angular/core';
import { DataService } from '../../services/data.service'; // Services

@Component({
  selector: 'app-cardpanel',
  templateUrl: './cardpanel.component.html',
  styleUrls: ['./cardpanel.component.css']
})
export class CardpanelComponent implements OnInit {
  // Variables ----------------
  posts: any; // ----- this is the result ----------
  post: any; // ------ this will be the payload from the result ---------
  openEditModal: boolean = false; // ----------- this is Edit Modal ----------
  openViewModal: boolean = false;
  openIngredientModal: boolean = false;
  deleteModal: boolean = false;

  constructor(private data: DataService) {}

  ngOnInit(): void {
    this.getFood(); // ----- RUNS FUNCTIONS --------
  }
  // GET ----------------------

  // GET INGREDIENTS --------------
  getFood(): void{
    this.data.getData('products').subscribe((res)=>{
      this.posts = res;
      this.post = this.posts.payload;
      console.log(this.post);
    });
  }
  openDelete(){
    this.deleteModal = true;
  }
  closeDelete(){
    this.deleteModal = false;
  }
   // Edit Product Modal --------------
  editIngModal(){
    this.openEditModal = false;
    this.openIngredientModal = true;
  }
  closeIngModal(){
    this.openIngredientModal = false;
    this.openEditModal = true;
  }
  // Edit Product Modal --------------
  editModal(){
    this.openEditModal = true;
  }
  closeEditModal(){
    this.openEditModal = false;
  }
  // View Product Modal --------------
  viewModal(){
    this.openViewModal = true;
  }
  closeViewModal(){
    this.openViewModal = false;
  }
}
