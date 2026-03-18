import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import { DropdownModule } from 'primeng/dropdown';
import { RadioButtonModule } from 'primeng/radiobutton';
import { ButtonModule } from 'primeng/button';
import { ReactiveFormsModule } from '@angular/forms';
import { RouterModule,ActivatedRoute } from '@angular/router'
import { CommonModule } from '@angular/common';
import { Location } from '@angular/common';

interface Estado {
  nombre: string;
  codigo: string;
}

interface Municipio {
  nombre: string;
  codigo: string;
  estado: string;
}

interface Colonia {
  nombre: string;
  codigo: string;
  municipio: string;
}

@Component({
  selector: 'app-formubicacion',
  standalone: true,
  imports: [DropdownModule,RadioButtonModule,ButtonModule,ReactiveFormsModule,RouterModule,CommonModule],
  templateUrl: './formubicacion.component.html',
  styleUrls: ['./formubicacion.component.css']
})
export class FormubicacionComponent implements OnInit {
  searchForm!: FormGroup;

  estados: Estado[] = [
    { nombre: 'Aguascalientes', codigo: 'AGS' },
    { nombre: 'Baja California', codigo: 'BC' },
    { nombre: 'Baja California Sur', codigo: 'BCS' },
    { nombre: 'Campeche', codigo: 'CAM' },
    { nombre: 'Chiapas', codigo: 'CHIS' },
    { nombre: 'Chihuahua', codigo: 'CHIH' },
    { nombre: 'Ciudad de México', codigo: 'CDMX' },
    { nombre: 'Coahuila', codigo: 'COAH' },
    { nombre: 'Colima', codigo: 'COL' },
    { nombre: 'Durango', codigo: 'DGO' },
    { nombre: 'Guanajuato', codigo: 'GTO' },
    { nombre: 'Guerrero', codigo: 'GRO' },
    { nombre: 'Hidalgo', codigo: 'HGO' },
    { nombre: 'Jalisco', codigo: 'JAL' },
    { nombre: 'México', codigo: 'MEX' },
    { nombre: 'Michoacán', codigo: 'MICH' },
    { nombre: 'Morelos', codigo: 'MOR' },
    { nombre: 'Nayarit', codigo: 'NAY' },
    { nombre: 'Nuevo León', codigo: 'NL' },
    { nombre: 'Oaxaca', codigo: 'OAX' },
    { nombre: 'Puebla', codigo: 'PUE' },
    { nombre: 'Querétaro', codigo: 'QRO' },
    { nombre: 'Quintana Roo', codigo: 'QROO' },
    { nombre: 'San Luis Potosí', codigo: 'SLP' },
    { nombre: 'Sinaloa', codigo: 'SIN' },
    { nombre: 'Sonora', codigo: 'SON' },
    { nombre: 'Tabasco', codigo: 'TAB' },
    { nombre: 'Tamaulipas', codigo: 'TAMPS' },
    { nombre: 'Tlaxcala', codigo: 'TLAX' },
    { nombre: 'Veracruz', codigo: 'VER' },
    { nombre: 'Yucatán', codigo: 'YUC' },
    { nombre: 'Zacatecas', codigo: 'ZAC' }
  ];

  municipios: Municipio[] = [
    { nombre: 'Aguascalientes', codigo: 'AGS-001', estado: 'AGS' },
    { nombre: 'Asientos', codigo: 'AGS-002', estado: 'AGS' },
    { nombre: 'Calvillo', codigo: 'AGS-003', estado: 'AGS' },
    { nombre: 'Tijuana', codigo: 'BC-001', estado: 'BC' },
    { nombre: 'Mexicali', codigo: 'BC-002', estado: 'BC' },
    { nombre: 'Ensenada', codigo: 'BC-003', estado: 'BC' },
    // Agrega más municipios según necesites
  ];

  colonias: Colonia[] = [
    { nombre: 'Centro', codigo: 'COL-001', municipio: 'AGS-001' },
    { nombre: 'Del Valle', codigo: 'COL-002', municipio: 'AGS-001' },
    { nombre: 'Las Américas', codigo: 'COL-003', municipio: 'AGS-001' },
    { nombre: 'Zona Río', codigo: 'COL-004', municipio: 'BC-001' },
    { nombre: 'Playas de Tijuana', codigo: 'COL-005', municipio: 'BC-001' },
    // Agrega más colonias según necesites
  ];

  filteredMunicipios: Municipio[] = [];
  filteredColonias: Colonia[] = [];
  type:string="";
  constructor(
    private fb: FormBuilder,
    private router: Router,
    private location: Location,
    private route : ActivatedRoute
  ) {}

  ngOnInit(): void {
    this.initForm();
    this.setupFormListeners();
        this.route.paramMap.subscribe(params => {
  console.log('params', params);
      this.type = params.get('type')?.toUpperCase() || "";
    })
    console.log('this', this.type);
  }

  initForm(): void {
    this.searchForm = this.fb.group({
      tipoPropiedad: ['Renta'],
      estado: [null, ],
      municipio: [{ value: null, }, ],
      colonia: [{ value: null, }, ]
    });
  }

  setupFormListeners(): void {
    // Listener para estado
    this.searchForm.get('estado')?.valueChanges.subscribe(estado => {
      if (estado) {
        this.filteredMunicipios = this.municipios.filter(
          m => m.estado === estado.codigo
        );

        // Habilitar municipio y resetear valores
        this.searchForm.get('municipio')?.enable();
        this.searchForm.patchValue({
          municipio: null,
          colonia: null
        });
        this.searchForm.get('colonia')?.disable();
        this.filteredColonias = [];
      } else {
        this.filteredMunicipios = [];
        this.filteredColonias = [];
        this.searchForm.get('municipio')?.disable();
        this.searchForm.get('colonia')?.disable();
      }
    });

    // Listener para municipio
    this.searchForm.get('municipio')?.valueChanges.subscribe(municipio => {
      if (municipio) {
        this.filteredColonias = this.colonias.filter(
          c => c.municipio === municipio.codigo
        );

        // Habilitar colonia y resetear valor
        this.searchForm.get('colonia')?.enable();
        this.searchForm.patchValue({
          colonia: null
        });
      } else {
        this.filteredColonias = [];
        this.searchForm.get('colonia')?.disable();
      }
    });
  }


  backPage(): void {
    this.location.back();
  }

  onSubmit(): void {

    if (this.searchForm.valid) {
      const searchData = this.searchForm.getRawValue();
      console.log('Datos de búsqueda:', searchData);


      // Navegar a la página de resultados con los parámetros
      this.router.navigate(['/propiedades'], {
        queryParams: {
          tipo: searchData.tipoPropiedad,
          estado: searchData.estado?.codigo,
          municipio: searchData.municipio?.codigo,
          colonia: searchData.colonia?.codigo
        }
      });
    } else {
      // Marcar todos los campos como touched para mostrar errores
      Object.keys(this.searchForm.controls).forEach(key => {
        this.searchForm.get(key)?.markAsTouched();
      });
    }
  }

  resetForm(): void {
    this.searchForm.reset({
      tipoPropiedad: 'Renta'
    });
    this.filteredMunicipios = [];
    this.filteredColonias = [];
    this.searchForm.get('municipio')?.disable();
    this.searchForm.get('colonia')?.disable();
  }
}
