# ⛺ Outdoor Rental System (Sistem Penyewaan Alat Camping)

Aplikasi manajemen penyewaan alat outdoor (camping/hiking) berbasis web yang dibangun menggunakan **Laravel**. Sistem ini dirancang untuk mempermudah Admin dalam mengelola stok dan pesanan, serta memudahkan Pelanggan dalam melakukan booking alat secara online.

Aplikasi ini menggunakan template admin profesional **Limitless** dan dilengkapi dengan fitur validasi stok otomatis, notifikasi email, dan laporan keuangan.

---

## ✅ Pemenuhan Requirement Tugas

Aplikasi ini telah memenuhi seluruh kriteria teknis yang diminta:

1.  **Relasi Tabel Database (Min. 2 Tabel)** ✅
    * Menggunakan 3 tabel utama yang saling berelasi: `users` (One-to-Many) `bookings` (Many-to-One) `items`.
2.  **Server-side DataTables** ✅
    * List data barang dan pesanan menggunakan **Yajra DataTables**
3.  **Validasi Data** ✅
    * Validasi stok real-time.
    * Validasi tanggal sewa.
    * Validasi input form.
4.  **Download Laporan (Excel & PDF)** ✅
    * Fitur Export Data Transaksi ke format **Excel** (.xlsx) dan **PDF**.
5.  **Upload Foto** ✅
    * Fitur upload gambar produk/barang ke *local storage* dengan symlink.
6.  **Notifikasi Email (SMTP)** ✅
    * Sistem mengirim notifikasi email otomatis ke pengguna saat melakukan pemesanan (menggunakan Gmail SMTP).
    * Sistem mengirim notifikasi email otomatis ke pengguna saat admin memvalidasi pesanan (menggunakan Gmail SMTP).
7.  **Auth (Login + Register)** ✅
    * Sistem autentikasi lengkap dengan pembagian hak akses (**Middleware**):
        * **Admin:** Akses penuh ke dashboard, kelola barang, approval pesanan.
        * **User:** Akses katalog, booking barang, riwayat pesanan.

---

## 🚀 Fitur Unggulan Lainnya

Selain requirement dasar, aplikasi ini dilengkapi fitur tambahan:
* **Modern UI/UX:** Menggunakan Template Admin *Limitless* & Glassmorphism Login Page.
* **Interactive Dashboard:** Grafik penjualan bulanan (Chart.js) & Statistik Real-time.
* **Bulk Actions:** Hapus banyak data sekaligus dengan checkbox.
* **SweetAlert2:** Notifikasi pop-up yang interaktif dan modern.
* **Auto-Calculation:** Perhitungan total harga sewa otomatis berdasarkan durasi hari.

---

## 🛠️ Teknologi yang Digunakan

* **Framework:** Laravel 6
* **Database:** MySQL
* **Frontend:** Bootstrap 4, Limitless Template, jQuery
* **Libraries:**
    * `yajra/laravel-datatables`
    * `maatwebsite/excel`
    * `barryvdh/laravel-dompdf`
    * `chart.js` & `sweetalert2`

---
## 👤 Akun Demo

Gunakan akun berikut untuk login:

* **Admin:**
    * Email: `admin@gmail.com`
    * Password: `adminpw123@gmail.com`
* **User:**
* **Gunakan akun email yang terverifikasi gmail untuk mencoba fitur Gmail SMTP**
* Atau gunakan akun dummy ini
    * Email: `user@gmail.com`
    * Password: `userpw123`
---
