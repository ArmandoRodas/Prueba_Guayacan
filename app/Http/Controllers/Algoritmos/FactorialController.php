<?php

namespace App\Http\Controllers\Algoritmos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FactorialController extends Controller
{
    public function __invoke(Request $request)
    {
        $n = null; $fact = null;

        if ($request->isMethod('post')) {
            $data = $request->validate(['n' => 'required|integer|min:0|max:1000']);
            $n = (int) $data['n'];

            $fact = 1;
            for ($i = 2; $i <= $n; $i++) $fact *= $i;
        }

        return view('algoritmos.factorial', compact('n', 'fact'));
    }
}
