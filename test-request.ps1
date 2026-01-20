Start-Sleep -Seconds 2
$endpoints = @("http://127.0.0.1:8000/debug_key", "http://127.0.0.1:8000/api/services", "http://127.0.0.1:8000/")
foreach ($endpoint in $endpoints) {
    try {
        $response = Invoke-WebRequest -Uri $endpoint -UseBasicParsing -TimeoutSec 3
        Write-Host "$endpoint - Status: $($response.StatusCode)"
    }
    catch {
        Write-Host "$endpoint - ERROR: $($_.Exception.Message)"
    }
}
