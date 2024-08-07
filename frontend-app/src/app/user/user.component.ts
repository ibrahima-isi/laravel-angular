import { Component } from '@angular/core';
import {FormBuilder, Validators, ReactiveFormsModule} from '@angular/forms'
import { HttpClient } from '@angular/common/http'
@Component({
  selector: 'app-user',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './user.component.html',
  styleUrl: './user.component.css'
})
export class UserComponent {
  constructor(private formBuilder: FormBuilder, private http: HttpClient) { }

  userForm = this.formBuilder.group({
    name: '',
    email: '',
    phone: ''
  }, { validators: Validators.required, updateOn: 'blur' });

  control = this.formBuilder.control(
    {value: 'my val', disabled: true}
  );

}
