🇪🇸 Español | [🇬🇧 English](README.en.md)

---

# VK Lightbox 🖼️

Añade un visor emergente (*lightbox*) responsivo en iframe para WordPress. Se activa automáticamente en cualquier enlace que tenga el atributo `rel="vk7k-lightbox"`. Incluye navegación entre elementos múltiples, barra superior con botón de cierre y spinner de precarga.

---

## 📖 Guías de Instalación

- 📋 **[Cómo instalar como Snippet (WPCode)](../README-SNIPPETS.md)**
- 🔌 **[Cómo instalar como Plugin de WordPress](../README-PLUGINS.md)**

---

## ✨ Características

- **Activación por atributo:** Solo requiere añadir `rel="vk7k-lightbox"` a cualquier enlace `<a>`.
- **Navegación integrada:** Si existen múltiples enlaces con el atributo en la página, se generan botones de "Anterior" y "Siguiente" para navegar entre ellos sin cerrar el lightbox.
- **Carga en iframe:** Permite mostrar páginas externas, formularios o URLs internas directamente en la ventana modal.
- **Autoajuste de altura:** Calcula la altura del contenido de forma dinámica y cuenta con un spinner animado durante la carga.

---

## 🚀 Modo de Uso

Inserta enlaces en tu contenido, páginas o bloques HTML con el atributo `rel="vk7k-lightbox"`:

```html
<!-- Enlace individual -->
<a href="https://ejemplo.com/formulario" rel="vk7k-lightbox">Abrir Formulario en Modal</a>

<!-- Galería o secuencia de enlaces -->
<a href="https://ejemplo.com/pagina-1" rel="vk7k-lightbox">Ver Paso 1</a>
<a href="https://ejemplo.com/pagina-2" rel="vk7k-lightbox">Ver Paso 2</a>
```

---

## ⚙️ Opciones de Instalación

1. **Como Snippet en WPCode:**
   - Tipo de código: **PHP Snippet**.
   - Ubicación: **Frontend Only** (Solo interfaz pública).
2. **Como Plugin:**
   - Comprime la carpeta `vk-lightbox` en un archivo `.zip` e instálalo desde **Plugins > Añadir nuevo plugin > Subir plugin**.
