[🇪🇸 Español](README.md) | 🇬🇧 English

---

# Meta CAPI for WooCommerce 📊

Captures Meta tracking parameters (`_fbp`, `_fbc`, IP address, and User Agent) during WooCommerce checkout and sends the **Purchase** event directly server-to-server to Meta's **Conversions API (CAPI)** when orders transition to completed (`woocommerce_order_status_completed`).

---

## 📖 Installation Guides

- 📋 **[How to Install as a Snippet (WPCode)](../README-SNIPPETS.en.md)**
- 🔌 **[How to Install as a WordPress Plugin](../README-PLUGINS.en.md)**

---

## ✨ Features

1. **Checkout Tracking Data Capture:**
   - Reads `_fbp` (Facebook Browser ID) and `_fbc` (Facebook Click ID).
   - Stores customer IP and User Agent in order metadata (`_meta_fbp`, `_meta_fbc`, `_meta_client_ip`, `_meta_client_ua`).
2. **Server-Side Conversions API (CAPI):**
   - Triggers upon order completion (`woocommerce_order_status_completed`).
   - Normalizes and hashes customer PII (email, phone, first name, last name) with SHA-256.
   - Includes event deduplication using `event_id: 'woo_{order_id}'`.
   - Prevents duplicate dispatches with `_meta_capi_sent` flag.
   - Ignores test orders containing `+test` in the email address.
3. **Audit Log System:**
   - Logs events and Meta API response codes to `wp-content/uploads/meta-capi-woo.log`.

---

## 🛠️ Required Configuration

Before activating, edit `vk7k-wp-meta-capi-woocommerce.php` and fill in your Meta credentials:

```php
$access_token = 'YOUR_META_ACCESS_TOKEN_HERE'; // Meta Events Manager Access Token
$pixel_id     = 'YOUR_PIXEL_ID_HERE';          // Meta Pixel / Dataset ID
```

---

## ⚙️ Installation Options

1. **As a Snippet in WPCode:**
   - Code Type: **PHP Snippet**.
   - Location: **Run Everywhere**.
2. **As a Plugin:**
   - Compress the `meta-capi-woocommerce` folder into `.zip` and upload via **Plugins > Add New Plugin > Upload Plugin**.
