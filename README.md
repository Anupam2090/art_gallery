# 🎨 Anupam’s Art Space

Hi, I’m Anupam Bera — an artist at heart and a developer by passion.
From sketching with a simple pencil to experimenting with digital tools, I love bringing imagination to life through pencil, digital, watercolor, oil, and acrylic paintings. Every stroke I make is not just about colors and shapes, but about telling a story, capturing an emotion, and freezing a moment forever.

Alongside my love for art, I’m also a passionate developer. Creativity doesn’t just flow in my paintings — it also guides the way I design and build meaningful digital experiences. Whether it’s coding or painting, my aim is the same: to create something unique, thoughtful, and impactful.

This gallery is a reflection of my journey — where art meets technology, and where every piece carries a little part of me. I hope as you explore my works, you’ll find inspiration, connection, and maybe even a piece that speaks to your own story.

A simple yet professional **Art Gallery Website** Where Every Canvas Speaks a Thousand Words!, built with **PHP, MySQL, Bootstrap 5, and FontAwesome**.  
It allows you (Admin) to manage artworks, about info, and contact details, while users can explore the gallery, sign up, and interact.


## Quick Start

1. Create a MySQL database and user, or run the schema:
   - Import `schema.sql` into MySQL (it creates `art_gallery` DB and tables and seeds a default admin).
   - Default Admin: **admin@example.com / admin123**

2. Configure DB credentials:
   - Edit `config.php` with your MySQL host, username, password.

3. Run with XAMPP/WAMP:
   - Copy the whole `art_gallery` folder into your server root:
     - XAMPP: `C:/xampp/htdocs/`
     - WAMP:  `C:/wamp64/www/`
   - Visit: `http://localhost/art_gallery/`

4. File/Folder Permissions:
   - Ensure `uploads/` is writable by the web server (for image uploads).

## Pages

- Public:
  - `/index.php` — About Me + nav
  - `/gallery.php` — Gallery with search & filters, lightbox
  - `/login.php` — User login
  - `/signup.php` — User signup
  - `/logout.php` — User logout
  - `/contact.php` — Contact info

- Admin:
  - `/admin/index.php` — Admin login
  - `/admin/dashboard.php` — Overview
  - `/admin/manage_gallery.php` — Add/Edit/Delete artworks
  - `/admin/manage_about.php` — Edit About Me
  - `/admin/manage_contact.php` — Edit Contact info
  - `/admin/manage_admin.php` — Change admin email/password
  - `/admin/logout.php` — Admin logout

## Notes

- Passwords are hashed using bcrypt (`password_hash` in PHP compatible). 
- Images uploaded go to `/uploads/`.
- Bootstrap 5 and FontAwesome are loaded via CDN.
- Lightbox uses GLightbox (CDN).

Enjoy creating! 🎨
