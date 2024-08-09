import { Component } from '@angular/core';
import {Route, Router} from "@angular/router";
import {FormBuilder, ReactiveFormsModule, Validators} from "@angular/forms";
import Swal from "sweetalert2";
import {NgIf} from "@angular/common";
import {Burger} from "../interface/burger";
import {BurgerService} from "../service/burger.service";


@Component({
  selector: 'app-burger-form',
  standalone: true,
  imports: [
    ReactiveFormsModule,
    NgIf
  ],
  templateUrl: './burger-form.component.html',
  styleUrl: './burger-form.component.css'
})
export class BurgerFormComponent {

    constructor(private  router: Router, private formBuilder: FormBuilder, private burgerService: BurgerService) { }

    ngOnInit() {
      console.log("Burger form: ",this.burger);
      if (this.burger) {
        // Mise à jour des valeurs du formulaire si un burger est présent
        this.burgerForm.patchValue({
          name: this.burger.name,
          price: this.burger.price,
          description: this.burger.description,
          quantity: this.burger.quantity,
        });
      }
    }
    burger = this.router.getCurrentNavigation()?.extras.state?.['burger'];
    submitted: boolean = false;
    id = this.burger?.id;
    title: "Formulaire d'ajout d'un burger" | undefined;

  /**
   * the form builder for the burger form
   */
  burgerForm = this.formBuilder.group({
    name: ['', [Validators.required]],
    price: ['', [Validators.required]],
    description: ['', [Validators.required]],
    quantity: ['', [Validators.required, Validators.min(1)]],
    image: ['']
  }, {updateOn: 'blur'});

  onSubmit() {
    this.submitted = true

    if(this.burgerForm.valid){
      if(this.id){
        this.burger = this.burgerForm.value;
        this.burger.id = this.id;
        console.log("burger value: ", this.burger);
        this.updateBurger(this.burger)
      }else {
        this.burger = this.burgerForm.value;
        console.log("burger value: ", this.burger);
        this.addBurger(this.burger);
      }
    }
    else {
      console.log("form invalid");
      this.displayFormErrors()
    }
  }

  /**
   * update a burger
   * @param burger burger to update
   */
  updateBurger(burger: Burger) {
    this.burgerService.updateBurger(burger).subscribe((response) => {
      Swal.fire({
        title : 'Success',
        text: 'Burger updated successfully',
        icon : 'success',
        position: "top-end",
        showConfirmButton: false,
        timer: 1000
      }).then(() => {
        this.router.navigate(['/burger']);
      });
    }, (error) => {
      console.log(error.error);
      Swal.fire({
        title: 'Error!',
        text: error.error.message,
        icon: 'error',
        confirmButtonText: 'Ok'
      })
    });
  }

  /**
   * add a burger
   */
  addBurger(burger: Burger) {
    this.burgerService.addBurger(this.burger).subscribe((response) => {
      Swal.fire({
        title : 'Success',
        text: 'Burger added successfully',
        icon : 'success',
        position: "top-end",
        showConfirmButton: false,
        timer: 1000
      }).then(() => {
        this.router.navigate(['/burger']);
      });
    }, (error) => {
      console.log(error.error);
      Swal.fire({
        title: 'Error!',
        text: error.error.message,
        icon: 'error',
        confirmButtonText: 'Ok',
        position: "center"
      }).then(() => {
        this.router.navigate(['/login']);
      })
    });
  }

  f(){
    return this.burgerForm.controls
  }

  displayFormErrors() {
    Object.keys(this.burgerForm.controls).forEach(key => {
      const controlErrors = this.burgerForm.get(key)?.errors;
      if (controlErrors) {
        Object.keys(controlErrors).forEach(errorKey => {
          console.log(`Error in ${key}: ${errorKey} - ${controlErrors[errorKey]}`);
        });
      }
    });
  }
}
