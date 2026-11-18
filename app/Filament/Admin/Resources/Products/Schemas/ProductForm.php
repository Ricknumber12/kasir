<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('product_id')
                    ->label('ID Produk')
                    ->numeric()
                    ->required()
                    ->unique(ignoreRecord: true),
                Select::make('category_id')
                    ->label('Kategori Produk')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('name')
                    ->label('Nama Produk')
                    ->required()
                    ->maxLength(100),
                TextInput::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),
                TextInput::make('stock')
                    ->label('Stok')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('rating')
                    ->label('Rating')
                    ->numeric()
                    ->step(0.1)
                    ->minValue(0)
                    ->maxValue(5),
            ]);
    }
}