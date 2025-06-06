# RT Administration system

Repositori ini menggunakan Laravel dengan Laravel Breeze

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
cd RT-administration-BE
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
pastikan kosong
```bash
php artisan migrate

##jika tidak kosong bisa menggunakan 
php artisan migrate:fresh

##jika ingin langsung seed
php artisan migrate --seed
php artisan migrate:fresh --seed
```

Seed
```bash
##dummy data, data awal
php artisan db:seed

##jika ingin dummy data tambahan untuk pengeluaran dan pembayaran
php artisan db:seed --class=DatabaseSeederSec
```

6. Storage

```bash
php artisan storage:link
```

7. **Jalankan server Laravel**

```bash
php artisan serve
```

Aplikasi akan berjalan di http://127.0.0.1:8000


