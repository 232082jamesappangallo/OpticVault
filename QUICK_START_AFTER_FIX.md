# ⚡ Quick Start - Setelah Fix

## 🎯 Ringkas Masalah & Solusi

| Masalah | Root Cause | Solusi | Status |
|---------|-----------|--------|--------|
| 401 pada login | Default guard salah | Ubah ke 'sanctum' di config/auth.php | ✅ FIXED |
| 500 pada items POST | Import Category invalid | Hapus di ItemController | ✅ FIXED |
| CORS blocked | Port mismatch | Add regex patterns di config/cors.php | ✅ FIXED |
| Middleware error | Route 'login' tidak ada | Return null di Authenticate | ✅ FIXED |
| Token tidak ada | ApiClient tidak init | Call initialize() di main() | ✅ FIXED |
| Sanctum tidak jalan | Middleware di-comment | Uncomment di Kernel.php | ✅ FIXED |

---

## 🚀 Langkah Testing

### Step 1: Pastikan Backend Running
```bash
# Terminal 1
cd backend
php artisan serve
# Harusnya: Laravel development server started at http://127.0.0.1:8000
```

### Step 2: Jalankan Frontend
```bash
# Terminal 2
cd frontend
flutter clean
flutter pub get
flutter run -d chrome  # atau -d web, atau -d android, dll
```

### Step 3: Test Login
- **Email**: `admin@opticvault.com`
- **Password**: `password123`
- **Expected**: ✅ Success, navigate ke Dashboard

### Step 4: Test Add Item
1. Klik tombol "+" (Tambah Barang)
2. Isi form:
   - Nama: "Kamera Test"
   - Deskripsi: "Test description"
   - Jumlah: 5
   - Lokasi: "Studio 1"
3. Klik "Tambah"
4. **Expected**: ✅ Berhasil ditambahkan, muncul di list

### Step 5: Test Edit & Delete
- Click "Edit" → ubah nama → "Simpan" → ✅ Updated
- Click "Hapus" → confirm → ✅ Deleted

---

## 🔧 Jika Masih Error

### Error: "CORS blocked"
```bash
# Backend
php artisan config:clear
php artisan cache:clear

# Frontend
flutter clean
flutter pub get
flutter run
```

### Error: "Failed to load resource"
```bash
# Cek apakah backend running
curl http://localhost:8000/api/health

# Harus return:
# {"status":"OK","timestamp":"..."}
```

### Error: "401 Unauthorized"
```bash
# Pastikan pakai credentials yang benar
Email: admin@opticvault.com
Password: password123

# Jika salah, create user baru dengan:
php artisan db:seed
```

### Error: "Invalid response format"
- Check browser DevTools → Network tab
- Lihat response dari /api/auth/login
- Pastikan ada field "data" dan "token"

---

## 📝 File yang Diubah

✅ `backend/app/Http/Controllers/ItemController.php` - Removed import
✅ `backend/app/Http/Kernel.php` - Uncommented Sanctum
✅ `backend/config/auth.php` - Guard changed to sanctum
✅ `backend/app/Http/Middleware/Authenticate.php` - Return null
✅ `backend/app/Exceptions/Handler.php` - Added JSON handler
✅ `backend/config/cors.php` - Added regex patterns
✅ `frontend/lib/main.dart` - Initialize ApiClient
✅ `frontend/lib/api/api_client.dart` - Enhanced token loading

---

## 🧪 Quick Test Commands (PowerShell)

### Test 1: Health Check
```powershell
Invoke-WebRequest -Uri "http://localhost:8000/api/health" -UseBasicParsing | Select-Object StatusCode
# Expected: 200
```

### Test 2: Login
```powershell
$body = @{email="admin@opticvault.com"; password="password123"} | ConvertTo-Json
$response = (Invoke-WebRequest -Uri "http://localhost:8000/api/auth/login" -Method POST `
  -ContentType "application/json" -Body $body -UseBasicParsing).Content | ConvertFrom-Json
$token = $response.data.token
Write-Host "✅ Token: $($token.Substring(0, 20))..."
```

### Test 3: Create Item
```powershell
$token = "15|YOUR_TOKEN_HERE"  # Ganti dengan token dari Test 2
$headers = @{"Authorization"="Bearer $token"; "Content-Type"="application/json"}
$body = @{name="Kamera"; description="Test"; category="Kamera"; quantity=5} | ConvertTo-Json
$response = (Invoke-WebRequest -Uri "http://localhost:8000/api/items" -Method POST `
  -Headers $headers -Body $body -UseBasicParsing).Content | ConvertFrom-Json
Write-Host "✅ Item created with ID: $($response.data.id)"
```

---

## 📋 Checklist Sebelum Testing

- [ ] Backend running di `http://localhost:8000`
- [ ] Semua files sudah di-fix sesuai checklist di atas
- [ ] `php artisan config:clear` dan `php artisan cache:clear` sudah dijalankan
- [ ] Frontend sudah di-rebuild dengan `flutter clean && flutter pub get`
- [ ] Menggunakan credentials: `admin@opticvault.com` / `password123`
- [ ] Browser DevTools siap untuk monitoring network

---

## 🎉 Jika Semua Sudah Bekerja

Berarti:
✅ Backend auth & authorization berjalan
✅ CORS configured correctly untuk Flutter Web
✅ Frontend token management berjalan
✅ API endpoints protected dan accessible
✅ Database connected dan working

### Sekarang Bisa:
- ✅ Register user baru
- ✅ Login dengan token
- ✅ Add/Edit/Delete items
- ✅ View items with filters
- ✅ See recent items di dashboard
- ✅ All dengan proper authentication

---

## 📞 Next Steps

Jika ingin production-ready:
1. Update CORS origins di `config/cors.php` (jangan gunakan wildcard)
2. Set `APP_DEBUG=false` di `.env`
3. Configure environment variables untuk database, etc
4. Setup HTTPS
5. Run tests dan security audit
6. Deploy ke production

---

## 💡 Development Tips

### Enable Debug Logging
Di `frontend/lib/api/api_client.dart`, uncomment debug prints:

```dart
/// GET request
Future<dynamic> get(String endpoint) async {
  try {
    print('🔵 GET $endpoint');  // Uncomment ini
    // ...
  }
}
```

### Monitor Network (Browser DevTools)
1. Open DevTools (F12)
2. Go to Network tab
3. Filter by `/api/`
4. Lihat request headers & responses

### Monitor Logs (Terminal)
```bash
# Backend
tail -f backend/storage/logs/laravel.log

# Frontend
flutter run -v  # Verbose output
```

---

🚀 **Ready to test!** Ikuti langkah di atas dan pastikan semua ✅ bekerja.
