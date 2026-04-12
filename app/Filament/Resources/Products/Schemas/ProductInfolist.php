<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Product Tabs')
                    ->tabs([

                        // 🔹 TAB 1: PRODUCT INFO
                        Tabs\Tab::make('Product Info')
                            ->icon('heroicon-o-cube')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Product Name')
                                    ->weight(FontWeight::Bold)
                                    ->color('primary'),

                                TextEntry::make('sku')
                                    ->label('SKU')
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('description')
                                    ->label('Description'),
                            ]),

                        // 🔹 TAB 2: PRICING & STOCK
                        Tabs\Tab::make('Pricing & Stock')
                            ->icon('heroicon-o-banknotes')
                            ->schema([
                                TextEntry::make('price')
                                    ->label('Price')
                                    ->icon('heroicon-o-currency-dollar')
                                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                                    ->weight(FontWeight::Bold)
                                    ->color('primary'),

                                // ✅ BADGE DINAMIS BERDASARKAN STOK
                                TextEntry::make('stock')
                                    ->label('Stock')
                                    ->badge()
                                    ->formatStateUsing(function ($state) {
                                        if ($state == 0) return 'Habis';
                                        if ($state < 10) return 'Sedikit (' . $state . ')';
                                        return 'Tersedia (' . $state . ')';
                                    })
                                    ->color(function ($state) {
                                        if ($state == 0) return 'danger';   // merah
                                        if ($state < 10) return 'warning'; // kuning
                                        return 'success';                  // hijau
                                    }),
                            ]),

                        // 🔹 TAB 3: IMAGE & STATUS
                        Tabs\Tab::make('Image & Status')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                ImageEntry::make('image')
                                    ->label('Product Image')
                                    ->disk('public'),

                                IconEntry::make('is_active')
                                    ->label('Active')
                                    ->boolean(),

                                IconEntry::make('is_featured')
                                    ->label('Featured')
                                    ->boolean(),
                            ]),
                    ])

                    // ✅ VERTICAL TABS
                    // ->vertical()
                    ->columnSpanFull(),
            ]);
    }
}