<?php

namespace App\Filament\Pages;

use App\Enum\MovementType;
use App\Models\Material;
use App\Models\MaterialMovement;
use App\Models\Movement;
use App\Models\OrderParchuse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Ingreso extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.ingreso';

    protected static ?string $navigationParentItem = 'Materiales';

    public ?array $data = [];

    public $orderProducts = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return  $form
            ->schema([
                Forms\Components\Section::make('Ingresos')
                    ->description('registro de ingrso materiales')
                    ->schema([
                        Forms\Components\Select::make('tipo')
                            ->label('Tipo')
                            ->options(MovementType::class)
                            ->required()
                            ->native(false)
                            ->reactive()
                            ->afterStateUpdated(function ($state) {
                                $this->handleTipoChange($state);
                            }),
                        Forms\Components\Select::make('order_id')
                            ->label('Orden de compra')
                            ->options(OrderParchuse::pluck('number', 'id')->toArray())

                            ->native(false)
                            ->reactive()
                            ->afterStateUpdated(function ($state) {
                                $this->handleOrderChange($state);
                            }),
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('fecha ingreso')
                            ->native(false)
                            ->reactive()
                            ->live()
                            ->required()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                $this->handleFechaIngresoChange($state, $set, $get);
                            })
                    ])->columns(3),
                Forms\Components\Repeater::make('movementproduct')
                    ->label('Materiales')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('material_id')
                            ->label('Material')
                            ->searchable()
                            ->options(function () {
                                return collect($this->orderProducts)->pluck('name', 'id');
                            })
                            ->native(false)
                            ->reactive()
                            ->dehydrated()
                            ->live()
                            ->afterStateUpdated(
                                function ($state, $get, $set) {
                                    $this->updateQuantity(
                                        $state,
                                        $get,
                                        $set
                                    );
                                }
                            )->columnSpan(2),
                        Forms\Components\TextInput::make('quantity')
                            ->label('Cantidad a Mover')
                            ->required()
                            ->dehydrated()
                            ->live(),
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('fecha registro')
                            ->dehydrated()
                            ->live()
                            ->required(),

                    ])->columns(4)
            ])
            ->statePath('data')
            ->model(Movement::class);
    }
    public function handleTipoChange($state): void
    {
        if ($state === 'entrada') {
            $this->orderProducts = [];
        }
    }
    public function handleOrderChange($state): void
    {
        if ($this->data['tipo'] === 'entrada' && $state) {
            $this->orderProducts = OrderParchuse::find($state)->materials->toArray();
        } else {
            $this->orderProducts = [];
        }
    }
    public function handleFechaIngresoChange($state, $set, $get): void
    {
        $movementProducts = $get('movementproduct');
        foreach ($movementProducts as $index => $product) {
            $set("movementproduct.{$index}.created_at", $state);
        }
    }

    public function updateQuantity($productId, $get, $set): void
    {
        $product = Material::find($productId);
        if ($product) {
            $set('quantity', $product->quantity);
        } else {
            $set('quantity', 0);
        }
    }
    public function create(): void
    {
        $data = $this->form->getState();

        $record = Movement::create($data);

        $this->form->model($record)->saveRelationships();
        foreach ($record['movementproduct'] as $item) {
            $product = Material::find($item['material_id']);
            $product->quantity;
            $product->created_at;
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
            ->body(__('Ingreso registrado correctamente'))
            ->success();
    }
}
