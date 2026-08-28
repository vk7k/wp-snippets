[🇪🇸 Español](README.md) | 🇬🇧 English

---

# WP Admin Notes Snippet 📌
Put internal notes, warnings, and reminders anywhere in the WordPress admin panel. Snippet & Plugin version.

A lightweight and secure snippet and plugin for WordPress that allows you to create notices, reminders, or documentation directly in the admin dashboard. Built with CRUD architecture using native WordPress APIs with zero third-party dependencies, storing data in `wp_options` without bloating the database.

---

## 📖 Installation Guides

- 📋 **[How to Install as a Snippet (WPCode)](../README-SNIPPETS.en.md)**
- 🔌 **[How to Install as a WordPress Plugin](../README-PLUGINS.en.md)**

---

## ✨ Features
- **Ultra Lightweight:** Single file. No extra DB tables (uses `wp_options`).
- **Secure:** Strict sanitization (`sanitize_text_field`, `wp_kses_post`) and WordPress Nonces against CSRF & XSS.
- **Granular Targeting:** Inject notices into specific admin screens (Screen IDs) or everywhere.
- **Access Control:** Restrict visibility by WordPress user roles or exact usernames.

---

## ⚙️ How to Use

Once activated (via WPCode or as a plugin), navigate to **Tools > Internal Notes** (visible only to Administrators) to manage your notes.

---

## 📚 Reference: Form Field Guide

### 1. Target Screen ID
The *Screen ID* is the internal identifier WordPress assigns to each admin page. Common Screen IDs include:

**Dashboard**
- `dashboard` (Main dashboard home)
- `update-core` (Updates screen)

**Posts**
- `edit-post` (Posts list table)
- `post` (Post editor)
- `edit-category` (Categories screen)
- `edit-post_tag` (Tags screen)

**Pages**
- `edit-page` (Pages list table)
- `page` (Page editor)

**Media**
- `upload` (Media library)
- `media` (Add new media)

**Appearance & Themes**
- `themes` (Themes list)
- `widgets` (Widgets screen)
- `nav-menus` (Menus screen)

**Plugins & Users**
- `plugins` (Installed plugins)
- `users` (Users list)
- `profile` (Current user profile)

**Settings**
- `options-general` (General Settings)
- `options-writing` (Writing Settings)
- `options-reading` (Reading Settings)
- `options-discussion` (Discussion Settings)
- `options-media` (Media Settings)
- `options-permalink` (Permalinks Settings)

**Popular Plugin Pages (Examples)**
- `toplevel_page_wpcf7` (Contact Form 7 main screen)
- `woocommerce_page_wc-settings` (WooCommerce Settings)

*(Pro Tip: Leave blank or enter `*` to display the notice on all admin pages).*

---

### 2. Permissions (Roles or Usernames)
Specify who is authorized to view the notice:

**By System Roles:**
- `administrator` (Full control)
- `editor` (Editors)
- `author` (Authors)
- `contributor` (Contributors)
- `subscriber` (Subscribers)
- `*` or `all` (All logged-in users)

**By Specific Username:**
Enter the exact username (e.g. `victor` or `dev_agency`) so only that user can see the reminder.
