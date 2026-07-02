# 🔐 Token Management API

## Endpoints

Semua endpoint memerlukan authentication (Bearer token).

### 1. **GET /api/tokens** - Lihat Semua Token User

**Request:**
```bash
GET http://localhost:8000/api/tokens
Authorization: Bearer {token}
```

**Response:**
```json
{
  "message": "Tokens retrieved successfully",
  "data": [
    {
      "id": 38,
      "name": "auth-token",
      "last_used_at": "2026-07-01T12:20:41.000000Z",
      "created_at": "2026-07-01T12:20:41.000000Z",
      "expires_at": null,
      "abilities": ["*"]
    }
  ],
  "total": 1
}
```

---

### 2. **GET /api/tokens/current** - Info Token Saat Ini

**Request:**
```bash
GET http://localhost:8000/api/tokens/current
Authorization: Bearer {token}
```

**Response:**
```json
{
  "message": "Current token info",
  "data": {
    "id": 38,
    "name": "auth-token",
    "last_used_at": "2026-07-01T12:20:41.000000Z",
    "created_at": "2026-07-01T12:20:41.000000Z",
    "expires_at": null,
    "abilities": ["*"]
  }
}
```

---

### 3. **DELETE /api/tokens/{tokenId}** - Revoke Token Tertentu

**Request:**
```bash
DELETE http://localhost:8000/api/tokens/38
Authorization: Bearer {token}
```

**Response:**
```json
{
  "message": "Token revoked successfully"
}
```

---

### 4. **POST /api/tokens/revoke-all** - Revoke Semua Token

**Request:**
```bash
POST http://localhost:8000/api/tokens/revoke-all
Authorization: Bearer {token}
```

**Response:**
```json
{
  "message": "All tokens revoked successfully"
}
```

---

## Testing dengan PowerShell

### Test 1: Get All Tokens
```powershell
$token = "32|NjpxSml..."
$headers = @{"Authorization"="Bearer $token"}
(Invoke-WebRequest -Uri "http://localhost:8000/api/tokens" -Headers $headers -UseBasicParsing).Content | ConvertFrom-Json | ConvertTo-Json
```

### Test 2: Get Current Token
```powershell
$token = "32|NjpxSml..."
$headers = @{"Authorization"="Bearer $token"}
(Invoke-WebRequest -Uri "http://localhost:8000/api/tokens/current" -Headers $headers -UseBasicParsing).Content | ConvertFrom-Json | ConvertTo-Json
```

### Test 3: Revoke Specific Token
```powershell
$token = "32|NjpxSml..."
$headers = @{"Authorization"="Bearer $token"}
(Invoke-WebRequest -Uri "http://localhost:8000/api/tokens/38" -Method DELETE -Headers $headers -UseBasicParsing).Content
```

### Test 4: Revoke All Tokens
```powershell
$token = "32|NjpxSml..."
$headers = @{"Authorization"="Bearer $token"}
(Invoke-WebRequest -Uri "http://localhost:8000/api/tokens/revoke-all" -Method POST -Headers $headers -UseBasicParsing).Content
```

---

## Token Fields Explained

| Field | Arti |
|-------|------|
| `id` | Token ID di database |
| `name` | Nama token (usually "auth-token") |
| `last_used_at` | Kapan terakhir token digunakan |
| `created_at` | Kapan token dibuat |
| `expires_at` | Kapan token expired (null = tidak pernah) |
| `abilities` | Permissions (["*"] = semua akses) |

---

## Current Status

✅ **Endpoint**: GET /api/tokens
✅ **Status**: 200 OK
✅ **Response**: Menampilkan 1 token untuk admin user

```json
{
  "id": 38,
  "name": "auth-token",
  "created_at": "2026-07-01T12:20:41.000000Z",
  "expires_at": null,
  "abilities": ["*"]
}
```

---

## Files Modified/Created

1. **Created**: `backend/app/Http/Controllers/TokenController.php`
   - 4 methods: index(), current(), revoke(), revokeAll()

2. **Updated**: `backend/routes/api.php`
   - Added 4 token routes
   - Added TokenController import

3. **Cleared**: Route cache (php artisan route:clear)

---

## Use Cases

### 1. Security Audit
Check berapa token active untuk user tertentu
```
GET /api/tokens
```

### 2. Logout from All Devices
Revoke semua token user (force login ulang di semua device)
```
POST /api/tokens/revoke-all
```

### 3. Revoke Suspicious Token
Jika ada token yang suspicious, delete specific token
```
DELETE /api/tokens/{id}
```

### 4. Token Status Check
Cek info token yang sedang digunakan
```
GET /api/tokens/current
```

---

## Next Steps

### Frontend Integration (Optional):
Tambahkan UI di user profile untuk:
- Lihat semua token/login devices
- Logout dari device tertentu
- Logout dari semua devices

### Database Logging (Optional):
Track ketika token di-revoke untuk security audit

---

**Status**: ✅ Token Management API Ready!
