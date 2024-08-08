import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {environment} from "../../../environments/environment";
import {Burger} from "../interface/burger";

@Injectable({
  providedIn: 'root'
})
export class BurgerService {

  constructor( private httpClient: HttpClient) { }
  private apiUrl = 'http://localhost:8000/api';

  /**
   * get all burgers from the server
   */
  getBurgers() {
    return this.httpClient.get<Burger[]>(`${this.apiUrl}/burgers`);
  }

  /**
   * get a burger by id
   */
  getBurgerById(id: number) {
    return this.httpClient.get<Burger>(`${this.apiUrl}/burgers/${id}`);
  }

  /**
   * add a burger
   */
  addBurger(burger: Burger) {
    return this.httpClient.post(`${this.apiUrl}/burgers`, burger);
  }

  /**
   * update a burger
   */
  updateBurger(burger: Burger) {
    return this.httpClient.put(`${this.apiUrl}/burgers/${burger.id}`, burger);
  }

  /**
   * delete a burger
   */
  deleteBurger(id: number) {
    return this.httpClient.delete(`${this.apiUrl}/burgers/${id}`);
  }
}
