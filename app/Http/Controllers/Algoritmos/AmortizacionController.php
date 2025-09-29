<?php

namespace App\Http\Controllers\Algoritmos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AmortizacionController extends Controller
{
    public function __invoke(Request $request)
    {
        $monto = $tasa = $n = $abonoFijo = null;
        $rows = null;

        if ($request->isMethod('post')) {
            $data = $request->validate([
                'monto'    => 'required|numeric|min:0.01',
                'tasa'     => 'required|numeric|min:0',   // % mensual
                'periodos' => 'required|integer|min:1|max:600',
            ]);

            $monto = (float) $data['monto'];
            $tasa  = ((float) $data['tasa']) / 100.0;
            $n     = (int) $data['periodos'];

            // Método "cuota sobre saldos": abono (capital) CONSTANTE
            $abonoFijo = $monto / $n;

            $rows = [];
            for ($p = 1; $p <= $n; $p++) {
                $saldoInicio = $monto - $abonoFijo * ($p - 1);
                $interes = $saldoInicio * $tasa;
                $pago = $abonoFijo + $interes;
                $rows[] = [
                    'periodo' => $p,
                    'saldo'   => $saldoInicio,
                    'interes' => $interes,
                    'abono'   => $abonoFijo,
                    'pago'    => $pago,
                ];
            }
        }

        return view('algoritmos.amortizacion', compact('monto','tasa','n','abonoFijo','rows'));
    }
}
