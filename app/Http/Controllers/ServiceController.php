<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Client;
use App\Models\Device;
use App\Models\User;
use App\Models\ServiceStatus;
use App\Models\ServiceStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q        = trim((string) $request->get('q', ''));
        $clientId = $request->get('client_id');
        $statusId = $request->get('status_id');
        $techId   = $request->get('tech_id');

        $services = Service::query()
            ->with(['client','device.deviceType','device.brand','status','technician'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('id', $q)
                      ->orWhere('reported_issue', 'like', "%{$q}%")
                      ->orWhereHas('client', fn($c)=>$c->where('first_name','like',"%{$q}%")
                                                       ->orWhere('last_name','like',"%{$q}%"))
                      ->orWhereHas('device', fn($d)=>$d->where('model','like',"%{$q}%")
                                                       ->orWhere('serial_number','like',"%{$q}%")
                                                       ->orWhere('imei','like',"%{$q}%"));
                });
            })
            ->when($clientId, fn($q)=>$q->where('client_id', $clientId))
            ->when($statusId, fn($q)=>$q->where('current_status_id', $statusId))
            ->when($techId,   fn($q)=>$q->where('assigned_tech_id', $techId))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $clients  = Client::orderBy('first_name')->orderBy('last_name')->get(['id','first_name','last_name']);
        $statuses = ServiceStatus::orderBy('label')->get(['id','label']);
        $techs    = User::orderBy('name')->get(['id','name']);

        return view('services.index', compact('services','q','clientId','statusId','techId','clients','statuses','techs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients  = Client::orderBy('first_name')->orderBy('last_name')->get(['id','first_name','last_name']);
        $devices  = Device::with('client')->orderByDesc('id')->get();
        $statuses = ServiceStatus::orderBy('label')->get(['id','label']);
        $techs    = User::orderBy('name')->get(['id','name']);

        return view('services.create', compact('clients','devices','statuses','techs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'         => ['required','exists:clients,id'],
            'device_id'         => ['required','exists:devices,id'],
            'received_at'       => ['required','date'],
            'reported_issue'    => ['required','string'],
            'diagnosis'         => ['nullable','string'],
            'solution'          => ['nullable','string'],
            'current_status_id' => ['required','exists:service_statuses,id'],
            'assigned_tech_id'  => ['nullable','exists:users,id'],
        ]);

        // El equipo debe pertenecer al cliente
        $belongs = Device::where('id',$data['device_id'])
                         ->where('client_id',$data['client_id'])
                         ->exists();
        if (!$belongs) {
            return back()->withErrors(['device_id'=>'El equipo seleccionado no pertenece al cliente.'])->withInput();
        }

        // Generar folio (ajusta el formato si tu columna es más corta)
        $next = (Service::max('id') ?? 0) + 1;
        $data['folio'] = 'SRV-'.now()->format('Ymd').'-'.str_pad($next, 6, '0', STR_PAD_LEFT);

        $service = Service::create($data);

        // Historial: estado inicial
        ServiceStatusHistory::create([
            'service_id'    => $service->id,
            'status_id'     => $service->current_status_id,
            'changed_by_id' => null, // auth()->id() si tienes login
            'changed_at'    => now(),
            'notes'         => 'Servicio creado',
        ]);

        return redirect()->route('services.index')->with('success','Servicio creado correctamente.');
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
    public function edit(Service $service)
    {
       $service->load(['client','device','status','technician','history.status']);

        $clients  = Client::orderBy('first_name')->orderBy('last_name')->get(['id','first_name','last_name']);
        $devices  = Device::with('client')->orderByDesc('id')->get();
        $statuses = ServiceStatus::orderBy('label')->get(['id','label']);
        $techs    = User::orderBy('name')->get(['id','name']);

        return view('services.edit', compact('service','clients','devices','statuses','techs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'client_id'         => ['required','exists:clients,id'],
            'device_id'         => ['required','exists:devices,id'],
            'received_at'       => ['required','date'],
            'reported_issue'    => ['required','string'],
            'diagnosis'         => ['nullable','string'],
            'solution'          => ['nullable','string'],
            'current_status_id' => ['required','exists:service_statuses,id'],
            'assigned_tech_id'  => ['nullable','exists:users,id'],
            'history_note'      => ['nullable','string','max:500'],
        ]);

        $belongs = Device::where('id',$data['device_id'])
                         ->where('client_id',$data['client_id'])
                         ->exists();
        if (!$belongs) {
            return back()->withErrors(['device_id'=>'El equipo seleccionado no pertenece al cliente.'])->withInput();
        }

        $statusChanged = (int)$service->current_status_id !== (int)$data['current_status_id'];

        $service->update($data);

        if ($statusChanged) {
            ServiceStatusHistory::create([
                'service_id'    => $service->id,
                'status_id'     => $service->current_status_id,
                'changed_by_id' => null,
                'changed_at'    => now(),
                'notes'         => $request->input('history_note'),
            ]);
        }

        return redirect()->route('services.index')->with('success','Servicio actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        try {
            $service->delete();
            return redirect()->route('services.index')->with('success','Servicio eliminado.');
        } catch (QueryException $e) {
            return redirect()->route('services.index')->with('error','No se puede eliminar: el servicio está en uso.');
        }
    }
}
