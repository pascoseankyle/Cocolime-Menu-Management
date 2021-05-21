import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {
  // Add Modal Var -------------
  ingredientString: any;
  inputProduct: any;
  arraySample: string[] = [];
  // Modals Var ------------------
  openAddModal: boolean = false;
  openAddModalIng: boolean = false;

  constructor() { }
  
  ngOnInit(): void {
  }
  // Add Product Modal ---------------
  openModal(){
    this.openAddModal = true;
  }
  closeModal(){
    this.openAddModal = false;
    this.arraySample=[];
    this.inputProduct="";
    this.ingredientString="";
  }
  // Ingredient Modal ------------------
  openModalIng(){
    this.openAddModal = false;
    this.openAddModalIng = true;
  }
  backToAdd(){
    this.openAddModal = true;
    this.openAddModalIng = false;
  }
  finishAdd(){
    this.openAddModalIng = false;
    this.arraySample=[];
    this.inputProduct="";
    this.ingredientString="";
    alert("New Menu Added!");
  }
 addIng(){
   this.arraySample.push(this.ingredientString);
 }
 removeIng(i: number){
   this.arraySample.splice(i, 1);
 }
}
