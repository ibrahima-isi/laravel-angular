import { Component } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {BurgerService} from "./service/burger.service";
import {Burger} from "./interface/burger";
import {NgForOf, NgOptimizedImage} from "@angular/common";
import Swal from "sweetalert2";
import {Router} from "@angular/router";
import {FormBuilder, Validators} from "@angular/forms";

@Component({
  selector: 'app-burger',
  standalone: true,
  imports: [
    NgForOf,
    NgOptimizedImage
  ],
  templateUrl: './burger.component.html',
  styleUrl: './burger.component.css'
})
export class BurgerComponent {

  constructor(private  http: HttpClient, private burgerService: BurgerService, private router: Router, private formBuilder: FormBuilder) { }

  /**
   * the form builder for the burger form
   */
  burgerForm = this.formBuilder.group({
    name: ['', [Validators.required]],
    price: ['', [Validators.required]],
    description: ['', [Validators.required, Validators.maxLength(80)]],
    quantity: ['', [Validators.required, Validators.min(1)]],
    image: ['']
  }, {updateOn: 'blur'});


  ngOnInit() {
    this.getBurgers();
  }

  /**
   * get all burgers
   */
  tabBurgers: Burger[] = [];
  getBurgers() {
    this.burgerService.getBurgers().subscribe((response: Burger[]) => {
      this.tabBurgers  = response;
    });
  }


  editBurger(id: number) {
    this.burgerService.getBurgerById(id).subscribe((response: Burger) => {
      this.router.navigate(['/form-burger/'+response.id, response]);
    }, (error) => {
      console.log(error.error);
    });
  }

  /**
   * update a burger
   * @param burger burger to update
   */
  updateBurger(burger: Burger) {
    this.burgerService.updateBurger(burger).subscribe((response) => {
      console.log(response)
    }, (error) => {
      console.log(error.error);
    });
  }

  deleteBurger(id: number) {
    this.burgerService.deleteBurger(id).subscribe((response) => {
      Swal.fire('Success', 'Burger deleted successfully', 'success');
      this.getBurgers();
    }, (error) => {
      console.log(error.error);
      Swal.fire('Failed', `${error.error.message}`, 'error');
    });
  }

  order(id: number) {

  }
}
