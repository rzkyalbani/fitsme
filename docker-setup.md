# Docker Setup dengan Laravel Sail

Proyek Fitsme menggunakan Laravel Sail untuk manajemen Docker environment.

## Persiapan Awal

1. Pastikan Docker dan Docker Compose sudah terinstall di sistem Anda
2. Pastikan port 80, 3306, dan 6379 tidak digunakan oleh service lain

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
   ```

2. **Migration gagal**: Pastikan database container sudah sepenuhnya start:
   ```bash
   ./vendor/bin/sail logs mysql
   ```

3. **Perubahan tidak muncul**: Pastikan volume mounting bekerja dengan benar, file-file seharusnya langsung terupdate di dalam container.