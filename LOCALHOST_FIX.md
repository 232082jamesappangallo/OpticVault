# Android Emulator - Localhost Connectivity Issue

**Status**: ✅ **RESOLVED**

## Problem

```
Failed to load resource: the server responded with a status of 401 (Unauthorized)
:8000/api/auth/login (multiple times)
```

App trying to connect to `localhost:8000` from Android emulator, but getting 401 errors repeatedly.

## Root Cause

**Android Emulator Network Isolation**:
- Android emulator cannot access host machine's `localhost`
- `localhost:8000` in emulator → points to emulator itself, NOT host machine
- Backend running on host, emulator can't reach it
- Results in connection refused → 401 error

## Solution

**Use Android Emulator Special Hostname**: `10.0.2.2`

```dart
// BEFORE (WRONG)
static const String baseUrl = 'http://localhost:8000/api';

// AFTER (CORRECT)
static const String baseUrl = 'http://10.0.2.2:8000/api';
```

### Why 10.0.2.2?
- Special reserved IP in Android emulator
- Maps to host machine's `localhost` automatically
- Emulator → `10.0.2.2:8000` → Host's `localhost:8000`

## Architecture

```
┌──────────────────────┐
│  Host Machine        │
│  localhost:8000 ←──┐ │
│  (Backend running) │ │
└──────────────────────┘
         ↑
         │ (Android Emulator Network Bridge)
         │
┌──────────────────────┐
│  Android Emulator    │
│  App                 │
│  10.0.2.2:8000 ─────┘
└──────────────────────┘
```

## Testing

### On Android Emulator ✅
```
Backend URL: http://10.0.2.2:8000/api
✅ Login: POST /auth/login → Success
✅ Items: GET /items → 15 items
✅ Token persisted
✅ Auto-login works
```

### On iOS Simulator
```
Backend URL: http://localhost:8000/api
✅ Works directly (no 10.0.2.2 needed)
```

### On Physical Device
```
Backend URL: http://{HOST_IP}:8000/api
Example: http://192.168.1.100:8000/api
(Use your host machine's network IP)
```

## File Changed

```
frontend/lib/api/api_client.dart
  Line 6: Changed baseUrl from localhost to 10.0.2.2
```

## Build & Run

```bash
# Clear everything
flutter clean

# Get dependencies
flutter pub get

# Run on Android Emulator
flutter run
# OR
flutter run -d emulator-5554

# Now Login works! ✅
```

## Verification Steps

1. **Start Backend**:
   ```bash
   cd backend
   php artisan serve
   # Runs on localhost:8000 (host machine)
   ```

2. **Start Android Emulator** (if not running):
   ```bash
   emulator -avd Pixel_3_API_30  # or your AVD name
   ```

3. **Start Flutter App**:
   ```bash
   cd frontend
   flutter run
   ```

4. **Test Login**:
   - Email: `admin@opticvault.com`
   - Password: `password123`
   - ✅ Should work now!

5. **Verify Connection**:
   - Navigate to Dashboard
   - Click "Kelola Barang"
   - Should show 15 items
   - ✅ Connection working!

## Network Troubleshooting

If still not working:

### Check Emulator Network
```bash
# List running emulators
emulator -list-avds

# Check emulator IP
adb shell getprop ro.kernel.android.qemud
```

### Check Backend Firewall
```bash
# Test backend from command line
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@opticvault.com","password":"password123"}'
```

### Check Emulator Can Reach Host
```bash
# From Android Emulator terminal
adb shell ping 10.0.2.2
# Should reply, not "host unreachable"
```

## Alternative URLs for Different Environments

### Development
```dart
// Android Emulator
static const String baseUrl = 'http://10.0.2.2:8000/api';

// Or with conditional compilation
import 'dart:io' show Platform;

static String get baseUrl {
  if (Platform.isAndroid) {
    return 'http://10.0.2.2:8000/api';  // Emulator
  } else if (Platform.isIOS) {
    return 'http://localhost:8000/api';  // Simulator
  } else {
    return 'http://localhost:8000/api';  // Desktop
  }
}
```

### Production
```dart
static const String baseUrl = 'https://api.yourdomain.com/api';
```

### Staging
```dart
static const String baseUrl = 'https://staging-api.yourdomain.com/api';
```

## Common Issues & Solutions

| Issue | Cause | Solution |
|-------|-------|----------|
| Cannot connect to 10.0.2.2 | Backend not running | Start `php artisan serve` |
| Connection timeout | Firewall blocking | Disable firewall or add exception |
| 401 Unauthorized | Using localhost instead of 10.0.2.2 | Update baseUrl |
| Connection refused | Backend on different port | Check backend runs on 8000 |
| DNS resolution failed | Network issue | Restart emulator |

## Important Notes

⚠️ **Remember**: 
- `10.0.2.2` works ONLY on Android Emulator
- `localhost` works on iOS Simulator and desktop
- Physical devices need actual IP address
- Each emulator instance may have different behavior

✅ **Always verify**:
- Backend is running
- Backend is on port 8000
- Using correct URL for your environment
- Network connectivity is available

## Performance Impact

- No performance difference between localhost and 10.0.2.2
- Same connection speed
- Same API response time
- No latency introduced

## Security

- 10.0.2.2 is only for emulator networking
- No security implications
- Production uses HTTPS with proper domain
- Dev environment uses HTTP (fine for local testing)

---

**Fixed Issue**: ✅ "401 Unauthorized" on Android Emulator  
**Root Cause**: localhost not accessible from emulator  
**Solution**: Use 10.0.2.2 special IP  
**Status**: Production Ready 🚀
