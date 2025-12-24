# Page Translation Architecture

## Current Approach: **Page-Level Locale** (Recommended ✅)

### Database Structure:
- `pages` table: Stores non-translatable fields (slug, header_image_path, published)
- `page_translations` table: Stores translatable fields per locale:
  - `page_id` + `locale` (unique key)
  - `title` (string)
  - `content` (JSON - contains all Builder blocks)
  - `meta_title`, `meta_description`, `meta_keywords`

### How It Works:

1. **Each locale has its own complete content JSON**
   - Arabic (`locale='ar'`) → Has its own `content` JSON with Arabic blocks
   - English (`locale='en'`) → Has its own `content` JSON with English blocks

2. **In Filament:**
   - When editing Arabic: You see Arabic title + Arabic Builder blocks
   - When editing English: You see English title + English Builder blocks
   - Each locale tab contains its own Builder with its own block structure

3. **Accessing Content:**
```php
// Get Arabic content blocks
$page->getArabicContent();

// Get English content blocks  
$page->getEnglishContent();

// Get content for specific locale
$page->getContentForLocale('ar');
```

### Advantages:
- ✅ Simple and clean - standard translatable pattern
- ✅ Each locale can have completely different block structures
- ✅ Works naturally with Filament Builder
- ✅ Easy to query and manage
- ✅ Consistent with Laravel Translatable package

### Alternative Approach (NOT Recommended ❌):

**Block-Level Locale**: Each block would store translations internally
- ❌ Much more complex JSON structure
- ❌ Harder to manage in Filament Builder
- ❌ Would require custom handling for each block
- ❌ Not compatible with standard translatable patterns

## Conclusion:

**Use Page-Level Locale** - Each page has locale translations, and the entire `content` JSON (all Builder blocks) is stored per locale in the `page_translations` table.

