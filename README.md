# Invoice Online (InvoicePro)
```
echo "# Invoice_Online" >> README.md
git init
git add README.md
git commit -m "first commit"
git branch -M main
git remote add origin https://github.com/ryanbekabe/Invoice_Online.git
git push -u origin main
```
Aplikasi pembuat invoice online berbasis web yang ringan, modern, dan mudah digunakan. Didesain secara khusus untuk memenuhi kebutuhan pembuatan tagihan dengan tampilan layaknya dokumen profesional premium.

## 🌟 Fitur Utama

- **Desain Premium:** Antarmuka modern dan *user-friendly* dengan estetika bersih (Vanilla CSS).
- **Pembuatan Invoice Dinamis:** Tambahkan item tagihan (barang/jasa) sebanyak yang Anda perlukan. Perhitungan subtotal dan total dilakukan secara otomatis (JavaScript).
- **Database Auto-Setup:** Tidak perlu import file `.sql` secara manual. Sistem akan otomatis mendeteksi dan membuat database serta tabel ketika aplikasi pertama kali dibuka.
- **Cetak ke PDF:** Fitur *Print/Save PDF* bawaan yang merender halaman invoice persis seperti lembar dokumen fisik/kertas A4 tanpa terganggu elemen UI lainnya.
- **Dashboard Ringkas:** Lihat status tagihan (Draft, Sent, Paid) dan kelola semua riwayat invoice di satu tempat.

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
4. **Selesai!** Database bernama `invoice_app_db` beserta tabelnya akan otomatis terinstal oleh sistem saat Anda membuka halaman tersebut untuk pertama kalinya. Aplikasi sudah siap digunakan.

## 📂 Struktur Direktori

```text
c:\xampp\htdocs\invoice\
├── assets/
│   ├── css/
│   │   └── style.css       # File gaya utama (Premium UI)
│   └── js/
│       └── script.js       # Logika perhitungan dinamis form invoice
├── config/
│   └── db.php              # Konfigurasi database & script auto-setup tabel
├── create.php              # Halaman form pembuatan invoice baru
├── index.php               # Halaman Dashboard yang menampilkan list invoice
├── save_invoice.php        # Script pemroses simpan data ke database
├── view.php                # Halaman view/print invoice sebagai dokumen
└── README.md               # Dokumentasi proyek
```

## 🔐 Kredensial Database Default

Secara *bawaan / default*, sistem terhubung dengan kredensial instalasi bersih XAMPP:
- **Host:** localhost
- **Username:** root
- **Password:** *(kosong)*

Jika server Anda menggunakan password MySQL, silakan edit variabel `$pass` pada file `config/db.php`.

---
*Dibuat untuk mempermudah bisnis Anda.*
