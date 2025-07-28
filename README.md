# VoltPay (Aplikasi Pembayaran Listrik Pasca Bayar)

VoltPay adalah aplikasi web modern untuk pembayaran listrik pasca bayar, dirancang agar mudah digunakan, responsif, dan aman. UI telah sepenuhnya dimigrasi ke Tailwind CSS untuk tampilan yang lebih fresh dan user friendly.

## Fitur Utama

- **Dashboard Agen & PLN**: Monitoring data, statistik, dan akses cepat ke fitur utama.
- **Daftar Penggunaan Listrik**: Melihat detail penggunaan listrik pelanggan secara real-time.
- **Riwayat Pembayaran**: Histori transaksi pembayaran listrik lengkap.
- **Manajemen Pelanggan**: CRUD data pelanggan, petugas, dan agen.
- **Manajemen Tagihan**: Kelola tagihan, pembayaran, dan cetak struk digital.
- **Laporan**: Rekap data penggunaan, pembayaran, dan aktivitas petugas/agen.
- **Autentikasi & Hak Akses**: Login terpisah untuk Agen dan PLN, sistem hak akses.
- **Responsive Design**: Tampilan optimal di desktop dan mobile.

## Screenshot

### Dashboard

<img width="1350" height="654" alt="image" src="https://github.com/user-attachments/assets/e89bd864-7cc1-4e2f-beda-41ac8273b26d" />


### Kelola Pembayaran

<img width="1365" height="651" alt="image" src="https://github.com/user-attachments/assets/a8a1de02-4080-4fec-b9b9-7960d317b47f" />


## Teknologi

- PHP 5 (Procedural)
- MySQL
- HTML5
- Tailwind CSS (UI Modern, Responsive)
- Javascript
- Jquery
- [Bootstrap (legacy, sudah diganti Tailwind CSS)]

## Instalasi & Penggunaan

1. Clone/copy project ke folder web server (XAMPP/htdocs).
2. Import database dari `db/db_voltpay.sql` ke MySQL.
3. Konfigurasi koneksi database di `config/koneksi.php`.
4. Jalankan aplikasi via browser: `http://localhost/voltpay`
5. Login sebagai Agen/PLN sesuai hak akses.

## Struktur Folder

- `agen/` : Halaman dan fitur untuk Agen
- `pln/` : Halaman dan fitur untuk PLN
- `config/` : Konfigurasi database
- `db/` : File SQL database
- `css/`, `js/`, `fonts/`, `images/` : Asset pendukung
- `library/` : Fungsi PHP

## Catatan

- Aplikasi ini merupakan aplikasi Setroom-Payment yang sudah dimigrasi ke PHP5. Dan, semua tampilan telah dimigrasi ke Tailwind CSS untuk UI yang lebih modern dan konsisten.
- Fitur CRUD, pencarian, dan filter tersedia di semua modul utama.
- Pastikan PHP dan MySQL aktif di XAMPP sebelum menjalankan aplikasi.

---
## Credit
- Email - programzidun@gmail.com
- [LinkedIn](https://www.linkedin.com/in/ramdanzidun/) - Muhammad Ramdan
