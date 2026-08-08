<div align="center">

<img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
<img src="https://img.shields.io/badge/TailwindCSS-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="TailwindCSS">
<img src="https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
<img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">

# 💸 Dompetku

**Aplikasi manajemen keuangan pribadi yang modern dan manusiawi.**  
*Biar uangmu tahu jalan pulang. 🌿*

</div>

---

## ✨ Fitur Unggulan

- 📊 **Dashboard Interaktif** — Ringkasan saldo, pemasukan, pengeluaran, dan grafik arus kas bulanan
- 💳 **Multi-Wallet** — Kelola beberapa dompet sekaligus (Tunai, BCA, GoPay, dll.)
- 📝 **Pencatatan Transaksi** — Catat pemasukan & pengeluaran dengan kategori, filter, dan ekspor CSV/PDF
- 🏷️ **Kategori Kustom** — Buat kategori sendiri sesuai kebiasaan belanja
- 💰 **Budget Limit** — Set batas anggaran bulanan dengan visualisasi progress bar
- 🌐 **Bilingual** — Antarmuka tersedia dalam Bahasa Indonesia & English
- 🌙 **Dark Mode** — Nyaman dipakai kapan saja
- 🔐 **Google OAuth** — Login cepat dengan akun Google
- 📱 **Responsive** — Tampil sempurna di laptop maupun HP
- 🖼️ **Upload Foto Profil** — Personalisasi akun dengan foto sendiri

---

## 🎨 Tampilan
<img width="2559" height="1348" alt="image" src="https://github.com/user-attachments/assets/ab66be42-4200-4c74-b2c0-ce91d7479d44" />

> UI didesain dengan vibe **glassmorphism** + palet warna warm pastel (clay, blush, sage) terinspirasi dari Linear, Notion, dan Arc Browser.

---

## 🛠️ Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 12, PHP 8.2 |
| Frontend | Blade, Tailwind CSS v4, Alpine.js |
| Database | MySQL 8 |
| Auth | Laravel Breeze + Google OAuth (Socialite) |
| Charts | Chart.js |
| Build Tool | Vite |

---

## 🚀 Instalasi Lokal

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL

### Langkah-langkah

```bash
# 1. Clone repository
git clone https://github.com/username/dompetku.git
cd dompetku

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Salin file environment
cp .env.example .env

# 5. Generate app key
php artisan key:generate

# 6. Konfigurasi database di .env
# DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 7. Jalankan migrasi
php artisan migrate

# 8. Buat symlink storage
php artisan storage:link

# 9. Build assets
npm run build

# 10. Jalankan server
php artisan serve
```

Buka `http://127.0.0.1:8000` di browser.

---

## 🔐 Konfigurasi Google OAuth (Opsional)

1. Buka [Google Cloud Console](https://console.cloud.google.com)
2. Buat project baru → **APIs & Services** → **Credentials**
3. Buat **OAuth 2.0 Client ID** (Web Application)
4. Tambahkan Authorized redirect URI: `http://localhost:8000/auth/google/callback`
5. Isi di `.env`:

```env
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

---

## 📁 Struktur Project

```
dompetku/
├── app/
│   ├── Http/Controllers/     # DashboardController, TransactionController, dll.
│   └── Models/               # User, Transaction, Wallet, Category
├── database/migrations/      # Skema database
├── lang/                     # Terjemahan ID & EN
├── resources/views/          # Blade templates
│   ├── dashboard.blade.php
│   ├── transactions/
│   ├── wallets/
│   └── layouts/
└── routes/web.php
```

---

## 🤝 Kontribusi

Pull request sangat disambut! Untuk perubahan besar, buka issue terlebih dahulu.

---
</div>
