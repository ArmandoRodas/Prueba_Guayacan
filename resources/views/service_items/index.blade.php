@extends('adminlte::page')

@section('title', 'Ítems del servicio')
@section('content_header')
  <h1>
    Ítems del servicio #{{ $service->id }}
    @if($service->folio) <small class="text-muted">({{ $service->folio }})</small>@endif
  </h1>
@stop

@section('content')
  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div>   @endif

  <div class="mb-3 d-flex gap-2">
    <a href="{{ route('services.edit', $service) }}" class="btn btn-secondary">Regresar al servicio</a>
    <a href="{{ route('services.items.create', $service) }}" class="btn btn-primary">Nuevo ítem</a>
  </div>

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Concepto</th>
            <th class="text-end">Cantidad</th>
            <th class="text-end">Precio unit.</th>
            <th class="text-end">Subtotal</th>
            <th style="width:160px;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @php $total = 0; @endphp

          @forelse ($items as $it)
            @php
              $sub = $it->quantity * $it->unit_price;
              $total += $sub;
            @endphp
            <tr>
              <td>
                <strong>{{ $it->description ?? $it->concept }}</strong>
                @if ($it->notes)
                  <div class="text-muted small">{{ $it->notes }}</div>
                @endif
              </td>
              <td class="text-end">{{ number_format($it->quantity) }}</td>
              <td class="text-end">{{ number_format($it->unit_price, 2) }}</td>
              <td class="text-end">{{ number_format($sub, 2) }}</td>
              <td>
                <a href="{{ route('services.items.edit', [$service, $it]) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('services.items.destroy', [$service, $it]) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('¿Eliminar este ítem?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">Eliminar</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5">No hay ítems agregados.</td></tr>
          @endforelse
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3" class="text-end">Total</th>
            <th class="text-end">{{ number_format($total, 2) }}</th>
            <th></th>
          </tr>
        </tfoot>
      </table>

      <div class="mt-2">
        {{ $items->links() }}
      </div>
    </div>
  </div>
@stop
