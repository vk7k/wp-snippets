[🇪🇸 Español](README.md) | 🇬🇧 English

---

# VK Lightbox 🖼️

Adds a responsive floating iframe lightbox for WordPress. It automatically binds to any anchor link containing the attribute `rel="vk7k-lightbox"`. Includes multi-item navigation buttons, top utility bar with a close button, and a loading spinner.

---

## 📖 Installation Guides

- 📋 **[How to Install as a Snippet (WPCode)](../README-SNIPPETS.en.md)**
- 🔌 **[How to Install as a WordPress Plugin](../README-PLUGINS.en.md)**

---

## ✨ Features

- **Attribute-Based Trigger:** Simply add `rel="vk7k-lightbox"` to any `<a>` tag.
- **Integrated Navigation:** If multiple lightbox links exist on the same page, "Previous" and "Next" buttons allow sequential navigation without closing the modal.
- **Iframe Container:** Easily display external sites, custom forms, or internal URLs inside a clean modal popup.
- **Dynamic Height Adjustment:** Automatically monitors iframe height and shows an animated spinner while loading.

---

## 🚀 Usage

Add links in your content, templates, or HTML blocks using `rel="vk7k-lightbox"`:

```html
<!-- Single link -->
<a href="https://example.com/form" rel="vk7k-lightbox">Open Form in Lightbox</a>

<!-- Gallery / sequence of links -->
<a href="https://example.com/step-1" rel="vk7k-lightbox">View Step 1</a>
<a href="https://example.com/step-2" rel="vk7k-lightbox">View Step 2</a>
```

---

## ⚙️ Installation Options

1. **As a Snippet in WPCode:**
   - Code Type: **PHP Snippet**.
   - Location: **Frontend Only**.
2. **As a Plugin:**
   - Compress the `vk-lightbox` folder into a `.zip` file and install via **Plugins > Add New Plugin > Upload Plugin**.
