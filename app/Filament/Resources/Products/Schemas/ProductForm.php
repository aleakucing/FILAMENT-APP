<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([

                    // STEP 1
                    Step::make('Product Info')
                        ->icon('heroicon-o-cube')
                        ->description('Isi informasi dasar produk')
                        ->schema([
                            Group::make([
                                TextInput::make('name')
                                    ->label('Nama Produk')
                                    ->required()
                                    ->prefixIcon('heroicon-o-cube'),

                                TextInput::make('sku')
                                    ->label('SKU')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->prefixIcon('heroicon-o-hashtag'),
                            ])->columns(2),

                            MarkdownEditor::make('description')

                                ->label('Deskripsi Produk')
                                ->required()
                                ->columnSpanFull()
                                ->toolbarButtons([
                                    'bold',
                                    'italic',
                                    'bulletList'
                                ]),
                        ]),

                    // STEP 2
                    Step::make('Pricing & Stock')
                        ->icon('heroicon-o-banknotes')
                        ->description('Isi harga dan jumlah stok')
                        ->schema([
                            TextInput::make('price')
                                ->label('Harga')
                                ->numeric()
                                ->required()
                                ->minValue(1)
                                ->prefix('Rp')
                                ->prefixIcon('heroicon-o-banknotes'),

                            TextInput::make('stock')
                                ->label('Stok')
                                ->numeric()
                                ->required()
                                ->minValue(0)
                                ->prefixIcon('heroicon-o-archive-box'),
                        ])
                        ->columns(2),

                    // STEP 3
                    Step::make('Media & Status')
                        ->icon('heroicon-o-photo')
                        ->description('Upload gambar dan atur status')
                        ->schema([
                            FileUpload::make('image')
                                ->label('Gambar Produk')
                                ->image()
                                ->disk('public')
                                ->directory('products')
                                ->maxSize(2048)
                                ->imagePreviewHeight('150')
                                ->hintIcon('heroicon-o-photo'),

                            Checkbox::make('is_active')
                                ->label('Aktifkan Produk')
                                ->default(true),

                            Checkbox::make('is_featured')
                                ->label('Produk Unggulan'),
                        ]),
                ])
                    ->skippable(false)
                    ->columnSpanFull()
                    ->submitAction(
                        Action::make('save')
                            ->label('💾 Simpan Produk')
                            ->color('primary')
                            ->submit('save')
                    ),
            ]);
    }
}
