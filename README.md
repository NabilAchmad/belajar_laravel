PerpusKita - Aplikasi Perpustakaan Online Modern
PerpusKita adalah aplikasi web manajemen perpustakaan yang dibangun menggunakan Laravel 11. Aplikasi ini dirancang dengan antarmuka yang modern, bersih, dan responsif, serta dilengkapi dengan fitur-fitur esensial untuk mengelola koleksi buku dan transaksi peminjaman.

✨ Fitur Utama
Otentikasi Pengguna: Sistem registrasi dan login yang aman menggunakan Laravel Breeze.

Manajemen Peran (Role-Based Access Control):

Member: Dapat menjelajahi katalog, meminjam & mengembalikan buku, dan melihat riwayat pinjaman pribadi.

Staff: Memiliki hak akses seperti Admin untuk mengelola buku (tambah, edit).

Admin: Akses penuh untuk mengelola buku (CRUD), dan memonitor semua transaksi peminjaman yang sedang aktif dari seluruh member.

Katalog Buku (CRUD):

Admin & Staff dapat menambah, mengedit, dan menghapus koleksi buku.

Fitur upload gambar sampul buku yang disimpan secara lokal.

Tampilan daftar buku dalam format grid yang menarik.

Sistem Peminjaman:

Logika untuk meminjam buku (mengurangi stok) dan mengembalikan buku (menambah stok kembali).

Status peminjaman yang jelas (Dipinjam, Sudah Kembali, Terlambat).

Panel Pengguna & Admin:

Halaman "Pinjaman Saya" untuk member melacak riwayat peminjaman mereka.

Halaman "Panel Pinjaman Aktif" untuk admin, dengan data yang dikelompokkan per member.

Antarmuka Modern & Responsif:

Desain UI yang menarik dengan gradien warna dan layout profesional.

Animasi halus yang muncul saat pengguna melakukan scroll.

Tampilan yang sepenuhnya responsif untuk desktop dan perangkat mobile.

📸 Screenshot
<table>
<tr>
<td align="center"><b>Halaman Login</b></td>
<td align="center"><b>Detail Buku</b></td>
</tr>
<tr>
<td><img src="https://storage.googleapis.com/gemini-prod/images/image_e41fcb.jpg_bb70eb1d-c6ec-4671-8431-12d80bbf8ec1" alt="Login Page"></td>
<td><img src="https://storage.googleapis.com/gemini-prod/images/image_ef7209.jpg_bb70eb1d-c6ec-4671-8431-12d80bbf8ec1" alt="Book Detail"></td>
</tr>
</table>

(Anda bisa menambahkan lebih banyak screenshot ke dalam folder proyek Anda dan menampilkannya di sini)

🛠️ Teknologi yang Digunakan
Backend: Laravel 11, PHP 8.2+

Frontend: Tailwind CSS, Alpine.js

Database: MySQL

Lingkungan Pengembangan: XAMPP / Laragon / Laravel Sail

🚀 Instalasi & Setup
Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan lokal Anda.

Clone repository ini:

Bash

git clone https://github.com/USERNAME_ANDA/NAMA_REPO.git
cd NAMA_REPO
Install dependensi PHP & Node.js:

Bash

composer install
npm install
Siapkan file environment:

Bash

cp .env.example .env
Generate application key:

Bash

php artisan key:generate
Konfigurasi file .env:
Buka file .env dan atur koneksi database Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

Jalankan migrasi dan seeder:
Perintah ini akan membuat semua tabel dan mengisinya dengan data awal (akun admin, member, buku, dll).

Bash

php artisan migrate:fresh --seed
Hubungkan folder storage:

Bash

php artisan storage:link
Compile aset frontend:

Bash

npm run dev
Jalankan server pengembangan:

Bash

php artisan serve
Aplikasi sekarang berjalan di http://127.0.0.1:8000.

🔑 Akun Demo
Anda dapat menggunakan akun berikut yang sudah dibuat oleh seeder untuk mencoba berbagai peran:

Admin

Email: admin@perpus.com

Password: password

Staff

Email: staff@perpus.com

Password: password

Member

Email: member@perpus.com

Password: password

📝 Rencana Pengembangan
Beberapa fitur yang dapat ditambahkan di masa mendatang:

[ ] Fitur pencarian dan filter di katalog buku.

[ ] Sistem denda untuk keterlambatan pengembalian.

[ ] Fitur ulasan dan rating buku oleh member.

[ ] Dashboard admin dengan statistik (buku terpopuler, member paling aktif, dll.).

[ ] Notifikasi email saat buku akan jatuh tempo.

📄 Lisensi
Proyek ini berada di bawah Lisensi MIT.
