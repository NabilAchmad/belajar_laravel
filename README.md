📚 PerpusKita — Aplikasi Perpustakaan Online Modern
PerpusKita adalah aplikasi web manajemen perpustakaan berbasis Laravel 11 dengan antarmuka modern, bersih, dan responsif. Dirancang untuk mempermudah pengelolaan koleksi buku dan transaksi peminjaman, aplikasi ini menggabungkan kemudahan penggunaan dengan tampilan profesional.

✨ Fitur Unggulan
🔐 Otentikasi & Keamanan
Sistem registrasi & login aman menggunakan Laravel Breeze.

Role-Based Access Control:

Member → Menjelajahi katalog, meminjam & mengembalikan buku, melihat riwayat pinjaman.

Staff → Mengelola koleksi buku (Tambah/Edit).

Admin → Akses penuh (CRUD Buku, monitoring seluruh transaksi).

📚 Manajemen Katalog Buku (CRUD)
Tambah, edit, dan hapus koleksi buku.

Upload gambar sampul yang disimpan secara lokal.

Tampilan grid view menarik & informatif.

🔄 Sistem Peminjaman Buku
Logika otomatis saat meminjam & mengembalikan buku.

Status peminjaman jelas: Dipinjam, Sudah Kembali, Terlambat.

📊 Panel Khusus
Member → Halaman Pinjaman Saya.

Admin → Panel Pinjaman Aktif dengan data terkelompok per member.

🎨 UI/UX Modern
Desain profesional dengan gradien warna elegan.

Animasi smooth scrolling.

Full Responsive — nyaman di desktop & mobile.

🖼 Tampilan Aplikasi
<table> <tr> <td align="center"><b>Halaman Login</b></td> <td align="center"><b>Detail Buku</b></td> </tr> <tr> <td><img src="https://storage.googleapis.com/gemini-prod/images/image_e41fcb.jpg_bb70eb1d-c6ec-4671-8431-12d80bbf8ec1" alt="Login Page"></td> <td><img src="https://storage.googleapis.com/gemini-prod/images/image_ef7209.jpg_bb70eb1d-c6ec-4671-8431-12d80bbf8ec1" alt="Book Detail"></td> </tr> </table>
🛠 Teknologi yang Digunakan
Backend → Laravel 11, PHP 8.2+

Frontend → Tailwind CSS, Alpine.js

Database → MySQL

Dev Environment → XAMPP / Laragon / Laravel Sail

🚀 Cara Instalasi
bash
Salin
Edit
# 1. Clone repository
git clone https://github.com/USERNAME_ANDA/NAMA_REPO.git
cd NAMA_REPO

# 2. Install dependencies
composer install
npm install

# 3. Copy environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Konfigurasi database di file .env

# 6. Migrasi & seeding data awal
php artisan migrate:fresh --seed

# 7. Link storage
php artisan storage:link

# 8. Compile assets frontend
npm run dev

# 9. Jalankan server
php artisan serve
Akses aplikasi di http://127.0.0.1:8000

🔑 Akun Demo
Role	Email	Password
Admin	admin@perpus.com	password
Staff	staff@perpus.com	password
Member	member@perpus.com	password

📝 Roadmap Fitur Selanjutnya
 🔍 Pencarian & filter katalog buku.

 ⏰ Sistem denda keterlambatan.

 ⭐ Ulasan & rating buku.

 📊 Dashboard statistik buku & aktivitas member.

 📧 Notifikasi email untuk jatuh tempo.

📜 Lisensi
Proyek ini dirilis di bawah lisensi MIT — bebas digunakan, dimodifikasi, dan dikembangkan.
