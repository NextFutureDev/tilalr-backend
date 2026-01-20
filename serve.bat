@echo off
"C:\xampp\php\php.exe" -d max_execution_time=0 artisan serve --host=127.0.0.1 --port=8000 --no-reload %*
