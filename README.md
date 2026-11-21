# Sistem Akademik SMK Kemangkon

Sistem informasi akademik berbasis web untuk SMK Kemangkon yang mencakup pengelolaan data siswa, guru, kelas, mata pelajaran, jadwal, dan nilai. Proyek ini merupakan tugas akhir semester mata kuliah Software Development.

---

## Daftar Isi

- [Teknologi](#teknologi)
- [Fitur](#fitur)
- [Prasyarat](#prasyarat)
- [Instalasi](#instalasi)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Akun Demo](#akun-demo)
- [Struktur Proyek](#struktur-proyek)
- [Dokumentasi API](#dokumentasi-api)
- [Skema Database](#skema-database)
- [Kontributor](#kontributor)

---

## Teknologi

| Komponen | Versi | Keterangan |
| :--- | :--- | :--- |
| Laravel | 12.x | Framework PHP utama |
| PHP | 8.5 | Runtime bahasa pemrograman |
| MySQL | 8.x | Sistem manajemen basis data |
| Laravel Sail | - | Lingkungan Docker untuk pengembangan |
| Laravel Sanctum | 4.x | Autentikasi berbasis token |
| Tailwind CSS | CDN | Styling antarmuka admin |
| Docker Desktop | - | Container runtime |

---

## Fitur

Sistem ini menyediakan fitur berikut:

**Autentikasi dan Otorisasi**
- Login multi-role (Admin, Guru, Siswa)
- Role-based access control pada endpoint API dan halaman web

**Manajemen Data Master**
- CRUD User
- CRUD Siswa
- CRUD Guru
- CRUD Kelas
- CRUD Mata Pelajaran

**Manajemen Akademik**
- CRUD Jadwal dengan validasi bentrok otomatis
- CRUD Nilai dengan perhitungan nilai akhir otomatis
- Rapor siswa per semester

**Fitur Khusus**
- Dashboard statistik untuk admin
- Rapor pribadi untuk siswa
- Jadwal pribadi untuk guru dan siswa
- Update profil dan ubah password mandiri

---

## Prasyarat

Sebelum menjalankan proyek, pastikan perangkat telah terpasang:

- **Docker Desktop** (wajib, digunakan untuk menjalankan container)
- **Git** (untuk kloning repositori)
- **Composer** (apabila ingin menjalankan perintah PHP di luar container)

---
