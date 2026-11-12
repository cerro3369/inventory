<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Muestra el resumen financiero del comerciante autenticado.
     */
    public function index(): View
    {
        // 1. Ingresos Totales (El Trait BelongsToUser en Sale filtra por user_id)
        $ingresosTotales = Sale::sum('total') ?? 0.00;

        // 2. Costos de Inversión / Mercancía Vendida (Filtrado por las ventas del usuario)
        $gastosTotales = SaleDetail::whereHas('sale')
            ->join('editions', 'sale_details.edition_id', '=', 'editions.id')
            ->sum(DB::raw('sale_details.cantidad * editions.precio_compra')) ?? 0.00;

        return view('admin.dashboard', compact('ingresosTotales', 'gastosTotales'));
    }
}