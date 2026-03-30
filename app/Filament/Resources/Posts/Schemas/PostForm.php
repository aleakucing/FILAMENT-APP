<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // LEFT (2/3)
                Section::make("Post Details")
                    ->icon("heroicon-o-document-text")
                    ->description("Isi data utama post")
                    ->schema([

                        // 2 kolom field utama
                        Group::make([
                            TextInput::make('title')
                                ->rules('required | min:5 | max:10')
                                ->validationMessages([
                                    'min' => 'Title harus lebih dari 5.',
                                ]),
                            // ->minLength(5),

                            TextInput::make('slug')
                                ->required()
                                ->minLength(3)
                                ->unique()
                                ->validationMessages([
                                    'unique' => 'Slug harus unik dan tidak boleh sama.',
                                ]),

                            Select::make('category_id')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required(),

                            ColorPicker::make('color'),
                        ])->columns(2),

                        // full width editor
                        MarkdownEditor::make('content')
                            ->columnSpanFull(),

                    ])
                    ->columnSpan(2),

                // RIGHT (1/3)
                Group::make([

                    Section::make("Image Upload")
                        ->icon("heroicon-o-photo")
                        ->schema([
                            FileUpload::make('image')
                                ->image()
                                ->disk('public')
                                ->required()
                                ->directory('posts'),
                                
                        ]),

                    Section::make("Meta Information")
                        ->icon("heroicon-o-cog-6-tooth")
                        ->schema([
                            TagsInput::make('tags'),
                            Checkbox::make('published'),
                            DateTimePicker::make('published_at'),
                        ]),

                ])
                    ->columnSpan(1),

            ])
            ->columns(3);
    }
}
