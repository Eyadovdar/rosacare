@php
    use Filament\Support\Icons\Heroicon;

    $icon = Heroicon::tryFrom($value);
    if (!$icon) {
        echo $value;
        return;
    }

    $name = $icon->name;
    $displayName = \Illuminate\Support\Str::of($name)
        ->replaceMatches('/[A-Z]/', ' $0')
        ->trim()
        ->title()
        ->toString();
@endphp

<div class="flex items-center gap-2">
    @svg('heroicon-o-' . $value, 'w-5 h-5 text-gray-700 dark:text-gray-300')
    <span>{{ $displayName }} <span class="text-gray-500 dark:text-gray-400 text-xs">({{ $value }})</span></span>
</div>
