import { Routes, RouterModule } from '@angular/router';
import {LoginComponent} from "./components/login/login.component";
import {RegisterComponent} from "./components/register/register.component";
import {ProfileComponent} from "./components/profile/profile.component";
import {UrlPermission} from "./urlPermission/url.permission";
import {HistoryComponent} from "./components/history/history.component";
import {CheckPointComponent} from "./components/check-point/check-point.component";


const appRoutes: Routes = [
  { path: 'profile', component: ProfileComponent, canActivate: [UrlPermission] },
  { path: 'check-point', component: ProfileComponent, canActivate: [UrlPermission] },
  { path: 'history', component: ProfileComponent, canActivate: [UrlPermission] },
  { path: 'login', component: LoginComponent, canActivate: [UrlPermission] },
  { path: 'register', component: RegisterComponent, canActivate: [UrlPermission] },

  // otherwise redirect to profile
  { path: '**', redirectTo: '/profile' }
];

export const routing = RouterModule.forRoot(appRoutes);
