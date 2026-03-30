<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                ->required()
                ->minLength(5),
                TextInput::make('slug')
                ->required() 
                ->unique(ignoreRecord: true),
                Select::make('category_id')
                    ->label('Category')
                    ->options(
                        \App\Models\Category::all()->pluck('name', 'id')
                    )
                    ->required(),
                ColorPicker::make('color'),
                MarkdownEditor::make('body'),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('posts'),
                TagsInput::make('tags'),
                Checkbox::make('published'),
                DatePicker::make('published_at'),
            ]);
    }
}
