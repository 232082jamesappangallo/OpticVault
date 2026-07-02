# Frontend Debug Guide

## 🔧 Quick Testing Steps

### Step 1: Verify Backend is Running
```bash
curl http://localhost:8000/api/health
# Expected: {"status":"OK","timestamp":"..."}
```

### Step 2: Rebuild Flutter App
```bash
cd frontend
flutter clean
flutter pub get
flutter run
```

### Step 3: Test Login
- **Credentials**: 
  - Email: `admin@opticvault.com`
  - Password: `password123`
- **Expected**: Should navigate to dashboard, NOT show 401 error

### Step 4: Monitor Network Requests

#### Option A: Browser DevTools (Web)
1. Open DevTools (F12)
2. Go to Network tab
3. Try login and check:
   - POST `/api/auth/login` → Status 200
   - Response contains `token` field
   - Next request includes `Authorization: Bearer <token>` header

#### Option B: Flutter Console
Add debug print in `api_client.dart`:

```dart
/// GET request
Future<dynamic> get(String endpoint) async {
  try {
    print('🔵 GET $endpoint with token: ${_token?.substring(0, 10)}...');
    final response = await http.get(
      Uri.parse('$baseUrl$endpoint'),
      headers: _getHeaders(),
    ).timeout(
      const Duration(seconds: 30),
      onTimeout: () => throw Exception('Request timeout'),
    );

    print('📦 Response status: ${response.statusCode}');
    return _handleResponse(response);
  } catch (e) {
    throw Exception('GET request failed: $e');
  }
}
```

## 🔐 Token Flow Verification

### Expected Flow:

1. **main.dart starts**
   ```
   → ApiClient().initialize() called
   → Loads token from SharedPreferences
   → Sets _prefs and _token if exists
   ```

2. **User taps Login**
   ```
   → LoginScreen._handleLogin()
   → AuthService.login(email, password)
   → POST /auth/login
   → Backend returns token
   → ApiClient.setToken() saves to SharedPreferences
   → Navigate to Dashboard
   ```

3. **User adds Item**
   ```
   → ItemService.createItem()
   → POST /items with data
   → _getHeaders() includes Authorization: Bearer <token>
   → Backend validates token
   → Item created successfully
   ```

## ❌ Troubleshooting Common Issues

### Issue 1: "401 Unauthorized" on Login

**Possible Causes:**
1. Wrong email/password
   - **Solution**: Use `admin@opticvault.com` / `password123`

2. CORS error (might show in console)
   - **Solution**: Verify backend CORS config:
     ```bash
     php artisan config:show cors.allowed_origins
     # Should show: http://localhost:8081, http://localhost:3000, etc.
     ```

3. Request format wrong
   - **Debug**: Add logging to see what's being sent:
     ```dart
     print('📤 Request body: ${jsonEncode(data)}');
     print('📤 Headers: ${_getHeaders()}');
     ```

**Fix:**
```bash
# Backend
php artisan config:clear
php artisan cache:clear

# Frontend
flutter clean
flutter pub get
flutter run
```

---

### Issue 2: "500 Internal Server Error" on Items POST

**Possible Causes:**
1. Token not included in header
   - **Debug**: Check if `_token` is null in `_getHeaders()`
   - **Solution**: Ensure `ApiClient.setToken()` was called after login

2. Database error
   - **Debug**: Check `backend/storage/logs/laravel.log`
   - **Solution**: Run `php artisan migrate:fresh --seed`

3. Validation error (422 status)
   - **Debug**: Frontend might be hiding 422 in "500" error message
   - **Solution**: Check exact error in response

**Fix:**
```dart
// Add this to api_client.dart _handleResponse() to see exact error
print('🔴 Error: ${response.statusCode}');
print('📝 Response: $body');
```

---

### Issue 3: Token Not Persisting After App Restart

**Possible Causes:**
1. `ApiClient.initialize()` not called in `main()`
   - **Check**: `frontend/lib/main.dart` line 8-9
   - **Should be**: 
     ```dart
     Future<void> initialize() async {
       final prefs = await _getPrefs();
       _token = prefs.getString(_tokenKey);
     }
     ```

2. SharedPreferences not saving
   - **Debug**: Add logging:
     ```dart
     Future<void> setToken(String token) async {
       _token = token;
       final prefs = await _getPrefs();
       print('💾 Saving token to SharedPreferences...');
       await prefs.setString(_tokenKey, token);
       print('✅ Token saved: ${token.substring(0, 10)}...');
     }
     ```

