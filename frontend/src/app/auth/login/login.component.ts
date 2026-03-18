import { Component } from '@angular/core';
import { FormBuilder, FormControlName, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { AuthService } from '../../services/guards/auth.service';
import { Router } from '@angular/router';
import { environment } from '../../../environments/environment';
import { jwtDecode } from 'jwt-decode';
import { RouterLink } from '@angular/router';

@Component({
    standalone:true,
    selector: 'app-login',
    imports: [ReactiveFormsModule,RouterLink],
    templateUrl: './login.component.html',
    styleUrl: './login.component.scss'
})
export class LoginComponent {
  loginError:boolean=false
  form:FormGroup= this.fb.group({
    email: ['', [Validators.required, Validators.email] ],
    password: ['', Validators.required ],

  });
  accessTokenDetails: any;
  constructor(private fb:FormBuilder, private as:AuthService, private router:Router){}
  ngOnInit(): void {
    localStorage.removeItem('dpm_'+environment.location)
    localStorage.removeItem('dpm_'+environment.location+"_user")
  }
  login(): void {
    //this.router.navigate(['/admin']);

    this.as.login(this.form.value.email, this.form.value.password).subscribe((res: any) => {

      localStorage.setItem('dpm_'+environment.location, res.access_token);
      localStorage.setItem('dpm_'+environment.location+"_user", JSON.stringify(res.user));
      const tokenInfo:any = this.getDecodedAccessToken(res.access_token);
      console.log("RES",res)

      if(tokenInfo.level==1){
        //this.router.navigate(['/admin']);
        //location.href="/#/admin"
        this.router.navigate(['/admin']).then(() => {
          window.location.reload(); // Fuerza la recarga
        });
      }else if(tokenInfo.level == 2){
        //this.router.navigate(['/admin/mis-rutas']);
        //location.href="/#/admin/mis-rutas"
        this.router.navigate(['/admin/mis-rutas']).then(() => {
          window.location.reload(); // Fuerza la recarga
        });
      }else{
        this.router.navigate(['/']);
        //location.href="/admin"

      }


    }, (err: any) => {
      console.log(err)
      this.loginError=true;

    });

  }
  getDecodedAccessToken(token: string): any {
    try {
      return jwtDecode(token);
    } catch(Error) {
      return null;
    }
  }
}
