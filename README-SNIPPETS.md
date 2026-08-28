🇪🇸 Español | [🇬🇧 English](README-SNIPPETS.en.md)

---

# 📋 Guía de Instalación como Snippets (WPCode)

Todos los snippets de este repositorio han sido diseñados para poder utilizarse directamente a través de plugins gestores de código como **WPCode (Code Snippets)**, **Code Snippets**, o agregándolos al archivo `functions.php` de tu tema hijo (*child theme*).

---

## 🚀 Pasos para Instalar en WPCode

1. **Instalar y activar WPCode:**
   - En tu panel de WordPress, dirígete a **Plugins > Añadir nuevo**.
   - Busca **WPCode – Insert Headers and Footers + Custom Code Snippets** e instálalo/actívalo.

2. **Crear un nuevo Snippet:**
   - Ve a **Code Snippets > + Add Snippet** (o **Añadir fragmento**).
   - Selecciona **"Add Your Custom Code (New Snippet)"** y pulsa en **"Use snippet"**.

3. **Configurar el tipo de código:**
   - Asigna un título descriptivo (ej: *VK7K - Admin Notes* o *VK7K - Lightbox*).
   - En el desplegable **Code Type** (Tipo de código), selecciona **PHP Snippet** (o **JavaScript Snippet** si solo usas el script cliente).

4. **Copiar y pegar el código:**
   - Abre el archivo `.php` correspondiente dentro de la carpeta del snippet (por ejemplo, `admin-notes/vk7k-wp-admin-notes.php`).
   - Copia el contenido del archivo y pégalo en el editor de WPCode.

5. **Configurar la ubicación de inserción (*Insertion*):**
   - **Auto Insert (Inserción automática):**
     - **Ubicación:** Selecciona dónde debe ejecutarse:
       - **Run Everywhere (Ejecutar en todas partes):** Para snippets que afecten frontend y backend (ej. `vk7k-wp-justify-text.php`, `vk7k-wp-admin-notes.php`).
       - **Frontend Only (Solo interfaz pública):** Para snippets visuales o de seguimiento (ej. `vk7k-wp-vk-lightbox.php`, `vk7k-wp-contact-form-7.php`).
       - **Admin Only (Solo administración):** Para herramientas exclusivas del panel de control.

6. **Activar y Guardar:**
   - Cambia el interruptor superior de **Inactive** a **Active**.
   - Haz clic en **Save Snippet** (Guardar fragmento).

---

## ⚠️ ¿Qué partes del código debes sacar o ajustar al usar WPCode?

### 1. Etiqueta de apertura `<?php`
- **WPCode gestiona `<?php` automáticamente en modo PHP:**
  - El editor de WPCode suele incluir la etiqueta `<?php` por defecto fuera del cuadro de texto.
  - **Recomendación:** Si al pegar el código notas que empieza con `<?php`, verifica que no quede duplicado como `<?php <?php`. Si tu editor ya tiene el `<?php` fijado arriba, pega el código a partir del comentario o retira el `<?php` inicial.

### 2. Cabecera del Plugin (`/* Plugin Name: ... */`)
- Las primeras líneas con información como `Plugin Name:`, `Version:`, `Author:`, etc., son metadatos para WordPress cuando el archivo se usa como plugin independiente.
- **¿Debes borrarlo?** No es obligatorio. Si lo dejas dentro del comentario `/** ... */`, PHP lo ignorará y el snippet funcionará perfectamente. Puedes conservarlo como referencia o eliminarlo si prefieres un código más limpio.

### 3. Línea de seguridad `defined( 'ABSPATH' ) || exit;`
- Esta línea previene la ejecución directa del archivo desde el navegador web.
- **¿Debes borrarlo?** **No.** En WPCode esta constante siempre estará definida y no causará ningún error. Déjala intacta.

### 4. Variables de configuración personalizadas
Algunos snippets requieren configurar variables específicas para tu sitio antes de activarlos:

- **Meta CAPI WooCommerce (`vk7k-wp-meta-capi-woocommerce.php`):**
  - Cambia `$access_token = 'TOKEN';` por tu Token de Conversiones de Meta.
  - Cambia `$pixel_id = 'PIXEL ID';` por el ID de tu píxel.
  - Ajusta la ruta `$log_file` si tu servidor tiene otra estructura.
- **Contact Form 7 Redirect (`vk7k-wp-contact-form-7.php`):**
  - Ajusta el diccionario `redirectRoutes` con los IDs de tus formularios y las URLs de destino.
- **Varnish Clear Cache (`vk7k-wp-varnish-clear-cache.php`):**
  - Configura la IP y puerto del servidor Varnish (por defecto `127.0.0.1:6081`) desde los ajustes o directamente en el código.

---

## 🔌 ¿Prefieres instalarlo como Plugin?
Si deseas empaquetarlo y gestionarlo desde **Plugins > Plugins instalados**, consulta la guía:
👉 [Cómo instalar como Plugin de WordPress](README-PLUGINS.md)
