<?php

namespace App\Livewire\Admin\Datatable;

use App\Models\Waste;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class WasteTable extends PowerGridComponent
{
    public string $tableName = 'wasteTable';

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
        return Waste::query()->with('edition.product');
    }

    public function relationSearch(): array
    {
        return [
            'edition.product' => [
                'titulo',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('cantidad')
            ->add('tipo_baja', fn (Waste $model) => __($model->tipo_baja))
            ->add('notas', fn (Waste $model) => $model->notas ?? __('Sin observaciones'))
            ->add('product_titulo', fn (Waste $model) => ($model->edition?->product?->titulo ?? __('Sin Producto')) . ' (' . ($model->edition?->numero_edicion ?? '-') . ')')
            ->add('created_at_formatted', fn (Waste $model) => Carbon::parse($model->created_at)->format('d/m/Y h:i A'));
    }

    public function columns(): array
    {
        return [
            Column::make(__('ID'), 'id'),

            Column::make(__('Producto / Edición'), 'product_titulo', 'edition.product.titulo')
                ->searchable(),

            Column::make(__('Cantidad'), 'cantidad')
                ->sortable(),

            Column::make(__('Tipo de Baja'), 'tipo_baja')
                ->sortable()
                ->searchable(),

            Column::make(__('Notas / Observaciones'), 'notas'),

            Column::make(__('Fecha de Registro'), 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action(__('Acciones'))
        ];
    }

    public function actions(Waste $row): array
    {
        return [
            Button::add('edit')
                ->slot(__('Editar'))
                ->class('bg-blue-600 hover:bg-blue-700 text-white font-bold py-1.5 px-3 rounded-lg shadow-sm text-xs transition')
                ->route('admin.mermas.edit', ['waste' => $row->id])
        ];
    }
}