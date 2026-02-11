#!/usr/bin/env python3
"""
Download Alexandria font files from Google Fonts for local hosting
"""

import urllib.request
import re
import os
from pathlib import Path

FONTS_DIR = Path("public/fonts/alexandria")
FONTS_DIR.mkdir(parents=True, exist_ok=True)

WEIGHT_NAMES = {
    "100": "Thin",
    "200": "ExtraLight",
    "300": "Light",
    "400": "Regular",
    "500": "Medium",
    "600": "SemiBold",
    "700": "Bold"
}

print("Fetching Alexandria font CSS from Google Fonts...")

# Fetch CSS with proper user agent
req = urllib.request.Request(
    "https://fonts.googleapis.com/css2?family=Alexandria:wght@100;200;300;400;500;600;700&display=swap"
)
req.add_header("User-Agent", "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36")

try:
    with urllib.request.urlopen(req) as response:
        css = response.read().decode("utf-8")
except Exception as e:
    print(f"Error fetching CSS: {e}")
    sys.exit(1)

print("Parsing font URLs...")

# Extract font-weight and URL pairs (try woff2 first, then ttf)
weight_urls = []
blocks = css.split("@font-face")

for block in blocks:
    weight_match = re.search(r'font-weight:\s*(\d+)', block)
    # Try woff2 first
    url_match = re.search(r'url\(([^)]+\.woff2)\)', block)
    if not url_match:
        # Fallback to ttf
        url_match = re.search(r'url\(([^)]+\.ttf)\)', block)
    
    if weight_match and url_match:
        weight = weight_match.group(1)
        url = url_match.group(1).strip("\"'")
        weight_urls.append((weight, url))

print(f"Found {len(weight_urls)} font files to download\n")

# Download each font file
for weight, url in weight_urls:
    weight_name = WEIGHT_NAMES.get(weight, f"Weight{weight}")
    # Determine file extension from URL
    if url.endswith('.woff2'):
        ext = 'woff2'
    elif url.endswith('.ttf'):
        ext = 'ttf'
    else:
        ext = 'woff2'
    
    filename = FONTS_DIR / f"Alexandria-{weight_name}.{ext}"
    
    print(f"Downloading Alexandria {weight_name} (weight {weight})...")
    print(f"  URL: {url[:80]}...")
    
    try:
        font_req = urllib.request.Request(url)
        font_req.add_header("User-Agent", "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36")
        
        with urllib.request.urlopen(font_req) as response:
            font_data = response.read()
            
            with open(filename, "wb") as f:
                f.write(font_data)
            
            size_kb = len(font_data) / 1024
            print(f"  ✓ Downloaded: {filename.name} ({size_kb:.1f} KB)")
    except Exception as e:
        print(f"  ✗ Error downloading: {e}")

print(f"\nDownload complete! Fonts saved to {FONTS_DIR}/")
print(f"Total files: {len(list(FONTS_DIR.glob('*.woff2')))}")

