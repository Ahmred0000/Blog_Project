@extends('layouts.app')

@section('title', __('admin_posts.Admin_Posts'))

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ __('admin_posts.Posts') }}</h1>
        <div>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-success me-2">
                <i class="bi bi-plus-lg"></i> {{ __('admin_posts.Create_New_Post') }}
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
                <i class="bi bi-tags"></i> {{ __('admin_categories.Manage_Categories') }}
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>{{ __('admin_posts.Title') }}</th>
                    <th>{{ __('admin_posts.Category') }}</th>
                    <th>{{ __('admin_posts.Published_At') }}</th>
                    <th>{{ __('admin_posts.Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->category->name }}</td>
                        <td>{{ $post->published_at?->format('Y-m-d H:i') ?? __('admin_posts.Unpublished') }}</td>
                        <td>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-primary me-1">
                                <i class="bi bi-pencil"></i> {{ __('admin_posts.Edit') }}
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('admin_posts.Confirm_Delete') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> {{ __('admin_posts.Delete') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $posts->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
@endsection
