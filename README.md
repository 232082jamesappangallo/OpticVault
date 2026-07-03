# OpticVault Backend - REST API

Backend API untuk aplikasi OpticVault menggunakan Laravel framework dengan autentikasi JWT dan REST API yang lengkap.

## 🚀 Fitur

- **Autentikasi JWT**: Menggunakan Laravel Sanctum untuk token-based authentication
- **API RESTful**: CRUD operations untuk Resource (Category, Item, User)
- **Database ORM**: Eloquent untuk database management
- **Migration System**: Database schema versioning
- **Error Handling**: Comprehensive error responses

## 📦 Teknologi

- **PHP**: ^8.1
- **Laravel**: ^10.10
- **Database**: MySQL/PostgreSQL/SQLite
- **Authentication**: Laravel Sanctum (JWT)

## 🛠️ Instalasi

### Prerequisites
- PHP 8.1+
- Composer
- MySQL/PostgreSQL
- Node.js (untuk frontend assets)

### Setup

```bash
# Clone repository
git clone <repository-url>
cd backend

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create database
# Update .env file dengan database credentials
mysql -u root -p -e "CREATE DATABASE opticvault"

# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed

# Start development server
php artisan serve
```

Server akan berjalan di `http://localhost:8000`

## 📚 API Endpoints

### Authentication
- `POST /api/auth/register` - Register user baru
- `POST /api/auth/login` - Login user
- `POST /api/auth/logout` - Logout user
- `GET /api/auth/profile` - Get current user profile

### Categories
- `GET /api/categories` - List semua kategori
- `POST /api/categories` - Create kategori baru
- `GET /api/categories/{id}` - Get kategori detail
- `PUT /api/categories/{id}` - Update kategori
- `DELETE /api/categories/{id}` - Delete kategori

### Items
- `GET /api/items` - List semua barang
- `POST /api/items` - Create barang baru
- `GET /api/items/{id}` - Get barang detail
- `PUT /api/items/{id}` - Update barang
- `DELETE /api/items/{id}` - Delete barang

## 🔐 Autentikasi

Semua endpoint (kecuali login/register) memerlukan JWT token di header:

```bash
Authorization: Bearer <your_jwt_token>
```

## 📝 Environment Configuration

File `.env` yang penting:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=opticvault
DB_USERNAME=root
DB_PASSWORD=

APP_URL=http://localhost:8000
APP_DEBUG=true
```

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/AuthTest.php

# Run with coverage
php artisan test --coverage
```

## 📋 Database Schema

### Users Table
- `id`: Primary key
- `name`: User full name
- `email`: User email (unique)
- `password`: Hashed password
- `created_at`: Timestamp

### Categories Table
- `id`: Primary key
- `name`: Category name
- `description`: Optional description
- `created_at`, `updated_at`: Timestamps

### Items Table
- `id`: Primary key
- `name`: Item name
- `description`: Item description
- `category_id`: Foreign key to categories
- `quantity`: Stock quantity
- `location`: Storage location
- `condition`: Item condition (Baik/Rusak/Perlu Perbaikan)
- `created_at`, `updated_at`: Timestamps

## 🔗 CORS Configuration

CORS sudah dikonfigurasi di `config/cors.php` untuk support frontend di berbagai domain.

## 📞 Support

Untuk bantuan atau pertanyaan, hubungi tim development.

## 📄 License

Proprietary - OpticVault Studio Management System
