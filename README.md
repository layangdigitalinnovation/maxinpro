# MaxinPro — Website Properti (Laravel + MySQL)

> **Status terkini:** proyek sudah melewati beberapa putaran pengembangan (login &
> panel admin/agen, SEO, 2FA, optimasi gambar, dashboard analitik, hingga fitur
> "Proyek Baru" dengan urutan prioritas). **Mulai dari checklist konsolidasi di bawah**,
> baru masuk ke bab-bab detail kalau butuh penjelasan lebih dalam soal satu fitur tertentu.

Overlay aplikasi untuk **maxinpro.com**, dibangun berdasarkan `Maxinpro_website_review.zip`
(design handoff: Header/Footer/Home/Listing/Project/TitipProperti/KPR/About).

> **Penting:** Folder ini bukan instalasi Laravel yang lengkap (tidak ada `vendor/`,
> `bootstrap/`, atau file inti framework lain) — ini adalah **overlay berisi kode
> aplikasi** (migrations, models, controllers, views, routes, config, docker).
> Sandbox tempat saya bekerja tidak punya akses ke `packagist.org`, sehingga saya
> tidak bisa menjalankan `composer install` di sini untuk memverifikasi build end-to-end.
> Ikuti langkah di bawah ini di komputer/servermu sendiri.

## Arsitektur (ringkas)

- **Monolith modular Laravel** — cukup untuk trafik marketplace properti regional,
  jauh lebih murah dioperasikan & lebih cepat dikembangkan dibanding microservices.
- **Blade + Tailwind CSS** (bukan SPA/Livewire) — sesuai rekomendasi design handoff;
  lebih ringan, SEO-friendly (server-rendered), tanpa kompleksitas state management.
- **MySQL 8** sebagai satu-satunya sumber data (relational, cocok untuk listing/filter).
- **Tanpa admin-panel package berat** (Filament dll) di fase ini — CRUD admin bisa
  ditambahkan sebagai fase berikutnya begitu prioritas fitur back-office jelas
  (lihat "Langkah Berikutnya"). Untuk saat ini data dikelola lewat seeder/tinker
  atau langsung di database.

## Skema Database (ER, ringkas)

```
property_types ─┐                    developers ─┐
                 ├─< listings         areas ──────┼─< projects >── project_images
areas ───────────┘        └─< listing_images      developers ─┘
agents ──< listings

articles (mandiri)         testimonials (mandiri)         partner_banks (mandiri)
leads (mandiri, FK opsional ke property_types)
users ──< saved_listings >── listings
```

Lihat file di `database/migrations/` untuk DDL lengkap (kolom, tipe data, index,
foreign key, soft delete pada `listings` & `projects`).

---

## 📋 CHECKLIST UNTUK TIM — WAJIB DIJALANKAN SETELAH SETIAP UPDATE BUILD

Ringkasan semua langkah wajib dari seluruh bab di bawah, dikumpulkan di satu tempat.
Jalankan urut dari atas ke bawah setelah menarik/mengganti kode ke versi ini.

### Sekali saja (setup awal proyek)
- [ ] `composer create-project laravel/laravel` lalu salin isi overlay ini (lihat Bab 1)
- [ ] `composer install` && `npm install`
- [ ] Salin `.env.example` → `.env`, isi `DB_*`, `MAIL_*`, `APP_URL=https://maxinpro.com`
- [ ] `php artisan key:generate`
- [ ] Daftarkan middleware alias `role` di `bootstrap/app.php` (lihat Bab 6) — **tanpa ini situs tidak akan jalan sama sekali**
- [ ] (Opsional) Tambahkan blok `recaptcha` di `config/services.php` (lihat Bab 7)

### Setiap kali menarik update kode baru (rutin)
- [ ] `composer install` ulang (dependency baru ditambahkan beberapa kali: `guzzlehttp/guzzle`, `pragmarx/google2fa`, `intervention/image`)
- [ ] `php artisan migrate` (banyak migration baru ditambahkan sepanjang Fase 2–8)
- [ ] `php artisan storage:link` (kalau belum pernah / kalau server baru)
- [ ] **`docker compose build` ulang, bukan cuma restart** — Dockerfile berubah untuk dukungan WebP (Bab 10)
- [ ] `npm run build` (kalau ada perubahan CSS/JS)
- [ ] `php artisan test` — **jalankan ini di mesin kalian sendiri**, karena semua QA yang saya lakukan bersifat analisis statis (baca kode), bukan eksekusi nyata — sandbox saya tidak punya PHP

