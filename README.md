# OpticVault - Sistem Manajemen Inventaris Studio

OpticVault adalah aplikasi mobile cross-platform untuk mengelola inventaris peralatan studio fotografi dan videografi dengan sistem autentikasi JWT dan REST API.

## 📋 Fitur Utama

- **Autentikasi JWT**: Login aman dengan token-based authentication
- **Dashboard Responsif**: Ringkasan data dan navigasi menu utama
- **Manajemen Kategori**: CRUD penuh untuk kategori peralatan
- **Manajemen Inventaris**: CRUD penuh untuk barang/peralatan studio
- **Real-time Data**: Integrasi seamless antara backend API dan frontend

## 🏗️ Struktur Proyek

```
opticvault/
├── backend/                 # Laravel REST API
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── routes/
│   └── composer.json
├── frontend/                # Flutter Mobile App
│   ├── lib/
│   │   ├── screens/        # UI Screens (Login, Dashboard, dll)
│   │   ├── models/         # Data Models
│   │   ├── api/            # API Service
│   │   ├── constants/      # Colors, Strings, dll
│   │   └── main.dart
│   └── pubspec.yaml
└── README.md
```

## 🚀 Instalasi & Setup

### Backend (Laravel)
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

### Frontend (Flutter)
```bash
cd frontend
flutter pub get
flutter run
```

## 🎨 Desain UI

### Halaman Login
- Logo/Ikon OpticVault dengan gradient biru
- Form email dan password dengan validasi
- Tombol login dengan loading animation (BLoC)
- Responsif untuk semua ukuran layar

### Dashboard
- App bar dengan tombol logout
- Greeting section
- Grid menu navigasi (Kelola Kategori, Kelola Barang)
- List barang terbaru

## 🔐 Autentikasi

Menggunakan JWT (JSON Web Token) dengan Laravel Sanctum untuk keamanan API.

## 📝 License

Proprietary - OpticVault Studio Management System
