# OpticVault - Architecture & Best Practices

Dokumentasi arsitektur teknis dan best practices untuk OpticVault.

## 🏗️ Architecture Overview

### Monolithic + Mobile Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                     Flutter Mobile App                       │
│  ┌─────────────────┐      ┌──────────────────────────┐      │
│  │  UI Layer       │      │  State Management (BLoC) │      │
│  │  - Screens      │──────│  - Events                │      │
│  │  - Widgets      │      │  - States                │      │
│  │  - Theme        │      │  - Bloc Logic            │      │
│  └─────────────────┘      └──────────────────────────┘      │
│           │                          │                       │
│  ┌────────┴────────────────────────┬─────────────────────┐  │
│  │         Service Layer           │                     │  │
│  │  - AuthService                  │  Local Storage      │  │
│  │  - CategoryService              │  (Hive/SharedPref)  │  │
│  │  - ItemService                  │                     │  │
│  └────────┬────────────────────────┴─────────────────────┘  │
│           │                                                  │
│  ┌────────┴─────────────────────────────────────────────┐   │
│  │  API Client Layer                                    │   │
│  │  - HTTP Client (http package)                        │   │
│  │  - Token Management                                  │   │
│  │  - Error Handling                                    │   │
│  └────────┬─────────────────────────────────────────────┘   │
└───────────┼──────────────────────────────────────────────────┘
            │
            │ HTTP/REST
            │
┌───────────┴──────────────────────────────────────────────────┐
│              Laravel REST API Backend                         │
│  ┌─────────────────────────────────────────────────────────┐ │
│  │  API Layer (Routes & Controllers)                       │ │
│  │  - POST   /api/auth/login                               │ │
│  │  - GET/POST/PUT/DELETE /api/categories                  │ │
│  │  - GET/POST/PUT/DELETE /api/items                       │ │
│  └─────────────────────────────────────────────────────────┘ │
│                        │                                      │
│  ┌─────────────────────┴────────────────────────────────────┐ │
│  │  Middleware Layer                                        │ │
│  │  - Auth (JWT/Sanctum)                                    │ │
│  │  - CORS                                                  │ │
│  │  - Request Validation                                    │ │
│  └─────────────────────┬────────────────────────────────────┘ │
│                        │                                      │
│  ┌─────────────────────┴────────────────────────────────────┐ │
│  │  Business Logic Layer                                    │ │
│  │  - Service/Repository Pattern                            │ │
│  │  - Business Rules                                        │ │
│  │  - Data Transformation                                   │ │
│  └─────────────────────┬────────────────────────────────────┘ │
│                        │                                      │
│  ┌─────────────────────┴────────────────────────────────────┐ │
│  │  Data Access Layer                                       │ │
│  │  - Eloquent Models                                       │ │
│  │  - Database Queries                                      │ │
│  └─────────────────────┬────────────────────────────────────┘ │
└───────────────────────┼──────────────────────────────────────┘
                        │
                        │ SQL
                        │
            ┌───────────┴──────────┐
            │                      │
         MySQL             PostgreSQL
```

## 📱 Frontend Architecture

### Layered Architecture

```
┌──────────────────────────────────────────┐
│          Presentation Layer              │
│  ┌────────────────┐  ┌────────────────┐  │
│  │  Login Screen  │  │ Dashboard      │  │
│  │  Category List │  │ Category Form  │  │
│  │  Item List     │  │ Item Form      │  │
│  └────────────────┴──┴────────────────┘  │
└───────────────┬──────────────────────────┘
                │
┌───────────────┴──────────────────────────┐
│      State Management Layer (BLoC)       │
│  ┌────────────────┐  ┌────────────────┐  │
│  │  AuthBloc      │  │ CategoryBloc   │  │
│  │  ItemBloc      │  │ DashboardBloc  │  │
│  └────────────────┴──┴────────────────┘  │
└───────────────┬──────────────────────────┘
                │
