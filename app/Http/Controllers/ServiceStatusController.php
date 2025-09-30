<?php

namespace App\Http\Controllers;

use App\Models\ServiceStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class ServiceStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $statuses = ServiceStatus::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('code', 'like', "%{$q}%")
                    ->orWhere('label', 'like', "%{$q}%");
            })
            ->orderBy('code')
            ->paginate(10)
            ->withQueryString();

        return view('service-statuses.index', compact('statuses', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('service-statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code'       => ['required', 'string', 'max:40', 'alpha_dash', 'unique:service_statuses,code'],
            'label'      => ['required', 'string', 'max:120'],
        ]);

        $data['code']       = strtoupper($data['code']);


        ServiceStatus::create($data);

        return redirect()->route('service-statuses.index')->with('success', 'Estado creado correctamente.');
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
    public function edit(ServiceStatus $serviceStatus)
    {
        return view('service-statuses.edit', ['status' => $serviceStatus]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceStatus $serviceStatus)
    {
        $data = $request->validate([
            'code'       => ['required', 'string', 'max:40', 'alpha_dash', Rule::unique('service_statuses', 'code')->ignore($serviceStatus->id)],
            'label'      => ['required', 'string', 'max:120'],
        ]);

        $data['code']       = strtoupper($data['code']);

        $serviceStatus->update($data);

        return redirect()->route('service-statuses.index')->with('success', 'Estado actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceStatus $serviceStatus)
    {
        try {
            $serviceStatus->delete();
            return redirect()->route('service-statuses.index')->with('success', 'Estado eliminado.');
        } catch (QueryException $e) {
            // Si está en uso por services o history, la FK lo impide
            return redirect()->route('service-statuses.index')
                ->with('error', 'No se puede eliminar: el estado está en uso.');
        }
    }
}
