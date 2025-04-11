<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HotelResource\Pages;
use App\Filament\Resources\HotelResource\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\HotelResource\RelationManagers\ReviewsRelationManager;
use App\Models\Hotel;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HotelResource extends Resource
{
    protected static ?string $model = Hotel::class;

    protected static ?string $slug = 'hotels';

    protected static ?string $navigationLabel = 'Отели';
    protected static ?string $pluralLabel = 'Отели';
    protected static ?string $label = 'Отели';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Название')
                    ->required(),

                TextInput::make('address')
                    ->label('Адрес')
                    ->required(),

                TextInput::make('rooms')
                    ->label('Количество комнат')
                    ->required(),

                TextInput::make('phone')
                    ->label('Телефон')
                    ->required(),

                TextInput::make('email')
                    ->label('Email'),

                TextInput::make('stars')
                    ->label('Звезды')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5),

                TextInput::make('site')
                    ->label('Сайт'),

                Textarea::make('description')
                    ->label('Описание'),

                Textarea::make('short_description')
                    ->label('Краткое описание'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Название')
                    ->searchable(),

                TextColumn::make('stars')
                    ->label('Звезды'),

                TextColumn::make('address')
                    ->label('Адрес'),

                TextColumn::make('rooms')
                    ->label('Количество комнат'),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHotels::route('/'),
            'create' => Pages\CreateHotel::route('/create'),
            'edit' => Pages\EditHotel::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'email'];
    }

    public static function getRelations(): array
    {
        return [
            ReviewsRelationManager::class,
            ImagesRelationManager::class
        ];
    }
}
