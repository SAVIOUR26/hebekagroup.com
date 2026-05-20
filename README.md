# hebekagroup.com — Coming Soon Page

A modern, animated "Coming Soon" landing page for **Hebeka Group**, built in PHP.  
Designed for FTP deployment on any standard PHP shared hosting.

---

## Features

- **Animated gradient background** — smooth shifting dark-purple palette
- **Floating bubble canvas** — GPU-friendly HTML5 Canvas particle animation
- **Glassmorphism card** — frosted-glass UI with backdrop blur
- **Live countdown timer** — JavaScript countdown to a configurable launch date
- **Development progress bar** — animated shimmer progress indicator
- **Email subscriber capture** — form appends emails to `subscribers.txt`
- **Font Awesome 6** — social media icons + UI icons (CDN)
- **Google Fonts** — Inter + Space Grotesk (CDN)
- **Fully responsive** — mobile-first, works on all screen sizes
- **Zero dependencies** — pure PHP, HTML, CSS, JS (no frameworks, no npm)

---

## File Structure

```
hebekagroup.com/
├── index.php          ← Main landing page
├── subscribers.txt    ← Auto-created; stores subscriber emails (one per line)
└── README.md
```

---

## Configuration

Open `index.php` and edit the variable at the top of the file:

```php
$launch_date = '2026-01-01 00:00:00';   // Change to your actual launch date
```

The progress bar percentage is set in CSS — search for `width: 35%` inside
`.progress-fill` and adjust as your build progresses.

---

## FTP Deployment

1. Purchase hosting with PHP support (PHP 7.4+ recommended).
2. Point your domain `hebekagroup.com` to the hosting nameservers.
3. Connect to your host via FTP (FileZilla, Cyberduck, etc.).
4. Upload **all files** to the `public_html` (or `www`) root directory.
5. Verify `index.php` is accessible at `https://hebekagroup.com`.

> **Note:** `subscribers.txt` is created automatically on the first form submission.  
> Ensure the web server user has **write permission** on the directory, or  
> pre-create the file and `chmod 664 subscribers.txt`.

---

## Upgrading Subscriber Storage

The default storage writes to a plain text file — fine for early signups.
When you're ready for a proper integration, replace the file-write block
in `index.php` with one of the following:

- **MySQL/MariaDB** — `PDO` insert into a `subscribers` table  
- **Mailchimp API** — `curl` POST to the Mailchimp Marketing API  
- **Brevo (Sendinblue)** — REST API subscriber add  
- **Custom mailer** — PHPMailer to forward each signup via SMTP  

---

## Social Media Links

The social icons at the bottom are placeholder `href="#"` links.  
Update them in `index.php` inside the `.socials` section:

```html
<a href="https://linkedin.com/company/hebekagroup" aria-label="LinkedIn">
<a href="https://twitter.com/hebekagroup"          aria-label="X / Twitter">
<a href="https://facebook.com/hebekagroup"         aria-label="Facebook">
```

---

## Browser Support

Chrome 88+, Firefox 87+, Safari 14+, Edge 88+  
(backdrop-filter requires these versions or later for glassmorphism effect)

---

## License

Proprietary — &copy; Hebeka Group. All rights reserved.