### Sebelum go-live production
- [ ] Ganti SEMUA password akun contoh dari seeder (admin & 3 agen — lihat Bab 6)
- [ ] Ganti nomor WhatsApp bisnis `6281112345678` yang tersebar di banyak file (cari-ganti global)
- [ ] Ganti `public/images/og-default.jpg` (masih placeholder) dan semua foto listing/project contoh
- [ ] `APP_ENV=production`, `APP_DEBUG=false`
- [ ] HTTPS aktif + `SESSION_SECURE_COOKIE=true`
- [ ] Isi data JSON-LD (`resources/views/layouts/app.blade.php`) dengan alamat & telepon resmi (Bab 8)
- [ ] Daftarkan `sitemap.xml` ke Google Search Console
- [ ] Setidaknya ada **2 akun admin aktif** (jaga-jaga jika satu akun terkunci 2FA — lihat Bab 11)
- [ ] Atur urutan tampil di `/admin/projects-order` untuk pertama kali (Bab 13)

Detail & alasan teknis tiap poin ada di bab-bab di bawah ini.

---

## 1. Setup Awal (sekali saja)

```bash
# 1. Buat proyek Laravel 11 baru
composer create-project laravel/laravel maxinpro-app "11.*"
cd maxinpro-app

# 2. Salin/timpa seluruh isi overlay ini ke dalam folder proyek
#    (app/, database/, resources/, routes/web.php, public/images, public/favicon.png,
#     composer.json, .env.example, Dockerfile, docker-compose.yml, docker/, tests/, .github/)
cp -r ../maxinpro-overlay/{app,database,resources,routes,public,tests,.github} .
cp ../maxinpro-overlay/{composer.json,.env.example,Dockerfile,docker-compose.yml,.dockerignore,tailwind.config.js,postcss.config.js,vite.config.js} .

# 3. Install dependencies
composer install
npm install

# 4. Konfigurasi environment
cp .env.example .env
php artisan key:generate
# Edit .env: isi DB_DATABASE, DB_USERNAME, DB_PASSWORD sesuai MySQL lokal/servermu

# 5. Migrasi + data contoh (data seeder ditandai sebagai PLACEHOLDER, ganti sebelum production)
php artisan migrate --seed

# 6. Storage symlink (untuk upload gambar listing/project via storage/app/public)
php artisan storage:link

# 7. Build asset frontend
npm run build   # atau `npm run dev` untuk mode pengembangan (hot reload)

# 8. Jalankan
php artisan serve
```

Buka `http://127.0.0.1:8000`.

**Akun admin contoh (seeder):** `admin@maxinpro.com` / `ChangeThisPassword123!`
— **wajib diganti** sebelum production (belum ada halaman login di fase ini;
password hash sudah dibuat sebagai fondasi untuk auth admin di fase berikutnya).

## 2. Menjalankan dengan Docker (opsional, cara paling konsisten)

```bash
cp .env.example .env
# edit .env: DB_HOST=mysql, isi DB_DATABASE/DB_USERNAME/DB_PASSWORD

docker compose build
docker compose up -d
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
```

Website tersedia di `http://localhost`. Stack terdiri dari: `app` (PHP-FPM 8.3),
`nginx`, `mysql:8.4`, dan `queue` (worker background job).

## 3. Checklist Pra-Produksi

