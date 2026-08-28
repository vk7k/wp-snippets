🇪🇸 Español | [🇬🇧 English](README.en.md)

---

# Meta CAPI para WooCommerce 📊

Este módulo captura parámetros de seguimiento de Meta (`_fbp`, `_fbc`, IP y User Agent) al momento de crear un pedido en WooCommerce, y envía el evento **Purchase** directamente al servidor de Meta mediante la **Conversions API (CAPI)** en el hook `woocommerce_order_status_completed`.

---

## 📖 Guías de Instalación

- 📋 **[Cómo instalar como Snippet (WPCode)](../README-SNIPPETS.md)**
- 🔌 **[Cómo instalar como Plugin de WordPress](../README-PLUGINS.md)**

---

## ✨ Características

1. **Captura de Cookies y Metadatos en Checkout:**
   - Lee `_fbp` (Facebook Browser ID) y `_fbc` (Facebook Click ID).
   - Registra la IP del cliente y el User Agent en los metadatos de la orden de WooCommerce (`_meta_fbp`, `_meta_fbc`, `_meta_client_ip`, `_meta_client_ua`).
2. **Envío Servidor a Servidor (Server-Side CAPI):**
   - Se ejecuta cuando el pedido cambia a estado **Completado** (`woocommerce_order_status_completed`).
   - Normaliza y hashea en SHA-256 los datos del usuario (email, teléfono, nombre, apellido).
   - Incluye deduplicación con `event_id: 'woo_{order_id}'`.
   - Evita reenvíos múltiples mediante el flag `_meta_capi_sent`.
   - Filtra compras de prueba que contengan `+test` en el email.
3. **Registro de Logs de Auditoría:**
   - Guarda logs en `wp-content/uploads/meta-capi-woo.log` con el estado y respuestas de la API de Meta.

---

## 🛠️ Configuración Requerida

Antes de activar el snippet o plugin, abre `vk7k-wp-meta-capi-woocommerce.php` y configura tus credenciales de Meta:

```php
$access_token = 'TU_META_ACCESS_TOKEN_AQUI'; // Token de acceso del Administrador de Eventos de Meta
$pixel_id     = 'TU_PIXEL_ID_AQUI';          // ID de tu Dataset / Píxel de Meta
```

---

## ⚙️ Opciones de Instalación

1. **Como Snippet en WPCode:**
   - Tipo de código: **PHP Snippet**.
   - Ubicación: **Run Everywhere** (Ejecutar en todas partes).
2. **Como Plugin:**
   - Comprime la carpeta `meta-capi-woocommerce` en un archivo `.zip` e instálalo desde **Plugins > Añadir nuevo plugin > Subir plugin**.
