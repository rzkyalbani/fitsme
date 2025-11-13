# Docker Setup dengan Laravel Sail

Proyek Fitsme menggunakan Laravel Sail untuk manajemen Docker environment.

## Persiapan Awal - Docker (Laravel Sail)

1. Pastikan Docker dan Docker Compose sudah terinstall di sistem Anda
2. Pastikan port 80, 3306, 6379, dan 8080 tidak digunakan oleh service lain

## Persiapan Awal - Non-Docker (Lokal)

Jika Anda ingin menjalankan aplikasi ini secara lokal tanpa Docker, Anda perlu mengubah beberapa konfigurasi di .env:

```env
# Database Configuration
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fitsme
DB_USERNAME=root  # atau username database lokal Anda
DB_PASSWORD=      # atau password database lokal Anda

# Redis Configuration  
REDIS_HOST=127.0.0.1
REDIS_PORT=6379

# Mail Configuration
MAIL_HOST=127.0.0.1
MAIL_PORT=1025  # jika menggunakan mailhog lokal, atau sesuaikan

# Jika menggunakan PHP built-in server
APP_URL=http://localhost:8000
```

Pastikan Anda juga memiliki:
- PHP 8.2+ terinstall
- Composer terinstall
- MySQL terinstall dan berjalan
- Node.js dan npm terinstall (jika menggunakan frontend assets)

## Setup Awal

1. **Clone repository dan install dependencies**
   ```bash
   git clone <repository-url>
   cd fitsme
   cp .env.example .env
   ```

2. **Jalankan container**
   ```bash
   ./vendor/bin/sail up -d
   ```

3. **Install composer dependencies (jika belum)**
   ```bash
   ./vendor/bin/sail composer install
   ```

4. **Generate application key**
   ```bash
   ./vendor/bin/sail artisan key:generate
   ```

5. **Jalankan migration**
   ```bash
   ./vendor/bin/sail artisan migrate
   ```

## Perintah Umum

- **Menjalankan container**:
  ```bash
  ./vendor/bin/sail up -d
  ```

- **Menghentikan container**:
  ```bash
  ./vendor/bin/sail down
  ```

- **Mengakses shell container**:
  ```bash
  ./vendor/bin/sail shell
  ```

- **Menjalankan artisan commands**:
  ```bash
  ./vendor/bin/sail artisan <command>
  ```

- **Menjalankan composer commands**:
  ```bash
  ./vendor/bin/sail composer <command>
  ```

- **Menjalankan npm commands**:
  ```bash
  ./vendor/bin/sail npm <command>
  ```

## Konfigurasi Google OAuth

Untuk social login berfungsi dengan baik di lingkungan Docker:

1. Gunakan `http://localhost` sebagai base URL
2. Tambahkan `http://localhost/auth/google/callback` ke daftar Authorized redirect URIs di Google Cloud Console
3. Pastikan konfigurasi di `.env`:
   ```env
   GOOGLE_CLIENT_ID=your_client_id
   GOOGLE_CLIENT_SECRET=your_client_secret
   GOOGLE_REDIRECT_URI=http://localhost/auth/google/callback
   ```

## Troubleshooting

1. **Port bentrok**: Jika port default sudah digunakan, Anda bisa mengganti di `.env`:
   ```env
   APP_PORT=8080          # untuk web server
   FORWARD_DB_PORT=3307   # untuk database
   FORWARD_REDIS_PORT=6380 # untuk redis
   FORWARD_PHPMYADMIN_PORT=8081 # untuk phpMyAdmin
   ```

2. **Migration gagal**: Pastikan database container sudah sepenuhnya start:
   ```bash
   ./vendor/bin/sail logs mysql
   ```

3. **Perubahan tidak muncul**: Pastikan volume mounting bekerja dengan benar, file-file seharusnya langsung terupdate di dalam container.

## Konfigurasi Google OAuth

Untuk social login berfungsi dengan baik di lingkungan Docker:

1. Gunakan `http://localhost` sebagai base URL
2. Tambahkan `http://localhost/auth/google/callback` ke daftar Authorized redirect URIs di Google Cloud Console
3. Pastikan konfigurasi di `.env`:
   ```env
   GOOGLE_CLIENT_ID=your_client_id
   GOOGLE_CLIENT_SECRET=your_client_secret
   GOOGLE_REDIRECT_URI=http://localhost/auth/google/callback
   ```

## phpMyAdmin

Proyek ini juga include phpMyAdmin untuk manajemen database yang mudah:

- Akses phpMyAdmin di: `http://localhost:8080`
- Server: `mysql`
- Username: `sail`
- Password: `password`