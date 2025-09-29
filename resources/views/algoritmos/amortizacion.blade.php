@extends('adminlte::page')

@section('title', 'Amortización')

@section('content_header')
    <h1>Amortización (cuota sobre saldos)</h1>
@stop

@section('content')
<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('alg.amort') }}">
      @csrf
      <div class="row">
        <div class="col-md-4 mb-3">
          <label class="form-label">Monto</label>
          <input type="number" step="0.01" min="0.01" class="form-control" name="monto"
                 value="{{ old('monto', $monto ?? '') }}" required>
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label">Tasa mensual (%)</label>
          <input type="number" step="0.0001" min="0" class="form-control" name="tasa"
                 value="{{ old('tasa', isset($tasa) ? $tasa*100 : '') }}" required>
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label">Periodos (meses)</label>
          <input type="number" min="1" class="form-control" name="periodos"
                 value="{{ old('periodos', $n ?? '') }}" required>
        </div>
      </div>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
          </ul>
        </div>
      @endif

      <button type="submit" class="btn btn-primary">Generar tabla</button>
    </form>
  </div>
</div>

@isset($rows)
<div class="card">
  <div class="card-body">
    <p>
      <strong>Monto:</strong> Q{{ number_format($monto,2) }} |
      <strong>Tasa:</strong> {{ number_format($tasa*100,2) }}% |
      <strong>Meses:</strong> {{ $n }} |
      <strong>Abono fijo:</strong> Q{{ number_format($abonoFijo,2) }}
    </p>

    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Periodo</th>
            <th>Saldo</th>
            <th>Interés</th>
            <th>Abono</th>
            <th>Pago</th>
          </tr>
        </thead>
        <tbody>
          @foreach($rows as $r)
            <tr>
              <td>{{ $r['periodo'] }}</td>
              <td>Q{{ number_format($r['saldo'],2) }}</td>
              <td>Q{{ number_format($r['interes'],2) }}</td>
              <td>Q{{ number_format($r['abono'],2) }}</td>
              <td>Q{{ number_format($r['pago'],2) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endisset
@stop
