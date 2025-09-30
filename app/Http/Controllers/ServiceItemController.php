<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceItem;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ServiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Service $service)
    {
        $items = ServiceItem::where('service_id', $service->id)
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('service_items.index', compact('service', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Service $service)
    {
        return view('service_items.create', compact('service'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Service $service)
    {
        $this->normalizeNumbers($request);   // <-- AÑADIR

    $data = $request->validate([
        'description' => ['required','string','max:190'],
        'quantity'    => ['required','integer','min:1'],
        'unit_price'  => ['required','numeric','min:0'],
        'notes'       => ['nullable','string','max:500'],
    ]);

    $data['service_id'] = $service->id;

    ServiceItem::create($data);

    return redirect()->route('services.items.index', $service)
                     ->with('success', 'Ítem agregado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service, ServiceItem $item)
    {
        // seguridad: asegurar pertenencia
        abort_unless($item->service_id === $service->id, 404);

        return view('service_items.edit', compact('service', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service, ServiceItem $item)
    {
       abort_unless($item->service_id === $service->id, 404);

    $this->normalizeNumbers($request);   // <-- AÑADIR

    $data = $request->validate([
        'description' => ['required','string','max:190'],
        'quantity'    => ['required','integer','min:1'],
        'unit_price'  => ['required','numeric','min:0'],
        'notes'       => ['nullable','string','max:500'],
    ]);

    $item->update($data);

    return redirect()->route('services.items.index', $service)
                     ->with('success', 'Ítem actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service, ServiceItem $item)
    {
        abort_unless($item->service_id === $service->id, 404);

        try {
            $item->delete();
            return redirect()->route('services.items.index', $service)->with('success', 'Ítem eliminado.');
        } catch (QueryException $e) {
            return redirect()->route('services.items.index', $service)->with('error', 'No se puede eliminar el ítem.');
        }
    }
    private function normalizeNumbers(Request $request): void
    {
        // Quita separadores de miles y usa punto como decimal
        $q = (string) $request->input('quantity', '');
        $p = (string) $request->input('unit_price', '');

        // Elimina espacios y no-break spaces
        $q = str_replace(["\xC2\xA0", ' '], '', $q);
        $p = str_replace(["\xC2\xA0", ' '], '', $p);

        // Convierte coma decimal a punto
        $q = str_replace(',', '.', $q);
        $p = str_replace(',', '.', $p);

        // Para cantidad queremos entero (24,00 => 24)
        if ($q !== '') {
            $q = (int) floatval($q);
        }

        // Precio como número con punto
        if ($p !== '') {
            $p = floatval($p);
        }

        $request->merge([
            'quantity'   => $q,
            'unit_price' => $p,
        ]);
    }
}
