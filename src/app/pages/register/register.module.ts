import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http'

import {
  NbActionsModule,
  NbButtonModule,
  NbCardModule,
  NbCheckboxModule,
  NbDatepickerModule, NbIconModule,
  NbInputModule,
  NbRadioModule,
  NbSelectModule,
  NbUserModule,
  NbSpinnerModule,
} from '@nebular/theme';

import { ThemeModule } from '../../@theme/theme.module';
import { RegisterRoutingModule } from './register-routing.module';
import { RegisterComponent } from './register.component';
import { RegisterAddComponent } from './add/add-person.component';
// import { FormLayoutsComponent } from './form-layouts/form-layouts.component';
// import { DatepickerComponent } from './datepicker/datepicker.component';
// import { ButtonsComponent } from './buttons/buttons.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

@NgModule({
  imports: [
    NbSpinnerModule,
    ThemeModule,
    NbInputModule,
    NbCardModule,
    NbButtonModule,
    NbActionsModule,
    NbUserModule,
    NbCheckboxModule,
    NbRadioModule,
    NbDatepickerModule,
    RegisterRoutingModule,
    NbSelectModule,
    NbIconModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule
  ],
  declarations: [
    RegisterComponent,
    RegisterAddComponent,
    // FormInputsComponent,
    // FormLayoutsComponent,
    // DatepickerComponent,
  ],
})
export class RegisterModule { }
