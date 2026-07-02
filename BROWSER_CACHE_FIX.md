# 🔧 Browser Cache Fix - CORS Error

## Problem
Browser masih cache CORS error dari config lama. Backend sudah fixed tapi browser belum tahu.

## Solution: Hard Refresh & Clear Cache

### Method 1: Chrome/Edge Hard Refresh
```
Ctrl + Shift + R  (Windows/Linux)
Cmd + Shift + R   (Mac)
```

### Method 2: DevTools Cache Disable
1. Open DevTools (F12)
2. Go to Settings (⚙️ icon)
3. Check: "Disable cache (while DevTools is open)"
4. Close DevTools (F12 again)
5. Refresh page (Ctrl + R)

### Method 3: Clear All Browser Data
**Chrome/Edge:**
1. Press `Ctrl + Shift + Delete`
2. Select "All time"
3. Check "Cookies and other site data", "Cached images and files"
4. Click "Clear data"
5. Refresh page

**Firefox:**
1. Press `Ctrl + Shift + Delete`
2. Click "Clear Now"
3. Refresh page

## Full Reset Steps

### Step 1: Stop Flutter Dev Server
```bash
# Di terminal Flutter, press Ctrl + C
```

### Step 2: Clear Flutter Cache
```bash
flutter clean
flutter pub get
```

### Step 3: Backend Cache Clear
```bash
cd backend
php artisan config:clear
php artisan cache:clear
```

### Step 4: Clear Browser Cache (Chrome/Edge/Firefox)
```
Ctrl + Shift + Delete
Select "All time"
Click "Clear data"
```

### Step 5: Close ALL Browser Windows/Tabs
- Close entire browser completely
- Don't just close tab

### Step 6: Restart Everything
```bash
# Terminal 1: Backend
cd backend
php artisan serve --host=localhost --port=8000

# Terminal 2: Frontend (wait 3 seconds)
cd frontend
flutter run -d chrome
```

### Step 7: Test Again
1. Open app at `http://localhost:XXXXX` (flutter dev port)
2. Login dengan: `admin@opticvault.com` / `password123`
3. **Should work now!** ✅

---

## Verify Fixes Applied

Sebelum restart, verify semua fixes sudah di-apply:

### Backend Checks
```bash
# Check 1: CORS config
php artisan config:show cors.allowed_origins_patterns
# Should show regex patterns

# Check 2: Auth guard
php artisan config:show auth.defaults.guard
# Should show: sanctum

# Check 3: Server running
curl http://localhost:8000/api/health
# Should return: {"status":"OK","timestamp":"..."}
```

### Frontend Checks
```dart
// Check main.dart memiliki:
void main() async {
  await ApiClient().initialize();  // ✅ Ada ini
  runApp(const OpticVaultApp());
}
```

---

## Verification Commands

Setelah restart, test dengan commands ini:

### Test 1: Preflight Request
```powershell
$headers = @{"Origin"="http://localhost:52725"}
(Invoke-WebRequest -Uri "http://localhost:8000/api/auth/login" -Method OPTIONS `
  -Headers $headers -UseBasicParsing).RawContent | Select-String "Access-Control-Allow-Origin"
# Should show: Access-Control-Allow-Origin: http://localhost:52725
```

### Test 2: Login Request
```powershell
$body = @{email="admin@opticvault.com"; password="password123"} | ConvertTo-Json
(Invoke-WebRequest -Uri "http://localhost:8000/api/auth/login" -Method POST `
  -ContentType "application/json" -Body $body -UseBasicParsing).Content | ConvertFrom-Json
# Should show token in response
```

### Test 3: Health Check
```powershell
(Invoke-WebRequest -Uri "http://localhost:8000/api/health" -UseBasicParsing).Content
# Should show: {"status":"OK","timestamp":"..."}
```

---

## Common Issues

### Still Getting CORS Error?

**1. Check Browser DevTools Network Tab:**
- Open DevTools (F12)
- Network tab
- Try login
- Look at OPTIONS preflight request
- Check Response Headers
- Should show: `Access-Control-Allow-Origin: http://localhost:52725`

**2. If NO CORS headers:**
- Backend server tidak restart
- Config cache belum clear
- Run: `php artisan config:clear && php artisan cache:clear`
- Kill PHP processes: `Get-Process php | Stop-Process -Force`
- Restart server: `php artisan serve`

**3. If CORS headers ada tapi still error:**
- Browser cache corrupt
- Clear browser cache completely
- Close browser
- Restart browser
- Refresh page

### Still Getting 500 on Items?

Check logs:
```bash
tail -f backend/storage/logs/laravel.log
```

Common causes:
- Token not in header → missing Authorization bearer
- Validation error → check field names match API expectation
- Database error → run `php artisan migrate:fresh --seed`

---

## Advanced Debugging

### Enable Debug Mode
Edit `backend/.env`:
```
APP_DEBUG=true
```

Then errors akan show detailed messages.

### Check Requests in DevTools
1. Open DevTools (F12)
2. Network tab
3. Perform action (login, add item)
4. Click request
5. Headers tab → Check "Authorization" header
6. Response tab → See error details

### Example Headers Should Show:
```
Request Headers:
  Authorization: Bearer 17|POYkEa0uSvlRbQ7rGvB9y40N6NQgMA0CfM80I2YXd761b535
  Content-Type: application/json
  Accept: application/json

Response Headers:
  Access-Control-Allow-Origin: http://localhost:52725
  Access-Control-Allow-Credentials: true
```

---

## Summary

✅ **Backend**: Fixed CORS, auth, exceptions
✅ **Frontend**: Inisialisasi ApiClient, token loading
❌ **Browser**: Cache lama perlu di-clear

**Actions:**
1. Hard refresh (Ctrl + Shift + R)
2. Clear browser cache (Ctrl + Shift + Delete)
3. Close browser completely
4. Restart everything
5. Test again

Biasanya after clear cache, semua akan jalan dengan baik! 🎉
