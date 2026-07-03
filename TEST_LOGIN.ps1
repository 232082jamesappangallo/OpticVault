# Test Login Script

Write-Host "Testing OpticVault Backend Login" -ForegroundColor Green

$body = @{
    email = "admin@opticvault.com"
    password = "password123"
} | ConvertTo-Json

$headers = @{
    "Content-Type" = "application/json"
}

Write-Host "`n1. Testing Login Endpoint..."
try {
    $response = Invoke-RestMethod -Uri "http://localhost:8000/api/auth/login" `
        -Method POST `
        -Body $body `
        -Headers $headers

    Write-Host "✅ Login Successful" -ForegroundColor Green
    Write-Host "Token: $($response.data.token)" -ForegroundColor Cyan
    
    $token = $response.data.token
    
    Write-Host "`n2. Testing Items Endpoint with Token..."
    $itemsHeaders = @{
        "Content-Type" = "application/json"
        "Authorization" = "Bearer $token"
    }
    
    $itemsResponse = Invoke-RestMethod -Uri "http://localhost:8000/api/items?page=1&per_page=100" `
        -Method GET `
        -Headers $itemsHeaders
    
    Write-Host "✅ Items Retrieved" -ForegroundColor Green
    Write-Host "Item Count: $($itemsResponse.data.Count)" -ForegroundColor Cyan
    
    if ($itemsResponse.data.Count -gt 0) {
        Write-Host "First Item: $($itemsResponse.data[0].name)" -ForegroundColor Cyan
    }
    
    Write-Host "`n✅ ALL TESTS PASSED" -ForegroundColor Green
    
} catch {
    Write-Host "❌ Test Failed: $_" -ForegroundColor Red
    Write-Host $_.Exception.Message
}
