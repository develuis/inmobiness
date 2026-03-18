import { Component } from '@angular/core';
import { Router,ActivatedRoute } from '@angular/router';
import { CommonModule } from '@angular/common';

interface Propiedad {
  id: number;
  titulo: string;
  precio: number;
  ubicacion: string;
  imagen: string;
  habitaciones: number;
  banos: number;
  m2: number;
  tipo: 'casa' | 'departamento' | 'oficina' | 'terreno';
  featured: boolean;
  nuevo: boolean;
  descripcion: string;
  direccion: string;
}
@Component({
  selector: 'app-preview',
  imports: [CommonModule],
  templateUrl: './preview.component.html',
  styleUrl: './preview.component.scss'
})


export class PreviewComponent {
  propiedades: Propiedad[] = [];
  filteredPropiedades: Propiedad[] = [];
  searchTerm: string = '';
  selectedTipo: string = 'todos';
  sortBy: string = 'recientes';

  // Para el acordeón de filtros
  filtrosAbiertos: boolean = false;

  // Opciones para los selects
  tiposPropiedad = [
    { value: 'todos', label: 'Todos los tipos' },
    { value: 'casa', label: 'Casas' },
    { value: 'departamento', label: 'Departamentos' },
    { value: 'oficina', label: 'Oficinas' },
    { value: 'terreno', label: 'Terrenos' }
  ];

  opcionesOrden = [
    { value: 'recientes', label: 'Más recientes' },
    { value: 'precio-asc', label: 'Precio: menor a mayor' },
    { value: 'precio-desc', label: 'Precio: mayor a menor' },
    { value: 'mayor-m2', label: 'Mayor superficie' }
  ];
  type:string = "";
  constructor(private router: Router, private route:ActivatedRoute) {}

  ngOnInit(): void {
    this.cargarPropiedades();

    this.route.paramMap.subscribe(params => {
      this.type = params.get('type') || "";
    })
  }

  cargarPropiedades(): void {
    // Aquí normalmente harías una petición HTTP
    // Por ahora usamos datos de ejemplo
    this.propiedades = [
      {
        id: 1,
        titulo: 'Casa Moderna en Roma Norte',
        precio: 4250000,
        ubicacion: 'Roma Norte, CDMX',
        imagen: 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1473&q=80',
        habitaciones: 3,
        banos: 2.5,
        m2: 200,
        tipo: 'casa',
        featured: true,
        nuevo: true,
        descripcion: 'Hermosa casa moderna en la mejor zona de Roma Norte',
        direccion: 'Av. Álvaro Obregón 123'
      },
      {
        id: 2,
        titulo: 'Departamento de Lujo Polanco',
        precio: 3850000,
        ubicacion: 'Polanco, CDMX',
        imagen: 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
        habitaciones: 2,
        banos: 2,
        m2: 120,
        tipo: 'departamento',
        featured: false,
        nuevo: true,
        descripcion: 'Departamento con acabados de lujo y vista panorámica',
        direccion: 'Av. Presidente Masaryk 456'
      },
      {
        id: 3,
        titulo: 'Oficina Corporativa Santa Fe',
        precio: 5200000,
        ubicacion: 'Santa Fe, CDMX',
        imagen: 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?ixlib=rb-4.0.3&auto=format&fit=crop&w=1469&q=80',
        habitaciones: 4,
        banos: 3,
        m2: 300,
        tipo: 'oficina',
        featured: true,
        nuevo: false,
        descripcion: 'Oficina en el corazón financiero de Santa Fe',
        direccion: 'Av. Santa Fe 789'
      },
      {
        id: 4,
        titulo: 'Terreno Residencial Valle',
        precio: 2800000,
        ubicacion: 'Valle, CDMX',
        imagen: 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
        habitaciones: 0,
        banos: 0,
        m2: 500,
        tipo: 'terreno',
        featured: false,
        nuevo: true,
        descripcion: 'Excelente terreno para desarrollo residencial',
        direccion: 'Calzada de Tlalpan 234'
      },
      {
        id: 5,
        titulo: 'Casa Colonial Coyoacán',
        precio: 6100000,
        ubicacion: 'Coyoacán, CDMX',
        imagen: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
        habitaciones: 4,
        banos: 3,
        m2: 350,
        tipo: 'casa',
        featured: true,
        nuevo: false,
        descripcion: 'Casa colonial restaurada en el centro de Coyoacán',
        direccion: 'Francisco Sosa 567'
      },
      {
        id: 6,
        titulo: 'Departamento Condesa',
        precio: 3450000,
        ubicacion: 'Condesa, CDMX',
        imagen: 'https://images.unsplash.com/photo-1493809842364-78817add7ffb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
        habitaciones: 2,
        banos: 1,
        m2: 85,
        tipo: 'departamento',
        featured: false,
        nuevo: true,
        descripcion: 'Departamento con excelente iluminación y ubicación',
        direccion: 'Av. Amsterdam 890'
      }
    ];

    this.aplicarFiltros();
  }

  aplicarFiltros(): void {
    let filtradas = [...this.propiedades];

    // Filtro por búsqueda
    if (this.searchTerm) {
      filtradas = filtradas.filter(p =>
        p.titulo.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
        p.ubicacion.toLowerCase().includes(this.searchTerm.toLowerCase())
      );
    }

    // Filtro por tipo
    if (this.selectedTipo !== 'todos') {
      filtradas = filtradas.filter(p => p.tipo === this.selectedTipo);
    }

    // Ordenamiento
    switch(this.sortBy) {
      case 'precio-asc':
        filtradas.sort((a, b) => a.precio - b.precio);
        break;
      case 'precio-desc':
        filtradas.sort((a, b) => b.precio - a.precio);
        break;
      case 'mayor-m2':
        filtradas.sort((a, b) => b.m2 - a.m2);
        break;
      default: // 'recientes'
        filtradas.sort((a, b) => b.id - a.id);
    }

    this.filteredPropiedades = filtradas;
  }

  toggleFiltros(): void {
    this.filtrosAbiertos = !this.filtrosAbiertos;
  }

  isOpen(section: string): boolean {
    return section === 'filtros' ? this.filtrosAbiertos : false;
  }

  verDetalle(id: number): void {
    // this.router.navigate(['/propiedad', id]);
    this.router.navigate(['view/propiedad'])
  }

  formatPrecio(precio: number): string {
    return precio.toLocaleString('es-MX', {
      minimumFractionDigits: 0,
      maximumFractionDigits: 0
    });
  }

}
