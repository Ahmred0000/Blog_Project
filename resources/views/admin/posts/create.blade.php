@extends('layouts.app')

@section('title', __('Create Post'))

@section('content')
<h1>{{ __('Create Post') }}</h1>

<form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="title" class="form-label">{{ __('Title') }}</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}"
               class="form-control @error('title') is-invalid @enderror" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="body" class="form-label">{{ __('Body') }}</label>
        <textarea id="body" name="body" rows="8"
                  class="form-control @error('body') is-invalid @enderror" required>{{ old('body') }}</textarea>
        @error('body')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">{{ __('Category') }}</label>

        <div class="row g-2">
            <div class="col-md-6">
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                    <option value="">{{ __('Select Category') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- OR Create New Category -->
            <div class="col-md-6">
                <input type="text" name="new_category" placeholder="{{ __('Or create new category') }}"
                       class="form-control @error('new_category') is-invalid @enderror" value="{{ old('new_category') }}">
                @error('new_category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-text">{{ __('You must choose an existing category or enter a new one.') }}</div>
    </div>

    <!-- Image -->
    <div class="mb-3">
        <label for="image" class="form-label">{{ __('Image (optional)') }}</label>
        <input type="file" id="image" name="image" class="form-control" accept="image/*">
        @error('image')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="published_at" class="form-label">{{ __('Publish Date (optional)') }}</label>
        <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at') }}"
               class="form-control">
        @error('published_at')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
</form>
@endsection
