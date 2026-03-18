import { Component, OnInit } from '@angular/core';

import { ButtonModule } from 'primeng/button';
import { TableModule } from 'primeng/table';
import { RouterLink } from '@angular/router';
import { CurrencyPipe, DatePipe } from '@angular/common';

import { ToastModule } from 'primeng/toast';
import { ConfirmDialogModule } from 'primeng/confirmdialog';
import { PreloaderComponent } from '../../../shared/preloader/preloader.component';
import { RoutesService } from '../../services/routes/routes.service';
import { MessagesService } from '../../../services/messages/messages.service';
@Component({
    standalone:true,
    selector: 'app-employe-home',
    imports: [PreloaderComponent,ButtonModule,TableModule,RouterLink,DatePipe,ToastModule,ConfirmDialogModule],
    templateUrl: './employe-home.component.html',
    styleUrl: './employe-home.component.scss'
})
export class EmployeHomeComponent {
        constructor(private rs:RoutesService,private ms:MessagesService) { }
        data:any = []
        loaded:boolean = false
    
    
        ngOnInit(): void {
            this.refresh()
            // this.rs.import().subscribe((res:any)=>{
            //     console.log(res)
            // })
        }
        refresh(){
            this.rs.get().subscribe((res:any)=>{
                console.log(res)
                this.data = res.data
                this.loaded = true
            })
        }
        confirmDelete(id:number) {
            this.ms.showConfirmation("¿Está seguro de querer eliminar el registro?").then((confirm:any) => {
              if (confirm) {
                this.loaded=false
                this.rs.removeRoute(id).subscribe((res:any)=>{
                  console.log(res)
                  this.ms.showSuccess("Registro eliminado correctamente")
                  this.refresh()
                },(err:any)=>{
                    console.log(err)
                  this.loaded=true
                  this.ms.showError("No se pudo eliminar el registro")
                })
               
              } 
            })
          }
}
