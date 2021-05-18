import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http'; // Http

@Injectable({
  providedIn: 'root'
})
export class DataService {

  // GET
  baseURL = 'http://localhost:8080/SIA-Menu/api/';

  // GET STATIC DATA
  statURL = 'http://localhost:8080/SIA-Menu/api/'
  constructor(private http: HttpClient) { console.log('its working!') }

  public getData(endpoint: any) {
    return this.http.get(this.baseURL + endpoint);
  }
}
