import { Component, OnInit } from '@angular/core';
import { DataService } from '../../services/data.service'; // Services

@Component({
  selector: 'app-cardpanel',
  templateUrl: './cardpanel.component.html',
  styleUrls: ['./cardpanel.component.css']
})
export class CardpanelComponent implements OnInit {
  // Variables ----------------
  stat: any;
  search: any;
  available: boolean = false;
  notAvailable: boolean = true;
  // Menu / Food /Productss
  food: any; 
  foodArray: any={};
  // Ingredients
  ingredients: any;
  ingredientsArray: any={};
  ingredientsInput: any={};
  // Modal Variables
  openEditModal: boolean = false;
  openViewModal: boolean = false;
  openIngredientModal: boolean = false;
  addIngredientModal: boolean = false;
  deleteModal: boolean = false;

  constructor(private data: DataService) {}

  ngOnInit(): void {
    this.getFood();
    this.upAvailable();
    this.intervalFunction();
  }

// --------------- MODALS ------------------------------

// Edit Ingredient Modal 
editIngModal(ingIndex: any){
  this.openEditModal = false;
  this.openIngredientModal = true;
  this.ingredientsArray = ingIndex;
}
// Delete Ingredient
deleteIng(ingredients: any): void{
  this.data.getData("delete_ing", ingredients).subscribe((results: any) => {})
  this.getIngredients(ingredients.prod_id);
}
// Add Ingredient Modal
addIngModal(ingredient: any): void{
  this.addIngredientModal = true;
}
addIng(event: any,ingredient: any): void{
  this.ingredientsInput.name=event.target.ingredientAdd.value;
  this.ingredientsInput.qty=event.target.ingredientQty.value;
  this.ingredientsInput.id=ingredient.product_id;
  this.data.getData("add_ing_prod", this.ingredientsInput).subscribe((results: any) => {
    this.getIngredients(this.ingredientsInput.id);
  })
}
// Close Add Ingredient Modal
closeAddIng(): void{
  this.addIngredientModal = false;
}
// Close Edit Ingredient Modal
closeIngModal(){
  this.openIngredientModal = false;
  this.openEditModal = true;
}
// Edit Product Modal 
editModal(editFood: any){
  this.openEditModal = true;
  this.foodArray.product_id = editFood.product_id;
  this.foodArray.product_name = editFood.product_name;
  this.foodArray.product_price = editFood.product_price;
  this.foodArray.product_type = editFood.product_type;
  this.getIngredients(this.foodArray.product_id);
}
// Close Edit Product Modal
closeEditModal(){
  this.openEditModal = false;
}
// View Product Modal 
viewModal(editFood: any){ 
  this.openViewModal = true;
  this.foodArray.product_id = editFood.product_id;
  this.foodArray.product_name = editFood.product_name;
  this.getIngredients(this.foodArray.product_id);
}
// Close View Product Modal
closeViewModal(){
  this.openViewModal = false;
}
// Delete Product Modal 
openDelete(food: any){
  this.deleteModal = true;
  this.getFood();
  this.foodArray.product_id = food.product_id;
  this.foodArray.product_name = food.product_name;
}
// Close Delete Modal
closeDelete(){
  this.deleteModal = false;
}
// ------------------ FUNCTIONS ------------------------
// Get all Products 
getFood() {
  this.data.getData("all_menu", this.search).subscribe((results: any) => {
    this.food = results.data;
  })
}
// Get all Ingredients of the product
getIngredients(ingId: number){
  this.ingredientsArray.product_id = ingId;
  this.data.getData("ingredients", this.ingredientsArray).subscribe((results: any) => {
    this.ingredients = results.data;
  })
}
// Delete Product
deleteFood(foodId: any): void{
  this.foodArray.product_id = foodId;
  this.data.getData("delete_menu", this.foodArray).subscribe((results: any) => {
  this.getFood();
  this.closeDelete();
  })
}
// Update Product
updateProduct(): void {
  this.data.getData("update_menu", this.foodArray).subscribe((results: any) => {})
  this.openEditModal = true;
  window.location.reload();
}
// Update Ingredient
updateIng(): void {
  this.openIngredientModal = false;
  this.openEditModal = true;
  this.data.getData("update_ing", this.ingredientsArray).subscribe((results: any) => {})
}  
// Updata Avaialble
upAvailable(): void {
  this.data.getData("available", this.ingredientsArray).subscribe((results: any) => {})
}

intervalFunction(): void{
    setInterval(() => { this.upAvailable() }, 5000);
    setInterval(() => { this.getFood() }, 5000);
}


}
