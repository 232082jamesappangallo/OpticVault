# 🔐 JWT Configuration Guide

## Lokasi Konfigurasi JWT

### File Utama:
1. **`backend/config/sanctum.php`** - Konfigurasi token expiration
2. **`backend/.env`** - Environment variable untuk token lifetime

---

## Token Expiration Settings

### Di File: `backend/config/sanctum.php`

```php
'expiration' => env('SANCTUM_TOKEN_EXPIRATION', 60 * 24),
```

**Penjelasan:**
- `env('SANCTUM_TOKEN_EXPIRATION', 60 * 24)` = Baca dari .env, default 24 jam
- Token akan expired setelah durasi yang ditentukan
- Setelah expired, user harus login ulang

---

## Konfigurasi di `.env`

### Default (24 Jam):
```
SANCTUM_TOKEN_EXPIRATION=1440
```

### Opsi Lain:

**7 Hari:**
```
SANCTUM_TOKEN_EXPIRATION=10080
```

**30 Hari:**
```
SANCTUM_TOKEN_EXPIRATION=43200
```

**1 Jam:**
```
SANCTUM_TOKEN_EXPIRATION=60
```

**Tidak Pernah Expire (Development Only):**
```
SANCTUM_TOKEN_EXPIRATION=
```
atau
```
# Kosongkan atau comment SANCTUM_TOKEN_EXPIRATION
```

---

## Cara Mengubah Token Expiration

### Step 1: Edit `.env`
```bash
# Ganti nilai SANCTUM_TOKEN_EXPIRATION
SANCTUM_TOKEN_EXPIRATION=10080  # 7 hari
```

### Step 2: Clear Cache
```bash
cd backend
php artisan config:clear
php artisan cache:clear
```

### Step 3: Restart Server
```bash
# Kill existing process
Get-Process php | Stop-Process -Force

# Start fresh
php artisan serve --host=localhost --port=8000
```

---

## Current Settings

**File**: `backend/config/sanctum.php`
```php
'expiration' => env('SANCTUM_TOKEN_EXPIRATION', 60 * 24),
```

**File**: `backend/.env`
```
SANCTUM_TOKEN_EXPIRATION=1440
```

**Duration**: 24 hours (1440 minutes)

---

## Testing Token Expiration

### Cara Cek Token Sudah Expired:

1. **Login** → Token generated
2. **Wait** → Tunggu sampai durasi expiration
3. **Try POST /items** → Seharusnya return 401 Unauthorized
4. **Login Again** → Generate token baru

### Expected Behavior:
```
✅ Sebelum expired: Token bekerja (201/200)
❌ Sesudah expired: Token tidak valid (401)
```

---

## Security Best Practices

1. **Production**: Gunakan 24-72 jam
   ```
   SANCTUM_TOKEN_EXPIRATION=1440  # 24 jam
   ```

2. **Development**: Bisa lebih panjang
   ```
   SANCTUM_TOKEN_EXPIRATION=10080  # 7 hari
   ```

3. **Never**: Jangan infinite expiration di production
   ```
   # ❌ DON'T DO THIS IN PRODUCTION
   SANCTUM_TOKEN_EXPIRATION=
   ```

---

## Token Format

Token yang dihasilkan:
```
32|POYkEa0uSvlRbQ7rGvB9y40N6NQgMA0CfM80I2YXd761b535
├─ ID (sebelum |)
└─ Hash (setelah |)
```

**Struktur:**
- ID: User token ID di database
- Hash: Encrypted token value
- Expiration: Ditentukan oleh config

---

## File Reference

```
backend/
├── config/
│   └── sanctum.php          ← 'expiration' setting
├── .env                      ← SANCTUM_TOKEN_EXPIRATION
└── app/Models/User.php       ← HasApiTokens trait
```

---

## Troubleshooting

### Token Tidak Expired Padahal Sudah Tua

**Penyebab:**
- Config cache belum di-clear
- SANCTUM_TOKEN_EXPIRATION tidak ada di .env

**Solusi:**
```bash
php artisan config:clear
php artisan cache:clear
# Restart server
```

### Token Expired Terlalu Cepat

**Penyebab:**
- SANCTUM_TOKEN_EXPIRATION terlalu kecil

**Solusi:**
- Edit .env: Ubah nilai lebih besar
- Clear cache dan restart

---

## Summary

| Setting | File | Value | Duration |
|---------|------|-------|----------|
| Expiration | sanctum.php | env('SANCTUM_TOKEN_EXPIRATION', 60 * 24) | - |
| Environment | .env | SANCTUM_TOKEN_EXPIRATION=1440 | 24 jam |

**Current Status**: ✅ Token berlaku **24 jam**

Setelah 24 jam, user perlu login ulang untuk mendapatkan token baru!
