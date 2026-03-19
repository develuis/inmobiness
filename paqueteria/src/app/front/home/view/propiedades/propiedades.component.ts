import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { CommonModule } from '@angular/common';

interface AccordionItem {
  id: string;
  title: string;
  iconBg: string;
  iconColor: string;
  iconPath: string | string[];
  isOrange?: boolean;
}

@Component({
  standalone: true,
  providers: [CommonModule],
  selector: 'app-propiedades',
  templateUrl: './propiedades.component.html',
  styleUrl: './propiedades.component.scss'
})
export class PropiedadesComponent {

  liked = false;

  toggleLike(): void {
    this.liked = !this.liked;
  }

   openItem: string | null = null;

  toggle(id: string): void {
    this.openItem = this.openItem === id ? null : id;
  }

  isOpen(id: string): boolean {
    return this.openItem === id;
  }
}
