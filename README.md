<h1>Laravel Livewire News Portal</h1>

<p>A feature-rich news portal CMS built with Laravel, Livewire, and TailwindCSS.
It comes with dynamic homepage builder, role-based access, SEO-friendly routes, and full news management system.</p>

<h2>✨ Features</h2>

<h3>🏠 Frontend</h3>
<p>Dynamic homepage builder with multiple layouts (lead sections, category grids, videos, photo news).

SEO-friendly news pages: /news/{slug} with print-ready PDF option.</p>

<h3>Browse by:</h3>

<ul>
  <li>Category /category/{slug}</li>
  <li>Subcategory /subcategory/{slug}</li>
  <li>Division, District, Upazila (regional browsing).</li>
  <li>News archive by date /archive/{date}.</li>
  <li>Search system /search.</li>
  <li>Photo news gallery /photo-news.</li>
  <li>Video section /videos.</li>
  <li>Custom pages (About, Terms, etc.) /page/{slug}.</li>
  <li>Author-wise news listing /all-news/user/{user}.</li>
  <li>Email subscriber verification + unsubscribe option.</li>
</ul>

<h3>🛠️ Admin Panel</h3>

<ul>
  <li>🔑 User Management: Users, roles, permissions.</li>
  <li>📰 News Management: Categories, sub-categories, tags, divisions, districts, upazilas.</li>
  <li>✍️ News CRUD: Create, edit, drafts, scheduled posts, trashed recovery.</li>
  <li>🖼️ Media: Photo news, videos, ads management.</li>
  <li>📑 Pages: Static page builder (About, Contact, etc.).</li>
  <li>🎨 Theme: Theme selector, color picker, homepage builder.</li>
  <h3>🧩 Homepage Builder:</h3>
  <ul>
    <li>Drag-and-drop section ordering.</li>
    <li>Multiple lead section designs.</li>
    <li>Section previews with images.</li>
  </ul>
  <li>📡 Site Settings: General info, connections, social links.</li>
  <li>📬 Newsletter system: Subscribers, bulk email sender.</li>
  <li>📊 Analytics: Dashboard + settings.</li>
  <h2>⚡ Utilities:</h2>
  <ul>
    <li>Clear cache button.</li>
    <li>Custom code editor.</li>
    <li>Advertisement placements.</li>
  </ul>
</ul>

<hr />

<h2>👤 Authentication</h2>
<ul>
  <li>Built-in user authentication (login, register).</li>
  <li>Email verification for subscribers.</li>
  <li>Role-based access (Admin, Editor, etc.).</li>
</ul>

<h2>🚀 Installation</h2>
<h4>1.Clone repo:</h4>
git clone https://github.com/yourusername/news-portal.git <br />
cd news-portal

<h4>2. Install dependencies:</h4>
composer install <br />
npm install && npm run build

<h4>3. Setup .env:</h4>

cp .env.example .env <br />
php artisan key:generate

<h4>4. Run migrations & seed:</h4>
php artisan migrate --seed

<h4>5. Start server:</h4>
php artisan serve

<h2>🖼️ Homepage Builder</h2>

<ul>
  <li>Drag & drop sections</li>
  <li>Choose different lead news layouts (visual preview images)</li>
  <li>Toggle on/off sections</li>
  <li>Fully dynamic & customizable</li>
</ul>

<h3>📜 License</h3>

MIT License
































