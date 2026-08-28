🇪🇸 Español | [🇬🇧 English](README.en.md)

---

# Varnish Clear Cache ⚡

Snippet y plugin para purgar automáticamente la caché de **Varnish Cache** (usado frecuentemente en CloudPanel, servidores dedicados o VPS) cada vez que se crea, edita o publica una entrada o página en WordPress.

---

## 📖 Guías de Instalación

- 📋 **[Cómo instalar como Snippet (WPCode)](../README-SNIPPETS.md)**
- 🔌 **[Cómo instalar como Plugin de WordPress](../README-PLUGINS.md)**

---

## ✨ Características

- **Purga Inteligente al Guardar:** Envía una petición `PURGE` a Varnish cuando se publica o actualiza un post o página.
- **Purga de Portada Opcional:** Permite activar la purga automática de la página de inicio (`/`) al modificar contenidos.
- **Panel de Configuración:** Interfaz en **Ajustes > Varnish Cache** para configurar la dirección del servidor (ej. `127.0.0.1:6081`) y activar/desactivar la purga.
- **Registro y Rotación de Logs:** Guarda un historial de peticiones de purga con límite de 5MB y visualizador de los últimos logs en el panel.
- **Reintentos Automáticos:** Hasta 3 intentos en caso de fallo temporal de red hacia Varnish.

---

## ⚙️ Opciones de Instalación

1. **Como Snippet en WPCode:**
   - Tipo de código: **PHP Snippet**.
   - Ubicación: **Run Everywhere** (Ejecutar en todas partes) o **Admin Only**.
2. **Como Plugin:**
   - Comprime la carpeta `varnish-clear-cache` en un archivo `.zip` e instálalo desde **Plugins > Añadir nuevo plugin > Subir plugin**.

---

## 🛠️ Configuración

Una vez activo:
1. Ve a **Ajustes > Varnish Cache** en tu panel de WordPress.
2. Ingresa la dirección de tu servidor Varnish (por defecto `127.0.0.1:6081` o `localhost:6081`).
3. Marca la casilla **Activar purga automática** y **Purgar homepage también** (si aplica).
4. Haz clic en **Guardar cambios**.
