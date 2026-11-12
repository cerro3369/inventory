<?php

namespace App\Livewire\Admin\Datatable;

use App\Models\Edition;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class EditionTable extends PowerGridComponent
{
    public string $tableName = 'editionTable';

    public function setUp(): array
    {
        // $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        // whereHas('product') dispara el Global Scope de Product por user_id, 
        // filtrando automáticamente solo las ediciones del usuario en sesión.
        return Edition::query()
            ->whereHas('product')
            ->with('product');
    }

    public function relationSearch(): array
    {
        return [
            'product' => [
                'titulo',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('product_titulo', fn(Edition $model) => $model->product?->titulo ?? __('Sin Producto'))
            ->add('numero_edicion')
            ->add('precio_compra')
            ->add('precio_venta')
            ->add('stock_actual')
            ->add('product_id')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make(__('Título'), 'product_titulo', 'product.titulo')
                ->searchable(),

            Column::make(__('Número edición'), 'numero_edicion'),

            Column::make(__('Precio compra'), 'precio_compra'),

            Column::make(__('Precio venta'), 'precio_venta'),

            Column::make(__('Stock actual'), 'stock_actual'),

            Column::action(__('Acción'))
        ];
    }

    public function filters(): array
    {
        return [];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    public function actions(Edition $row): array
    {
        return [
            Button::add('edit')
                ->slot(__('Editar'))
                ->id()
                ->class('flex items-center gap-x-2 text-sm font-semibold rounded-xl border border-blue-300 bg-blue-500 px-3 py-2 text-black shadow-sm hover:bg-blue-600 focus:outline-none dark:bg-blue-400 dark:text-black dark:hover:bg-blue-500')
                ->route('admin.inventario.edit', ['edition' => $row->id])
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}