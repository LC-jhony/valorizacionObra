<?php

namespace App\Filament\Pages;

use App\Enum\MovementType;
use App\Models\Material;
use App\Models\Movement;
use App\Models\OrderParchuse;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Salida extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.salida';
    protected static ?string $navigationParentItem = 'Materiales';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make("Movimiento")
                    ->description("registre movimiento de materiales")
                    ->schema([
                        Forms\Components\Select::make('tipo')
                            ->label('tipo')
                            ->options(MovementType::class)
                            ->required()
                            ->native(false),


                    ]),
                Forms\Components\Repeater::make('movementproduct')
                    ->label('Materiales')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('material_id')
                            ->label('Material')
                            ->options(Material::query()->pluck('name', 'id'))
                            ->native(false)
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('quantity')
                            ->label('Cantidad')

                    ])->columns(3)
            ])
            ->statePath('data')
            ->model(Movement::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = Movement::create($data);

        $this->form->model($record)->saveRelationships();

        foreach ($record['movementproduct'] as $item) {
            $product = Material::find($item['material_id']);
            $product->quantity -= $item['quantity'];
            $product->save();
        }
        $this->reset();

        $this->getSavedNotification()->send();
    }
    protected function getSavedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title(__('Movimiento'))
            ->body(__('Salida registrado correctamente'))
            ->success();
    }
}
