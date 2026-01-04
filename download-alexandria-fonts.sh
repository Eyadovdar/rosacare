#!/bin/bash
# Script to download Alexandria font files from Google Fonts

FONTS_DIR="public/fonts/alexandria"
mkdir -p "$FONTS_DIR"

echo "Fetching Alexandria font URLs from Google Fonts..."

# Get the CSS file with font URLs
CSS_CONTENT=$(curl -s -H "User-Agent: Mozilla/5.0" "https://fonts.googleapis.com/css2?family=Alexandria:wght@100;200;300;400;500;600;700&display=swap")

# Extract font URLs and weights
declare -A FONT_MAP
FONT_MAP[100]="Thin"
FONT_MAP[200]="ExtraLight"
FONT_MAP[300]="Light"
FONT_MAP[400]="Regular"
FONT_MAP[500]="Medium"
FONT_MAP[600]="SemiBold"
FONT_MAP[700]="Bold"

echo "$CSS_CONTENT" | while IFS= read -r line; do
    if [[ $line == *"font-weight:"* ]]; then
        # Extract weight
        WEIGHT=$(echo "$line" | grep -oP 'font-weight: \K[0-9]+')
    fi
    if [[ $line == *"url("* && $line == *".woff2"* ]]; then
        # Extract URL
        URL=$(echo "$line" | grep -oP 'url\(([^)]+)\)' | sed 's/url(\(.*\))/\1/' | tr -d "'\"")
        if [ ! -z "$WEIGHT" ] && [ ! -z "$URL" ]; then
            WEIGHT_NAME="${FONT_MAP[$WEIGHT]}"
            if [ ! -z "$WEIGHT_NAME" ]; then
                FILENAME="${FONTS_DIR}/Alexandria-${WEIGHT_NAME}.woff2"
                echo "Downloading Alexandria ${WEIGHT_NAME} (${WEIGHT})..."
                curl -L -s "$URL" -o "$FILENAME"
                if [ -f "$FILENAME" ]; then
                    SIZE=$(du -h "$FILENAME" | cut -f1)
                    echo "  ✓ Downloaded: $FILENAME (${SIZE})"
                else
                    echo "  ✗ Failed to download: $FILENAME"
                fi
            fi
        fi
    fi
done

echo ""
echo "Checking downloaded files..."
ls -lh "$FONTS_DIR" 2>/dev/null | tail -n +2 || echo "No files found"

