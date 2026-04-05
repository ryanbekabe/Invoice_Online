# InvoicePro (Invoice Online)
```
echo "# Invoice_Online" >> README.md
git init
git add README.md
git commit -m "first commit"
git branch -M main
git remote add origin https://github.com/ryanbekabe/Invoice_Online.git
git push -u origin main
```
Aplikasi pembuat invoice online berbasis web yang ringan, modern, dan didesain secara khusus untuk memenuhi kebutuhan pembuatan tagihan bisnis bergaya premium di Indonesia.

## 🌟 Fitur Utama

- **Sistem Multi-User (SaaS Ready):** Memiliki fitur Registrasi dan Login mandiri. Setiap user memiliki ruang database (_tenant_) yang sepenuhnya dipisahkan sehingga invoice & pengaturan tidak akan tercampur dengan akun lain.
- **Lokalisasi Indonesia (Rp):** Seluruh antarmuka telah disesuaikan dengan bahasa Indonesia secara menyeluruh, termasuk kalkulasi otomatis menggunakan format mata uang Rupiah.
- **Manajemen Tema Profil:** Anda tidak hanya bisa mengatur nama, logo, dan profil perusahan via *Pengaturan*, tetapi juga dapat memilih warna UI favorit (tersedia kombinasi warna lembut / *Soft Color* seperti *Default Indigo, Matcha Green,* dan *Soft Rose*).
- **Keamanan Tautan (Obfuscation ID):** Tautan cetak dokumen invoice dilengkapi fitur *hashing MD5*, sehingga pihak asing tidak bisa menebak kode ID invoice dan hanya orang yang memiliki *link*-nya yang bisa melihat tagihan tersebut.
- **Direktori Kostumer Terpadu:** Anda bisa langsung melihat daftar klien yang sudah pernah ditagih beserta perhimpunan jumlah tagihan dan nilai pembelanjaannya melalui menu "Kostumer".
- **Pembuatan Invoice Dinamis:** Tambahkan item tagihan sebanyak yang Anda perlukan. Perhitungan subtotal dan total dilakukan secara otomatis tanpa reload halaman (JavaScript).
- **Cetak ke PDF Dinamis:** Fitur *Print/Save PDF* merender halaman pesanan persis seperti lembar dokumen fisik/kertas A4 tanpa terganggu kemunculan elemen tata letak website (Sidebar/Tombol).
- **Database Auto-Migrate:** Tidak perlu import file `.sql` secara manual. Sistem akan otomatis mendeteksi, membuat tabel baru, atau melakukan alterasi perombakan skema tabel saat sistem mengalami pembaharuan versi terbaru.

## 🛠️ Tech Stack

- **Frontend:** HTML5, Vanilla CSS 3 (Inter font, FontAwesome Icons), Vanilla JavaScript
- **Backend:** PHP 8+
- **Database:** MySQL

## 📋 Persyaratan Sistem

- **XAMPP / WAMP / MAMP / Laragon** atau server web lokal lain yang mendukung Apache dan PHP.
- **PHP** versi 7.4 atau lebih baru (disarankan 8+).
- **MySQL / MariaDB**.

## 🚀 Panduan Instalasi & Menjalankan

1. **Clone repositori** ini atau ekstrak folder project ke dalam direktori *document root* server lokal Anda:
   - Jika menggunakan XAMPP: pindahkan ke `C:\xampp\htdocs\invoice`
2. **Jalankan Apache dan MySQL** melalui kontrol panel server lokal Anda (misal: XAMPP Control Panel).
3. **Buka Browser**, lalu akses URL berikut:
   ```
   http://localhost/invoice/
   ```
4. Sistem akan otomatis mensetup database `invoice_app_db`. Anda akan disuguhkan halaman **Login**. 
5. Klik pada tautan **Daftar di sini** untuk membuat akun baru, lalu login. Seluruh data tagihan dan tema antarmuka sepenuhnya milik akun Anda secara aman.

## 📂 Struktur Direktori Terbaru

```text
c:\xampp\htdocs\invoice\
├── assets/
│   ├── css/
│   │   └── style.css       # File gaya utama (Premium UI & Konfigurasi Tema)
│   └── js/
│       └── script.js       # Logika perhitungan dinamis Rupiah form invoice
├── config/
│   ├── auth.php            # Verifikator User & Injeksi State Tema Global
│   └── db.php              # Koneksi, setup tabel auto-migrate
├── login.php               # Halaman masuk user
├── register.php            # Halaman daftar dan auto-seed entitas profil
├── logout.php              # Penghancur sesi user
├── create.php              # Form pembuatan invoice baru
├── index.php               # Dashboard monitoring tagihan
├── customers.php           # Direktori klien dan analitik tagihan
├── save_invoice.php        # Logika simpan invoice dengan teknik URL Obfuscation
├── settings.php            # Pengaturan parameter toko & tema aplikasi
├── view.php                # Halaman view/print invoice
└── README.md               # Dokumentasi proyek
```

## 🔐 Kredensial Database Default

Secara *bawaan / default*, sistem terhubung dengan kredensial instalasi bersih XAMPP:
- **Host:** localhost
- **Username:** root
- **Password:** *(kosong)*

Jika server Anda menggunakan password MySQL, silakan edit variabel `$pass` pada file `config/db.php`.

---
*InvoicePro — Cepat, Elegan, dan Aman.*
