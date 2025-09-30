@extends('adminlte::page')

@section('title', 'Equipos')

@section('content_header')
  <h1>Equipos de clientes</h1>
@stop

@section('content')
  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div>   @endif

  <form class="row g-2 mb-3" method="GET" action="{{ route('devices.index') }}">
    <div class="col-md-3">
      <input type="text" name="q" class="form-control" placeholder="Buscar por modelo, serie o IMEI" value="{{ $q }}">
    </div>
    <div class="col-md-3">
      <select name="client_id" class="form-select">
        <option value="">— Cliente —</option>
        @foreach($clients as $c)
          <option value="{{ $c->id }}" {{ (string)$client===(string)$c->id?'selected':'' }}>
            {{ trim($c->first_name.' '.$c->last_name) }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2">
      <select name="device_type_id" class="form-select">
        <option value="">— Tipo —</option>
        @foreach($deviceTypes as $t)
          <option value="{{ $t->id }}" {{ (string)$type===(string)$t->id?'selected':'' }}>{{ $t->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2">
      <select name="brand_id" class="form-select">
        <option value="">— Marca —</option>
        @foreach($brands as $b)
          <option value="{{ $b->id }}" {{ (string)$brand===(string)$b->id?'selected':'' }}>{{ $b->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-outline-primary w-100">Filtrar</button>
    </div>
  </form>

  <div class="mb-3">
    <a href="{{ route('devices.create') }}" class="btn btn-primary">Nuevo equipo</a>
  </div>

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Cliente</th>
            <th>Tipo</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Serie</th>
            <th>IMEI</th>
            <th style="width:160px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @forelse($devices as $d)
          <tr>
            <td>{{ $d->id }}</td>
            <td>{{ optional($d->client)->first_name }} {{ optional($d->client)->last_name }}</td>
            <td>{{ optional($d->deviceType)->name }}</td>
            <td>{{ optional($d->brand)->name }}</td>
            <td>{{ $d->model }}</td>
            <td>{{ $d->serial_number }}</td>
            <td>{{ $d->imei }}</td>
            <td>
              <a href="{{ route('devices.edit', $d) }}" class="btn btn-sm btn-warning">Editar</a>
              <form action="{{ route('devices.destroy', $d) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('¿Eliminar este equipo?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Eliminar</button>
              </form>
            </td>
          </tr>
          @empty
            <tr><td colspan="8">No hay registros.</td></tr>
          @endforelse
        </tbody>
      </table>

      <div class="mt-2">
        {{ $devices->links() }}
      </div>
    </div>
  </div>
@stop
