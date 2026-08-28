🇪🇸 Español | [🇬🇧 English](README.en.md)

---

# CF7 Redirect After Send 📧

Este módulo permite redirigir a los usuarios a URLs específicas o páginas de gracias personalizadas tras el envío exitoso de un formulario creado con **Contact Form 7 (CF7)**, con soporte para múltiples formularios y tiempo de retardo configurable.

---

## 📖 Guías de Instalación

- 📋 **[Cómo instalar como Snippet (WPCode)](../README-SNIPPETS.md)**
- 🔌 **[Cómo instalar como Plugin de WordPress](../README-PLUGINS.md)**

---

## ⚙️ Cómo Obtener el Post ID del Formulario en CF7

Debes obtener el **Post ID** del formulario, que es el ID interno del post de WordPress (distinto al atributo `id=""` del formulario HTML).

1. Entra a tu panel de WordPress y ve a **Contacto > Formularios de contacto**.
2. Haz clic para editar el formulario deseado.
3. Observa la barra de direcciones de tu navegador. Verás una URL similar a:
   ```text
   tusitio.com/wp-admin/admin.php?page=wpcf7&post=1544&action=edit
   ```
4. El número en `post=1544` es el Post ID del formulario (en este ejemplo, `1544`).

---

## 🛠️ Configuración del Snippet

Edita las variables dentro de `vk7k-wp-contact-form-7.php` (o en tu editor de WPCode):

```javascript
// 1. Lista de rutas de redirección: 'ID_Formulario': 'URL_Destino'
const redirectRoutes = {
    '1544': 'https://tusitio.com/gracias/',
    '2339': 'https://tusitio.com/confirmacion-curso/'
};

// 2. Mensaje visual mientras espera la redirección
const successMessageInnerText = '📧✔ Redirigiendo...';

// 3. Retardo en segundos antes de redirigir
const delayInSecondsAfterSent = 2;
```

---

## 🚀 Opciones de Uso

1. **Como Snippet en WPCode:**
   - Modo: **PHP Snippet** (usando el archivo `vk7k-wp-contact-form-7.php`) o **JavaScript Snippet** (copiando solo el bloque interior `<script>`).
   - Ubicación: **Frontend Only** (Solo interfaz pública).
2. **Como Plugin:**
   - Comprime la carpeta `contact-form-7` en `.zip` y súbela desde **Plugins > Añadir nuevo plugin > Subir plugin**.
