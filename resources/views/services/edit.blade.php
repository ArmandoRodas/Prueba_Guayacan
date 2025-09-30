@extends('adminlte::page')

@section('title', 'Editar servicio')
@section('content_header')
    <h1>Editar servicio #{{ $service->id }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('services.update', $service) }}">
                        @csrf @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Cliente *</label>
                                <select name="client_id" class="form-select" required>
                                    @foreach ($clients as $c)
                                        <option value="{{ $c->id }}"
                                            {{ old('client_id', $service->client_id) == $c->id ? 'selected' : '' }}>
                                            {{ $c->first_name }} {{ $c->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Equipo *</label>
                                <select name="device_id" class="form-select" required>
                                    @foreach ($devices as $d)
                                        <option value="{{ $d->id }}"
                                            {{ old('device_id', $service->device_id) == $d->id ? 'selected' : '' }}>
                                            [{{ optional($d->client)->first_name }} {{ optional($d->client)->last_name }}]
                                            -
                                            {{ optional($d->deviceType)->name }} {{ optional($d->brand)->name }}
                                            {{ $d->model }}
                                            ({{ $d->serial_number }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('device_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Estado actual *</label>
                                <select name="current_status_id" class="form-select" required>
                                    @foreach ($statuses as $s)
                                        <option value="{{ $s->id }}"
                                            {{ old('current_status_id', $service->current_status_id) == $s->id ? 'selected' : '' }}>
                                            {{ $s->label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('current_status_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-5 mb-3">
                                <label class="form-label">Técnico asignado</label>
                                <select name="assigned_tech_id" class="form-select">
                                    <option value="">— (Ninguno) —</option>
                                    @foreach ($techs as $t)
                                        <option value="{{ $t->id }}"
                                            {{ old('assigned_tech_id', $service->assigned_tech_id) == $t->id ? 'selected' : '' }}>
                                            {{ $t->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Recibido *</label>
                                <input type="datetime-local" name="received_at" class="form-control"
                                    value="{{ old('received_at', \Illuminate\Support\Carbon::parse($service->received_at)->format('Y-m-d\TH:i')) }}"
                                    required>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Problema *</label>
                                <textarea name="reported_issue" class="form-control" rows="3" required>{{ old('reported_issue', $service->reported_issue) }}</textarea>
                                @error('reported_issue')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Diagnóstico</label>
                                <textarea name="diagnosis" class="form-control" rows="2">{{ old('diagnosis', $service->diagnosis) }}</textarea>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Solución / trabajo</label>
                                <textarea name="solution" class="form-control" rows="2">{{ old('solution', $service->solution) }}</textarea>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Nota para el historial (si cambia el estado)</label>
                                <input type="text" name="history_note" class="form-control" maxlength="500"
                                    value="{{ old('history_note') }}">
                            </div>
                        </div>

                        <a href="{{ route('services.index') }}" class="btn btn-secondary">Regresar</a>
                        <button class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><strong>Historial de estados</strong></div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Nota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($service->history()->with('status')->orderByDesc('changed_by_id')->get() as $h)
                                <tr>
                                    <td>{{ \Illuminate\Support\Carbon::parse($h->changed_at)->format('Y-m-d H:i') }}</td>
                                    <td>{{ optional($h->status)->label }}</td>
                                    <td>{{ $h->notes }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Sin historial.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
