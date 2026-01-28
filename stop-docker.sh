#!/bin/bash
# ==========================================
# Tilalr Docker Stop Script
# ==========================================

echo "🛑 Stopping Tilalr Stack..."
docker compose -f docker-compose.full.yml down

echo ""
echo "✅ All containers stopped!"
echo ""
echo "To remove volumes (data), run:"
echo "  docker compose -f docker-compose.full.yml down -v"
