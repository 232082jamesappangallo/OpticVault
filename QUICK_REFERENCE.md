# OpticVault - Quick Reference

Panduan cepat untuk command, endpoint, dan informasi penting.

## 🚀 Quick Start Commands

### Start Backend
```bash
cd backend
php artisan serve
# Runs at: http://localhost:8000
```

### Start Frontend
```bash
cd frontend
flutter run
```

### Both Together (dari root)
```bash
# Terminal 1 - Backend
cd backend && php artisan serve

# Terminal 2 - Frontend
cd frontend && flutter run
```

## 🔌 API Endpoints Quick Lookup

### Authentication
```
POST   /api/auth/register       Register new user
POST   /api/auth/login          Login user
POST   /api/auth/logout         Logout (requires token)
GET    /api/auth/profile        Get current user (requires token)
```

### Categories (All require authentication)
```
GET    /api/categories          Get all categories
GET    /api/categories/{id}     Get category detail
POST   /api/categories          Create category
PUT    /api/categories/{id}     Update category
DELETE /api/categories/{id}     Delete category
```

### Items (All require authentication)
```
GET    /api/items               Get all items
GET    /api/items/{id}          Get item detail
GET    /api/items/recent        Get recent items (for dashboard)
POST   /api/items               Create item
PUT    /api/items/{id}          Update item
DELETE /api/items/{id}          Delete item
GET    /api/categories/{id}/items  Get items by category
```

## 🧪 Testing API with cURL

### Login
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@example.com",
    "password": "password"
  }'
```

### Get Categories (replace TOKEN with actual token)
```bash
curl -X GET http://localhost:8000/api/categories \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json"
```

### Create Category
```bash
curl -X POST http://localhost:8000/api/categories \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Kamera",
    "description": "Peralatan kamera studio"
  }'
```

## 📱 Screen Navigation

### Current Screens
```
LoginScreen
  ↓ (after login)
DashboardScreen
  ├─ Kelola Kategori (TBD)
  └─ Kelola Barang (TBD)
```

### Programmatic Navigation
```dart
// Push to new screen
Navigator.pushNamed(context, '/dashboard');

// Replace current screen
Navigator.pushReplacementNamed(context, '/login');

// Pop current screen
Navigator.pop(context);
```

## 💾 File Locations

### Important Frontend Files
```
frontend/lib/
├── main.dart                    ← App entry point
├── screens/
│   ├── login_screen.dart       ← Login UI
│   └── dashboard_screen.dart   ← Dashboard UI
├── models/
│   ├── user_model.dart
│   ├── category_model.dart
│   └── item_model.dart
├── api/
│   ├── api_client.dart         ← HTTP client
│   ├── auth_service.dart
│   ├── category_service.dart
│   └── item_service.dart
└── constants/
    ├── app_colors.dart         ← Colors palette
    ├── app_strings.dart        ← Text strings
    └── app_theme.dart          ← Typography & theme
```

### Important Backend Files
```
backend/
├── app/Http/Controllers/
│   ├── AuthController.php
│   ├── CategoryController.php
│   └── ItemController.php
├── app/Models/
│   ├── User.php
│   ├── Category.php
│   └── Item.php
├── database/migrations/
│   └── (migration files)
├── routes/
│   └── api.php                 ← API routes definition
└── config/
    ├── auth.php
    └── sanctum.php
