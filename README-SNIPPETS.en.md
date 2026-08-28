[🇪🇸 Español](README-SNIPPETS.md) | 🇬🇧 English

---

# 📋 Guide: Installing as Snippets (WPCode)

All snippets in this repository are designed to be used directly through snippet manager plugins such as **WPCode (Code Snippets)**, **Code Snippets**, or by adding them to your child theme's `functions.php`.

---

## 🚀 Steps to Install in WPCode

1. **Install and activate WPCode:**
   - In your WordPress dashboard, navigate to **Plugins > Add New**.
   - Search for **WPCode – Insert Headers and Footers + Custom Code Snippets** and click Install/Activate.

2. **Create a new Snippet:**
   - Go to **Code Snippets > + Add Snippet**.
   - Select **"Add Your Custom Code (New Snippet)"** and click **"Use snippet"**.

3. **Configure Code Type:**
   - Give it a descriptive title (e.g. *VK7K - Admin Notes* or *VK7K - Lightbox*).
   - In the **Code Type** dropdown, select **PHP Snippet** (or **JavaScript Snippet** if only inserting client-side code).

4. **Copy and paste the code:**
   - Open the corresponding `.php` file in the snippet folder (e.g. `admin-notes/vk7k-wp-admin-notes.php`).
   - Copy the file contents and paste them into the WPCode code editor.

5. **Configure Insertion Location:**
   - **Auto Insert:**
     - **Location:** Choose where it should execute:
       - **Run Everywhere:** For snippets that affect both frontend and backend (e.g. `vk7k-wp-justify-text.php`, `vk7k-wp-admin-notes.php`).
       - **Frontend Only:** For visual or tracking snippets (e.g. `vk7k-wp-vk-lightbox.php`, `vk7k-wp-contact-form-7.php`).
       - **Admin Only:** For backend/admin-only tools.

6. **Activate and Save:**
   - Toggle the switch at the top right from **Inactive** to **Active**.
   - Click **Save Snippet**.

---

## ⚠️ Which code parts should you remove or adjust in WPCode?

### 1. Opening `<?php` Tag
- **WPCode manages `<?php` automatically in PHP mode:**
  - WPCode often shows a `<?php` badge outside the editable box.
  - **Recommendation:** When pasting, make sure you don't end up with duplicate opening tags (`<?php <?php`). If your WPCode instance already enforces `<?php`, remove the initial `<?php` or paste starting from the comment block.

### 2. Plugin Header (`/* Plugin Name: ... */`)
- The metadata lines (`Plugin Name:`, `Version:`, `Author:`, etc.) are intended for WordPress plugin discovery.
- **Should you delete them?** Not necessary. Inside the `/** ... */` PHP docblock comment, PHP ignores them. You can keep them for reference or delete them for a cleaner snippet.

### 3. Direct Access Guard `defined( 'ABSPATH' ) || exit;`
- This security line prevents unauthorized direct web access to the PHP file.
- **Should you delete it?** **No.** Inside WordPress and WPCode, `ABSPATH` is always defined. Leave it intact.

### 4. Custom Configuration Variables
Some snippets require setting configuration values before activating:

- **Meta CAPI WooCommerce (`vk7k-wp-meta-capi-woocommerce.php`):**
  - Replace `$access_token = 'TU_META_ACCESS_TOKEN_AQUI';` with your Meta Conversion API Token.
  - Replace `$pixel_id = 'TU_PIXEL_ID_AQUI';` with your Pixel / Dataset ID.
- **Contact Form 7 Redirect (`vk7k-wp-contact-form-7.php`):**
  - Adjust the `redirectRoutes` object with your form IDs and destination URLs.
- **Varnish Clear Cache (`vk7k-wp-varnish-clear-cache.php`):**
  - Configure the Varnish server IP and port (defaults to `127.0.0.1:6081`) via Settings or directly in code.

---

## 🔌 Prefer to install as a Plugin?
If you'd like to package and manage it from **Plugins > Installed Plugins**, check the guide:
👉 [How to Install as a WordPress Plugin](README-PLUGINS.en.md)