- [ ] Ganti seluruh data seeder (listing, project, artikel, testimoni, foto) dengan data & foto asli berlisensi
- [ ] Ganti password akun admin default & (setelah fase auth ditambahkan) aktifkan 2FA
- [ ] `APP_ENV=production`, `APP_DEBUG=false` di `.env`
- [ ] `APP_KEY` di-generate ulang khusus untuk environment production (jangan pakai `.env` dev)
- [ ] HTTPS aktif (Let's Encrypt via certbot, atau SSL dari provider hosting) + `SESSION_SECURE_COOKIE=true`
- [ ] Jalankan `php artisan config:cache route:cache view:cache` setelah setiap deploy
- [ ] Backup database terjadwal (mysqldump harian minimum) + backup folder `storage/app/public`
- [ ] Nomor WhatsApp (`https://wa.me/6281112345678`) di semua view diganti ke nomor resmi MaxinPro
- [ ] Endpoint `/up` dipantau oleh uptime monitor (UptimeRobot/BetterStack/dst.)
- [ ] Rate limit `titip-properti.store` (`throttle:5,1`) dan pertimbangkan tambah CAPTCHA (hCaptcha/Turnstile) jika terjadi spam

## 4. Opsi Hosting

| Opsi | Cocok untuk |
|---|---|
| **VPS (DigitalOcean/Vultr/Biznet) + Docker Compose** | Kontrol penuh, biaya lebih murah untuk trafik menengah, cocok karena stack ini sudah di-dockerize |
| **Laravel Forge + VPS** | Kalau tim ingin zero-devops (Forge urus Nginx/PHP/deploy/SSL otomatis) |
| **Railway / Render** | Paling cepat untuk staging/demo, kurang ideal untuk kontrol biaya jangka panjang |

Untuk `maxinpro.com`: arahkan A record domain ke IP VPS/load balancer, lalu jalankan
`certbot --nginx -d maxinpro.com -d www.maxinpro.com` (jika tidak pakai Docker nginx bawaan)
atau gunakan reverse proxy seperti Caddy/Traefik yang otomatis mengurus TLS.

## 5. Keamanan yang Sudah Diterapkan

- Validasi input server-side lengkap di setiap form (`StoreTitipPropertiRequest`, query listing)
- Eloquent/Query Builder di semua akses data → aman dari SQL injection (tidak ada raw query)
- Blade `{{ }}` meng-escape semua output → aman dari XSS
- CSRF token otomatis di setiap form (`@csrf`)
- Rate limiting pada form submission publik (anti-spam dasar)
- Password di-hash otomatis (`'password' => 'hashed'` cast, bcrypt)
- Soft delete pada `listings`/`projects` agar data tidak hilang permanen secara tidak sengaja
- `.env` terpisah dari kode (secret tidak pernah masuk repo)

## 6. Fase 2 — Login, Panel Admin & Panel Agen

Dibangun **custom (Blade + auth manual, tanpa Filament/Breeze package)** sesuai keputusan:
lebih ringan, tanpa dependency tambahan, kontrol penuh atas alur admin/agen.

### Langkah tambahan wajib setelah migrate

**1. Daftarkan middleware alias `role`** — edit `bootstrap/app.php` bawaan Laravel,
tambahkan di dalam `->withMiddleware(function (Middleware $middleware) { ... })`:

```php
$middleware->alias([
    'role' => \App\Http\Middleware\EnsureUserHasRole::class,
]);
```

Tanpa baris ini, route yang memakai `middleware(['auth', 'role:admin'])` akan error
"Target class [role] does not exist."

**2. `php artisan storage:link`** — wajib supaya foto listing/project ter-upload bisa diakses publik.

### Apa yang bisa dilakukan tiap role

| Role | Bisa akses |
|---|---|
| **Admin** (`/admin/...`) | Dashboard, CRUD Listing (semua), CRUD Project, kelola status Leads, CRUD Agen (buat akun login agen baru), CRUD Area, CRUD Developer |
| **Agen** (`/agent/...`) | Dashboard (statistik listing miliknya), CRUD Listing **miliknya sendiri saja** — dijamin di level controller (`agent_id` di-force dari sesi login, bukan dari input form), agen tidak bisa lihat/edit/hapus listing agen lain |

Agen **tidak bisa** publik mendaftar sendiri — akun dibuat oleh admin lewat
`/admin/agents/create`, sistem generate password sementara acak yang ditampilkan
sekali ke admin untuk dibagikan secara aman ke agen (agen sebaiknya diminta ganti
password setelah login pertama — fitur ganti password ada di daftar Fase 3).

### Akun contoh dari seeder

| Role | Email | Password |
|---|---|---|
| Admin | `admin@maxinpro.com` | `ChangeThisPassword123!` |
| Agen | `dedi.agent@maxinpro.com` | `ChangeThisPassword123!` |
| Agen | `sari.agent@maxinpro.com` | `ChangeThisPassword123!` |
| Agen | `budi.agent@maxinpro.com` | `ChangeThisPassword123!` |

**Wajib diganti sebelum production.**

### Keamanan tambahan Fase 2

- Login dibatasi rate limit (5x percobaan gagal → lockout sementara, per email+IP)
- Route admin/agen diproteksi middleware `auth` + `role:xxx` — bukan sekadar disembunyikan di UI
- Agen tidak bisa mengubah `agent_id` (kepemilikan), `is_featured`, atau menyembunyikan listing (`status: hidden` khusus moderasi admin) — dicegah di server, bukan cuma disembunyikan di form
- Upload foto divalidasi (`image`, maksimal 2MB) sebelum disimpan ke `storage/app/public`
- Test otomatis (`tests/Feature/RoleAccessTest.php`) memverifikasi agen tidak bisa mengakses dashboard admin maupun listing agen lain

## 7. Fase 3 — Artikel/Testimoni/Bank/Tipe CRUD, Ganti & Lupa Password, Registrasi Customer, Favorit, reCAPTCHA, Notifikasi Lead

### Langkah tambahan wajib

**1. (Opsional) Aktifkan reCAPTCHA** — tambahkan ke `config/services.php` (file bawaan Laravel, bukan bagian overlay ini):

```php
'recaptcha' => [
    'site_key' => env('RECAPTCHA_SITE_KEY'),
    'secret_key' => env('RECAPTCHA_SECRET_KEY'),
],
```

Lalu isi `RECAPTCHA_SITE_KEY` dan `RECAPTCHA_SECRET_KEY` di `.env` (dapatkan di
https://www.google.com/recaptcha/admin, pilih reCAPTCHA v2 "checkbox"). Jika dikosongkan,
form Titip Properti tetap berfungsi normal tanpa captcha (tidak akan error).

**2. Konfigurasi mail** — isi `MAIL_MAILER`, `MAIL_HOST`, dll di `.env` supaya dua hal ini berjalan:
- Email "lupa password" terkirim
- Notifikasi lead baru terkirim ke semua akun admin

Karena notifikasi lead memakai `ShouldQueue`, pastikan `queue:work` berjalan (sudah
otomatis lewat service `queue` di `docker-compose.yml`; kalau jalan manual pakai
`php artisan queue:work`).

**3. `composer install` ulang** — Fase 3 menambah dependency `guzzlehttp/guzzle`
(dipakai untuk memverifikasi reCAPTCHA ke server Google).

### Fitur baru per role

| Siapa | Bisa apa |
|---|---|
| **Admin** | + CRUD Tipe Properti, Artikel (draft/terbit), Testimoni, Bank Rekanan |
| **Semua yang login** | Ganti password sendiri di halaman "Ganti Kata Sandi" |
| **Siapa saja (guest)** | Bisa daftar akun sendiri (`/register`) — **selalu jadi role `customer`**, tidak bisa dijadikan admin/agen lewat form ini walau field `role` disisipkan paksa ke request (dipaksa server-side, ada test-nya) |
| **Customer** | Simpan/hapus properti favorit (tombol ♡ di kartu & halaman detail listing), lihat daftar di "Favorit Saya" |
| **Siapa saja yang lupa password** | `/forgot-password` → email reset (link berlaku sesuai `config('auth.passwords')`, default 60 menit) |

### Keamanan tambahan Fase 3

- Registrasi customer memvalidasi & **mengabaikan** field `role` dari input — role selalu di-set `'customer'` di controller, tidak pernah dari request
- Reset password memberi respons yang sama persis baik email terdaftar maupun tidak (`Password::sendResetLink`), mencegah enumerasi akun terdaftar
- Ganti password mewajibkan `current_password` valid (bukan hanya token sesi) sebelum bisa ganti
- Toggle simpan/favorit di-scope ke `user_id` dari sesi login — tidak menerima `user_id` dari request
- reCAPTCHA diverifikasi di server (`siteverify`), bukan hanya validasi di JS/browser
- Notifikasi lead di-*queue* — kalau SMTP lambat/down, submit form Titip Properti pengunjung tidak ikut lambat/gagal

## 8. SEO — apa yang sudah diterapkan

Hasil audit + perbaikan SEO menyeluruh (Juli 2026).

### Technical SEO

| Item | Implementasi |
|---|---|
| **Canonical URL** | Otomatis di semua halaman (`url()->current()`, tanpa query string) sehingga URL berfilter tidak jadi duplicate content |
| **Open Graph** | `og:title`, `og:description`, `og:image` (1200×630), `og:type`, `og:locale=id_ID` — tampilan link rapi saat dibagikan di WhatsApp/Facebook/LinkedIn |
| **Twitter Card** | `summary_large_image` |
| **robots meta** | `index, follow, max-image-preview:large` di halaman publik; **`noindex, nofollow`** di `/admin`, `/agent`, `/account`, dan semua halaman auth |
| **`robots.txt`** | Memblokir panel internal + URL berfilter (`?sort=`, `?type=`, dll), menunjuk ke sitemap |
| **`sitemap.xml`** | **Dinamis** (`SitemapController`) — otomatis memuat listing aktif, project terbit, dan artikel terbit; draft & listing tersembunyi otomatis dikecualikan |
| **Paginasi** | Halaman 2+ pakai canonical mandiri + `noindex, follow` — crawler tetap menelusuri link listing di dalamnya, tapi halaman paginasi yang tipis tidak bersaing di hasil pencarian |
| **Bahasa** | `<html lang="id">` + `og:locale=id_ID` |

### Structured data (JSON-LD)

| Halaman | Schema |
|---|---|
| Semua halaman | `RealEstateAgent` (nama, logo, kontak, alamat, `areaServed`) |
| Detail listing | `Accommodation` + `Offer` (harga, mata uang IDR, ketersediaan `InStock`/`SoldOut`, jumlah kamar, luas bangunan, alamat) + `BreadcrumbList` |
| Detail project | `Residence` + `BreadcrumbList` |
| Detail artikel | `BlogPosting` (headline, tanggal terbit/ubah, penulis, publisher) + `BreadcrumbList` |

### On-page SEO

- **Meta description unik** di setiap halaman (sebelumnya 8 dari 10 halaman memakai deskripsi generik yang sama — penalti duplicate description)
- **Judul halaman deskriptif berbasis kata kunci**, mis. detail listing jadi `"{judul} — {area} | MaxinPro"`, bukan sekadar nama properti
- **Tepat satu `<h1>` per halaman** (sudah diverifikasi otomatis di seluruh 10 halaman publik)
- **Semua `<img>` punya `alt`** (sudah diverifikasi otomatis)
- **`<time datetime>`** semantik untuk tanggal artikel
- **Skip-to-content link** + `<main id="main-content">` — aksesibilitas, yang juga jadi faktor ranking
- **`loading="lazy"`** pada gambar kartu listing/project
- **`preconnect`** ke Google Fonts untuk mempercepat render (Core Web Vitals)

### Yang WAJIB kamu lakukan sendiri sebelum launch

1. **Ganti `public/images/og-default.jpg`** — saat ini masih placeholder polos. Buat banner 1200×630 asli dengan logo + tagline.
2. **Set `APP_URL=https://maxinpro.com`** di `.env` — semua canonical, OG URL, dan sitemap dibangun dari sini. Kalau salah, seluruh SEO ikut salah.
3. **Daftarkan sitemap** di Google Search Console (`https://maxinpro.com/sitemap.xml`) dan Bing Webmaster Tools.
4. **Ganti nomor telepon & alamat** di JSON-LD `RealEstateAgent` (`resources/views/layouts/app.blade.php`) dengan data resmi MaxinPro — data palsu di structured data bisa kena penalti.
5. **Isi deskripsi asli** untuk setiap listing/project. Deskripsi kosong membuat meta description jatuh ke teks generik hasil generate — lemah untuk ranking.
6. **Validasi structured data** di https://search.google.com/test/rich-results setelah live.
7. **Pasang HTTPS + redirect www → non-www** (atau sebaliknya) agar tidak ada dua versi situs yang bersaing.

### Catatan jujur soal batasan

- Saya **tidak bisa menjalankan Lighthouse / PageSpeed** dari sandbox ini, jadi skor Core Web Vitals belum terukur. Ukur sendiri setelah deploy.
- Halaman listing berfilter sengaja di-`Disallow` di `robots.txt`. Kalau nanti kamu ingin menargetkan kata kunci seperti "rumah dijual BSD 3 kamar", pendekatan yang benar adalah membuat **landing page statis per area/tipe** (mis. `/rumah-dijual/bsd-city`) dengan konten unik — bukan mengandalkan URL berparameter. Itu pekerjaan Fase 4.
- Belum ada `hreflang` karena situs ini masih satu bahasa (Indonesia).


## 9. Fase 4 — Audit Log, Verifikasi Email, Landing Page SEO, Galeri, Export, Restore, 2FA

### Langkah tambahan wajib

**1. `composer install` ulang** — Fase 4 menambah dependency `pragmarx/google2fa` (murni PHP,
tanpa SMS/API eksternal berbayar — sesuai keputusan menggunakan TOTP, bukan OTP SMS).

**2. Jalankan migrasi baru** — `php artisan migrate` akan menambah tabel `audit_logs`
dan kolom 2FA (`two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`) di `users`.

**3. Tidak ada langkah manual lain** — verifikasi email & landing page area otomatis aktif.

### Fitur baru

| Fitur | Ringkasan |
|---|---|
| **Audit log** | Setiap create/update/delete pada Listing & Project otomatis tercatat (siapa, kapan, field apa yang berubah). Lihat di `/admin/audit-logs` |
| **Verifikasi email** | Customer wajib verifikasi email sebelum bisa menyimpan favorit. Akun admin/agen yang dibuat admin **otomatis terverifikasi** (tidak pernah menerima email verifikasi — dianggap tepercaya sejak dibuat) |
| **Landing page SEO per area** | `/properti/{area}` dan `/properti/{area}/{tipe}` — menggantikan URL berfilter yang di-`Disallow` di robots.txt. Otomatis masuk sitemap, tapi HANYA untuk kombinasi yang punya listing aktif (tidak membuang crawl budget ke halaman kosong) |
| **Galeri multi-gambar** | Admin bisa upload beberapa foto sekaligus untuk listing/project, dan menghapus foto tertentu lewat centang. Semua foto galeri otomatis masuk ke `image` di structured data (`Accommodation` schema) |
| **Export leads ke CSV** | Tombol di `/admin/leads` — file di-stream (bukan dibangun penuh di memori), aman untuk data besar; sudah termasuk BOM UTF-8 agar teks Indonesia tampil benar di Excel |
| **Restore & hapus permanen** | `/admin/listings-trashed` dan `/admin/projects-trashed` — listing/project yang di-soft-delete bisa dipulihkan; foto fisik baru benar-benar dihapus saat "Hapus Permanen" ditekan, bukan saat soft-delete biasa |
| **2FA (TOTP)** | Verifikasi dua langkah pakai aplikasi authenticator (Google Authenticator/Authy/Microsoft Authenticator) — **gratis, tanpa SMS/pulsa**, bekerja offline setelah setup awal. Aktifkan di menu "Verifikasi Dua Langkah" (tersedia untuk semua role yang login, tapi ditujukan terutama untuk admin) |

### Cara kerja 2FA (penting untuk dipahami)

1. Buka menu "Verifikasi Dua Langkah" → QR code otomatis dibuat
2. Scan dengan aplikasi authenticator apa pun yang support standar TOTP (semua app populer support ini)
3. Masukkan kode 6 digit yang muncul untuk mengonfirmasi & mengaktifkan
4. **8 kode pemulihan sekali-pakai ditampilkan SATU KALI saat itu juga** — wajib disimpan di tempat aman. Kode ini penyelamat kalau HP hilang/rusak dan authenticator app tidak bisa diakses
5. Login berikutnya: setelah email+password benar, diarahkan ke halaman kode 6 digit sebelum benar-benar masuk ke dashboard

**Kalau lupa/hilang HP dan kode pemulihan juga hilang**: satu-satunya jalan adalah admin lain (atau developer, lewat `php artisan tinker`) menjalankan `User::find($id)->disableTwoFactor()` langsung di server. Tidak ada cara "lupa 2FA" via UI — ini memang sifat 2FA yang aman, tapi pastikan setidaknya 2 akun admin exists supaya tidak saling mengunci diri sendiri keluar.

### Keamanan tambahan Fase 4

- Sesi login TIDAK pernah dianggap selesai sampai kode 2FA benar dikonfirmasi — kredensial benar tapi 2FA salah = tetap `guest`, tidak bisa akses halaman admin sama sekali (ada test khusus untuk ini: `TwoFactorTest::test_login_is_rejected_without_completing_2fa_challenge`)
- Rate limit di langkah 2FA (5x percobaan/menit) mencegah brute-force kode 6 digit
- Kode pemulihan sekali pakai — otomatis terhapus dari daftar setelah dipakai
- Secret 2FA & kode pemulihan dienkripsi di database (`encrypted` cast) — bahkan kalau database bocor, tidak langsung bisa dipakai menembus 2FA
- Menonaktifkan 2FA wajib konfirmasi password saat ini (bukan cuma klik tombol)
- Audit log mencatat `user_id` dari sesi yang aktif — kalau `null`, berarti dilakukan sistem/seeder, bukan manusia
- Restore/hapus permanen dibatasi role `admin` (sudah ada test `Phase4FeaturesTest::test_agent_cannot_access_trashed_listings_or_audit_log`)

## 10. Optimasi Gambar Otomatis (Resize + WebP)

Semua upload foto (cover listing/project, galeri, foto testimoni, cover artikel) sekarang
otomatis **di-resize dan dikonversi ke WebP** lewat `App\Services\ImageUploadService`,
tanpa perlu tindakan tambahan dari admin/agen — mereka tetap upload JPG/PNG seperti biasa,
konversi terjadi otomatis di server.

### Langkah tambahan wajib

**1. `composer install` ulang** — menambah dependency `intervention/image` (^3.5).

**2. `docker compose build` ulang (bukan cuma restart)** — Dockerfile sudah diperbarui:
menambah `libwebp-dev` dan flag `--with-webp` saat compile extension GD. Instalasi non-Docker
harus memastikan GD di-compile dengan dukungan WebP juga (`php -i | grep -i webp` untuk cek).

### Ukuran & kualitas yang dipakai

| Jenis foto | Lebar maksimum | Kualitas WebP |
|---|---|---|
| Cover listing/project | 1600px | 82 |
| Galeri listing/project | 1400px | 82 |
| Cover artikel | 1600px | 82 |
| Foto testimoni | 400px | 82 |

Foto yang lebih kecil dari lebar maksimum **tidak diperbesar** (pakai `scaleDown`, bukan `scale`)
— memperbesar foto kecil cuma menambah ukuran file tanpa menambah detail asli.

### Kenapa ini penting

- Foto HP modern seringkali 3-12 MB per file dalam format JPG — setelah resize+WebP, biasanya turun jadi 100-400 KB tanpa penurunan kualitas visual yang terlihat
- Dampak langsung ke Core Web Vitals (LCP - Largest Contentful Paint), yang jadi salah satu faktor ranking Google
- Menghemat storage & bandwidth server secara signifikan seiring bertambahnya jumlah listing

### Catatan jujur

- Saya **tidak bisa menguji hasil kompresi visual secara langsung** di sandbox ini (tidak ada PHP/GD di sini) — jalankan `php artisan test --filter=ImageUploadServiceTest` di mesinmu untuk verifikasi, dan cek beberapa hasil upload secara visual sebelum go-live
- Kalau server production ternyata tidak bisa compile GD dengan WebP (jarang terjadi, tapi mungkin di beberapa shared hosting lama), `ImageManager::gd()` bisa diganti ke `ImageManager::imagick()` di `ImageUploadService` — asalkan extension Imagick tersedia dan sudah dicompile dengan dukungan WebP

## 11. Fase 6 — Remember Me, Audit Log Lebih Rapi, Reset Darurat 2FA, Konversi Foto Lama

> ### ⚠️ Bug kritis yang ditemukan & diperbaiki saat mengerjakan fase ini
>
> `User` model men-*declare* `implements MustVerifyEmail` (interface) sejak Fase 4, tapi
> **tidak pernah memakai trait `Illuminate\Auth\MustVerifyEmail`** yang menyediakan isi
> method-nya (`hasVerifiedEmail()`, `markEmailAsVerified()`, dll). Interface di PHP hanya
> kontrak kosong — tanpa trait itu, class `User` gagal di-compile sama sekali dan
> **seluruh aplikasi akan fatal error di setiap request**, karena `User` dipakai di mana-mana
> (auth, session, dsb). Ini lolos sebelumnya karena sandbox saya tidak punya PHP untuk
> mencoba benar-benar me-load class tersebut. Sudah diperbaiki di `app/Models/User.php`
> — **wajib** `composer install` ulang & langsung tes login setelah update ke versi ini.

### Fitur baru

| Fitur | Ringkasan |
|---|---|
| **Remember Me** | Checkbox di form login — sesi tidak langsung expired saat browser ditutup. Diteruskan dengan benar bahkan lewat alur 2FA (dites di `Phase6FeaturesTest`) |
| **Rate limit setup 2FA** | `/account/two-factor/enable`, `/disable`, `/regenerate` sekarang dibatasi 10x/menit — sebelumnya cuma dilindungi `auth` |
| **Reset darurat 2FA** | Untuk yang kehilangan HP authenticator DAN kode pemulihan sekaligus — link "Kehilangan akses?" di halaman challenge login, kirim tautan bertanda-tangan (signed URL) berlaku 30 menit ke email terdaftar |
| **Audit log lebih rapi** | Nama field diterjemahkan ke Bahasa Indonesia (`price` → "Harga"), harga diformat Rupiah, boolean jadi Ya/Tidak, plus kolom pencarian berdasarkan nama listing/project |
| **Konversi foto lama** | `php artisan images:optimize-legacy` — mengonversi foto yang diupload SEBELUM fitur WebP aktif (Fase 5). Aman dijalankan berulang kali, otomatis skip file yang sudah `.webp` |

### Cara kerja reset darurat 2FA (penting dipahami trade-off-nya)

Fitur ini menukar "sesuatu yang Anda punya" (authenticator app) dengan "akses ke inbox email
terdaftar" sebagai faktor kedua. Ini pola yang umum dipakai banyak layanan untuk skenario
"kehilangan HP", tapi konsekuensinya: **kalau email akun juga diretas, 2FA bisa dinonaktifkan
orang lain**. Mitigasi yang sudah diterapkan:

- Link bertanda-tangan (signed URL), kedaluwarsa 30 menit, sekali pakai
- Rate limit ketat (5x/menit) di endpoint permintaan reset
- **Email konfirmasi otomatis terkirim ke pemilik akun begitu 2FA benar-benar dinonaktifkan** —
  kalau itu bukan pemilik asli yang minta, mereka langsung tahu dan bisa segera amankan akun
- Respons yang identik baik email terdaftar/tidak, dan baik 2FA aktif/tidak — mencegah orang
  luar menebak-nebak akun mana yang punya 2FA aktif

### Menjalankan konversi foto lama

```bash
# Lihat dulu apa yang akan diubah, tanpa benar-benar mengubah apa pun:
php artisan images:optimize-legacy --dry-run

# Jalankan sungguhan:
php artisan images:optimize-legacy
```

Command ini memproses: cover listing (termasuk yang soft-deleted), galeri listing, cover
project (termasuk soft-deleted), galeri project, cover artikel, dan foto testimoni.

### Keamanan tambahan Fase 6

- Rate limit di semua endpoint terkait 2FA (setup, challenge, emergency reset)
- Signed URL untuk emergency reset — tidak bisa ditebak/dipalsukan tanpa `APP_KEY` server
- Test regresi eksplisit untuk bug `MustVerifyEmail` di atas, supaya kalau ada yang tidak sengaja menghapus trait-nya lagi di masa depan, test suite langsung merah

## 12. Fase 7 (sebagian) — Detail Audit Log, Export CSV, Dashboard Analitik

### Fitur baru

| Fitur | Ringkasan |
|---|---|
| **Detail audit log** | Klik baris manapun di `/admin/audit-logs` untuk lihat detail lengkap (tabel before/after per field) + riwayat penuh objek tersebut (semua perubahan dari waktu ke waktu, bukan cuma satu entri) |
| **Export audit log ke CSV** | Tombol di halaman audit log, pola sama dengan export leads (streaming, BOM UTF-8), ikut filter tipe/pencarian yang sedang aktif |
| **Dashboard analitik** | 4 grafik baru di Dashboard Admin: tren lead masuk 6 bulan terakhir (line chart), distribusi status lead (donut), listing aktif per area top-6 (bar chart), listing aktif per tipe properti (pie chart) — pakai Chart.js via CDN, tanpa build step tambahan |

### Catatan teknis

- Grafik tren bulanan pakai `DATE_FORMAT()` — fungsi SQL **spesifik MySQL**. Sesuai karena stack ini MySQL-only sejak awal, tapi catat kalau suatu saat pindah database lain
- Semua grafik otomatis sembunyikan diri dan tampilkan pesan "belum ada data" kalau memang belum ada apa-apa untuk ditampilkan — tidak menampilkan grafik kosong yang membingungkan
- Route `/admin/audit-logs/export` sengaja didaftarkan **sebelum** `/admin/audit-logs/{auditLog}` di `routes/web.php` — kalau terbalik, kata "export" akan coba dicari sebagai ID audit log (404), bukan menjalankan export. Ada test regresi khusus untuk ini

### Notifikasi lead: WhatsApp manual (bukan API)

Sesuai keputusan — **tanpa API WhatsApp berbayar apa pun**. Setiap lead di `/admin/leads` dan di
Dashboard Admin punya tombol **💬 Chat WhatsApp** yang membuka `wa.me` dengan nomor HP admin/agen
sendiri, sudah terisi otomatis pesan pembuka yang menyebut nama & properti yang mereka ajukan.
Tinggal klik, WhatsApp App/Web terbuka, kirim seperti chat biasa — tidak ada pesan yang terkirim
otomatis tanpa sepengetahuan admin.

Email notifikasi lead baru (Fase 3) juga sekarang menyertakan link WhatsApp yang sama, supaya bisa
langsung diklik dari HP saat notifikasi masuk ke email.

Nomor telepon dinormalisasi otomatis (`App\Support\IndonesianPhone`) — baik ditulis `0812...`,
`+62 812...`, atau `62812...`, semuanya diubah ke format yang benar untuk `wa.me`.


## 13. Rename "Proyek Kerjasama" → "Proyek Baru" + Urutan Prioritas Drag & Drop

Perubahan ini mengikuti konsep referensi (brighton.co.id): section "Proyek Baru" tampil di
beranda tepat di bawah banner promo, sebelum listing, sebagai carousel geser horizontal —
serta menambahkan kontrol urutan tampil yang bisa diatur admin (bukan sekadar "terbaru dulu").

### Langkah tambahan wajib

**`php artisan migrate`** — migration baru menambah `priority_order` dan `property_type_id` ke tabel `projects`.

### Yang berubah

| Area | Perubahan |
|---|---|
| **Penamaan** | Semua sebutan "Project Kerjasama Developer" / "Proyek Kerjasama" diganti "Proyek Baru" — di menu nav, footer, judul halaman `/project`, kartu kategori beranda |
| **Beranda** | Section project dipindah ke bawah banner promo (sebelum listing), layout 2 kolom: kiri judul+deskripsi+tombol "Lihat Semua", kanan carousel geser dengan tombol panah ← → |
| **Kartu proyek** | Sekarang menampilkan badge tipe properti (RUMAH/TANAH/dll — opsional per proyek), badge "✓ Official Partner", dan tombol "Hubungi" (wa.me langsung, bukan API) |
| **Urutan tampil** | `priority_order` per proyek — dipakai baik di beranda maupun `/project`. Proyek baru otomatis masuk ke urutan paling akhir |
| **Admin: Atur Urutan** | Halaman baru `/admin/projects-order` — drag & drop pakai SortableJS (CDN, ~10KB), tersimpan otomatis setiap kali urutan diubah (tanpa tombol "Simpan" terpisah) |
| **Admin: Form Proyek** | Field baru "Tipe Properti" (dropdown, opsional) |

### Cara admin mengatur prioritas ("satu proyek selalu di kiri, yang lain gonta-ganti")

1. Buka `/admin/projects-order`
2. Seret proyek yang harus selalu tampil pertama ke posisi paling atas — dan **jangan sentuh** posisi itu lagi
3. Proyek-proyek lain bebas diseret naik-turun kapan saja sesuai prioritas yang berubah-ubah
4. Setiap kali selesai menyeret satu item, urutan langsung tersimpan ke database (indikator hijau muncul) — tidak perlu klik "Simpan"

### Dampak teknis yang perlu diketahui

- **Tipe properti pada proyek bersifat opsional** (`nullable`) — proyek lama yang belum diberi tipe tidak akan menampilkan badge tipe, bukan error
- **Menghapus Tipe Properti di admin sekarang dicegah** kalau masih dipakai listing ATAU project (sebelumnya hanya cek listing)
- Urutan prioritas **tidak pernah berubah otomatis** saat admin edit data proyek biasa (harga, deskripsi, dll) — hanya berubah lewat halaman "Atur Urutan" atau saat proyek baru dibuat (otomatis ke urutan paling akhir)
- Test regresi memverifikasi: urutan di beranda & `/project` konsisten ikut `priority_order` (bukan tanggal terbit), endpoint reorder hanya bisa diakses admin, dan ID proyek palsu ditolak (422) saat reorder
