<?php

namespace App\Filament\Resources\Products\Tables;

use App\Filament\Resources\Products\ProductResource;
use App\Models\Product;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featuredImage.file_name')
                    ->label('Image')
                    ->getStateUsing(function ($record) {
                        $image = $record->featuredImage;
                        return $image ? $image->url : null;
                    })
                    ->circular()
                    ->size(50),
                TextColumn::make('name')
                    ->label('Product')
                    ->searchable(query: function ($query, $search) {
                        return $query->where(function ($q) use ($search) {
                            $q->whereHas('translations', function ($qb) use ($search) {
                                $qb->where('name', 'like', "%{$search}%");
                            })
                                ->orWhereHas('category.translations', function ($qb) use ($search) {
                                    $qb->where('name', 'like', "%{$search}%");
                                });
                        });
                    })
                    ->formatStateUsing(function ($state, $record) {
                        $name = e($state ?: '-');
                        $categoryName = $record->category?->name;
                        if ($categoryName) {
                            $badge = '<span style="display:inline-flex;align-items:center;border-radius:0.375rem;border:1px solid var(--primary-500);color:var(--primary-600);padding:0.125rem 0.5rem;font-size:0.75rem;font-weight:500;">' . e($categoryName) . '</span>';
                            return $name . '<br>' . $badge;
                        }
                        return $name;
                    })
                    ->html(),
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('price')
                    ->money()
                    ->sortable(),
                TextColumn::make('sale_price')
                    ->money()
                    ->sortable(),
                TextColumn::make('stock_quantity')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('in_stock')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_active')
                    ->boolean(),
                IconColumn::make('is_featured')
                    ->boolean(),
                TextColumn::make('sort_order')
                ->label('Sort')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('view_count')
                    ->label(self::viewCountHeaderIcon())
                    ->headerTooltip('View count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordUrl(fn (Product $record): string => ProductResource::getUrl('edit', ['record' => $record]))
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('duplicate')
                    ->label('Duplicate')
                    ->icon(Heroicon::OutlinedDocumentDuplicate)
                    ->color('gray')
                    ->action(function (Product $record, $livewire) {
                        $copy = $record->duplicate();
                        $livewire->redirect(ProductResource::getUrl('edit', ['record' => $copy]));
                    })
                    ->successNotificationTitle('Product duplicated'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    /** Outline eye icon (stroke, no fill) for view count column header. */
    private static function viewCountHeaderIcon(): Htmlable
    {
        $svg = '<span style="display:inline-flex;color:var(--gray-500);" aria-hidden="true">'
            . '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">'
            . '<path d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>'
            . '<path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>'
            . '</svg></span>';
        return new HtmlString($svg);
    }
}
