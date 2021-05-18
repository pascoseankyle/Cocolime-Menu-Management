import { Component, OnInit } from '@angular/core';
import { DataService } from '../../services/data.service'; // Services

@Component({
  selector: 'app-cardpanel',
  templateUrl: './cardpanel.component.html',
  styleUrls: ['./cardpanel.component.css']
})
export class CardpanelComponent implements OnInit {
  openHome: boolean = true;
  posts: any;
  post: any;
  constructor(private data: DataService) { }

  ngOnInit(): void {
    this.getPosts();
  }
  // GET Products
  getPosts(): void{
    this.data.getData('products').subscribe((res)=>{
      this.posts = res;
      this.post = this.posts.payload;
      console.log(this.post);
    });
  }
}
