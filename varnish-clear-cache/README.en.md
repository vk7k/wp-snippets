[🇪🇸 Español](README.md) | 🇬🇧 English

---

# Varnish Clear Cache ⚡

A WordPress snippet and plugin designed to automatically purge **Varnish Cache** (commonly configured with CloudPanel or standalone VPS servers) whenever a post or page is published or modified.

---

## 📖 Installation Guides

- 📋 **[How to Install as a Snippet (WPCode)](../README-SNIPPETS.en.md)**
- 🔌 **[How to Install as a WordPress Plugin](../README-PLUGINS.en.md)**

---

## ✨ Features

- **Smart Purge on Save:** Dispatches a `PURGE` HTTP request directly to Varnish when saving/updating posts or pages.
- **Optional Homepage Purge:** Automatically purges the front page (`/`) on content changes.
- **Admin Settings Screen:** Configurable under **Settings > Varnish Cache** to set the host/port (e.g. `127.0.0.1:6081`) and toggle automatic purging.
- **Log Management & Rotation:** Logs purge activities with a 5MB size limit and includes an admin log viewer.
- **Retry Mechanism:** Retries up to 3 times on temporary connection failures.

---

## ⚙️ Installation Options

1. **As a Snippet in WPCode:**
   - Code Type: **PHP Snippet**.
   - Location: **Run Everywhere** or **Admin Only**.
2. **As a Plugin:**
   - Compress the `varnish-clear-cache` folder into `.zip` and upload via **Plugins > Add New Plugin > Upload Plugin**.

---

## 🛠️ Configuration

Once activated:
1. Go to **Settings > Varnish Cache** in your WordPress admin.
2. Specify your Varnish server address (defaults to `127.0.0.1:6081` or `localhost:6081`).
3. Check **Enable automatic purge** and **Purge homepage too** (if desired).
4. Click **Save Changes**.
