<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttractionResource\Pages;
use App\Filament\Resources\AttractionResource\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\AttractionResource\RelationManagers\ReviewsRelationManager;
use App\Models\Attraction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AttractionResource extends Resource
{
    protected static ?string $model = Attraction::class;

    protected static ?string $slug = 'attractions';

    protected static ?string $navigationLabel = 'Достопримечательности';
    protected static ?string $pluralLabel = 'Достопримечательности';
    protected static ?string $label = 'Достопримечательности';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Название')
                    ->required(),

                TimePicker::make('begin')
                    ->label('Начало работы')
                    ->seconds(false),

                TimePicker::make('end')
                    ->label('Конец работы')
                    ->seconds(false),

                TextInput::make('address')
                    ->label('Адрес')
                    ->required(),

                Textarea::make('description')
                    ->label('Описание'),

                Textarea::make('short_description')
                    ->label('Краткое описание'),

                Placeholder::make('created_at')
                    ->label('Создано')
                    ->content(fn(?Attraction $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Обновлено')
                    ->content(fn(?Attraction $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('begin')
                    ->label('Начало работы')
                    ->time(),

                TextColumn::make('end')
                    ->label('Конец работы')
                    ->time(),

                TextColumn::make('address')
                    ->label('Адрес'),

                TextColumn::make('short_description')
                    ->label('Краткое описание'),
            ])
            ->filters([
                //
            ])
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
            'index' => Pages\ListAttractions::route('/'),
            'create' => Pages\CreateAttraction::route('/create'),
            'edit' => Pages\EditAttraction::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            ReviewsRelationManager::class,
            ImagesRelationManager::class
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title'];
    }
}
