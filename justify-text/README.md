🇪🇸 Español | [🇬🇧 English](README.en.md)

---

# Botón Justificar para Editor de Bloques WordPress (Gutenberg) 🔤

Este snippet y plugin de PHP añade un botón de **Justificar** a la barra de herramientas de bloques específicos (Párrafo y Encabezado) en el editor de bloques de WordPress (Gutenberg). A diferencia de otros métodos que aplican justificación solo al texto seleccionado (*inline*), este snippet funciona a nivel de bloque, similar a los botones nativos de alineación Izquierda, Centro y Derecha.

Al hacer clic en el botón Justificar, se añade la clase CSS `has-text-align-justify` al bloque completo (`<p>`, `<h1>`, etc.) y se eliminan otras clases de alineación (`has-text-align-left`, `has-text-align-center`, `has-text-align-right`) para evitar conflictos. Al hacer clic de nuevo, se elimina la clase de justificación.

Creado con ❤️ por Victor Mellado (vk7k) y Gemini.

---

## 📖 Guías de Instalación

- 📋 **[Cómo instalar como Snippet (WPCode)](../README-SNIPPETS.md)**
- 🔌 **[Cómo instalar como Plugin de WordPress](../README-PLUGINS.md)**

---

## ✨ Características

* Añade un botón "Justificar" a la barra de herramientas principal de los bloques seleccionados.
* Funciona a nivel de bloque (aplica/quita la clase `has-text-align-justify` al elemento principal del bloque).
* Elimina otras clases de alineación (izquierda, centro, derecha) al justificar para evitar conflictos CSS.
* Aplica los estilos CSS necesarios tanto en el editor como en el frontend.
* Actualmente configurado para bloques de Párrafo (`core/paragraph`) y Encabezado (`core/heading`).

---

## ⚙️ Opciones de Instalación

1. **Como Snippet en WPCode:**
   - Tipo de código: **PHP Snippet**.
   - Ubicación: **Run Everywhere** (Ejecutar en todas partes) para cargar los estilos en el editor y el frontend.
   - Pega el contenido de `vk7k-wp-justify-text.php` y activa el snippet.
2. **Como Plugin:**
   - Comprime la carpeta `justify-text` en `.zip` y súbela desde **Plugins > Añadir nuevo plugin > Subir plugin**.

---

## 🎯 Modo de Uso

1. Edita una entrada o página con el editor de bloques Gutenberg.
2. Selecciona un bloque de Párrafo o Encabezado.
3. Haz clic en el nuevo icono de justificar en la barra de herramientas principal del bloque.
4. Haz clic de nuevo para quitar la justificación (volverá a la alineación por defecto).

---

## 🧩 Compatibilidad

* Compatible con WordPress 6.0+ y versiones recientes del editor de bloques Gutenberg.
* Aplica a `core/paragraph` y `core/heading`. Puedes modificar la constante `allowedBlocks` en el archivo si deseas añadir soporte para otros bloques.