┌───────────────┴──────────────────────────┐
│        Business Logic Layer              │
│  ┌────────────────┐  ┌────────────────┐  │
│  │  AuthService   │  │ CategoryServ.  │  │
│  │  ItemService   │  └────────────────┘  │
│  └────────────────┘                      │
└───────────────┬──────────────────────────┘
                │
┌───────────────┴──────────────────────────┐
│         Data Access Layer               │
│  ┌────────────────┐  ┌────────────────┐  │
│  │  ApiClient     │  │ LocalStorage   │  │
│  │  (HTTP)        │  │ (Hive/SharedP) │  │
│  └────────────────┴──┴────────────────┘  │
└──────────────────────────────────────────┘
```

### BLoC Pattern Flow

```
┌─────────────┐
│   Event     │  (User interaction: button tap, form submit)
│  (e.g.      │
│  LoginEvent)│
└──────┬──────┘
       │
       ▼
┌─────────────────────────────┐
│  BLoC (Business Logic)      │
│  - Receive event            │
│  - Call service             │
│  - Transform data           │
└──────┬──────────────────────┘
       │
       ▼
┌─────────────────────────────┐
│  Emit State                 │
│  (e.g. LoadingState,        │
│   SuccessState, ErrorState) │
└──────┬──────────────────────┘
       │
       ▼
┌─────────────────────────────┐
│  UI Rebuilds                │
│  Based on new state         │
└─────────────────────────────┘
```

## 🖥️ Backend Architecture

### MVC + Repository Pattern

```
Routes
  ↓
Controllers (HTTP layer)
  ↓
Service Layer / Repository Pattern (Business logic)
  ↓
Models (Data access)
  ↓
Database
```

### Request Flow

```
┌─────────────────┐
│  HTTP Request   │
└────────┬────────┘
         │
    ┌────┴──────────┐
    │ CORS Middleware│
    └────┬──────────┘
         │
    ┌────┴──────────┐
    │Auth Middleware │ (JWT Validation)
    └────┬──────────┘
         │
    ┌────┴─────────────┐
    │ Route Dispatcher │
    └────┬─────────────┘
         │
    ┌────┴─────────────┐
    │   Controller    │ (Request handling)
    └────┬─────────────┘
         │
    ┌────┴─────────────────────┐
    │  Service/Repository      │ (Business logic)
    └────┬──────────────────────┘
         │
    ┌────┴──────────┐
    │    Model      │ (Query builder)
    └────┬──────────┘
         │
    ┌────┴──────────┐
    │   Database    │
    └────┬──────────┘
         │
    ┌────┴──────────────┐
    │   HTTP Response  │
    └────────────────────┘
```

## 📚 Design Patterns Used

### 1. **Singleton Pattern** (API Client)
```dart
// Ensures single instance of API client throughout app
static final ApiClient _instance = ApiClient._internal();

factory ApiClient() {
  return _instance;
}
```

### 2. **Factory Pattern** (Models)
```dart
// Creates model instances from JSON
factory UserModel.fromJson(Map<String, dynamic> json) {
  return UserModel(
    id: json['id'],
    name: json['name'],
    email: json['email'],
  );
}
```

### 3. **Service Locator Pattern** (Future - DI)
```dart
// Will use get_it for dependency injection
final getIt = GetIt.instance;
getIt.registerSingleton<AuthService>(AuthService());
```

### 4. **Repository Pattern** (Backend)
```php
// Separates data access from business logic
class CategoryRepository {
  public function getAll() { }
  public function findById($id) { }
  public function create($data) { }
  public function update($id, $data) { }
  public function delete($id) { }
}
```

## 🔐 Security Considerations

### Frontend Security
1. **Token Management**
   - Store JWT securely (encrypted SharedPreferences/Keychain)
   - Refresh token implementation
   - Clear token on logout

2. **Input Validation**
   - Email format validation
   - Password strength validation
   - Form field sanitization

3. **Network Security**
   - Use HTTPS in production
   - Certificate pinning (optional)
   - CORS configuration

### Backend Security
1. **Authentication**
   - JWT with expiration time
   - Refresh token mechanism
   - Rate limiting on auth endpoints

2. **Authorization**
   - Role-based access control
   - Middleware for protected routes

3. **Data Validation**
   - Input validation on all endpoints
   - Sanitization of user input
   - SQL injection prevention (ORM)

4. **API Security**
   - CORS headers
   - CSRF protection
   - Request rate limiting

## 📊 Data Flow Examples

### Login Flow
```
User enters email/password
           ↓
