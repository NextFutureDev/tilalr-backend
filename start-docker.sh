#!/bin/bash
# ==========================================
# Tilalr Docker Startup Script
# ==========================================
# Run: ./start-docker.sh
# ==========================================

set -e

echo "🚀 Starting Tilalr Full Stack..."
echo "================================"

# Check if .env file exists
if [ ! -f ".env" ]; then
    echo "📝 Creating .env file from .env.docker..."
    cp .env.docker .env
    echo "✅ .env file created. Please edit it with your settings if needed."
fi

# Generate APP_KEY if not set
if grep -q "APP_KEY=$" .env 2>/dev/null || grep -q "APP_KEY=base64:dGhpc2lzYXRlc3RrZXlmb3JsYXJhdmVsYXBwbGljYXRpb24=" .env 2>/dev/null; then
    echo "🔑 Generating Laravel APP_KEY..."
    NEW_KEY=$(openssl rand -base64 32)
    if [[ "$OSTYPE" == "darwin"* ]]; then
        sed -i '' "s|APP_KEY=.*|APP_KEY=base64:$NEW_KEY|g" .env
    else
        sed -i "s|APP_KEY=.*|APP_KEY=base64:$NEW_KEY|g" .env
    fi
    echo "✅ APP_KEY generated"
fi

# Build and start containers
echo ""
echo "🔨 Building and starting containers..."
docker compose -f docker-compose.full.yml up -d --build

echo ""
echo "⏳ Waiting for services to be healthy..."
sleep 10

# Check container status
echo ""
echo "📊 Container Status:"
docker compose -f docker-compose.full.yml ps

echo ""
echo "================================"
echo "✅ Tilalr Stack Started!"
echo "================================"
echo ""
echo "🌐 Frontend:     http://localhost:3000"
echo "🔧 Backend API:  http://localhost:8000/api"
echo "📊 phpMyAdmin:   http://localhost:8080 (run with --profile dev)"
echo ""
echo "📝 Useful Commands:"
echo "  - View logs:        docker compose -f docker-compose.full.yml logs -f"
echo "  - Stop:             docker compose -f docker-compose.full.yml down"
echo "  - Run migrations:   docker exec tilalr-backend php artisan migrate"
echo "  - Seed database:    docker exec tilalr-backend php artisan db:seed"
echo ""
