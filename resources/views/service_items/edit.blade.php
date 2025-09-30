@extends('adminlte::page')

@section('title', 'Editar ítem')
@section('content_header')
  <h1>Editar ítem — Servicio #{{ $service->id }}</h1>
@stop

@section('content')
<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('services.items.update', [$service, $item]) }}">
      @csrf @method('PUT')
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Descripccion *</label>
          <input type="text" name="descrption" class="form-control" value="{{ old('description', $item->description) }}" required>
          @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-2 mb-3">
          <label class="form-label">Cantidad *</label>
          <input type="number" name="quantity" class="form-control" min="1" step="1" value="{{ old('quantity', $item->quantity) }}" required>
          @error('quantity') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-2 mb-3">
          <label class="form-label">Precio unit. *</label>
          <input type="number" name="unit_price" class="form-control" min="0" step="0.01" value="{{ old('unit_price', $item->unit_price) }}" required>
          @error('unit_price') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-12 mb-3">
          <label class="form-label">Notas</label>
          <input type="text" name="notes" class="form-control" value="{{ old('notes', $item->notes) }}">
          @error('notes') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
      </div>

      <a href="{{ route('services.items.index', $service) }}" class="btn btn-secondary">Regresar</a>
      <button class="btn btn-primary">Actualizar</button>
    </form>
  </div>
</div>
@stop
