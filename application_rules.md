Ini adalah application rules untuk sistem aplikasi Laravel 12 (web + admin panel) untuk manajemen produk dan verifikasi garansi dengan ketentuan berikut:

---

## 🎯 Fitur Utama

### 1. QR Code Universal (Shared untuk Semua Produk)
- **SEMUA PRODUK menggunakan QR CODE YANG SAMA** (Universal QR Code).
- QR code berisi link universal ke halaman form registrasi garansi.
- **User akan memilih produk dari dropdown/list setelah scan**.
- **Quantity tidak terikat ke QR**, melainkan ke database stok.
- **1 QR Code bisa di-scan berkali-kali** oleh user berbeda untuk produk apapun.

---

## 🗄️ Admin Panel

### **Warehouse – Product Received**
Admin dapat input data barang masuk dengan field:
- Part Number
- Quantity
- Product Type

Setelah disubmit:
- Sistem mencatat stok produk di database.
- Sistem meng-generate Serial Number unik sesuai quantity.
- Admin dapat mencetak daftar Serial Number untuk ditempel pada masing-masing unit produk.
- QR Code universal tetap sama untuk semua produk.
- Admin dapat download Universal QR Code untuk ditempel di semua unit produk.

### **Generate Product Label**
Admin dapat generate dan mengunduh label setelah produk diterima warehouse yang berisi:
- QR Code Universal
- Nama Produk
- Tipe Produk
- Part Number
- Serial Number unik hasil generate warehouse
Label ini digunakan untuk ditempel pada unit produk masing-masing.
---

## 🛠️ Fitur Aplikasi

### **1. Manage Product**
- Add Product
- Create Product (dengan detail: nama, tipe, garansi, part number)
- View Product (detail + status garansi)

### **2. Verify Garansi**
Fitur untuk user/teknisi:
- Scan QR Code Universal
- Sistem menampilkan:
  - Detail produk (setelah dipilih dari dropdown)
  - Masa garansi
  - Status (aktif / expired)
  - Tanggal aktivasi dan berakhir

- Jika scan pertama → redirect ke form registrasi garansi
- Jika sudah pernah scan → bisa cek status dengan Serial Number

---

## 📋 Workflow Proses Verifikasi Garansi

1. **SCAN QR CODE UNIVERSAL**
   - Pengguna melakukan pemindaian QR code yang mengarahkan ke halaman form registrasi garansi.
   - **QR code sama untuk SEMUA produk** (universal).
   - Link: `https://domain.com/warranty/register`

2. **PILIH PRODUK**
   - Setelah scan, pengguna diarahkan ke halaman form.
   - Pengguna **memilih produk** dari dropdown list yang menampilkan:
     - Part Number
     - Nama Produk
     - Tipe Produk
   - Dropdown hanya menampilkan produk yang ada di database (dari warehouse).

3. **ISI FORM REGISTRASI**
   - Setelah memilih produk, pengguna mengisi form:
     - **Part Number** (otomatis terisi dari pilihan produk, readonly)
     - **Nama Produk** (otomatis terisi dari pilihan produk, readonly)
     - **Serial Number Produk** (diisi manual oleh user - WAJIB & UNIQUE)
     - Nama Lengkap / Nama Perusahaan
     - Nomor Telepon
     - Alamat Email (opsional)
     - Informasi Tambahan (opsional)
    - User mengisi captcha

4. **UPLOAD INVOICE**
   - Pengguna wajib meng-upload invoice dalam format PDF, foto, atau PNG.

5. **TUNGGU KONFIRMASI ADMIN**
   - Setelah pengisian form dan upload invoice, pengguna menunggu konfirmasi dari admin dalam waktu 3 hari kerja.
   - Admin memverifikasi berdasarkan:
     - Serial Number yang diinput user
     - Invoice yang diupload
     - Kecocokan dengan database produk

6. **STATUS KONFIRMASI**
   - **6a. TERKONFIRMASI (APPROVED)**
     - Pengguna dapat mengakses kartu garansi digital
     - **Garansi aktif berdasarkan Serial Number**
     - Garansi mulai dari tanggal approval
     - Warranty end date = warranty start date + warranty period (bulan)
   
   - **6b. DITOLAK (REJECTED)**
     - Sistem mengirim notifikasi penolakan via email
     - Menampilkan alasan penolakan
     - User dapat mengajukan ulang dengan data yang benar

---

## ⚙️ Kebutuhan Teknis
- **1 QR Code Universal** untuk semua produk.
- QR Code berisi URL: `https://domain.com/warranty/register`
- Form registrasi menampilkan dropdown/select untuk memilih produk dari database.
- **Tracking garansi berdasarkan Serial Number** yang diinput user (harus unique).
- User dapat cek status garansi dengan input Serial Number di halaman: `https://domain.com/warranty/check`
- Database: MySQL
- Admin panel memiliki role:
  - Super Admin (full access)
  - Warehouse Admin (manage stock & products)
  - Customer Service (verify warranty registrations)

---
