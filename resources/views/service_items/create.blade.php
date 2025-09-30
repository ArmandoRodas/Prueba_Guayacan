@extends('adminlte::page')

@section('title', 'Nuevo ítem')
@section('content_header')
  <h1>Nuevo ítem — Servicio #{{ $service->id }}</h1>
@stop

@section('content')
<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('services.items.store', $service) }}">
      @csrf

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Descripción *</label>
          <input
            type="text"
            name="description"            {{-- <— nombre correcto --}}
            class="form-control"
            value="{{ old('description') }}"  {{-- <— old correcto --}}
            required
          >
          @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-2 mb-3">
          <label class="form-label">Cantidad *</label>
          <input type="number" name="quantity" class="form-control"
                 min="1" step="1" value="{{ old('quantity', 1) }}" required>
          @error('quantity') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-2 mb-3">
          <label class="form-label">Precio unit. *</label>
          <input type="number" name="unit_price" class="form-control"
                 min="0" step="0.01" value="{{ old('unit_price', 0) }}" required>
          @error('unit_price') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-12 mb-3">
          <label class="form-label">Notas</label>
          <input type="text" name="notes" class="form-control" value="{{ old('notes') }}">
          @error('notes') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
      </div>

      <a href="{{ route('services.items.index', $service) }}" class="btn btn-secondary">Regresar</a>
      <button class="btn btn-primary">Guardar</button>
    </form>
  </div>
</div>
@stop
