<?php

namespace App\Filament\Resources;

use App\Enum\MovementType;
use App\Filament\Resources\MovementResource\Pages;
use App\Filament\Resources\MovementResource\RelationManagers;
use App\Filament\Resources\MovementResource\RelationManagers\MovementproductRelationManager;
use App\Models\Movement;
use App\Models\OrderParchuse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MovementResource extends Resource
{
    protected static ?string $model = Movement::class;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';
    protected static ?string $modelLabel = 'Movimiento';
    // protected static ?string $navigationGroup = 'Almacen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                forms\Components\Section::make('Movimientos')
                    ->schema([
                        Forms\Components\TextInput::make('tipo')
                            ->required(),
                        Forms\Components\Select::make('order_id')
                            ->options(OrderParchuse::query()->pluck('number', 'id')->toArray())
                            ->default(null),
                    ])->columns('2'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order.number')
                    ->label('O/C')
                    ->searchable()
                    ->badge()
                    ->placeholder('N/A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->searchable()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('order_id')
                    ->options(OrderParchuse::query()->pluck('number', 'id')->toArray())
                    ->native(false),
                SelectFilter::make('Tipo')
                    ->options(MovementType::class)
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MovementproductRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovements::route('/'),
            'create' => Pages\CreateMovement::route('/create'),
            'edit' => Pages\EditMovement::route('/{record}/edit'),
        ];
    }
}