3. Different ApiClient instances
   - **Check**: Singleton pattern is used correctly
   - **Should be**: All services use `ApiClient()` not `ApiClient._internal()`

**Fix:**
```bash
# Clear all data
flutter clean
rm -rf pubspec.lock
flutter pub get
flutter run

# Or on Windows PowerShell:
flutter clean
Remove-Item pubspec.lock
flutter pub get
flutter run
```

---

## 📋 API Endpoint Testing Reference

### Public Endpoints (No Token Required)

**Register**
```bash
POST http://localhost:8000/api/auth/register
Content-Type: application/json

{
  "name": "Test User",
  "email": "test@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Login**
```bash
POST http://localhost:8000/api/auth/login
Content-Type: application/json

{
  "email": "admin@opticvault.com",
  "password": "password123"
}

Response:
{
  "message": "Login successful",
  "data": {
    "id": 1,
    "name": "Admin Studio",
    "email": "admin@opticvault.com",
    "token": "14|Uo3syHC2uNrb...",
    "created_at": "2026-06-28T13:18:06.000000Z"
  }
}
```

### Protected Endpoints (Token Required)

**Create Item**
```bash
POST http://localhost:8000/api/items
Authorization: Bearer {TOKEN}
Content-Type: application/json

{
  "name": "Camera",
  "description": "Professional camera",
  "category": "Kamera",
  "quantity": 5,
  "location": "Studio 1",
  "condition": "Baik"
}
```

**Get Items**
```bash
GET http://localhost:8000/api/items?page=1&per_page=10
Authorization: Bearer {TOKEN}
```

**Get Recent Items**
```bash
GET http://localhost:8000/api/items/recent?limit=3
Authorization: Bearer {TOKEN}
```

**Update Item**
```bash
PUT http://localhost:8000/api/items/{id}
Authorization: Bearer {TOKEN}
Content-Type: application/json

{
  "name": "Updated Name",
  "description": "Updated description",
  "category": "Kamera",
  "quantity": 10,
  "location": "Studio 2"
}
```

**Delete Item**
```bash
DELETE http://localhost:8000/api/items/{id}
Authorization: Bearer {TOKEN}
```

---

## 🧪 Manual Testing with curl (Windows PowerShell)

### Get Token
```powershell
$body = @{email="admin@opticvault.com"; password="password123"} | ConvertTo-Json
$response = (Invoke-WebRequest -Uri "http://localhost:8000/api/auth/login" -Method POST -ContentType "application/json" -Body $body -UseBasicParsing).Content | ConvertFrom-Json
$token = $response.data.token
Write-Host "Token: $token"
```

### Create Item with Token
```powershell
$token = "14|Uo3syHC2uNrb..."
$headers = @{"Authorization"="Bearer $token"; "Content-Type"="application/json"}
$body = @{name="Test"; description="Desc"; category="Kamera"; quantity=5} | ConvertTo-Json
(Invoke-WebRequest -Uri "http://localhost:8000/api/items" -Method POST -Headers $headers -Body $body -UseBasicParsing).Content
```

---

## 📱 Platform-Specific Notes

### Android
- Use `10.0.2.2:8000` instead of `localhost:8000` if emulator
- Update `frontend/lib/api/api_client.dart`:
  ```dart
  static const String baseUrl = 'http://10.0.2.2:8000/api';
  ```

### iOS Emulator
- Use `localhost:8000` (direct access)
- May need to add exception for HTTP in `Info.plist`

### Web (Browser)
- Use `localhost:8000`
- Check DevTools Network tab for CORS issues

---

## 📝 Logging Checklist

Add these debug prints strategically:

```dart
// 1. In main.dart
void main() async {
  print('🚀 App starting...');
  await ApiClient().initialize();
  print('🔐 ApiClient initialized');
  runApp(const OpticVaultApp());
}

// 2. In auth_service.dart login()
print('📤 Sending login request...');
final response = await _apiClient.post('/auth/login', data: {...});
print('📥 Login response: $response');
if (user.token != null) {
  print('💾 Token received: ${user.token!.substring(0, 20)}...');
  await _apiClient.setToken(user.token!);
  print('✅ Token saved to ApiClient');
}

// 3. In item_service.dart createItem()
print('📤 Creating item: $name');
final response = await _apiClient.post('/items', data: {...});
print('📥 Item created: ${response['data']['id']}');
```

Then run with:
```bash
flutter run -v  # Verbose output
```
