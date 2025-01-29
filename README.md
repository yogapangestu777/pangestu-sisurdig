# Aplikasi Sisurdig (Sistem Informasi Surat Digital)

Aplikasi ini adalah sistem manajemen surat menyurat berbasis web yang dikembangkan menggunakan Laravel. Aplikasi ini dirancang untuk membantu organisasi dalam mengelola surat masuk, surat keluar, serta arsip surat dengan lebih efisien.

## 1. Penjelasan Menu
- **Ikhtisar**: Halaman dasbor utama yang menampilkan ringkasan data surat masuk, surat keluar, dan counting data lainnya.
- **Kategori**: Modul untuk mengelola kategori surat, memungkinkan pengelompokan surat berdasarkan jenis tertentu.
- **Pihak Terkait**: Menyimpan dan mengelola data instansi atau individu yang terkait dengan surat menyurat, seperti pengirim dan penerima surat.
- **Pengguna**: Modul untuk mengelola data pengguna dalam sistem, termasuk administrator, staf, dan pengguna dengan peran khusus.
- **Surat Masuk**: Menampilkan daftar surat yang diterima.
- **Surat Keluar**: Modul untuk mencatat dan mengelola surat yang dikirim dari organisasi, lengkap dengan informasi penerima dan lampiran jika ada.
- **Role & Hak Akses**: Fitur manajemen peran pengguna, yang memungkinkan admin mengatur hak akses berdasarkan peran masing-masing pengguna dalam sistem.

## 2. Instalasi Aplikasi
### Persyaratan
Sebelum menginstal, pastikan Anda memiliki:
- PHP ^8.1
- Composer
- MySQL

### Langkah Instalasi
1. **Clone Repository**
   ```sh
   git clone https://github.com/yogapangestu777/pangestu-sisurdig.git
   cd repository
   ```
2. **Instal Dependensi**
   ```sh
   composer install
   ```
3. **Konfigurasi Lingkungan**
   - Salin file `.env.example` menjadi `.env` dan atur konfigurasi database.
   ```sh
   cp .env.example .env
   ```
   - Atur kredensial database pada `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   - Tambahkan konfigurasi berikut untuk fitur tambahan:
   ```
   RECAPTCHA_SITE_KEY=your_site_key
   RECAPTCHA_SECRET_KEY=your_secret_key
   DEFAULT_PASSWORD_USER=default_password
   ```
4. **Generate Key & Jalankan Migrasi**
   ```sh
   php artisan key:generate
   php artisan migrate --seed
   ```
5. **Menjalankan Server**
   ```sh
   php artisan serve
   ```
   Akses aplikasi di `http://127.0.0.1:8000`

## 3. Catatan yang Belum Selesai
- **Undah Surat**: Fitur unduhan dokumen belum sepenuhnya berfungsi. Beberapa file tidak dapat diakses atau gagal dibuka setelah diunduh. Perlu dilakukan pengecekan terhadap format file dan header respons saat pengiriman file dari server ke klien.

## 4. Teknologi yang Digunakan
- **Backend**: Laravel 11
- **Frontend**: Blade
- **Database**: MySQL

## 5. Lisensi
Aplikasi ini menggunakan lisensi MIT.

---
**Dibuat dengan ❤️ menggunakan Laravel.**

