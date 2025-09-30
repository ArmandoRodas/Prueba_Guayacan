@extends('adminlte::page')

@section('title', 'Nuevo servicio')
@section('content_header')
    <h1>Nuevo servicio</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('services.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cliente *</label>
                        <select name="client_id" class="form-select" required>
                            <option value="">— Seleccionar —</option>
                            @foreach ($clients as $c)
                                <option value="{{ $c->id }}" {{ old('client_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->first_name }} {{ $c->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Equipo *</label>
                        <select name="device_id" class="form-select" required>
                            <option value="">— Seleccionar —</option>
                            @foreach ($devices as $d)
                                <option value="{{ $d->id }}" {{ old('device_id') == $d->id ? 'selected' : '' }}>
                                    [{{ optional($d->client)->first_name }} {{ optional($d->client)->last_name }}] -
                                    {{ optional($d->deviceType)->name }} {{ optional($d->brand)->name }}
                                    {{ $d->model }}
                                    ({{ $d->serial_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('device_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                        <small class="text-muted"></small>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Estado *</label>
                        <select name="current_status_id" class="form-select" required>
                            @foreach ($statuses as $s)
                                <option value="{{ $s->id }}" {{ old('current_status_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->label }}</option>
                            @endforeach
                        </select>
                        @error('current_status_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Técnico asignado</label>
                        <select name="assigned_tech_id" class="form-select">
                            <option value="">— (Opcional) —</option>
                            @foreach ($techs as $t)
                                <option value="{{ $t->id }}" {{ old('assigned_tech_id') == $t->id ? 'selected' : '' }}>
                                    {{ $t->name }}</option>
                            @endforeach
                        </select>
                        @error('assigned_tech_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fecha/hora de recepción *</label>
                        <input type="datetime-local" name="received_at" class="form-control"
                            value="{{ old('received_at', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('received_at')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Problema que presenta *</label>
                        <textarea name="reported_issue" class="form-control" rows="3" required>{{ old('reported_issue') }}</textarea>
                        @error('reported_issue')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Diagnóstico</label>
                        <textarea name="diagnosis" class="form-control" rows="2">{{ old('diagnosis') }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Solución / trabajo realizado</label>
                        <textarea name="solution" class="form-control" rows="2">{{ old('solution') }}</textarea>
                    </div>
                </div>

                <a href="{{ route('services.index') }}" class="btn btn-secondary">Regresar</a>
                <button class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
@stop
