# ⚡ Backend Quick Start

Panduan menjalankan backend Laravel untuk pertama kali atau reset.

## 🚀 Langkah 1: Pastikan Database Ada

```bash
# Buat database (jika belum ada)
mysql -u root -p -e "CREATE DATABASE opticvault"

# Atau jika tidak punya password:
mysql -u root -e "CREATE DATABASE opticvault"
```

## 🔧 Langkah 2: Setup Backend

```bash
cd backend

# Install dependencies (jika belum)
composer install

# Copy .env (jika belum)
cp .env.example .env

# Generate key (jika belum)
php artisan key:generate
```

## 📝 Langkah 3: Pastikan .env Database Config Benar

Edit `backend/.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=opticvault
DB_USERNAME=root
DB_PASSWORD=        ← Update dengan password MySQL Anda (atau kosongkan jika tidak ada)
```

## 🗄️ Langkah 4: Setup Database

```bash
# Run migrations (buat tables)
php artisan migrate

# Seed data (masukkan sample data)
php artisan db:seed

# Atau keduanya sekaligus:
php artisan migrate --seed

# Atau jika ingin fresh install (reset semua):
php artisan migrate:fresh --seed
```

## ✅ Verify Database Setup

```bash
# Check apakah migrations berjalan
php artisan migrate:status

# Output yang diharapkan:
# 2014_10_12_000000 ... create_users_table ✓ Ran
# 2019_12_14_000001 ... create_personal_access_tokens_table ✓ Ran
# 2024_01_01_000001 ... create_items_table ✓ Ran
```

## 🚀 Langkah 5: Jalankan Server

```bash
php artisan serve
```

**Server akan berjalan di: http://localhost:8000**

Output yang diharapkan:
```
Laravel development server started on [http://127.0.0.1:8000]
```

## 🧪 Langkah 6: Test API

Di terminal baru:

```bash
# Test health check
curl http://localhost:8000/api/health

# Test login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@opticvault.com",
    "password": "password123"
  }'

# Expected response:
# {
#   "message": "Login successful",
#   "data": {
#     "id": 1,
#     "name": "Admin Studio",
#     "email": "admin@opticvault.com",
#     "token": "..."
#   }
# }
```

## ⚠️ Troubleshooting

### Error: "SQLSTATE[HY000] [1045]"
→ Database password salah di .env
```bash
# Fix: Update DB_PASSWORD di .env
# Lalu jalankan: php artisan migrate --seed
```

### Error: "SQLSTATE[HY000] [2002] Connection refused"
→ MySQL tidak running
```bash
# Buka MySQL:
# Windows: Services → MySQL80 (start)
# Mac: brew services start mysql
# Linux: sudo service mysql start
```

### Error: "SQLSTATE[42000]: Syntax error"
→ Migration error
```bash
# Fix: 
php artisan migrate:rollback
php artisan migrate --seed
```

### Error: "Base table or view not found"
→ Database belum di-migrate
```bash
# Fix:
php artisan migrate --seed
```

### Server tidak mau start di port 8000
→ Port sudah terpakai
```bash
# Gunakan port lain:
php artisan serve --port=8001

# Lalu di frontend update API base URL:
# http://localhost:8001/api
```

## 📋 Full Fresh Install Sequence

Jika ingin start dari awal:

```bash
cd backend

# 1. Setup
composer install
cp .env.example .env
php artisan key:generate

# 2. Update .env dengan database credentials

# 3. Create database
mysql -u root -e "CREATE DATABASE opticvault"

# 4. Setup tables
php artisan migrate:fresh --seed

# 5. Start server
php artisan serve

# 6. Di terminal lain, test:
curl http://localhost:8000/api/health
```

## ✨ Yang Terjadi Saat Startup

Saat `php artisan serve` dijalankan:

```
✓ Load configuration
✓ Connect ke database
✓ Start development server
✓ Listen di http://127.0.0.1:8000
✓ Ready untuk API requests
```

## 🎯 Sekarang Siap

Backend sudah ready ketika:
- ✅ Server running di http://localhost:8000
- ✅ Database ter-connect
- ✅ Health check responds
- ✅ Login endpoint works
- ✅ Frontend bisa reach API

## 📱 Next: Frontend

Di terminal baru:

```bash
cd frontend
flutter pub get
flutter run
```

---

**Tips:** Jangan close terminal backend! Biarkan tetap running saat frontend development.
