# Backend Setup - OpticVault

Panduan setup dan configurasi backend Laravel OpticVault.

## 📋 Prerequisites

- PHP 8.1+
- Composer
- MySQL / PostgreSQL / SQLite
- Node.js (untuk asset compilation)

## 🚀 Setup Steps

### 1. Install Dependencies

```bash
cd backend
composer install
```

### 2. Environment Configuration

```bash
cp .env.example .env
```

Update `.env` dengan database credentials Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=opticvault
DB_USERNAME=root
DB_PASSWORD=

APP_URL=http://localhost:8000
```

### 3. Generate App Key

```bash
php artisan key:generate
```

### 4. Create Database

```bash
# MySQL
mysql -u root -p -e "CREATE DATABASE opticvault"

# Or buat manual melalui MySQL GUI
```

### 5. Run Migrations

```bash
php artisan migrate
```

Ini akan membuat tabel:
- `users` - Admin/User data
- `categories` - Kategori peralatan
- `items` - Barang/Inventaris
- `personal_access_tokens` - JWT tokens (Sanctum)

### 6. Seed Database (Optional - untuk test data)

```bash
php artisan db:seed
```

Ini akan membuat:
- Admin user: `admin@opticvault.com` / `password123`
- 7 kategori peralatan
- 15 item sampel

### 7. Start Development Server

```bash
php artisan serve
```

Server akan berjalan di `http://localhost:8000`

## 📁 Project Structure

```
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php       # Authentication
│   │   │   ├── CategoryController.php   # Category CRUD
│   │   │   └── ItemController.php       # Item CRUD
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Category.php
│   │   └── Item.php
│   └── Providers/
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_categories_table.php
│   │   └── 2024_01_01_000002_create_items_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── CategorySeeder.php
│       └── ItemSeeder.php
├── routes/
│   └── api.php                          # API routes
├── config/
│   ├── auth.php
│   ├── sanctum.php
│   └── cors.php
└── ...
```

## 🔌 API Endpoints

### Authentication (Public)
```
POST   /api/auth/register          Register user baru
POST   /api/auth/login             Login user
```

### Authentication (Protected)
```
GET    /api/auth/profile           Get current user profile
POST   /api/auth/logout            Logout & revoke token
```

### Categories (Protected)
```
GET    /api/categories             Get all categories (paginated)
GET    /api/categories/{id}        Get category detail
POST   /api/categories             Create category
PUT    /api/categories/{id}        Update category
DELETE /api/categories/{id}        Delete category
```

### Items (Protected)
```
GET    /api/items                  Get all items (paginated)
GET    /api/items/{id}             Get item detail
GET    /api/items/recent           Get recent items (for dashboard)
POST   /api/items                  Create item
PUT    /api/items/{id}             Update item
DELETE /api/items/{id}             Delete item
GET    /api/categories/{id}/items  Get items by category
```

## 🧪 Testing API

### Register User
```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### Login
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@opticvault.com",
    "password": "password123"
  }'
```

Response akan berisi token JWT.

### Get Categories (dengan token)
```bash
curl -X GET http://localhost:8000/api/categories \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json"
```

### Create Category
```bash
curl -X POST http://localhost:8000/api/categories \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Kategori Baru",
    "description": "Deskripsi kategori"
  }'
```

## 🗄️ Database Schema

### Users Table
```sql
id              INT PRIMARY KEY
name            VARCHAR(255)
email           VARCHAR(255) UNIQUE
password        VARCHAR(255)
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### Categories Table
```sql
id              INT PRIMARY KEY
name            VARCHAR(255) UNIQUE
description     TEXT
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### Items Table
```sql
id              INT PRIMARY KEY
name            VARCHAR(255)
description     TEXT
category_id     INT (FK to categories)
quantity        INT
location        VARCHAR(255)
condition       ENUM('Baik', 'Rusak', 'Perlu Perbaikan')
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

## 🔐 Authentication

OpticVault menggunakan **Laravel Sanctum** untuk JWT authentication.

### How it works:
1. User login dengan email/password
2. Backend return JWT token
3. Frontend menyimpan token
4. Setiap request, frontend kirim token di header: `Authorization: Bearer TOKEN`
5. Backend validate token sebelum process request

### Token Management:
```php
// Generate token
$token = $user->createToken('auth-token')->plainTextToken;

// Revoke token (logout)
$user->currentAccessToken()->delete();

// Revoke semua tokens
$user->tokens()->delete();
```

## 📝 Common Commands

```bash
# Database
php artisan migrate                 # Run migrations
php artisan migrate:rollback        # Rollback last migration
php artisan migrate:refresh         # Rollback and re-migrate
php artisan db:seed                 # Seed database
php artisan tinker                  # Interactive shell

# Models & Controllers
php artisan make:model ModelName
php artisan make:controller ControllerName
php artisan make:migration TableName

# Caching & Config
php artisan config:cache            # Cache configuration
php artisan config:clear            # Clear config cache
php artisan cache:clear             # Clear all cache
```

## 🐛 Troubleshooting

### Database Connection Error
```
SQLSTATE[HY000] [2002] Connection refused
```

**Solution:**
- Pastikan MySQL sudah running
- Check DB credentials di `.env`
- Verify DB_HOST (localhost vs 127.0.0.1)

### Migration Error
```
SQLSTATE[42000]: Syntax error
```

**Solution:**
```bash
php artisan migrate:rollback
php artisan migrate
```

### Token Invalid
```
Unauthenticated
```

**Solution:**
- Pastikan token dikirim di header: `Authorization: Bearer TOKEN`
- Check token belum expired
- Token harus dari endpoint login/register yang valid

## 📞 API Response Format

### Success Response
```json
{
  "message": "Operation successful",
  "data": {
    "id": 1,
    "name": "John Doe",
    ...
  }
}
```

### Error Response
```json
{
  "message": "Operation failed",
  "error": "Error details",
  "errors": {
    "field_name": ["Error message"]
  }
}
```

## ✅ Deployment Checklist

- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_ENV=production`
- [ ] Run migrations di production
- [ ] Seed data jika diperlukan
- [ ] Configure proper CORS origins
- [ ] Setup environment variables
- [ ] Enable caching
- [ ] Setup logging
- [ ] Configure database backups
- [ ] Setup SSL/HTTPS

## 🔗 Related Files

- Routes: `backend/routes/api.php`
- Controllers: `backend/app/Http/Controllers/`
- Models: `backend/app/Models/`
- Migrations: `backend/database/migrations/`
- Config: `backend/config/`

---

**Untuk frontend integration**, lihat dokumentasi di `SETUP_GUIDE.md` dan `QUICK_REFERENCE.md`
