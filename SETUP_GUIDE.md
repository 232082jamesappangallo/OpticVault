# OpticVault - Setup & Installation Guide

Panduan lengkap untuk setup dan menjalankan OpticVault.

## 📋 Requirements

### Backend (Laravel)
- PHP 8.1 atau lebih tinggi
- Composer
- MySQL/PostgreSQL/SQLite
- Node.js (untuk asset compilation)

### Frontend (Flutter)
- Flutter SDK 3.0+
- Dart 3.0+
- Android SDK atau Xcode (untuk native development)
- Android Studio atau VS Code dengan Flutter extension

## 🎯 Quick Start

### 1. Backend Setup

```bash
# Navigate ke folder backend
cd backend

# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Setup database
# Buka .env dan update database credentials
# Contoh:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=opticvault
# DB_USERNAME=root
# DB_PASSWORD=

# Buat database
# MySQL:
mysql -u root -p -e "CREATE DATABASE opticvault"

# Run migrations
php artisan migrate

# (Optional) Seed database dengan data dummy
php artisan db:seed

# Start Laravel development server
php artisan serve
# Server akan berjalan di http://localhost:8000
```

### 2. Frontend Setup

```bash
# Navigate ke folder frontend
cd frontend

# Get Flutter dependencies
flutter pub get

# (Optional) Clean build
flutter clean

# Run aplikasi
flutter run

# Atau specify device:
# flutter run -d chrome      # Web
# flutter run -d emulator    # Android emulator
```

## 🔐 Environment Configuration

### Backend (.env)

```env
# App Configuration
APP_NAME=OpticVault
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=opticvault
DB_USERNAME=root
DB_PASSWORD=

# JWT / Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost:8000
SESSION_DOMAIN=localhost
```

### Frontend (main.dart)

Konfigurasi API base URL di `frontend/lib/api/api_client.dart`:

```dart
static const String baseUrl = 'http://localhost:8000/api';
```

**Catatan**: Untuk Android emulator, gunakan `http://10.0.2.2:8000/api`

## 🗄️ Database Setup

### Automatic Migration
```bash
php artisan migrate
```

Ini akan membuat tabel:
- `users` - User/Admin data
- `categories` - Kategori peralatan
- `items` - Barang/Inventaris
- `personal_access_tokens` - JWT tokens (Sanctum)

### Manual Database Creation (Jika diperlukan)

```sql
-- Database
CREATE DATABASE opticvault;
USE opticvault;

-- Users
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255),
  email VARCHAR(255) UNIQUE,
  password VARCHAR(255),
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);

-- Categories
CREATE TABLE categories (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255),
  description TEXT,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);

-- Items
CREATE TABLE items (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255),
  description TEXT,
  category_id INT,
  quantity INT,
  location VARCHAR(255),
  condition VARCHAR(100),
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id)
);
```

## 🧪 Testing

### Backend
```bash
cd backend

# Run all tests
php artisan test

# Run specific test
php artisan test tests/Feature/AuthTest.php

# Run with coverage
php artisan test --coverage
```

### Frontend
```bash
cd frontend

# Run widget tests
flutter test

# Run with coverage
flutter test --coverage
```

## 🚨 Troubleshooting

### Backend Issues

**Error: "SQLSTATE[HY000] [2002] Connection refused"**
- Pastikan MySQL sudah running
- Check database credentials di .env
- Verify DB_HOST dan DB_PORT

**Error: "Class not found" atau "Composer autoloader error"**
```bash
composer install
composer dump-autoload
```

**Laravel tidak bisa connect ke database**
```bash
# Regenerate cache
php artisan config:cache
php artisan cache:clear
```

### Frontend Issues

**Error: "Connection refused" saat API call**
- Pastikan backend sudah running di http://localhost:8000
- Check API base URL di `api_client.dart`
- Untuk Android emulator, gunakan `http://10.0.2.2:8000/api`

**Flutter pubspec.yaml errors**
```bash
flutter clean
flutter pub get
```

**Android build errors**
```bash
cd frontend/android
./gradlew clean
cd ..
flutter run
```

## 📱 Running on Different Platforms

### Android
```bash
cd frontend

# Start Android emulator
# Or connect physical device via USB

flutter run
```

### iOS (macOS only)
```bash
cd frontend
flutter run -d ios
```

### Web
```bash
cd frontend
flutter run -d chrome
```

### Desktop (Windows/Linux)
```bash
cd frontend
flutter run -d windows  # atau linux
```

## 📊 API Endpoints

Setelah backend running, test API dengan:

```bash
# Get auth token
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'

# Get categories (with token)
curl -X GET http://localhost:8000/api/categories \
  -H "Authorization: Bearer YOUR_TOKEN"
```

Atau gunakan Postman/Insomnia untuk testing yang lebih lengkap.

## 🔄 Development Workflow

### 1. Ketika mengubah Backend
```bash
cd backend

# Restart Laravel development server
# Server akan auto-reload
```

### 2. Ketika mengubah Frontend
```bash
cd frontend

# Flutter akan hot-reload
# Tekan R di terminal untuk reload
# Tekan Shift+R untuk restart app
```

### 3. Ketika menambah dependency

**Backend**:
```bash
cd backend
composer require package/name
```

**Frontend**:
```bash
cd frontend
flutter pub add package_name
```

## 📦 Deployment

### Backend Deployment
- Deploy ke server (VPS, Heroku, Railway, dll)
- Set `.env` untuk production
- Run migrations di production
- Setup environment variables di hosting

### Frontend Deployment
- Build APK: `flutter build apk`
- Build iOS: `flutter build ios`
- Build web: `flutter build web`
- Upload ke Play Store/App Store

## 🔗 Useful Commands

```bash
# Backend
php artisan tinker                    # Interactive shell
php artisan route:list                # List all routes
php artisan make:migration name       # Create migration
php artisan make:model ModelName      # Create model
php artisan make:controller ControllerName

# Frontend
flutter devices                       # List connected devices
flutter pub upgrade                   # Upgrade dependencies
flutter pub outdated                  # Check outdated packages
flutter build                         # Build for production
```

## 📖 Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Flutter Documentation](https://flutter.dev/docs)
- [JWT Authentication](https://jwt.io/)
- [REST API Best Practices](https://restfulapi.net/)

## 💡 Tips

1. **Debugging Backend**: Gunakan `Log::info()` di Laravel dan check `storage/logs/`
2. **Debugging Frontend**: Gunakan `debugPrint()` atau Flutter DevTools
3. **Database Debugging**: Gunakan phpMyAdmin atau MySQL Workbench
4. **API Testing**: Gunakan Postman atau Insomnia
5. **Keep credentials secure**: Jangan commit `.env` file

## 🎯 Next Steps

Setelah setup berhasil:
1. Test login dengan email: `admin@example.com`
2. Explore Dashboard
3. Integrate dengan actual backend endpoints
4. Implement BLoC state management
5. Add more features (CRUD screens)

---

**Butuh bantuan?** Hubungi tim development atau baca dokumentasi lebih lanjut di `README.md` dan `OPTICVAULT_STRUCTURE.md`
