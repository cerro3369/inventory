<?php

namespace App\Livewire\Admin\Datatable;

use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use Illuminate\Support\Facades\Blade;

final class ProductTable extends PowerGridComponent
{
    public string $tableName = 'productTable';

    public function setUp(): array
    {
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
        return Product::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('titulo');
    }

    public function columns(): array
    {
        return [
            Column::make(__('ID'), 'id')
                ->sortable(),

            Column::make(__('Título'), 'titulo')
                ->searchable(),

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

    public function actions(Product $row): array
    {
        return [
            Button::add('edit')
                ->slot(__('Editar'))
                ->id()
                ->class('flex items-center gap-x-2 text-sm font-semibold rounded-xl border border-blue-300 bg-blue-500 px-3 py-2 text-black shadow-sm hover:bg-blue-600 focus:outline-none dark:bg-blue-400 dark:text-black dark:hover:bg-blue-500')
                ->route('admin.catalogo.edit', ['product' => $row->id])
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