@extends('adminlte::page')

@section('title', 'Edit Brand')

@section('content_header')
  <h1>Editar Marca</h1>
@stop

@section('content')
  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('brands.update', $brand) }}">
        @csrf @method('PUT')
        <div class="mb-3">
          <label class="form-label">Nombre de la marca</label>
          <input type="text" name="name" class="form-control" maxlength="80"
                 value="{{ old('name', $brand->name) }}" required>
          @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <a href="{{ route('brands.index') }}" class="btn btn-secondary">Regresar</a>
        <button class="btn btn-primary">Actualizar marca</button>
      </form>
    </div>
  </div>
@stop
