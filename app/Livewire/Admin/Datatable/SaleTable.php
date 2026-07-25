<?php

namespace App\Livewire\Admin\Datatable;

use App\Models\Sale;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class SaleTable extends PowerGridComponent
{
    public string $tableName = 'saleTable';

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
        return Sale::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('total', fn (Sale $model) => '$' . number_format($model->total, 2) . ' MXN')
            ->add('created_at_formatted', fn (Sale $model) => Carbon::parse($model->created_at)->format('d/m/Y h:i A'));
    }

    public function columns(): array
    {
        return [
            Column::make(__('Folio / ID'), 'id'),
            
            Column::make(__('Total Vendido'), 'total')
                ->sortable(),

            Column::make(__('Fecha de Venta'), 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action(__('Detalles'))
        ];
    }

    public function actions(Sale $row): array
    {
        return [
            Button::add('show')
                ->slot(__('Ver Detalle'))
                ->class('bg-blue-600 hover:bg-blue-700 text-white font-bold py-1.5 px-3 rounded-lg shadow-sm text-xs transition')
                ->route('admin.ventas.show', ['sale' => $row->id])
        ];
    }
}