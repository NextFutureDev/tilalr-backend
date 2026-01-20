#!/bin/bash

# Image Upload Test Script
# This script demonstrates how to upload an image for testing

echo "=== IMAGE UPLOAD TEST SCRIPT ==="
echo ""
echo "This script shows you how to upload images to the system."
echo ""

# Check if image file exists
ISLAND_ID=$1
IMAGE_FILE=$2

if [ -z "$ISLAND_ID" ] || [ -z "$IMAGE_FILE" ]; then
    echo "Usage: ./test_image_upload.sh <island_id> <image_file_path>"
    echo ""
    echo "Example:"
    echo "  ./test_image_upload.sh 13 /path/to/image.jpg"
    echo ""
    echo "Current Islands:"
    echo "  ID 13: Trip to AlUla"
    echo "  ID 14: Two Days AlUla Adventure"  
    echo "  ID 15: Three Days AlUla Experience"
    echo ""
    echo "MANUAL UPLOAD STEPS:"
    echo "1. Go to: http://localhost:8000/admin"
    echo "2. Login: superadmin@tilalr.com / password123"
    echo "3. Go to: Destinations > Island Destinations"
    echo "4. Click 'Edit' on the island you want to update"
    echo "5. Scroll to 'Media & Status' section"
    echo "6. Click the image upload area"
    echo "7. Select your image file"
    echo "8. Click 'Save'"
    echo ""
    echo "Then verify with:"
    echo "  php test_image_upload.php"
    exit 1
fi

if [ ! -f "$IMAGE_FILE" ]; then
    echo "Error: Image file not found: $IMAGE_FILE"
    exit 1
fi

echo "Preparing to upload image..."
echo "Island ID: $ISLAND_ID"
echo "Image: $IMAGE_FILE"
echo ""
echo "Note: API-based upload requires proper authentication."
echo "For now, please use the admin panel to upload images."
echo ""
echo "After uploading via admin panel, run:"
echo "  php test_image_upload.php"
