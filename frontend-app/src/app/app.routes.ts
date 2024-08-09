import { Routes } from '@angular/router';
import { UserComponent } from './user/user.component';
import { PageNotFoundComponent } from './page-not-found/page-not-found.component';
import {BurgerComponent} from "./burger/burger.component";
import {LoginComponent} from "./authentication/login/login.component";
import {RegisterComponent} from "./authentication/register/register.component";
import {authGuard} from "./authentication/guard/auth.guard";
import {BurgerFormComponent} from "./burger/burger-form/burger-form.component";
import {UserFormComponent} from "./user/user-form/user-form.component";
import {OrderComponent} from "./order/order/order.component";
import {PaymentComponent} from "./payment/payment/payment.component";
import {HomeComponent} from "./home/home.component";

export const routes: Routes = [
  // login routes
  {path: 'login', component: LoginComponent },
  {path: 'register', component: RegisterComponent },
  // user routes
  {path: 'user', component: UserComponent, canActivate: [authGuard]},
  {path: 'user-form', component: UserFormComponent, canActivate: [authGuard]},

  // burger routes
  {path: 'burger', component: BurgerComponent},
  {path: 'form-burger/:id', component: BurgerFormComponent},
  {path: 'form-burger', component: BurgerFormComponent},
  {path: '', redirectTo: '/burger', pathMatch: 'full'},

  // order routes
  {path: 'order', component: OrderComponent},

  // payment routes
  {path: 'payment', component: PaymentComponent},

    // Default route
  // {path: '', redirectTo: '/', pathMatch: 'full'},
  {path: 'home', component: BurgerComponent},
  {path: '',component: HomeComponent},
  {path: '**', component: PageNotFoundComponent}

];
