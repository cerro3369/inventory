<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{

    public function index(): View
    {
        $ingresosTotales = Sale::sum('total') ?? 0.00;

        $gastosTotales = SaleDetail::whereHas('sale')
            ->join('editions', 'sale_details.edition_id', '=', 'editions.id')
            ->sum(DB::raw('sale_details.cantidad * editions.precio_compra')) ?? 0.00;

        return view('admin.dashboard', compact('ingresosTotales', 'gastosTotales'));
    }
}