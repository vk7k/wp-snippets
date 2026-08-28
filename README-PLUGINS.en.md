[🇪🇸 Español](README-PLUGINS.md) | 🇬🇧 English

---

# 🔌 Guide: Installing as WordPress Plugins

All components in this repository include standard WordPress plugin headers (`Plugin Name`, `Version`, `Author`, etc.), allowing them to work completely standalone as traditional plugins or Must-Use Plugins (*mu-plugins*).

---

## 📦 Method 1: Upload as a ZIP file from WP Admin (Recommended)

1. **Prepare the ZIP:**
   - Select the plugin folder you want to install (e.g. `admin-notes` or `vk-lightbox`).
   - Compress the folder into a `.zip` file (e.g. `vk7k-admin-notes.zip`).
   - *Note:* Make sure the main `.php` file is located inside the folder before zipping.

2. **Upload to WordPress:**
   - Go to **Plugins > Add New Plugin** in your WordPress Admin dashboard.
   - Click the **Upload Plugin** button at the top.
   - Click **Choose File**, select your `.zip` archive, and click **Install Now**.

3. **Activate:**
   - Once uploaded, click **Activate Plugin**.
   - The plugin will appear in your installed plugins list with its official metadata, author, and version.

---

## 📁 Method 2: Upload via FTP / SSH / Hosting File Manager (cPanel / CloudPanel)

1. Connect to your server using SFTP, SSH, or your hosting control panel's file manager.
2. Navigate to your WordPress plugins directory:
   ```text
   wp-content/plugins/
   ```
3. Copy the entire snippet/plugin folder (e.g. `varnish-clear-cache`) into `wp-content/plugins/`.
4. Open the WordPress dashboard: navigate to **Plugins > Installed Plugins** and click **Activate**.

---

## ⚡ Method 3: Install as a Must-Use Plugin (`mu-plugins`)

*Must-Use plugins* execute automatically on every request across the entire site, cannot be deactivated by other administrators from the plugins list, and do not require manual activation.

1. Navigate on your server to `wp-content/mu-plugins/` (create the `mu-plugins` folder if it doesn't exist).
2. Upload the main `.php` file directly (e.g. `vk7k-wp-admin-notes.php`) inside `wp-content/mu-plugins/`.
3. Done! WordPress will automatically load the code on every page load.

---

## 🛠️ Post-Installation Setup
Check the individual `README.en.md` for each plugin to discover any required configuration options (API keys, admin menus, CSS selectors, etc.).

---

## 📋 Prefer to use it as a Snippet in WPCode?
If you'd rather not create plugin folders and prefer managing code via WPCode, check:
👉 [How to Install as a Snippet (WPCode)](README-SNIPPETS.en.md)
