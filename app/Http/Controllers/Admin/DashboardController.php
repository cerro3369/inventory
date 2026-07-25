<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ingresos Totales: Suma de todas las ventas
        $ingresosTotales = Sale::sum('total');

        // 2. Costo Total de lo Vendido (Inversión / Gastos)
        $gastosTotales = SaleDetail::join('editions', 'sale_details.edition_id', '=', 'editions.id')
            ->sum(DB::raw('sale_details.cantidad * editions.precio_compra'));

        // Enviamos únicamente los dos datos requeridos a la vista
        return view('admin.dashboard', compact('ingresosTotales', 'gastosTotales'));
    }
}