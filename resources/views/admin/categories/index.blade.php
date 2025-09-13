@extends('layouts.app')

@section('title', __('admin_categories.Admin_Categories'))

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>{{ __('admin_categories.Categories') }}</h1>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> {{ __('admin_categories.Create_New_Category') }}
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>{{ __('admin_categories.Name') }}</th>
                        <th>{{ __('admin_categories.Post_Count') }}</th>
                        <th>{{ __('admin_categories.Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->posts->count() }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                    class="btn btn-sm btn-primary me-1">
                                    <i class="bi bi-pencil"></i> {{ __('admin_categories.Edit') }}
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('{{ __('admin_categories.Confirm_Delete') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> {{ __('admin_categories.Delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $categories->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
@endsection
