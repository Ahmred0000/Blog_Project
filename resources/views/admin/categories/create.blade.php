@extends('layouts.app')

@section('title', __('admin_categories.Create_Category'))

@section('content')
<div class="container mt-4">
    <h1>{{ __('admin_categories.Create_Category') }}</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="mt-3">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('admin_categories.Name') }}</label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> {{ __('admin_categories.Create') }}
        </button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">{{ __('admin_categories.Cancel') }}</a>
    </form>
</div>
@endsection
