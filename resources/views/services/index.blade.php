@extends('adminlte::page')

@section('title', 'Servicios')
@section('content_header')
    <h1>Servicios</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form class="row g-2 mb-3" method="GET" action="{{ route('services.index') }}">
        <div class="col-md-3">
            <input type="text" name="q" class="form-control" placeholder="Buscar por cliente, equipo o texto"
                value="{{ $q }}">
        </div>
        <div class="col-md-3">
            <select name="client_id" class="form-select">
                <option value="">— Cliente —</option>
                @foreach ($clients as $c)
                    <option value="{{ $c->id }}" {{ (string) $clientId === (string) $c->id ? 'selected' : '' }}>
                        {{ $c->first_name }} {{ $c->last_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="status_id" class="form-select">
                <option value="">— Estado —</option>
                @foreach ($statuses as $s)
                    <option value="{{ $s->id }}" {{ (string) $statusId === (string) $s->id ? 'selected' : '' }}>
                        {{ $s->label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="tech_id" class="form-select">
                <option value="">— Técnico —</option>
                @foreach ($techs as $t)
                    <option value="{{ $t->id }}" {{ (string) $techId === (string) $t->id ? 'selected' : '' }}>
                        {{ $t->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <button class="btn btn-outline-primary w-100">Filtrar</button>
        </div>
    </form>

    <div class="mb-3">
        <a href="{{ route('services.create') }}" class="btn btn-primary">Nuevo servicio</a>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Recibido</th>
                        <th>Cliente</th>
                        <th>Equipo</th>
                        <th>Estado</th>
                        <th>Técnico</th>
                        <th style="width:160px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $s)
                        <tr>
                            <td>{{ $s->id }}</td>
                            <td>{{ \Illuminate\Support\Carbon::parse($s->received_at)->format('Y-m-d H:i') }}</td>
                            <td>{{ optional($s->client)->first_name }} {{ optional($s->client)->last_name }}</td>
                            <td>
                                {{ optional($s->device->deviceType)->name }}
                                {{ optional($s->device->brand)->name }}
                                {{ $s->device->model }} ({{ $s->device->serial_number }})
                            </td>
                            <td><span class="badge bg-info">{{ optional($s->status)->label }}</span></td>
                            <td>{{ optional($s->technician)->name }}</td>
                            <td>
                                <a href="{{ route('services.edit', $s) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('services.destroy', $s) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Eliminar este servicio?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                    <a href="{{ route('services.items.index', $s) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Ítems
                                    </a>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No hay servicios.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-2">
                {{ $services->links() }}
            </div>
        </div>
    </div>
@stop
