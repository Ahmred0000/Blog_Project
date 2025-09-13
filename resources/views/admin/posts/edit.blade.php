@extends('layouts.app')

@section('title', __('admin_edit_post.Edit_Post'))

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">{{ __('admin_edit_post.Edit_Post') }}</h1>

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">{{ __('admin_edit_post.Title') }}</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">{{ __('admin_edit_post.Body') }}</label>
            <textarea id="body" name="body" rows="6" class="form-control" required>{{ old('body', $post->body) }}</textarea>
            @error('body')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">{{ __('admin_edit_post.Category') }}</label>
            <select id="category_id" name="category_id" class="form-select" required>
                <option value="">{{ __('admin_edit_post.Select_Category') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">{{ __('admin_edit_post.Image_Optional') }}</label>
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid mb-2" style="max-width:200px;">
            @endif
            <input type="file" id="image" name="image" class="form-control" accept="image/*">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="published_at" class="form-label">{{ __('admin_edit_post.Publish_Date_Optional') }}</label>
            <input type="datetime-local" id="published_at" name="published_at" class="form-control" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}">
            @error('published_at')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ __('admin_edit_post.Update') }}</button>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary ms-2">{{ __('admin_edit_post.Cancel') }}</a>
    </form>
</div>
@endsection
