🇪🇸 Español | [🇬🇧 English](README.en.md)

---

# 🚀 WordPress Snippets & Plugins (wp-snippets)

Colección de snippets y utilidades en PHP/JS para WordPress, optimizados con arquitectura nativa, seguros y ligeros.

Todos los componentes de este repositorio tienen **doble propósito**:
1. **Como Snippets (Principal):** Puedes copiar y pegar el código directamente en gestores como **WPCode**, **Code Snippets** o en el archivo `functions.php`.
2. **Como Plugins (Secundario):** Cada archivo PHP incluye la cabecera estándar de WordPress (`Plugin Name`, `Version`, etc.) para que puedas comprimir la carpeta e instalarla como un plugin independiente o colocarla en `wp-content/mu-plugins/`.

---

## 📖 Guías de Instalación

- 📋 **[Cómo instalar como Snippet (WPCode)](README-SNIPPETS.md)**: Instrucciones paso a paso, qué partes de código mantener o ajustar (etiquetas `<?php`, metadatos, etc.).
- 🔌 **[Cómo instalar como Plugin de WordPress](README-PLUGINS.md)**: Instrucciones para instalar vía ZIP, FTP o como *Must-Use Plugin* (`mu-plugins`).

---

## 📂 Catálogo de Snippets / Plugins

| Directorio | Archivo Principal | Descripción |
| :--- | :--- | :--- |
| [📌 `admin-notes`](admin-notes/README.md) | `vk7k-wp-admin-notes.php` | Sistema CRUD para crear notas internas y avisos en pantallas específicas del panel de administración de WordPress por roles o usuarios. |
| [📧 `contact-form-7`](contact-form-7/README.md) | `vk7k-wp-contact-form-7.php` | Redirección configurable tras el envío exitoso de formularios en Contact Form 7 con retardo personalizable. |
| [🔤 `justify-text`](justify-text/README.md) | `vk7k-wp-justify-text.php` | Añade el botón de justificar a nivel de bloque (Párrafos y Encabezados) en el editor Gutenberg. |
| [📊 `meta-capi-woocommerce`](meta-capi-woocommerce/README.md) | `vk7k-wp-meta-capi-woocommerce.php` | Captura cookies de Meta (`_fbp`, `_fbc`), IP y User Agent al crear pedidos y envía eventos Purchase a Meta Conversions API (CAPI). |
| [⚡ `varnish-clear-cache`](varnish-clear-cache/README.md) | `vk7k-wp-varnish-clear-cache.php` | Purga automática de caché de Varnish (CloudPanel / servidores dedicados) al publicar o actualizar entradas y páginas. |
| [🖼️ `vk-lightbox`](vk-lightbox/README.md) | `vk7k-wp-vk-lightbox.php` | Lightbox flotante y responsive en iframe para enlaces con atributo `rel="vk7k-lightbox"`. |

---

## 📜 Licencia

Distribuido bajo la Licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más información.
