import { Component } from '@angular/core';
import {NgIf} from "@angular/common";
import {FormBuilder, FormGroup, ReactiveFormsModule, Validators} from "@angular/forms";
import {RouterLink} from "@angular/router";
import {RegisterService} from "./register.service";

@Component({
  selector: 'app-register',
  standalone: true,
    imports: [
        NgIf,
        ReactiveFormsModule,
        RouterLink
    ],
  templateUrl: './register.component.html',
  styleUrl: './register.component.css'
})
export class RegisterComponent {
  submitted: boolean = false;

  constructor(private formBuilder: FormBuilder, private  registerService: RegisterService) { }

  /**
   * init form
   */
  registerForm = this.formBuilder.group({
    email: ['', [Validators.required, Validators.email]],
    password: ['', [Validators.required, Validators.minLength(6)]],
    confirmPassword: ['', [Validators.required, Validators.minLength(6)]],
    name: ['', [Validators.required]],
    telephone: ['', [Validators.required, Validators.pattern('^[0-9]*$')]]
  });


  /**
   * submit form register
   */
  onSubmit()
  {
    this.submitted = true;
  }

  get f(){
    return this.registerForm.controls;
  }
}
