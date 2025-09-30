@extends('adminlte::page')

@section('title', 'Editar estado')
@section('content_header')
  <h1>Editar estado</h1>
@stop

@section('content')
<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('service-statuses.update', $status) }}">
      @csrf @method('PUT')

      <div class="row">
        <div class="col-md-4 mb-3">
          <label class="form-label">Código *</label>
          <input type="text" name="code" class="form-control" maxlength="40"
                 value="{{ old('code', $status->code) }}" required>
          @error('code') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Nombre *</label>
          <input type="text" name="label" class="form-control" maxlength="120"
                 value="{{ old('label', $status->label) }}" required>
          @error('label') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-2 mb-3 d-flex align-items-end">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="is_final" name="is_final"
                   {{ old('is_final', $status->is_final) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_final">¿Es final?</label>
          </div>
        </div>
      </div>

      <a href="{{ route('service-statuses.index') }}" class="btn btn-secondary">Regresar</a>
      <button class="btn btn-primary">Actualizar</button>
    </form>
  </div>
</div>
@stop
