[🇪🇸 Español](README.md) | 🇬🇧 English

---

# 🚀 WordPress Snippets & Plugins (wp-snippets)

A curated collection of lightweight, secure, and native PHP/JS snippets and utilities for WordPress.

All components in this repository serve a **dual purpose**:
1. **As Snippets (Primary):** Copy and paste the code directly into snippet manager plugins like **WPCode**, **Code Snippets**, or your child theme's `functions.php`.
2. **As Plugins (Secondary):** Each PHP file includes standard WordPress plugin headers (`Plugin Name`, `Version`, etc.) so you can zip the folder and install it as an independent plugin or place it in `wp-content/mu-plugins/`.

---

## 📖 Installation Guides

- 📋 **[How to Install as a Snippet (WPCode)](README-SNIPPETS.en.md)**: Step-by-step instructions, code adjustments (handling `<?php` tags, metadata, etc.).
- 🔌 **[How to Install as a WordPress Plugin](README-PLUGINS.en.md)**: Instructions for installing via ZIP upload, FTP, or as a Must-Use Plugin (`mu-plugins`).

---

## 📂 Snippets / Plugins Catalog

| Directory | Main File | Description |
| :--- | :--- | :--- |
| [📌 `admin-notes`](admin-notes/README.en.md) | `vk7k-wp-admin-notes.php` | CRUD system to create internal admin notes and notices on specific WordPress admin screens targeted by role or username. |
| [📧 `contact-form-7`](contact-form-7/README.en.md) | `vk7k-wp-contact-form-7.php` | Configurable redirection to specific URLs or thank-you pages upon successful Contact Form 7 submission with custom delay. |
| [🔤 `justify-text`](justify-text/README.en.md) | `vk7k-wp-justify-text.php` | Adds a block-level justify alignment button (Paragraphs and Headings) in the Gutenberg block editor. |
| [📊 `meta-capi-woocommerce`](meta-capi-woocommerce/README.en.md) | `vk7k-wp-meta-capi-woocommerce.php` | Captures Meta cookies (`_fbp`, `_fbc`), IP, and User Agent during checkout and sends Purchase events to Meta Conversions API (CAPI). |
| [⚡ `varnish-clear-cache`](varnish-clear-cache/README.en.md) | `vk7k-wp-varnish-clear-cache.php` | Automatic Varnish cache purge (CloudPanel / VPS) whenever posts or pages are published or updated. |
| [🖼️ `vk-lightbox`](vk-lightbox/README.en.md) | `vk7k-wp-vk-lightbox.php` | Responsive floating iframe lightbox triggered by links with `rel="vk7k-lightbox"`. |

---

## 📜 License

Distributed under the MIT License. See [LICENSE](LICENSE) for more details.
