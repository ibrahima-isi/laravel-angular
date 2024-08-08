import { Component } from '@angular/core';
import {FormBuilder, ReactiveFormsModule, Validators} from "@angular/forms";
import {NgIf} from "@angular/common";
import Swal from "sweetalert2";
import {LoginService} from "./login.service";
// import { ToastModule } from 'primeng/toast';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [
    ReactiveFormsModule,
    NgIf
  ],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent {
  private response: any;
  constructor(private formBuilder: FormBuilder,private loginService: LoginService) {}

  loginForm = this.formBuilder.group({
    email: ['', [Validators.required, Validators.email]],
    password: ['', [Validators.required, Validators.minLength(4)]]
  },
    {
      validators: Validators.required, updateOn: 'blur'
    });

  submitted = false;
  private email = this.loginForm.value.email;
  private password = this.loginForm.value.password;

  onSubmit(): void {
    this.submitted = true;
    if(this.loginForm.valid){
      console.log("saisi: ",  this.loginForm.value);
      this.response = this.loginService.login(this.email, this.password, true).subscribe((response) => {
        console.log('REPONSE 1: ', response);
        console.log('REPONSE 2: ', this.response);
        Swal.fire({
          title: 'Success!',
          text: 'Your order has been submitted',
          icon: 'success',
          confirmButtonText: 'Cool'
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
