# Fitsme - Fashion Outfit Recommendation App

Fitsme adalah aplikasi yang membantu pengguna menemukan outfit yang cocok dengan warna kulit mereka, berdasarkan teori warna fashion dan panduan visual.

## Prasyarat Sistem

### Untuk Docker (Disarankan)
- Docker Engine
- Docker Compose
- Composer (untuk install dependencies PHP)

### Untuk Instalasi Lokal
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js & NPM
- Redis (opsional, untuk queue dan cache)

## Instalasi

### Menggunakan Docker (Laravel Sail) - Disarankan

1. Clone repository
   ```bash
   git clone <repository-url>
   cd fitsme
   ```

2. Copy file environment
   ```bash
   cp .env.example .env
   ```

3. Jalankan service Docker
   ```bash
   ./vendor/bin/sail up -d
   ```

4. Install dependencies PHP
   ```bash
   ./vendor/bin/sail composer install
   ```

5. Generate application key
   ```bash
   ./vendor/bin/sail artisan key:generate
   ```

6. Jalankan migration
   ```bash
   ./vendor/bin/sail artisan migrate
   ```

7. Install dependencies frontend (jika ada)
   ```bash
   ./vendor/bin/sail npm install
   ```

Aplikasi akan tersedia di `http://localhost`
phpMyAdmin tersedia di `http://localhost:8080`

### Instalasi Lokal (Tanpa Docker)

1. Clone repository
   ```bash
   git clone <repository-url>
   cd fitsme
   ```

2. Copy file environment
   ```bash
   cp .env.example .env
   ```

3. Update konfigurasi di .env:
   - Ganti `DB_HOST=mysql` menjadi `DB_HOST=127.0.0.1`
   - Ganti `REDIS_HOST=redis` menjadi `REDIS_HOST=127.0.0.1`
   - Atur `DB_USERNAME` dan `DB_PASSWORD` sesuai database lokal Anda

4. Install dependencies PHP
   ```bash
   composer install
   ```

5. Generate application key
   ```bash
   php artisan key:generate
   ```

6. Jalankan migration
   ```bash
   php artisan migrate
   ```

7. Install dependencies frontend (jika ada)
   ```bash
   npm install
   ```

8. Jalankan aplikasi
   ```bash
   php artisan serve
   ```

Aplikasi akan tersedia di `http://127.0.0.1:8000`

## Konfigurasi OAuth Google

Untuk social login berfungsi, Anda perlu:

1. Buat project di Google Cloud Console
2. Buat OAuth 2.0 Client ID
3. Tambahkan redirect URI:
   - Untuk Docker: `http://localhost/auth/google/callback`
   - Untuk lokal: `http://127.0.0.1:8000/auth/google/callback`
4. Update `.env` dengan `GOOGLE_CLIENT_ID` dan `GOOGLE_CLIENT_SECRET`

## Fitur-fitur Utama

- Social login (Google)
- Digital wardrobe management
- Outfit planning
- Skin tone matching
- Style preference selection
- Global outfit inspiration

## Dokumentasi Tambahan

Lihat `docker-setup.md` untuk dokumentasi lengkap tentang setup Docker.