LoginScreen validates input
           ↓
Calls AuthService.login()
           ↓
ApiClient.post('/auth/login')
           ↓
Backend validates credentials
           ↓
Returns JWT token + user data
           ↓
Store token locally
           ↓
Set ApiClient authorization header
           ↓
Navigate to Dashboard
```

### Fetch Items Flow
```
DashboardScreen loaded
           ↓
DashboardBloc emits FetchItemsEvent
           ↓
ItemService.getRecentItems()
           ↓
ApiClient.get('/items/recent')
           ↓
Backend queries database
           ↓
Returns paginated items
           ↓
Bloc emits ItemsLoadedState with data
           ↓
UI rebuilds with items list
```

## 📈 Performance Considerations

### Frontend
1. **State Management**
   - Use BLoC to avoid rebuilding entire widget tree
   - Implement `Equatable` for state comparison

2. **Image Loading**
   - Lazy load images
   - Use cached_network_image for caching

3. **List Performance**
   - Use `ListView.builder` for large lists
   - Implement pagination

4. **Memory Management**
   - Dispose BLoCs properly
   - Close streams
   - Cancel API requests

### Backend
1. **Database Optimization**
   - Use indexes on frequently queried columns
   - Eager loading with `with()` to avoid N+1 queries
   - Pagination for large result sets

2. **API Response**
   - Only return necessary fields
   - Implement API versioning
   - Use response caching where appropriate

3. **Authentication**
   - Token expiration to prevent abuse
   - Rate limiting on sensitive endpoints

## 🧪 Testing Strategy

### Frontend Testing
```
Unit Tests (Services, Models)
         ↓
Widget Tests (Individual screens)
         ↓
Integration Tests (Full user flows)
```

### Backend Testing
```
Unit Tests (Models, Services)
         ↓
Feature Tests (API endpoints)
         ↓
Integration Tests (Database + API)
```

## 🚀 Scalability

### Future Improvements
1. **Caching Layer**
   - Redis for session/cache
   - API response caching

2. **Async Processing**
   - Job queues for long operations
   - Background workers

3. **Microservices** (if needed)
   - Separate services for auth, items, categories
   - API gateway

4. **Real-time Features**
   - WebSocket for live updates
   - Notification system

5. **Offline Support**
   - Local database sync
   - Conflict resolution

## 📝 Code Organization Best Practices

### Frontend (Dart)
```
✅ DO:
- Use meaningful variable names
- Keep widgets small and focused
- Separate concerns (UI, logic, data)
- Use constants for magic strings/numbers
- Document complex logic with comments

❌ DON'T:
- Put all code in one file
- Mix UI and business logic
- Use raw strings/numbers in UI
- Make widgets do too much
```

### Backend (PHP/Laravel)
```
✅ DO:
- Use meaningful method/variable names
- Follow Laravel conventions
- Separate concerns (controllers, services, models)
- Use dependency injection
- Write clear API responses

❌ DON'T:
- Put business logic in controllers
- Use raw database queries
- Repeat code across controllers
- Return unclear error messages
```

## 🔄 Deployment Checklist

### Backend
- [ ] Set production environment variables
- [ ] Enable caching
- [ ] Disable debug mode
- [ ] Run migrations
- [ ] Setup database backups
- [ ] Configure CORS properly
- [ ] Setup logging
- [ ] SSL/HTTPS certificate

### Frontend
- [ ] Update API base URL for production
- [ ] Remove debug prints
- [ ] Enable proguard (Android)
- [ ] Setup app signing
- [ ] Test on real devices
- [ ] Performance optimization
- [ ] Release build

---

**Next Step**: Implement BLoC state management and connect to real backend endpoints.
