[🇪🇸 Español](README.md) | 🇬🇧 English

---

# Justify Button for WordPress Block Editor (Gutenberg) 🔤

This PHP snippet and plugin adds a **Justify** button to the block toolbar for specific blocks (Paragraph and Heading) in the WordPress Gutenberg block editor. Unlike inline justify tools, this snippet works at the block level—similar to core Left, Center, and Right alignment controls.

Clicking the Justify button toggles the `has-text-align-justify` CSS class on the block element (`<p>`, `<h1>`, etc.) while removing conflicting alignment classes (`has-text-align-left`, `has-text-align-center`, `has-text-align-right`).

Created with ❤️ by Victor Mellado (vk7k) & Gemini.

---

## 📖 Installation Guides

- 📋 **[How to Install as a Snippet (WPCode)](../README-SNIPPETS.en.md)**
- 🔌 **[How to Install as a WordPress Plugin](../README-PLUGINS.en.md)**

---

## ✨ Features

* Adds a "Justify" button to the main block toolbar.
* Operates at block level (`has-text-align-justify` class on wrapper).
* Automatically removes conflicting text alignment classes upon justification.
* Injects required CSS for both editor and frontend views.
* Enabled by default for Paragraph (`core/paragraph`) and Heading (`core/heading`) blocks.

---

## ⚙️ Installation Options

1. **As a Snippet in WPCode:**
   - Code Type: **PHP Snippet**.
   - Location: **Run Everywhere** (to apply CSS and scripts in both admin editor and frontend).
   - Paste `vk7k-wp-justify-text.php` and activate.
2. **As a Plugin:**
   - Compress the `justify-text` folder into `.zip` and upload via **Plugins > Add New Plugin > Upload Plugin**.

---

## 🎯 How to Use

1. Edit a post or page in the Gutenberg block editor.
2. Select a Paragraph or Heading block.
3. Click the justify icon in the block toolbar.
4. Click it again to reset to default alignment.

---

## 🧩 Compatibility

* Compatible with WordPress 6.0+ and recent Gutenberg block editor releases.
* Configured for `core/paragraph` and `core/heading`. You can customize the `allowedBlocks` array in the code to include other blocks.
