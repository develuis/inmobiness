import { NgClass } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { JwtHelperService } from '../../../services/jwt/jwt-helper.service';

@Component({
  standalone:true,
    selector: 'app-sidebar',
    imports: [RouterLink, NgClass],
    templateUrl: './sidebar.component.html',
    styleUrl: './sidebar.component.scss'
})
export class SidebarComponent implements OnInit{
    currentRoute:string=''
    constructor(private router: Router,private auth:JwtHelperService){}
    routesadmin:any =
    [

      { path: '/admin',           title: 'Vender', icon:'pi pi-home'},
      { path: '/admin/paquetes',  title: 'Arrendar', icon:'pi pi-home'},

    ]
    routesemployes:any=[
      { path: '/admin/mis-rutas',           title: 'Mis rutas', icon:'pi pi-car'},
      { path: '/admin/history',             title: 'Historial', icon:'pi pi-list'},
    ]
    currents:any=[]
    ngOnInit(): void {

      if(this.auth.getUserData().level == 1){
        //console.log("IS ADMIN");
        this.currents = this.routesadmin
        this.currentRoute=this.router.url
      }else if(this.auth.getUserData().level == 2){
        //console.log("IS EMPLOYE");
        this.currents = this.routesemployes
        this.currentRoute=this.router.url
      }

    }



}
