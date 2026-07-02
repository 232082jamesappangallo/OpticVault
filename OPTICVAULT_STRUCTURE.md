# OpticVault - Struktur Proyek

## 📁 Struktur Folder

```
opticvault/
├── backend/                          # Laravel REST API Backend
│   ├── app/
│   │   ├── Console/                 # Artisan commands
│   │   ├── Exceptions/              # Exception handlers
│   │   ├── Http/
│   │   │   ├── Controllers/         # API Controllers
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   └── ItemController.php
│   │   │   ├── Kernel.php           # HTTP kernel
│   │   │   └── Middleware/          # Middlewares
│   │   ├── Models/                  # Eloquent Models
│   │   │   ├── User.php
│   │   │   ├── Category.php
│   │   │   └── Item.php
│   │   └── Providers/               # Service providers
│   ├── bootstrap/                   # Framework bootstrap
│   ├── config/                      # Configuration files
│   │   ├── app.php
│   │   ├── auth.php
│   │   ├── cors.php
│   │   ├── database.php
│   │   └── sanctum.php
│   ├── database/
│   │   ├── factories/               # Model factories
│   │   ├── migrations/              # Database migrations
│   │   └── seeders/                 # Database seeders
│   ├── public/                      # Public assets
│   ├── resources/                   # Blade templates & assets
│   ├── routes/
│   │   ├── api.php                  # API routes
│   │   └── web.php                  # Web routes
│   ├── storage/                     # Storage files
│   ├── tests/                       # Test files
│   ├── .env.example                 # Environment template
│   ├── composer.json                # PHP dependencies
│   ├── phpunit.xml                  # Test configuration
│   └── README.md                    # Backend documentation
│
├── frontend/                         # Flutter Mobile Frontend
│   ├── lib/
│   │   ├── api/                     # API Services
│   │   │   ├── api_client.dart      # HTTP client base
│   │   │   ├── auth_service.dart    # Authentication service
│   │   │   ├── category_service.dart # Category CRUD service
│   │   │   └── item_service.dart    # Item CRUD service
│   │   ├── models/                  # Data models
│   │   │   ├── user_model.dart
│   │   │   ├── category_model.dart
│   │   │   └── item_model.dart
│   │   ├── screens/                 # UI Screens
│   │   │   ├── login_screen.dart    # Login UI
│   │   │   ├── dashboard_screen.dart # Dashboard UI
│   │   │   ├── category_list_screen.dart (TBD)
│   │   │   ├── category_form_screen.dart (TBD)
│   │   │   ├── item_list_screen.dart (TBD)
│   │   │   └── item_form_screen.dart (TBD)
│   │   ├── constants/               # App constants
│   │   │   ├── app_colors.dart      # Color palette
│   │   │   ├── app_strings.dart     # String constants
│   │   │   └── app_theme.dart       # Theme & text styles
│   │   ├── services/                # Business logic services
│   │   │   └── local_storage.dart (TBD)
│   │   ├── views/                   # Reusable widgets
│   │   │   ├── custom_text_field.dart (TBD)
│   │   │   ├── custom_button.dart (TBD)
│   │   │   └── loading_widget.dart (TBD)
│   │   └── main.dart                # App entry point
│   ├── android/                     # Android native code
│   ├── ios/                         # iOS native code
│   ├── web/                         # Web support
│   ├── linux/                       # Linux support
│   ├── macos/                       # macOS support
│   ├── windows/                     # Windows support
│   ├── test/                        # Widget tests
│   ├── pubspec.yaml                 # Flutter dependencies
│   └── analysis_options.yaml        # Linter rules
│
├── README.md                         # Main project documentation
├── OPTICVAULT_STRUCTURE.md          # This file
└── .gitignore                       # Git ignore rules
```

## 🎯 Fitur Per Layar

### 1. Login Screen (`frontend/lib/screens/login_screen.dart`)
**Status**: ✅ Selesai

Komponen:
- Logo OpticVault dengan gradient biru
- Form email dengan validasi
- Form password dengan show/hide toggle
- Tombol login dengan loading animation
- Error handling dengan snackbar

**Validasi**:
- Email format check
- Password minimal 6 karakter

### 2. Dashboard Screen (`frontend/lib/screens/dashboard_screen.dart`)
**Status**: ✅ Selesai

Komponen:
- App bar dengan judul dan logout button
- Welcome greeting section
- Grid menu navigasi (2 cards):
  - Kelola Kategori
  - Kelola Barang
