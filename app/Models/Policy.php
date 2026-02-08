<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $fillable = [
        'title',
        'locale',
        'content',
        'slug',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Parse markdown-style content (## Section Title) into sections and extract last updated.
     * Returns shape expected by frontend: ['title' => string, 'lastUpdated' => string, 'sections' => [{ title, content }]].
     */
    public function getSectionsForFrontend(): array
    {
        $content = trim($this->content ?? '');
        $lastUpdated = '';

        // Extract "**Last Updated: ...**" or "**آخر تحديث: ...**"
        if (preg_match('/\*\*(?:Last Updated|آخر تحديث):\s*([^*]+)\*\*/ui', $content, $m)) {
            $lastUpdated = trim($m[1]);
            $content = preg_replace('/\*\*(?:Last Updated|آخر تحديث):[^*]*\*\*/ui', '', $content);
        }
        if ($lastUpdated === '') {
            $lastUpdated = $this->locale === 'ar' ? 'آخر تحديث: يناير 2025' : 'Last Updated: January 2025';
        }

        $sections = [];
        // Normalize: ensure we split by newline + ## so first block can start with ##
        $content = preg_replace('/^\s*##\s+/u', "\n## ", $content);
        $blocks = preg_split('/\n\s*##\s+/u', $content, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($blocks as $block) {
            $block = trim($block);
            if ($block === '') {
                continue;
            }
            $firstNewline = strpos($block, "\n");
            if ($firstNewline !== false) {
                $sectionTitle = trim(substr($block, 0, $firstNewline));
                $sectionContent = trim(substr($block, $firstNewline + 1));
            } else {
                $sectionTitle = $block;
                $sectionContent = '';
            }
            $sections[] = [
                'title' => $sectionTitle,
                'content' => $sectionContent,
            ];
        }

        return [
            'title' => $this->title,
            'lastUpdated' => $lastUpdated,
            'sections' => $sections,
        ];
    }
}
