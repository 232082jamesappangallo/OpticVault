# Testing OpticVault API Endpoints

Panduan untuk testing API setelah route fix.

## 🚀 Step 1: Start Backend

```bash
cd backend
php artisan serve
```

Backend akan berjalan di: **http://localhost:8000**

## 🧪 Step 2: Test Endpoints

### 1. Health Check (tidak perlu login)

```bash
curl http://localhost:8000/api/health
```

Response yang diharapkan:
```json
{"status":"OK","timestamp":"2026-06-28T..."}
```

### 2. Login (mendapatkan token)

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@opticvault.com",
    "password": "password123"
  }'
```

Response yang diharapkan:
```json
{
  "message": "Login successful",
  "data": {
    "id": 1,
    "name": "Admin Studio",
    "email": "admin@opticvault.com",
    "token": "YOUR_TOKEN_HERE",
    "created_at": "..."
  }
}
```

**Simpan TOKEN dari response!**

### 3. Get Recent Items (dengan token)

```bash
# Replace TOKEN dengan token dari login
curl -X GET http://localhost:8000/api/items/recent?limit=3 \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json"
```

Response yang diharapkan:
```json
{
  "message": "Recent items retrieved successfully",
  "data": [
    {
      "id": 1,
      "name": "Canon EOS R5",
      "description": "Professional mirrorless camera",
      "category_id": 1,
      "quantity": 2,
      "location": "Studio A",
      "condition": "Baik",
      "category": {
        "id": 1,
        "name": "Kamera"
      }
    },
    ...
  ]
}
```

### 4. Get All Items

```bash
curl -X GET http://localhost:8000/api/items \
  -H "Authorization: Bearer TOKEN"
```

### 5. Get Categories

```bash
curl -X GET http://localhost:8000/api/categories \
  -H "Authorization: Bearer TOKEN"
```

### 6. Logout

```bash
curl -X POST http://localhost:8000/api/auth/logout \
  -H "Authorization: Bearer TOKEN"
```

## ✅ Checklist - Route Fix

Setelah fix, pastikan:

- [ ] Route `/items/recent` didefinisikan SEBELUM `apiResource('items')`
- [ ] Route `/categories/{category}/items` didefinisikan sebelum resource routes
- [ ] Tidak ada error 404 pada `/items/recent`
- [ ] Items dengan category relationship loading
- [ ] Token diperlukan untuk protected routes

## 📝 Route Order (PENTING!)

File: `backend/routes/api.php`

```php
// ✅ BENAR - Special routes SEBELUM resource routes
Route::get('/items/recent', [ItemController::class, 'recent']);
Route::get('/categories/{category}/items', [ItemController::class, 'getByCategory']);
Route::apiResource('items', ItemController::class);

// ❌ SALAH - Resource routes SEBELUM special routes
Route::apiResource('items', ItemController::class);
Route::get('/items/recent', [ItemController::class, 'recent']);
```

**Mengapa?** Karena Laravel akan mencoba match routes dari atas ke bawah. 
- Jika `/items/{id}` sebelum `/items/recent`, maka `/items/recent` akan dianggap sebagai request ke item dengan ID "recent"
- Jika `/items/recent` sebelum `/items/{id}`, maka akan match route yang tepat

## 🔧 Jika Masih 404

1. Verify file routes sudah benar:
   ```bash
   php artisan route:list | grep items
   ```
   Akan menampilkan semua item routes

2. Clear route cache:
   ```bash
   php artisan route:clear
   php artisan config:clear
   ```

3. Restart server:
   ```bash
   # Ctrl+C untuk stop
   php artisan serve
   ```

4. Test lagi dengan curl

## 📱 Frontend akan sudah berfungsi

Setelah API fix, frontend akan:
- ✅ Login berhasil
- ✅ Dashboard fetch recent items berhasil
- ✅ Data ditampilkan dengan benar
- ✅ Tidak ada error 404

## 🎯 Testing via Postman (Alternative)

Jika ingin GUI, gunakan Postman:

1. Download: https://www.postman.com/downloads/
2. Create new request
3. Set method: GET
4. URL: `http://localhost:8000/api/items/recent`
5. Add header: `Authorization: Bearer YOUR_TOKEN`
6. Click Send

## ✨ Expected Results

```
GET /api/items/recent?limit=3
├─ Status: 200 OK
├─ Return 3 most recent items
├─ Each item has category relationship
└─ No 404 errors
```

---

**Dokumentasi lengkap:** Lihat `QUICK_REFERENCE.md` untuk semua endpoints
