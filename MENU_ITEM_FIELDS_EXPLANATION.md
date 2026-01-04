# MenuItem Filament Resource - Field Explanations

This document explains what each field in the MenuItem Filament resource does and how to use them.

## Overview
MenuItems are used to create navigation menu entries in the frontend navbar. Each menu item can link to different types of content (pages, categories, or custom URLs).

---

## Main Fields (Non-Translatable)

### 1. **Type** (`type`)
- **Field Type**: Text Input (Required)
- **Purpose**: Defines the type of menu item
- **Possible Values**:
  - `"Home"` - Links to the home page
  - `"page"` - Links to a specific page (uses the `page` field)
  - `"category"` - Links to a category (uses the `category_id` field)
  - `"products"` - Links to products listing
  - Custom string - For custom menu item types
- **Example**: `"Home"`, `"page"`, `"category"`
- **Note**: This field determines how the URL is resolved in the frontend

---

### 2. **URL** (`url`)
- **Field Type**: Text Input (Optional)
- **Purpose**: Custom URL for the menu item
- **When to Use**:
  - When `type` is a custom type or external link
  - As a fallback if `type` is `"page"` but the page mapping doesn't exist
- **Examples**:
  - `"/about"`
  - `"https://example.com"`
  - `"/custom-page"`
- **Note**: If `type` is `"category"` or `"page"`, the URL is automatically generated from the category slug or page mapping, but this field can serve as a fallback

---

### 3. **Icon** (`icon`)
- **Field Type**: Select Dropdown (Optional, Searchable)
- **Purpose**: Heroicon to display next to the menu item label
- **Options**: All available Heroicons (outlined and solid variants)
- **Features**:
  - Searchable dropdown
  - Preloaded options
  - Visual icon preview in the dropdown
- **Example Values**: `"heroicon-o-home"`, `"heroicon-s-shopping-bag"`
- **Note**: Icons are optional and may not always be displayed depending on the frontend implementation

---

### 4. **Category** (`category_id`)
- **Field Type**: Select Dropdown (Optional)
- **Purpose**: Links the menu item to a specific category
- **When to Use**: When `type` is `"category"`
- **Behavior**:
  - Shows a dropdown of all available categories
  - Displays the category's title
  - When selected, the menu item will link to `/categories/{category-slug}`
- **Example**: If category "Skincare" has slug "skincare", the URL becomes `/categories/skincare`
- **Note**: Only relevant when `type` is `"category"`

---

### 5. **Page** (`page`)
- **Field Type**: Text Input (Optional)
- **Purpose**: Specifies which page the menu item should link to
- **When to Use**: When `type` is `"page"` or `"Home"`
- **Supported Values**:
  - `"home"` or `"Home"` → Links to `/` (home page)
  - `"about"` → Links to `/about`
  - `"contact"` → Links to `/contact`
  - `"products"` or `"product"` → Links to `/products`
- **Example**: For a "Products" menu item, set `type` to `"page"` and `page` to `"products"`
- **Note**: The frontend has a mapping that converts these values to actual routes

---

### 6. **Sort Order** (`sort_order`)
- **Field Type**: Number Input (Required, Default: 0)
- **Purpose**: Determines the display order of menu items in the navbar
- **Behavior**:
  - Lower numbers appear first (left to right in LTR, right to left in RTL)
  - Items are sorted in ascending order
- **Examples**:
  - `0` - First item
  - `10` - Second item
  - `20` - Third item
- **Best Practice**: Use increments of 10 (0, 10, 20, 30...) to allow easy reordering

---

### 7. **Is Active** (`is_active`)
- **Field Type**: Toggle Switch (Required)
- **Purpose**: Controls whether the menu item is visible in the frontend navbar
- **Values**:
  - `true` (ON) - Menu item is visible
  - `false` (OFF) - Menu item is hidden
- **Default**: `true`
- **Note**: Only active menu items appear in the navbar. Inactive items are completely hidden.

---

