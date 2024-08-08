import { CanActivateFn } from '@angular/router';
import {Router} from "@angular/router";
import {inject} from "@angular/core";
import {LoginService} from "../login/login.service";
import Swal from "sweetalert2";

export const authGuard: CanActivateFn = (route, state) => {
  const authService = inject(LoginService);
  const router = inject(Router);
  if(authService.login('username', 'password', true)) {
    router.navigate(['/burger']).finally(() => {
      Swal.fire({
        title: 'Success',
        text: 'You are now logged in',
        icon: 'success',
        confirmButtonText: 'Ok'
      })
      return true;
    });
    return true;
  }else {
    router.navigate(['/login']).then(() => {
      Swal.fire({
        title: 'Error',
        text: 'You must be logged in to access this page',
        icon: 'error',
        confirmButtonText: 'Ok'
      }).finally(()=> {
        return false;
      })
    });
    return false;
  }
};
