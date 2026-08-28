[🇪🇸 Español](README.md) | 🇬🇧 English

---

# CF7 Redirect After Send 📧

This module redirects users to specific URLs or customized thank-you pages after a successful form submission in **Contact Form 7 (CF7)**, with multi-form support and customizable delay.

---

## 📖 Installation Guides

- 📋 **[How to Install as a Snippet (WPCode)](../README-SNIPPETS.en.md)**
- 🔌 **[How to Install as a WordPress Plugin](../README-PLUGINS.en.md)**

---

## ⚙️ How to Get the Form's Post ID in CF7

You need the **Post ID** of the Contact Form 7 post, which is different from any HTML form ID.

1. Go to your WordPress Admin dashboard and navigate to **Contact > Contact Forms**.
2. Click to edit your form.
3. Look at your browser address bar. You'll see a URL like:
   ```text
   yoursite.com/wp-admin/admin.php?page=wpcf7&post=1544&action=edit
   ```
4. The number in `post=1544` is the Form Post ID (in this example, `1544`).

---

## 🛠️ Snippet Configuration

Edit the variables inside `vk7k-wp-contact-form-7.php` (or in your WPCode editor):

```javascript
// 1. Redirection routes dictionary: 'Form_Post_ID': 'Target_URL'
const redirectRoutes = {
    '1544': 'https://yoursite.com/thank-you/',
    '2339': 'https://yoursite.com/registration-confirmed/'
};

// 2. Visual feedback message during redirection delay
const successMessageInnerText = '📧✔ Redirecting...';

// 3. Delay in seconds before navigating
const delayInSecondsAfterSent = 2;
```

---

## 🚀 Usage Options

1. **As a Snippet in WPCode:**
   - Code Type: **PHP Snippet** (using `vk7k-wp-contact-form-7.php`) or **JavaScript Snippet** (copying only the internal `<script>` content).
   - Location: **Frontend Only**.
2. **As a Plugin:**
   - Compress the `contact-form-7` folder into a `.zip` file and upload via **Plugins > Add New Plugin > Upload Plugin**.
