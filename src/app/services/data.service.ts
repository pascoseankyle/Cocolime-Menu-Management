import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http'; // HTTP

@Injectable({
  providedIn: 'root'
})
export class DataService {

  // URL ----------------------------------------

  baseURL = 'http://localhost:8080/SIA-Menu/api/';

  // USE HTTP CLIENT ----------------------------

  constructor(private http: HttpClient) { console.log('its working!') }

  // GET DATA FROM API --------------------------

  public getData(endpoint: any) {

    return this.http.get(this.baseURL + endpoint);
  }
}
