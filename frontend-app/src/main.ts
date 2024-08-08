import { bootstrapApplication } from '@angular/platform-browser';
import { appConfig } from './app/app.config';
import { AppComponent } from './app/app.component';

// Import Bootstrap JavaScript
import 'bootstrap/dist/js/bootstrap.min.js';


bootstrapApplication(AppComponent, appConfig)
  .catch((err) => console.error(err));
