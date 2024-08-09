import { Component } from '@angular/core';
import {BurgerService} from "./service/burger.service";
import {Burger} from "./interface/burger";
import {NgForOf, NgOptimizedImage} from "@angular/common";
import Swal from "sweetalert2";
import {Router, RouterLink} from "@angular/router";

@Component({
  selector: 'app-burger',
  standalone: true,
  imports: [
    NgForOf,
    NgOptimizedImage,
    RouterLink
  ],
  templateUrl: './burger.component.html',
  styleUrl: './burger.component.css'
})
export class BurgerComponent {

  tabBurgers: Burger[] = [];

  constructor(private burgerService: BurgerService, private router: Router) { }
  ngOnInit() {
    this.getBurgers();
  }

  /**
   * get all burgers
   */
  getBurgers() {
    this.burgerService.getBurgers().subscribe((response: Burger[]) => {
      this.tabBurgers  = response;
    });
  }


  editBurger(id: number) {
    this.burgerService.getBurgerById(id).subscribe((response: Burger) => {
      this.router.navigate(['/form-burger/'+response.id], {state: {burger: response}});
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
      Swal.fire('Failed', `${error.error.message}`, 'error').then(() => {
        if(error.error.redirect) {
          this.router.navigate(['/login']);
        }
      });
    });
  }

  order(id: number) {

  }
}
