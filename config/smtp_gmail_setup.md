# Konfigurasi SMTP Gmail

Untuk mengkonfigurasi aplikasi agar dapat mengirim email menggunakan akun Gmail, ikuti langkah-langkah berikut:

## 1. Aktifkan Less Secure Apps atau Gunakan App Password

Jika menggunakan akun Gmail biasa:

-   Buka https://myaccount.google.com/
-   Pilih "Security"
-   Aktifkan "Less secure app access" (tidak direkomendasikan untuk keamanan)

**Atau (lebih aman)**:

-   Gunakan App Password
-   Aktifkan 2-Factor Authentication
-   Generate App Password di https://myaccount.google.com/apppasswords
-   Gunakan password yang dihasilkan di file .env

## 2. Update File .env

Ubah konfigurasi email di file `.env`:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## 3. Clear Configuration Cache

Setelah mengubah file .env, clear cache konfigurasi:

```bash
php artisan config:clear
php artisan cache:clear
```

## 4. Testing

Untuk menguji apakah konfigurasi SMTP sudah benar, Anda dapat menggunakan perintah berikut:

```bash
php artisan tinker
```

Lalu di dalam tinker:

```php
Mail::raw('Test email from Laravel', function($message) {
    $message->to('recipient@example.com')->subject('Test Email');
});
```

## Catatan Penting

-   Jangan pernah menyimpan password Gmail asli di file .env yang di-commit ke repository
-   Gunakan App Password, bukan password Gmail asli
-   Port 587 digunakan untuk TLS encryption
-   Jika mengalami masalah, pastikan firewall tidak memblokir koneksi keluar
