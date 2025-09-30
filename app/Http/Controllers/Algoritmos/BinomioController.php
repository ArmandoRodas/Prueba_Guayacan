<?php

namespace App\Http\Controllers\Algoritmos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BinomioController extends Controller
{
    public function __invoke(Request $request)
    {
        $n = null;         
        $coef = null;     
        $expansion = null; 

        if ($request->isMethod('post')) {
           
            $data = $request->validate([
                'n' => 'required|integer|min:0|max:20', // 20 para que no salga demasiado grande
            ]);

            $n = (int) $data['n'];

            // 1) Obtenemos la fila n del triángulo de Pascal de forma RECURSIVA
            $coef = $this->pascalRow($n);

            // 2) Construimos el desarrollo simbólico (a+b)^n
            $terminos = [];
            for ($k = 0; $k <= $n; $k++) {
                $c = $coef[$k];       
                $aExp = $n - $k;       
                $bExp = $k;            

                $partes = [];
                if ($c != 1) $partes[] = (string)$c;
                if ($aExp > 0) $partes[] = 'a' . ($aExp > 1 ? '^'.$aExp : '');
                if ($bExp > 0) $partes[] = 'b' . ($bExp > 1 ? '^'.$bExp : '');
                if (empty($partes)) $partes[] = '1'; // caso n=0

                $terminos[] = implode('', $partes);
            }

            $expansion = implode(' + ', $terminos);
        }

        return view('algoritmos.binomio', compact('n', 'coef', 'expansion'));
    }

    /**
     * Devuelve la fila n del triángulo de Pascal usando RECURSIÓN.
     * Caso base: n = 0 => [1]
     * Paso recursivo: fila(n) = [1] + sumas adyacentes de fila(n-1) + [1]
     */
    private function pascalRow(int $n): array
    {
        if ($n === 0) return [1];

        $prev = $this->pascalRow($n - 1); // llamada RECURSIVA
        $row = [1];
        for ($i = 0; $i < count($prev) - 1; $i++) {
            $row[] = $prev[$i] + $prev[$i + 1];
        }
        $row[] = 1;
        return $row;
    }
}