### 8. **Open in New Tab** (`open_in_new_tab`)
- **Field Type**: Toggle Switch (Required)
- **Purpose**: Controls whether the menu item link opens in a new browser tab/window
- **Values**:
  - `true` (ON) - Link opens in new tab (`target="_blank"`)
  - `false` (OFF) - Link opens in same tab (normal navigation)
- **Default**: `false`
- **Use Cases**:
  - External links (e.g., social media, partner websites)
  - PDF downloads
  - Links that should not navigate away from the current page

---

## Translation Fields (Translatable)

### 9. **Label** (`label`)
- **Field Type**: Text Input (Translatable)
- **Purpose**: The text displayed in the navbar for this menu item
- **Translatable**: Yes (Arabic and English)
- **Location**: Translation tabs in Filament (if configured)
- **Examples**:
  - Arabic: `"الرئيسية"`, `"المنتجات"`, `"من نحن"`
  - English: `"Home"`, `"Products"`, `"About"`
- **Important Notes**:
  - Each locale (ar/en) can have a different label
  - If no translation exists, the frontend uses a fallback based on the `page` field
  - The label is what users see in the navigation menu

---

## How Fields Work Together

### Example 1: Home Menu Item
```
Type: "Home"
Page: "Home"
Sort Order: 0
Is Active: true
Open in New Tab: false
Label (ar): "الرئيسية"
Label (en): "Home"
```
**Result**: Displays as "الرئيسية" (ar) or "Home" (en), links to `/`, appears first in menu

---

### Example 2: Products Category Menu Item
```
Type: "category"
Category: [Select "Skincare" category]
Sort Order: 10
Is Active: true
Open in New Tab: false
Label (ar): "المنتجات"
Label (en): "Products"
```
**Result**: Displays as "المنتجات" (ar) or "Products" (en), links to `/categories/skincare`

---

### Example 3: External Link Menu Item
```
Type: "external"
URL: "https://facebook.com/rosacare"
Sort Order: 20
Is Active: true
Open in New Tab: true
Label (ar): "فيسبوك"
Label (en): "Facebook"
```
**Result**: Displays as "فيسبوك" (ar) or "Facebook" (en), opens Facebook in new tab

---

### Example 4: Products Page Menu Item (without translations)
```
Type: "products"
Page: "product"
Sort Order: 10
Is Active: true
Open in New Tab: false
Label (ar): (empty)
Label (en): (empty)
```
**Result**: Frontend fallback displays "المنتجات" (ar) or "Products" (en) based on page mapping, links to `/products`

---

## URL Resolution Logic

The frontend determines the final URL using this priority:

1. **If `type` is `"category"` and `category_id` is set**:
   → `/categories/{category-slug}`

2. **If `type` is `"page"` or `page` field is set**:
   → Uses page mapping:
     - `"home"` / `"Home"` → `/`
     - `"about"` → `/about`
     - `"contact"` → `/contact`
     - `"products"` / `"product"` → `/products`

3. **If `url` field is set**:
   → Uses the custom URL value

4. **Fallback**:
   → `/` (home page)

---

## Best Practices

1. **Always provide translations**: Add both Arabic and English labels for better UX
2. **Use consistent sort orders**: Use increments of 10 for easy reordering
3. **Set appropriate types**: Use `"category"` for category links, `"page"` for page links
4. **Keep items active**: Only set `is_active` to `false` when you want to temporarily hide an item
5. **Use new tab sparingly**: Only enable `open_in_new_tab` for external links or special cases

---

## Current Limitations

- The Filament form does not currently have translation tabs configured for the `label` field
- Translations must be managed through the database directly or by adding translation tabs to the form
- The `type` field is a free text input - consider using a Select dropdown with predefined options for better data consistency

---

## Frontend Behavior

- Menu items are filtered to show only those where `is_active = true`
- Items are sorted by `sort_order` (ascending)
- Labels are displayed based on the current locale (ar/en)
- If no translation exists, fallback labels are generated from the `page` field
- URLs are resolved using the logic described above
- Icons (if provided) may be displayed next to labels depending on frontend implementation

