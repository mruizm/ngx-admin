import { Component, OnInit, Input, OnChanges, ChangeDetectorRef} from '@angular/core';
import { FormGroup, FormControl } from '@angular/forms';
import { HttpClient } from '@angular/common/http'
import { GenNextId } from '../getNextId.model';
import { ChangeDetectionStrategy } from '@angular/core';

@Component({
  selector: 'ngx-add-person',
  changeDetection: ChangeDetectionStrategy.OnPush,
  styleUrls: ['./add-person.component.scss'],
  templateUrl: './add-person.component.html',
})
export class RegisterAddComponent implements OnInit{

  radioGroupValue = '';
  form_student_div = false;
  registry_id_div = false;
  form_type:string;
  register_type:string;
  registry_db_id:string;
  registry_letter:string
  registry_record_id:string
  registry_id_loaded = false;
  

  constructor(private http: HttpClient, private cd: ChangeDetectorRef){}
  
  ngOnInit(){}

  studentProfileFormData = new FormGroup({
    studentFirstName: new FormControl(''),
    studentFirstLastName: new FormControl(''),
    studentSecondLastName: new FormControl(''),
    studentBirthDay: new FormControl(''),
    studentGrade: new FormControl(''),
    studentVaccines: new FormControl(''),
    studentVaccinesCard: new FormControl(''),
    studentMedicalConditions: new FormControl(''),
    emergencyContactFirstName: new FormControl(''),
    emergencyContactFirstLastName: new FormControl(''),
    emergencyContactSecondLastName: new FormControl(''),
    emergencyContactPhoneNumber1: new FormControl(''),
    emergencyContactPhoneNumber2: new FormControl(''),
    emergencyContactStudentRelationship: new FormControl(''),
    emergencyContactHomeAddress: new FormControl(''),
    parent1FirstName: new FormControl(''),
    parent1FirstLastName: new FormControl(''),
    parent1SecondLastName: new FormControl(''),
    parent1PhoneNumber: new FormControl(''),
    parent1JobTitle: new FormControl(''),
    parent1Email: new FormControl(''),
    parent1HomeAddress: new FormControl(''),
    parent2FirstName: new FormControl(''),
    parent2FirstLastName: new FormControl(''),
    parent2SecondLastName: new FormControl(''),
    parent2PhoneNumber: new FormControl(''),
    parent2JobTitle: new FormControl(''),
    parent2Email: new FormControl(''),
    parent2HomeAddress: new FormControl('')
  });

  getFormType(form_type) {
    this.form_type = form_type;
    console.log("form_value:"+this.form_type)
    if(this.form_type == 'student_form'){
      this.register_type = 'student';
    }
    if(this.form_type == 'teacher_form'){
      this.register_type = 'teacher';
    }
    if(this.form_type == 'admin_form'){
      this.register_type = 'admin';
    }
    let form_data = { 'register_action': 'add',
                      'register_type': this.register_type }
    console.log(form_data)
    this.http.post<{ 
      status_code: string; 
      response: {
        record_type: string;
        record_action: string;
        record_id: string;
        transaction_id: string
      } }>('http://localhost:4200/next-persona-id', form_data, {headers: 
      {'Content-Type': 'application/json', 'Access-Control-Allow-Origin': '*' } })
        .subscribe(responseData =>{
          if(this.form_type == 'student_form'){
            this.registry_letter = 'E';
            this.form_student_div = true;            
          }
          if(this.form_type == 'teacher_form'){
            this.registry_letter = 'P';
            this.form_student_div = false;
          }
          if(this.form_type == 'admin_form'){
            this.registry_letter = 'A';
            this.form_student_div = false;
          }
          this.registry_db_id = responseData['response']['record_id'];
          this.registry_record_id = 'AM-'+this.registry_letter+'-'+this.registry_db_id;
          this.registry_id_loaded = true;
          console.log('registry_record_id:'+this.registry_record_id);
          console.log('registry_id_loaded:'+this.registry_id_loaded);
          this.registry_id_div = true;
          
          //to update UI when props change values
          this.cd.detectChanges();
      })
  }
  onSubmit() {
    // TODO: Use EventEmitter with form value
    // console.warn(this.profileFormData.value);
    let add_in_db = { 'user_id' : 'mruizm@activeminds.cr',
                      'role_type' : this.form_type,
                      'db_action' : 'add',
                      'in_data_glob' : this.studentProfileFormData.value
    };
    // console.log(this.studentProfileFormData.value)
    console.log(add_in_db);
  }
}
