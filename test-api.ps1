Write-Host "=== Testing Laravel API ===" -ForegroundColor Cyan
Write-Host ""

$baseUrl = "http://localhost:8000/api"
$endpoints = @(
    "/services?lang=ar",
    "/products?lang=ar",
    "/trips?lang=ar",
    "/cities?lang=ar",
    "/testimonials?lang=ar",
    "/team-members?lang=ar",
    "/settings"
)

foreach ($endpoint in $endpoints) {
    $url = "$baseUrl$endpoint"
    Write-Host "Testing: $url" -ForegroundColor Yellow
    
    try {
        $response = Invoke-RestMethod -Uri $url -Method GET -ErrorAction Stop
        Write-Host "  ✓ Success - Data type: $($response.GetType().Name)" -ForegroundColor Green
        
        if ($response -is [System.Array]) {
            Write-Host "  ✓ Returned $($response.Count) items" -ForegroundColor Green
        }
    }
    catch {
        Write-Host "  ✗ Failed: $($_.Exception.Message)" -ForegroundColor Red
    }
    
    Write-Host ""
}

Write-Host "=== Test Complete ===" -ForegroundColor Cyan
Write-Host ""
Write-Host "Next steps:" -ForegroundColor White
Write-Host "1. Add sample data using: php artisan tinker" -ForegroundColor Gray
Write-Host "2. Or add via API: See QUICK_START.md" -ForegroundColor Gray
Write-Host "3. Use in Next.js: import api from '@/lib/api'" -ForegroundColor Gray
