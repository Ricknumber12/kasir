<?php

namespace App\Filament\Admin\Resources\Products\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('stock')
                    ->label('Stok')
                    ->badge()
                    ->color(fn (int $state): string => $state <= 5 ? 'danger' : 'success')
                    ->sortable(),
                TextColumn::make('rating')
                    ->label('Rating')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Filter Kategori')
                    ->relationship('category', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}