- List barang terbaru (3 items)

**Fitur**:
- Display recent items dengan mock data
- Logout confirmation dialog

### 3. Category List Screen (TBD)
**Komponen yang dibutuhkan**:
- List view dengan pagination
- Search functionality
- Add button (FAB)
- Edit/Delete actions per item

### 4. Category Form Screen (TBD)
**Komponen yang dibutuhkan**:
- Form untuk create/edit category
- Text field untuk nama & deskripsi
- Submit button
- Cancel button

### 5. Item List Screen (TBD)
**Komponen yang dibutuhkan**:
- List view dengan pagination
- Filter by category
- Search functionality
- Add button (FAB)
- Edit/Delete actions

### 6. Item Form Screen (TBD)
**Komponen yang dibutuhkan**:
- Form untuk create/edit item
- Text fields: name, description, location, condition
- Dropdown: category selection
- Numeric field: quantity
- Submit/Cancel buttons

## 🔌 API Integration

### Base URL
```
http://localhost:8000/api
```

### Authentication
- JWT Token dalam header: `Authorization: Bearer <token>`
- Token di-set setelah login berhasil

### Available Services
1. **AuthService** - Login, Register, Profile, Logout
2. **CategoryService** - CRUD operations untuk categories
3. **ItemService** - CRUD operations untuk items

## 🗄️ Database Schema

### Users Table
```sql
id, name, email, password, created_at, updated_at
```

### Categories Table
```sql
id, name, description, created_at, updated_at
```

### Items Table
```sql
id, name, description, category_id, quantity, location, condition, created_at, updated_at
```

## 🎨 Design System

### Color Palette
- **Primary Dark**: #1E3A8A (Navy Blue)
- **Primary Bright**: #2563EB (Bright Blue)
- **Accent Orange**: #F97316
- **Accent Green**: #16A34A
- **Background Light**: #FAFAFA
- **Text Dark**: #1F2937

### Typography
- **Heading XL**: 32px, Bold
- **Heading Large**: 28px, Bold
- **Body Large**: 16px, Regular
- **Body Medium**: 14px, Regular
- **Body Small**: 12px, Regular

### Component Sizes
- **Border Radius**: 12px (standard)
- **Padding**: 16-24px (standard)
- **Icon Size**: 24-32px (standard)

## 📦 Dependencies

### Frontend (Flutter)
```yaml
flutter: SDK
flutter_bloc: ^8.1.3      # State management
http: ^1.2.1              # HTTP client
fl_chart: ^0.69.0         # Charts (optional)
cupertino_icons: ^1.0.8   # iOS icons
```

### Backend (Laravel)
```
laravel/framework: ^10.10
laravel/sanctum: ^3.3     # JWT authentication
guzzlehttp/guzzle: ^7.2
```

## 🚀 Development Workflow

1. **Frontend Development**
   ```bash
   cd frontend
   flutter pub get
   flutter run
   ```

2. **Backend Development**
   ```bash
   cd backend
   composer install
   php artisan serve
   ```

3. **Testing**
   - Frontend: `flutter test`
   - Backend: `php artisan test`

## 📋 TODO List

### Frontend
- [ ] Implement BLoC state management
- [ ] Add category list screen
- [ ] Add category form screen
- [ ] Add item list screen
- [ ] Add item form screen
- [ ] Implement local storage (hive/shared_preferences)
- [ ] Add loading/error states
- [ ] Add pagination
- [ ] Add search functionality
- [ ] Add image upload
- [ ] Unit tests

### Backend
- [ ] Create Category Model & Migration
- [ ] Create Item Model & Migration
- [ ] Create API Controllers
- [ ] Create API Routes
- [ ] Implement JWT authentication
- [ ] Add validation rules
- [ ] Add error handling
- [ ] Add API documentation
- [ ] Unit tests
- [ ] Feature tests

## 🔗 Related Files

- Main App: `frontend/lib/main.dart`
- Theme: `frontend/lib/constants/app_theme.dart`
- Colors: `frontend/lib/constants/app_colors.dart`
- Strings: `frontend/lib/constants/app_strings.dart`
- API Client: `frontend/lib/api/api_client.dart`

## 📞 Notes

- Semua screen sudah siap dengan UI dasar
- Mock data digunakan untuk demonstrasi
- Integrasi API real perlu dilakukan selanjutnya
- BLoC implementation untuk state management masih pending
- Local storage untuk token persistence masih pending
