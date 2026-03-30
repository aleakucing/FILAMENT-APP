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
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make("Post Details")
                ->schema([
                       Group::make([
                            TextInput::make('title'),
                            TextInput::make('slug'),
                            Select::make('category_id'),
                            ColorPicker::make('color'),
                        MarkdownEditor::make('body')
                            ->columnSpanFull(),
                    ])->columns(2),
                MarkdownEditor::make('content'),
                ])->columnSpan(2),
                Group::make([
                    Section::make('Image Upload')
                        ->schema([
                            FileUpload::make('image')
                                ->disk('public')
                                ->directory('post'),
                        ]),
                    Section::make('Meta')
                        ->schema([
                            TagsInput::make('tags'),
                            Checkbox::make('published'),
                            DatePicker::make('published_at'),
                        ]),
                ])->columnSpan(1)
            ])->columns(3);
    }
}
