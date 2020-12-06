import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { RegisterComponent } from './register.component';
import { RegisterAddComponent } from './add/add-person.component';
// import { RegisterEditComponent } from './edit/edit-person.component';
// import { RegisterRemoveComponent } from './remove/remove-person.component';
// import { ButtonsComponent } from './buttons/buttons.component';

const routes: Routes = [
  {
    path: '',
    component: RegisterComponent,
    children: [
      {
        path: 'add',
        component: RegisterAddComponent,
      }
    //   {
    //     path: 'edit',
    //     component: RegisterEditComponent,
    //   },
    //   {
    //     path: 'remove',
    //     component: RegisterRemoveComponent,
    //   }
    ],
  },
];

@NgModule({
  imports: [
    RouterModule.forChild(routes),
  ],
  exports: [
    RouterModule,
  ],
})
export class RegisterRoutingModule {
}

