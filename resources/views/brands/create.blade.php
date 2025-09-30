@extends('adminlte::page')

@section('title', 'New Brand')

@section('content_header')
  <h1>Nueva Marca</h1>
@stop

@section('content')
  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('brands.store') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Nombre de la marca</label>
          <input type="text" name="name" class="form-control" maxlength="80" value="{{ old('name') }}" required>
          @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <a href="{{ route('brands.index') }}" class="btn btn-secondary">Regresar</a>
        <button class="btn btn-primary">Guardar</button>
      </form>
    </div>
  </div>
@stop
