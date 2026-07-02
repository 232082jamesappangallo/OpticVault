# OpticVault - Cara Menjalankan Aplikasi

## 🚀 Quick Start (5 Menit)

### 1️⃣ Setup Backend

```bash
# Terminal 1 - Backend Setup
cd backend

# Install dependencies
composer install

# Setup environment
cp .env.example .env

# Generate key
php artisan key:generate

# Setup database
# Update .env dengan database credentials
# Contoh:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=opticvault
# DB_USERNAME=root
# DB_PASSWORD=

# Create database
mysql -u root -p -e "CREATE DATABASE opticvault"

# Run migrations & seed
php artisan migrate --seed

# Start backend (tetap berjalan)
php artisan serve
```

Backend akan berjalan di: **http://localhost:8000**

### 2️⃣ Setup Frontend

```bash
# Terminal 2 - Frontend Setup
cd frontend

# Get dependencies
flutter pub get

# Run app
flutter run
```

### 3️⃣ Test Login

Gunakan kredensial dari database seeder:
- **Email**: `admin@opticvault.com`
- **Password**: `password123`

## ✨ Yang Sudah Terhubung ke Database

### ✅ Login Screen
- Login dengan credentials dari database
- Generate JWT token
- Store token di memory (siap untuk SharedPreferences)
- Navigate ke Dashboard

### ✅ Register Screen
- Register user baru ke database
- Auto-redirect ke Login setelah sukses

### ✅ Dashboard Screen
- Fetch recent items dari API `/api/items/recent`
- Display dengan real data dari database
- Logout dengan token revocation

### ✅ API Integration
- `POST /api/auth/login` - Real authentication
- `POST /api/auth/register` - Real registration
- `GET /api/items/recent` - Real data fetching
- `POST /api/auth/logout` - Real token revocation

## 🔗 Backend API Endpoints

Semua endpoint siap digunakan:

```
# Authentication
POST   /api/auth/register
POST   /api/auth/login
GET    /api/auth/profile
POST   /api/auth/logout

# Categories
GET    /api/categories
POST   /api/categories
GET    /api/categories/{id}
PUT    /api/categories/{id}
DELETE /api/categories/{id}

# Items
GET    /api/items
POST   /api/items
GET    /api/items/{id}
PUT    /api/items/{id}
DELETE /api/items/{id}
GET    /api/items/recent
GET    /api/categories/{id}/items
```

## 📱 Current Screens Status

| Screen | Status | Integration |
|--------|--------|-------------|
| Login | ✅ Complete | ✅ Real API |
| Register | ✅ Complete | ✅ Real API |
| Dashboard | ✅ Complete | ✅ Real API |
| Categories List | ⏳ TODO | - |
| Category Form | ⏳ TODO | - |
| Items List | ⏳ TODO | - |
| Item Form | ⏳ TODO | - |

## 🔐 Authentication Flow

```
1. User enters email/password di Login Screen
2. Frontend calls: POST /api/auth/login
3. Backend validates & returns JWT token
4. Frontend stores token (in memory for now)
5. All next requests include token in header
6. Navigate to Dashboard
7. Dashboard fetches recent items with token
```

## 🗄️ Database Seeder

Automatic seeder menciptakan:

```
✅ 1 Admin User
   Email: admin@opticvault.com
   Password: password123

✅ 7 Categories
   - Kamera
   - Lensa
   - Lighting
   - Tripod & Stand
   - Background
   - Audio
   - Aksesoris

✅ 15 Items
   - Distributed across categories
   - Ready for testing
```

## 🐛 Troubleshooting

### Backend tidak bisa connect ke database
```bash
# Check MySQL status
mysql -u root -p -e "SELECT 1"

# Verify .env database settings
# Update credentials di .env
# Try again
php artisan migrate
```

### Frontend error: "Connection refused"
```
Pastikan:
1. Backend sudah running: php artisan serve
2. Backend URL correct: http://localhost:8000
3. Untuk Android emulator gunakan: http://10.0.2.2:8000
```

### Database tidak ter-seed
```bash
php artisan migrate:rollback
php artisan migrate --seed
```

### Token errors di Dashboard
```
Ini normal jika:
- Baru pertama kali login
- Token belum di-persist ke storage
- Todo: Implement SharedPreferences untuk token persistence
```

## 📋 Next Steps

### Priority 1 (Immediate)
- [ ] Persist JWT token ke SharedPreferences
- [ ] Load token on app startup
- [ ] Implement token refresh mechanism
- [ ] Create Categories List screen
- [ ] Create Items List screen

### Priority 2 (Important)
- [ ] Add Category form (create/edit)
- [ ] Add Item form (create/edit)
- [ ] Implement BLoC for state management
- [ ] Add search & filter
- [ ] Add pagination

### Priority 3 (Nice to have)
- [ ] Image upload for items
- [ ] Offline support
- [ ] Local caching
- [ ] Unit tests
- [ ] Dark mode

## 📊 Current Database State

```
Admin User:
- ID: 1
- Email: admin@opticvault.com
- Password: password123 (bcrypted)

Categories: 7 pre-created
Items: 15 pre-created with relationships

Ready for testing all CRUD operations!
```

## 🔗 File Structure Reference

**Frontend Key Files:**
- `frontend/lib/main.dart` - App entry
- `frontend/lib/screens/login_screen.dart` - Login UI (Real API)
- `frontend/lib/screens/register_screen.dart` - Register UI (Real API)
- `frontend/lib/screens/dashboard_screen.dart` - Dashboard UI (Real API)
- `frontend/lib/api/auth_service.dart` - Auth API calls
- `frontend/lib/api/item_service.dart` - Item API calls

**Backend Key Files:**
- `backend/routes/api.php` - API routes
- `backend/app/Http/Controllers/AuthController.php`
- `backend/app/Http/Controllers/ItemController.php`
- `backend/database/seeders/DatabaseSeeder.php`

## ✅ Ready to Development!

```
✅ Backend: Fully functional with real database
✅ Frontend: Connected to real API
✅ Authentication: Working with JWT
✅ Data fetching: Real-time from database

Next: Build Category & Item management screens!
```

---

**Tips:**
- Terminal 1: Backend (tetap running)
- Terminal 2: Frontend (hot reload support)
- Keep both running for best development experience
- Use Postman to test API endpoints manually if needed

**Ready? Let's go! 🎉**
