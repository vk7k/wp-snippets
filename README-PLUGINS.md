🇪🇸 Español | [🇬🇧 English](README-PLUGINS.en.md)

---

# 🔌 Guía de Instalación como Plugins de WordPress

Todos los componentes de este repositorio cuentan con las cabeceras estándar de plugins de WordPress (`Plugin Name`, `Version`, `Author`, etc.), por lo que pueden funcionar de manera completamente autónoma como plugins tradicionales o como plugins obligatorios (*Must-Use Plugins / mu-plugins*).

---

## 📦 Método 1: Subir como archivo ZIP desde el Panel de WordPress (Recomendado)

1. **Preparar el ZIP:**
   - Selecciona la carpeta del plugin que deseas instalar (por ejemplo `admin-notes` o `vk-lightbox`).
   - Comprime esa carpeta en un archivo `.zip` (ejemplo: `vk7k-admin-notes.zip`).
   - *Nota:* Asegúrate de que el archivo `.php` principal esté dentro de la carpeta antes de comprimir.

2. **Subir en WordPress:**
   - Ve a **Plugins > Añadir nuevo plugin** en tu panel de administración de WordPress.
   - Haz clic en el botón superior **Subir plugin**.
   - Haz clic en **Seleccionar archivo**, elige tu archivo `.zip` y pulsa en **Instalar ahora**.

3. **Activar:**
   - Una vez terminada la subida, pulsa en **Activar plugin**.
   - El plugin aparecerá en tu lista de plugins instalados con su versión, autor y descripción oficial.

---

## 📁 Método 2: Subir por FTP / SSH / Administrador de Archivos (cPanel / CloudPanel)

1. Conéctate a tu servidor mediante SFTP, SSH o el Gestor de Archivos de tu panel de hosting.
2. Navega al directorio de plugins de tu instalación de WordPress:
   ```text
   wp-content/plugins/
   ```
3. Copia la carpeta del snippet/plugin completa (por ejemplo `varnish-clear-cache`) dentro de `wp-content/plugins/`.
4. Ve al panel de WordPress: **Plugins > Plugins instalados** y haz clic en **Activar** en el plugin correspondiente.

---

## ⚡ Método 3: Instalar como Must-Use Plugin (`mu-plugins`)

Los *mu-plugins* se ejecutan automáticamente en todo el sitio, no pueden ser desactivados por otros administradores desde la lista de plugins y no requieren activación manual.

1. Navega en tu servidor a `wp-content/mu-plugins/` (si la carpeta `mu-plugins` no existe, créala).
2. Sube directamente el archivo `.php` principal (por ejemplo `vk7k-wp-admin-notes.php`) dentro de `wp-content/mu-plugins/`.
3. ¡Listo! WordPress cargará el código de forma automática en cada petición.

---

## 🛠️ Configuración Posterior
Revisa el `README.md` específico de cada plugin para conocer los parámetros a configurar (claves de API, menús de administración creados, selectores CSS, etc.).

---

## 📋 ¿Prefieres usarlo como Snippet en WPCode?
Si no quieres crear archivos de plugin y prefieres gestionarlo con un plugin de snippets, consulta:
👉 [Cómo instalar como Snippet (WPCode)](README-SNIPPETS.md)
