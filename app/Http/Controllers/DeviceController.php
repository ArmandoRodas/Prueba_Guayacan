<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Brand;
use App\Models\Client;
use App\Models\DeviceType;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q      = trim((string) $request->get('q', ''));
        $client = $request->get('client_id');
        $type   = $request->get('device_type_id');
        $brand  = $request->get('brand_id');

        $devices = Device::query()
            ->with(['client', 'deviceType', 'brand'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('model', 'like', "%{$q}%")
                        ->orWhere('serial_number', 'like', "%{$q}%")
                        ->orWhere('imei', 'like', "%{$q}%")
                        ->orWhere('notes', 'like', "%{$q}%");
                });
            })
            ->when($client, fn($x) => $x->where('client_id', $client))
            ->when($type,   fn($x) => $x->where('device_type_id', $type))
            ->when($brand,  fn($x) => $x->where('brand_id', $brand))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        // Opciones para filtros/selects
        $clients = Client::orderBy('first_name')->orderBy('last_name')->get(['id', 'first_name', 'last_name']);
        $deviceTypes = DeviceType::orderBy('name')->get(['id', 'name']);
        $brands = Brand::orderBy('name')->get(['id', 'name']);

        return view('devices.index', compact('devices', 'q', 'client', 'type', 'brand', 'clients', 'deviceTypes', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('first_name')->orderBy('last_name')->get(['id', 'first_name', 'last_name']);
        $deviceTypes = DeviceType::orderBy('name')->get(['id', 'name']);
        $brands = Brand::orderBy('name')->get(['id', 'name']);

        return view('devices.create', compact('clients', 'deviceTypes', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'      => ['required', 'exists:clients,id'],
            'device_type_id' => ['required', 'exists:device_types,id'],
            'brand_id'       => ['nullable', 'exists:brands,id'],
            'model'          => ['nullable', 'string', 'max:120'],
            'serial_number'  => ['nullable', 'string', 'max:120'],
            'imei'           => ['nullable', 'string', 'max:20'],
            'accessories'    => ['nullable', 'string', 'max:255'],
            'notes'          => ['nullable', 'string'],
        ]);

        Device::create($data);

        return redirect()->route('devices.index')->with('success', 'Equipo creado correctamente.');
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
    public function edit(Device $device)
    {
        $clients = Client::orderBy('first_name')->orderBy('last_name')->get(['id', 'first_name', 'last_name']);
        $deviceTypes = DeviceType::orderBy('name')->get(['id', 'name']);
        $brands = Brand::orderBy('name')->get(['id', 'name']);

        return view('devices.edit', compact('device', 'clients', 'deviceTypes', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device)
    {
        $data = $request->validate([
            'client_id'      => ['required','exists:clients,id'],
            'device_type_id' => ['required','exists:device_types,id'],
            'brand_id'       => ['nullable','exists:brands,id'],
            'model'          => ['nullable','string','max:120'],
            'serial_number'  => ['nullable','string','max:120'],
            'imei'           => ['nullable','string','max:20'],
            'accessories'    => ['nullable','string','max:255'],
            'notes'          => ['nullable','string'],
        ]);

        $device->update($data);

        return redirect()->route('devices.index')->with('success', 'Equipo actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
         try {
            $device->delete();
            return redirect()->route('devices.index')->with('success', 'Equipo eliminado.');
        } catch (QueryException $e) {
            // Probablemente existe un Service que referencia este device (FK)
            return redirect()->route('devices.index')->with('error', 'No se puede eliminar: el equipo está en uso.');
        }
    }
}
