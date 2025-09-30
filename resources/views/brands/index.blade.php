@extends('adminlte::page')

@section('title', 'Brands')

@section('content_header')
  <h1>Marcas</h1>
@stop

@section('content')
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="mb-3">
    <a href="{{ route('brands.create') }}" class="btn btn-primary">Nueva marca</a>
  </div>

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th style="width:140px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($brands as $b)
            <tr>
              <td>{{ $b->id }}</td>
              <td>{{ $b->name }}</td>
              <td>
                <a href="{{ route('brands.edit', $b) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('brands.destroy', $b) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Elimionar esta marca?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">Eliminar</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="3">Sin registros...</td></tr>
          @endforelse
        </tbody>
      </table>

      <div class="mt-2">
        {{ $brands->links() }}
      </div>
    </div>
  </div>
@stop
