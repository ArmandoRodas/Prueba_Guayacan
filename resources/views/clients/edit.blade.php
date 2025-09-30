@extends('adminlte::page')

@section('title', 'Editar cliente')

@section('content_header')
  <h1>Editar cliente</h1>
@stop

@section('content')
<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('clients.update', $client) }}">
      @csrf @method('PUT')

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Nombres *</label>
          <input type="text" name="first_name" class="form-control" maxlength="120"
                 value="{{ old('first_name', $client->first_name) }}" required>
          @error('first_name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Apellidos</label>
          <input type="text" name="last_name" class="form-control" maxlength="120"
                 value="{{ old('last_name', $client->last_name) }}">
          @error('last_name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">NIT / Documento</label>
          <input type="text" name="tax_id" class="form-control" maxlength="30"
                 value="{{ old('tax_id', $client->tax_id) }}">
          @error('tax_id') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">Teléfono</label>
          <input type="text" name="phone" class="form-control" maxlength="30"
                 value="{{ old('phone', $client->phone) }}">
          @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">Correo electrónico</label>
          <input type="email" name="email" class="form-control" maxlength="190"
                 value="{{ old('email', $client->email) }}">
          @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-12 mb-3">
          <label class="form-label">Dirección</label>
          <input type="text" name="address" class="form-control" maxlength="255"
                 value="{{ old('address', $client->address) }}">
          @error('address') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
      </div>

      <a href="{{ route('clients.index') }}" class="btn btn-secondary">Regresar</a>
      <button class="btn btn-primary">Actualizar</button>
    </form>
  </div>
</div>
@stop
