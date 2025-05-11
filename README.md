# TBC-CRUD with photo

Repositori ini menggunakan Laravel dengan Laravel Breeze, Inertia.js, dan React sebagai stack frontend-nya.

## Fitur

- Laravel 10+
- Laravel Breeze (Autentikasi dasar)

## Persyaratan

Sebelum menjalankan proyek ini, pastikan kamu sudah menginstal:

- PHP >= 8.1
- Composer
- MySQL 
- Laravel CLI (opsional tapi direkomendasikan)

## Langkah Instalasi

1. **Clone repositori**
```bash
git clone https://github.com/zidaneelfasya/RT-administration-BE.git
cd TBC-laravel
```
  
2. **Install dependensi PHP dengan Composer**

```bash
composer install
```

3. **Copy file .env dan atur konfigurasi**

```bash
cp .env.example .env
```

**Edit .env sesuai dengan konfigurasi database kamu:**

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=username_database
DB_PASSWORD=password_database
```

4. **Generate aplikasi key**

```bash
php artisan key:generate
```

5. **Jalankan migrasi database**

```bash
php artisan migrate
```

6. **Jalankan server Laravel**

```bash
php artisan serve
```

Aplikasi akan berjalan di http://127.0.0.1:8000


