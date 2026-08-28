🇪🇸 Español | [🇬🇧 English](README.en.md)

---

# WP Admin Notes Snippet 📌
Put notes everywhere in the wp admin. Snippet & Plugin version.

Un snippet y plugin ligero y seguro para WordPress que permite crear notas de advertencia, recordatorios o documentación directamente en el panel de administración. Creado con arquitectura CRUD, utilizando la API nativa de WordPress sin dependencias, sin engordar la base de datos y manteniendo un diseño nativo.

---

## 📖 Guías de Instalación

- 📋 **[Cómo instalar como Snippet (WPCode)](../README-SNIPPETS.md)**
- 🔌 **[Cómo instalar como Plugin de WordPress](../README-PLUGINS.md)**

---

## Características
- **Ultra Ligero:** Un solo archivo. No añade tablas a la base de datos (utiliza `wp_options`).
- **Seguro:** Sanitización estricta (`sanitize_text_field`, `wp_kses_post`) y uso de Nonces para evitar ataques CSRF y XSS.
- **Granular:** Permite inyectar avisos en pantallas de configuración específicas (Screen IDs).
- **Control de Acceso:** Muestra las notas solo a ciertos roles de usuario o a un nombre de usuario específico.

## ⚙️ Cómo usar

Una vez activo (como snippet en WPCode o como plugin), ve a **Herramientas > Notas Internas** (solo visible para Administradores) para gestionar tus notas.

---

## 📚 Referencia: ¿Qué poner en el formulario?

### 1. Ubicación (Screen ID)
El *Screen ID* es el identificador interno que WordPress le da a cada página de su panel de administración. Aquí tienes la lista de los más comunes:

**Dashboard & Escritorio**
- `dashboard` (Pantalla de inicio principal)
- `update-core` (Pantalla de actualizaciones)

**Entradas (Posts)**
- `edit-post` (Lista de todas las entradas)
- `post` (Editor de una entrada)
- `edit-category` (Categorías de entradas)
- `edit-post_tag` (Etiquetas)

**Páginas (Pages)**
- `edit-page` (Lista de todas las páginas)
- `page` (Editor de una página)

**Multimedia**
- `upload` (Biblioteca de medios)
- `media` (Añadir nuevo medio)

**Apariencia & Temas**
- `themes` (Lista de temas)
- `widgets` (Pantalla de Widgets)
- `nav-menus` (Menús)

**Plugins & Usuarios**
- `plugins` (Lista de plugins instalados)
- `users` (Lista de usuarios)
- `profile` (Perfil del usuario actual)

**Ajustes Globales (Settings)**
- `options-general` (Ajustes Generales)
- `options-writing` (Ajustes de Escritura)
- `options-reading` (Ajustes de Lectura)
- `options-discussion` (Ajustes de Comentarios)
- `options-media` (Ajustes de Medios)
- `options-permalink` (Enlaces Permanentes)

**Plugins Externos Populares (Ejemplos)**
- `toplevel_page_wpcf7` (Pantalla principal de Contact Form 7)
- `contact_page_wpcf7-integration` (Pantalla de Integración de CF7)
- `woocommerce_page_wc-settings` (Ajustes de WooCommerce)

*(Tip Pro: Si estás en una página que no está en esta lista, puedes encontrar su Screen ID abriendo la consola del navegador y escribiendo `wp.data.select('core').getCurrentUser()`, o inspeccionando la clase del `<body>` que usualmente contiene la clase de la pantalla).*

---

### 2. Permisos (Roles o Usuarios)
En el campo de permiso, debes indicar quién puede leer la nota. Puedes usar los **Roles Oficiales de WordPress** o el **Nombre de Usuario** exacto.

**Por Roles de Sistema:**
- `administrator` (Administradores - Control total)
- `editor` (Editores - Pueden publicar y gestionar posts de otros)
- `author` (Autores - Pueden publicar sus propios posts)
- `contributor` (Colaboradores - Pueden escribir pero no publicar)
- `subscriber` (Suscriptores - Solo leen)

**Por Nombre de Usuario Específico:**
Si solo quieres que un desarrollador o usuario vea la nota y nadie más en el sistema (incluso otros administradores), puedes escribir su *Username* (por ejemplo: `victor` o `desarrollo_agencia`).