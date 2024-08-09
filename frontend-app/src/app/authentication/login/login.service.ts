import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {Login} from "./login";

@Injectable({
  providedIn: 'root'
})
export class LoginService {

  constructor(private http: HttpClient ) { }

  private apiUrl = "http://localhost:8000/api";

  login(user: any): Observable<Login> {
    return this.http.post<Login>(this.apiUrl+'/login', user);
  }

  logout() {
    return this.http.post(this.apiUrl+"/logout", {});
  }
}
