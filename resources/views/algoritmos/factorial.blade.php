@extends('adminlte::page')

@section('title', 'Factorial')

@section('content_header')
    <h1>Factorial</h1>
@stop

@section('content')
<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('alg.factorial') }}">
      @csrf
      <div class="mb-3">
        <label for="n" class="form-label">Número (n)</label>
        <input type="number" min="0" class="form-control" id="n" name="n"
               value="{{ old('n', $n ?? '') }}" required>
        @error('n') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
      </div>
      <button type="submit" class="btn btn-primary">Calcular</button>
    </form>

    @isset($fact)
      <hr>
      <p class="mb-0"><strong>{{ $n }}!</strong> = {{ $fact }}</p>
    @endisset
  </div>
</div>
@stop
