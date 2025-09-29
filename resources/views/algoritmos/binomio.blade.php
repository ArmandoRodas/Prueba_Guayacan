@extends('adminlte::page')

@section('title', 'Binomio')

@section('content_header')
    <h1>(a + b)^n — versión recursiva (solo n)</h1>
@stop

@section('content')
<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('alg.binomio') }}">
      @csrf
      <div class="row">
        <div class="col-md-3 mb-3">
          <label class="form-label">n (entero ≥ 0)</label>
          <input type="number" min="0" max="20" class="form-control" name="n"
                 value="{{ old('n', $n ?? '') }}" required>
        </div>
      </div>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
          </ul>
        </div>
      @endif

      <button type="submit" class="btn btn-primary">Generar</button>
    </form>
  </div>
</div>

@isset($expansion)
<div class="card">
  <div class="card-body">
    <p class="mb-2"><strong>Triángulo de Pascal — fila {{ $n }}:</strong>
      [ {{ implode(', ', $coef) }} ]
    </p>
    <p class="mb-0"><strong>Desarrollo:</strong></p>
    <p>(a + b)<sup>{{ $n }}</sup> = {{ $expansion }}</p>
  </div>
</div>
@endisset
@stop