```

## 🎨 Colors Quick Lookup

```dart
AppColors.primaryDark       // #1E3A8A (Navy Blue)
AppColors.primaryBright     // #2563EB (Bright Blue)
AppColors.accentOrange      // #F97316
AppColors.accentGreen       // #16A34A
AppColors.accentRed         // #DC2626
AppColors.success           // #10B981
AppColors.error             // #EF4444
AppColors.textDark          // #1F2937
AppColors.textGray          // #6B7280
```

## 🔤 Common Strings

```dart
AppStrings.appName              // "OpticVault"
AppStrings.loginButton          // "MASUK"
AppStrings.dashboardTitle       // "Dashboard"
AppStrings.welcomeMessage       // "Halo, Admin Studio!"
AppStrings.manageCategories     // "Kelola Kategori"
AppStrings.manageInventory      // "Kelola Barang"
```

## 🛠️ Common Tasks

### Add New Screen
1. Create file: `frontend/lib/screens/new_screen.dart`
2. Create StatefulWidget class
3. Add route in `main.dart`
4. Navigate using: `Navigator.pushNamed(context, '/route')`

### Add New API Service
1. Create file: `frontend/lib/api/new_service.dart`
2. Implement service methods using `ApiClient`
3. Import and use in screens/BLoCs

### Add Database Migration (Backend)
```bash
php artisan make:migration create_table_name
# Edit generated file
php artisan migrate
```

### Add API Controller (Backend)
```bash
php artisan make:controller Api/ControllerName
# Implement CRUD methods
# Add routes in routes/api.php
```

## 📋 Database Models

### User
```json
{
  "id": 1,
  "name": "Admin",
  "email": "admin@example.com",
  "created_at": "2024-01-01T00:00:00.000000Z"
}
```

### Category
```json
{
  "id": 1,
  "name": "Kamera",
  "description": "Peralatan kamera studio",
  "created_at": "2024-01-01T00:00:00.000000Z",
  "updated_at": "2024-01-01T00:00:00.000000Z"
}
```

### Item
```json
{
  "id": 1,
  "name": "Canon EOS R5",
  "description": "Professional mirrorless camera",
  "category_id": 1,
  "category_name": "Kamera",
  "quantity": 3,
  "location": "Studio A",
  "condition": "Baik",
  "created_at": "2024-01-01T00:00:00.000000Z",
  "updated_at": "2024-01-01T00:00:00.000000Z"
}
```

## 🔑 Important Packages

### Frontend (pubspec.yaml)
```yaml
flutter: SDK
flutter_bloc: ^8.1.3     # State management
http: ^1.2.1             # HTTP client
```

### Backend (composer.json)
```json
"laravel/framework": "^10.10"
"laravel/sanctum": "^3.3"    # JWT auth
```

## 📞 Useful Shortcuts

### Dart/Flutter
```
Ctrl+Shift+R    Format code
Ctrl+/          Comment/uncomment
Ctrl+Click      Go to definition
F2              Rename symbol
Ctrl+Shift+O    Organize imports
```

### Laravel
```bash
php artisan tinker                      # Interactive shell
php artisan route:list                  # Show routes
php artisan config:cache                # Cache config
php artisan config:clear                # Clear config cache
php artisan cache:clear                 # Clear all cache
```

## 🐛 Debug Tips

### Frontend Debug
```dart
// Print to console
debugPrint('Debug message: $variable');

// Use Flutter DevTools
flutter pub global activate devtools
devtools
```

### Backend Debug
```php
// Log to file
Log::info('Message', ['data' => $data]);
// Check in: storage/logs/laravel.log

// Use tinker for quick testing
php artisan tinker
> User::all()
```

## 📚 Documentation Files

- **README.md** - Main project overview
- **SETUP_GUIDE.md** - Installation & setup instructions
- **ARCHITECTURE.md** - Architecture & design patterns
- **OPTICVAULT_STRUCTURE.md** - Detailed folder structure
- **QUICK_REFERENCE.md** - This file

## ⚠️ Common Gotchas

1. **Android Emulator Network**
   - Use `http://10.0.2.2:8000` instead of `http://localhost:8000`

2. **CORS Errors**
   - Make sure backend has CORS enabled in `config/cors.php`
   - Frontend API base URL must match backend URL

3. **Token Expiration**
   - Implement token refresh mechanism
   - Clear expired token and redirect to login

4. **Database Connection**
   - Verify `.env` database credentials
   - MySQL/PostgreSQL must be running
   - Check DB_HOST (localhost vs 127.0.0.1)

5. **Flutter Hot Reload**
   - Some changes require full restart (model changes, native code)
   - Press `Shift+R` to restart

## 🎯 Next Immediate Tasks

1. [ ] Test login flow with mock API
2. [ ] Implement BLoC for state management
3. [ ] Create Category List screen
4. [ ] Create Item List screen
5. [ ] Implement real API integration
6. [ ] Add form validation
7. [ ] Implement pagination
8. [ ] Add image upload
9. [ ] Implement local caching
10. [ ] Add unit tests

---

**Pro Tip**: Bookmark this file for quick access during development! 🚀
