<p align="center">
  <img src="logo.png" alt="MedikaLab Logo" width="120">
</p>

<h2 align="center">🧪 MedikaLab — Sistem Informasi Portal Pasien & Laboratorium</h2>

<p align="center">
  <img src="https://img.shields.io/badge/Stack-PHP%20Native%20%7C%20MySQL-777BB4?style=flat-square&logo=php&logoColor=white" alt="Tech Stack">
  <img src="https://img.shields.io/badge/UI-Glassmorphism-0ea5e9?style=flat-square" alt="UI Design">
  <a href="LICENSE"><img src="https://img.shields.io/badge/License-MIT-green.svg?style=flat-square" alt="License"></a>
</p>

---

## 📖 Ikhtisar Proyek

**MedikaLab** adalah aplikasi web sistem informasi laboratorium klinik yang dirancang untuk memudahkan manajemen hasil pemeriksaan pasien. Aplikasi ini memisahkan hak akses antara **Admin (Petugas Lab)** dan **Pasien**[cite: 5, 9], memberikan pengalaman yang transparan dan cepat dalam pendistribusian hasil uji laboratorium (termasuk dokumen PDF) secara *online*.

Antarmuka (UI) MedikaLab dibangun menggunakan pendekatan desain *Glassmorphism* yang modern, bersih, dan minimalis[cite: 11].

---

## ✨ Fitur Unggulan

### 👨‍⚕️ Panel Admin (Petugas Laboratorium)
* **Manajemen Pasien:** Mendaftarkan pasien baru ke dalam sistem menggunakan identitas unik berupa Nomor Rekam Medis (No. RM)[cite: 10].
* **Input Hasil Lab:** Mencatat parameter uji laboratorium, status pemeriksaan (PROSES / SELESAI), dan menambahkan catatan khusus dari dokter[cite: 12].
* **Unggah Dokumen (PDF):** Mendukung pengunggahan file hasil laboratorium berformat PDF yang divalidasi secara otomatis oleh sistem sebelum disimpan ke direktori `uploads/`[cite: 12].

### 🤒 Portal Pasien
* **Login Aman:** Pasien dapat masuk menggunakan Nomor Rekam Medis (No. RM) dan kata sandi yang diberikan oleh klinik[cite: 5].
* **Dasbor Riwayat Uji Lab:** Menampilkan rekapitulasi data diri dan riwayat pemeriksaan laboratorium pasien secara kronologis (dari yang terbaru)[cite: 8].
* **Unduh Hasil Lab (PDF):** Pasien dapat melihat status uji lab mereka (TERVALIDASI / PROSES) dan mengunduh dokumen hasil PDF langsung dari portal jika status sudah selesai[cite: 8].
* **Catatan Dokter:** Menampilkan pesan atau diagnosis singkat dari dokter yang menangani pemeriksaan[cite: 8].

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** PHP Native (Prosedural & Session Management)[cite: 7, 8, 9, 10, 12]
* **Database:** MySQL / MariaDB (Ekstensi `mysqli`)[cite: 6]
* **Frontend:** HTML5, CSS3 Custom (Tema *Glassmorphism* & *Minimalist Login*)[cite: 11]
* **Ikon & Tipografi:** FontAwesome 6.5 & Google Fonts (Inter)[cite: 5]

---

## 🗄️ Struktur Basis Data (Database)

Aplikasi ini menggunakan basis data bernama `medikalab`[cite: 6] yang terdiri dari relasi 3 tabel utama:
1. **`users`**: Menyimpan kredensial otentikasi (id, username/no_rm, password, role)[cite: 9, 10].
2. **`pasien`**: Menyimpan profil pasien (user_id, no_rm, nama, jk) yang terhubung ke tabel `users`[cite: 8, 10].
3. **`lab`**: Menyimpan riwayat pemeriksaan (pasien_id, parameter, hasil, catatan_dokter, tanggal, status, file_pdf)[cite: 8, 12].

---

## 🚀 Panduan Instalasi Lokal

1. **Kloning Repositori:**
   ```bash
   git clone [https://github.com/username/MedikaLab.git](https://github.com/username/MedikaLab.git)
   cd MedikaLab
