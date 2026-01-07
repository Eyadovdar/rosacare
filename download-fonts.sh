#!/bin/bash
# Script to download Alexandria font files from Google Fonts

FONTS_DIR="public/fonts/alexandria"
mkdir -p "$FONTS_DIR"

# Alexandria font weights: 100, 200, 300, 400, 500, 600, 700
WEIGHTS=(100 200 300 400 500 600 700)
WEIGHT_NAMES=("Thin" "ExtraLight" "Light" "Regular" "Medium" "SemiBold" "Bold")

echo "Downloading Alexandria font files..."

for i in "${!WEIGHTS[@]}"; do
    WEIGHT=${WEIGHTS[$i]}
    WEIGHT_NAME=${WEIGHT_NAMES[$i]}
    
    echo "Downloading Alexandria ${WEIGHT_NAME} (weight ${WEIGHT})..."
    
    # Download woff2 format
    curl -L "https://fonts.gstatic.com/s/alexandria/v1/0FlxVOGZlE1Rr_D_5MwT8QkT8EwEeA6WZ_9YbCg.woff2" \
        -H "User-Agent: Mozilla/5.0" \
        -o "${FONTS_DIR}/Alexandria-${WEIGHT_NAME}.woff2" 2>/dev/null || \
    curl -L "https://fonts.googleapis.com/css2?family=Alexandria:wght@${WEIGHT}&display=swap" \
        -H "User-Agent: Mozilla/5.0" \
        -o /tmp/alexandria-${WEIGHT}.css 2>/dev/null
    
    if [ -f "/tmp/alexandria-${WEIGHT}.css" ]; then
        # Extract woff2 URL from CSS
        WOFF2_URL=$(grep -oP 'url\([^)]+\.woff2\)' /tmp/alexandria-${WEIGHT}.css | head -1 | sed 's/url(\(.*\))/\1/' | tr -d "'\"")
        if [ ! -z "$WOFF2_URL" ]; then
            curl -L "$WOFF2_URL" -o "${FONTS_DIR}/Alexandria-${WEIGHT_NAME}.woff2" 2>/dev/null
        fi
        rm /tmp/alexandria-${WEIGHT}.css
    fi
done

echo "Font download complete. Files saved to ${FONTS_DIR}/"

