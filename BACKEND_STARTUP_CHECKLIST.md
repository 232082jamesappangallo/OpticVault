# Backend Startup Checklist

Gunakan checklist ini untuk memastikan backend berjalan dengan baik.

## ✅ Pre-Startup Checklist

### 1. MySQL Running?
- [ ] MySQL service sudah running
  - Windows: Services → MySQL80 → Running
  - Mac: `brew services list` → mysql running
  - Linux: `sudo service mysql status` → running

### 2. Database Exist?
```bash
mysql -u root -e "SHOW DATABASES LIKE 'opticvault';"
```
- [ ] Database `opticvault` ada

Jika tidak ada, buat:
```bash
mysql -u root -e "CREATE DATABASE opticvault"
```

### 3. .env File?
```bash
cd backend
ls -la .env
```
- [ ] File `backend/.env` exist

### 4. .env Database Config?
```bash
# Check in backend/.env:
cat .env | grep DB_
```
- [ ] `DB_CONNECTION=mysql`
- [ ] `DB_HOST=127.0.0.1`
- [ ] `DB_PORT=3306`
- [ ] `DB_DATABASE=opticvault`
- [ ] `DB_USERNAME=root`
- [ ] `DB_PASSWORD=` (sesuai dengan password MySQL Anda)

### 5. Dependencies Installed?
```bash
cd backend
ls -d vendor 2>/dev/null && echo "✓ vendor folder exists"
```
- [ ] `vendor/` folder exists

Jika tidak:
```bash
composer install
```

## 🚀 Startup Process

### Step 1: Navigate to Backend
```bash
cd backend
```

### Step 2: Generate Key (jika belum)
```bash
php artisan key:generate
```
Expected output: `Application key set successfully`
- [ ] Key generated

### Step 3: Run Migrations
```bash
php artisan migrate:fresh --seed
```

Expected output:
```
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table (XX.XXms)
Migrating: 2019_12_14_000001_create_personal_access_tokens_table
Migrated:  2019_12_14_000001_create_personal_access_tokens_table (XX.XXms)
Migrating: 2024_01_01_000001_create_items_table
Migrated:  2024_01_01_000001_create_items_table (XX.XXms)
Seeding: Database\Seeders\DatabaseSeeder
Seeded:  Database\Seeders\DatabaseSeeder (XX.XXms)
Database seeding completed successfully.
```

- [ ] All 3 migrations ran
- [ ] Seeding completed
- [ ] No errors

### Step 4: Verify Database
```bash
php artisan migrate:status
```

Expected output:
```
Run On                  Batch  Status
----                    -----  ------
2014_10_12_000000       1      Ran
2019_12_14_000001       1      Ran
2024_01_01_000001       1      Ran
```

- [ ] All 3 migrations "Ran"

### Step 5: Start Server
```bash
php artisan serve
```

Expected output:
```
Starting Laravel development server: http://127.0.0.1:8000

[Fri Jun 28 2026 12:34:56] Listening on [http://127.0.0.1:8000]
[Fri Jun 28 2026 12:34:56] Press Ctrl+C to quit
```

- [ ] Server started
- [ ] Listening on http://127.0.0.1:8000
- [ ] Terminal shows "Press Ctrl+C to quit"

**DO NOT CLOSE THIS TERMINAL!**

## 🧪 Post-Startup Verification

Di terminal baru, jalankan:

### Test 1: Health Check
```bash
curl http://localhost:8000/api/health
```

Expected:
```json
{"status":"OK","timestamp":"2026-06-28T..."}
```
- [ ] Response 200 OK
- [ ] Status is "OK"

### Test 2: Login
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@opticvault.com",
    "password": "password123"
  }'
```

Expected:
```json
{
  "message": "Login successful",
  "data": {
    "id": 1,
    "name": "Admin Studio",
    "email": "admin@opticvault.com",
    "token": "...",
    "created_at": "..."
  }
}
```
- [ ] Response 200 OK
- [ ] Token received
- [ ] Name is "Admin Studio"

### Test 3: Get Recent Items
```bash
# Replace TOKEN dengan token dari test login atas
curl -X GET http://localhost:8000/api/items/recent?limit=3 \
  -H "Authorization: Bearer TOKEN"
```

Expected:
```json
{
  "message": "Recent items retrieved successfully",
  "data": [
    {"id": 1, "name": "Canon EOS R5", "category": "Kamera", ...},
    {"id": 2, "name": "Nikon Z9", "category": "Kamera", ...},
    ...
  ]
}
```
- [ ] Response 200 OK
- [ ] 3 items returned
- [ ] Items have correct structure

## ✅ Backend Ready Indicators

Backend siap ketika:

- ✅ Server running di http://127.0.0.1:8000
- ✅ Health check returns 200 OK
- ✅ Login endpoint returns token
- ✅ Items endpoint returns data
- ✅ No errors in terminal
- ✅ Database migrations all "Ran"

## ⚠️ Common Issues

| Issue | Check | Fix |
|-------|-------|-----|
| `ERR_CONNECTION_REFUSED` | Server running? | `php artisan serve` |
| `SQLSTATE[HY000]` | MySQL running? | Start MySQL service |
| `SQLSTATE[42S02]` | Migrations ran? | `php artisan migrate` |
| `Unauthenticated` | Token passed? | Add `Authorization` header |
| `404 Not Found` | Endpoint exist? | Check routes: `php artisan route:list` |

## 🎯 Next Steps

Ketika Backend Ready:

1. ✅ Backend running di http://localhost:8000
2. ⏳ Frontend ready (`cd frontend && flutter run`)
3. ✅ Frontend reaches backend API
4. ✅ Login works end-to-end
5. ✅ Dashboard displays real data

## 📞 Need Help?

Jika stuck:

1. Baca: `backend/START_SERVER.md`
2. Check: Terminal output untuk error messages
3. Verify: All checklist items
4. Test: Health check endpoint

---

**Status:** Use this checklist untuk startup!
**Time to complete:** ~5 minutes
**Result:** Production-ready backend
