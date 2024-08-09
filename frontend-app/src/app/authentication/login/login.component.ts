import { Component } from '@angular/core';
import {FormBuilder, ReactiveFormsModule, Validators} from "@angular/forms";
import {NgIf} from "@angular/common";
import Swal from "sweetalert2";
import {LoginService} from "./login.service";
import {Login} from "./login";
import {Router, RouterLink} from "@angular/router";
// import { ToastModule } from 'primeng/toast';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [
    ReactiveFormsModule,
    NgIf,
    RouterLink
  ],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent {
  private response: any;
  constructor(private formBuilder: FormBuilder,private loginService: LoginService, private router: Router) {}

  loginForm = this.formBuilder.group({
    email: ['', [Validators.required, Validators.email]],
    password: ['', [Validators.required, Validators.minLength(4)]]
  },
    {
      validators: Validators.required, updateOn: 'blur'
    });

  submitted = false;
  private user: any;
  onSubmit(): void {
    this.submitted = true;
    if(this.loginForm.valid){
      console.log("saisi: ",  this.loginForm.value);
      this.user = this.loginForm.value

      this.response = this.loginService.login(this.user).subscribe((response: Login) => {
        console.log('REPONSE 1: ', response);
        Swal.fire({
          title: 'Success!',
          text: response.message,
          icon: 'success',
          timer: 1500,

        }).then(() => {
          this.router.navigate(['/burger'], {state: {user: response.user}});
        });
      }, (error) => {
        console.log('ERREUR: ', error);
      });
    } else {
      console.log(this.loginForm.errors);
      Swal.fire({
        title: 'Error!',
        text: 'Please fill in the form correctly',
        icon: 'error',
        confirmButtonText: 'Ok'
      });
    }

  }

  get f(){
    return this.loginForm.controls;
  }

}
