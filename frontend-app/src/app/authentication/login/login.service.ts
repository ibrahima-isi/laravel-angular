import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class LoginService {

  constructor(private http: HttpClient ) { }

  private apiUrl = "http://localhost:8000/api";

  login(email: any, password: any, remember: boolean) {
    return this.http.post(this.apiUrl+'/login', {"email" : email, "password": password, "remember": remember});
  }

  logout() {
    return this.http.post(this.apiUrl+"/logout", {});
  }
}
