<?php

namespace App\Filament\Resources\AttractionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class ReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'reviews';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Отзывы';
    protected static ?string $pluralLabel = 'Отзывы';
    protected static ?string $modelLabel = 'Отзывы';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Имя'),

                Forms\Components\Select::make('rating')
                    ->required()
                    ->options([
                        1 => '1 ★',
                        2 => '2 ★★',
                        3 => '3 ★★★',
                        4 => '4 ★★★★',
                        5 => '5 ★★★★★',
                    ])
                    ->label('Оценка'),

                Forms\Components\Textarea::make('comment')
                    ->required()
                    ->maxLength(1000)
                    ->columnSpanFull()
                    ->label('Комментарий'),

                Forms\Components\TextInput::make('ip')
                    ->default(request()->ip())
                    ->label('IP адрес')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Оценка')
                    ->formatStateUsing(fn (int $state): string => str_repeat('★', $state))
                    ->color(fn (int $state): string => match (true) {
                        $state <= 2 => 'danger',
                        $state <= 3 => 'warning',
                        default => 'success',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('comment')
                    ->label('Комментарий')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('rating')
                    ->label('Фильтр по оценке')
                    ->options([
                        1 => '1 ★',
                        2 => '2 ★★',
                        3 => '3 ★★★',
                        4 => '4 ★★★★',
                        5 => '5 ★★★★★',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Добавить отзыв'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
