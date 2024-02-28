@extends('layout.main')

@section('title', 'Crear una Cuenta')

@section('main')
    <h1 class="mb-3">Crear una Cuenta</h1>

    <form action="{{ route('auth.processRegister') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
            @error('email')
            <div class="mt-2 text-danger" id="email">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control">
            @error('password')
            <div class="mt-2 text-danger" id="error-password">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary w-100">Crear Cuenta</button>
    </form>
@endsection
