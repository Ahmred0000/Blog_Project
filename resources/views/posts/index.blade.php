@extends('layouts.app')

@section('title', __('home.home'))

@section('content')
    <div class="row">
        <!-- Main content -->
        <div class="col-md-8">
            <h1 class="mb-4">{{ __('home.recent_posts') }}</h1>

            @foreach ($posts as $post)
                <article class="mb-4 pb-3 border-bottom post-card p-3 d-flex flex-column flex-md-row">
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                            class="img-fluid rounded mb-2 mb-md-0 ms-md-3" style="max-width:200px; max-height:200px; margin-right: 5px;">
                    @endif

                    <div class="flex-grow-1">
                        <h2 class="h4">
                            <a href="{{ route('posts.show', $post) }}"
                                class="text-decoration-none link-dark fw-semibold post-link">
                                {{ $post->title }}
                            </a>
                        </h2>
                        <p class="text-muted small mb-2">
                            <i class="bi bi-calendar"></i> {{ $post->published_at?->translatedFormat('M d, Y H:i') }}
                            <span class="mx-1">|</span>
                            <i class="bi bi-folder"></i> {{ $post->category->name }}
                        </p>
                        <p class="mb-0">{{ Str::limit(strip_tags($post->body), 150) }}</p>
                    </div>
                </article>
            @endforeach


            <!-- Pagination -->
            <div class="mt-4">
                {{ $posts->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header fw-bold">
                    {{ __('home.categories') }}
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <a href="{{ route('home') }}"
                            class="d-block py-1 text-decoration-none category-link @if (!$categoryId) fw-bold @endif">
                            {{ __('home.all') }}
                        </a>
                    </li>
                    @foreach ($categories as $category)
                        <li class="list-group-item">
                            <a href="{{ route('home', ['category' => $category->id]) }}"
                                class="d-block py-1 text-decoration-none category-link @if ($categoryId == $category->id) fw-bold @endif">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
@endsection


@push('styles')
    <style>
        body {
        background: #f5f7fa;
    }

    /* Post card */
    .post-card {
        border-radius: 1rem;
        transition: all 0.3s ease-in-out;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 18px rgba(13, 197, 253, 0.3);
        border-left: 5px solid #0dc5fd;
    }

    .post-link {
        transition: color 0.2s ease, text-decoration 0.2s ease;
    }

    .post-link:hover {
        color: #0dc5fd;
        text-decoration: none;
    }

    .post-card img {
        border-radius: 0.75rem;
        object-fit: cover;
    }

    /* Meta info (date + category) */
    .post-meta {
        font-size: 0.9rem;
        color: #6c757d;
    }

    /* Sidebar */
    aside .card {
        border-radius: 1rem;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .card-header {
        background: linear-gradient(45deg, #0dc5fd, #007bff);
        color: #fff;
        font-weight: 600;
        border-radius: 1rem 1rem 0 0;
    }

    .category-link {
        transition: all 0.2s ease;
        color: #333;
    }

    .category-link:hover {
        background-color: #e9f7ff;
        padding-left: 10px;
        color: #0dc5fd;
    }

    /* Pagination */
    .pagination .page-link {
        border-radius: 50% !important;
        margin: 0 3px;
        color: #0dc5fd;
        border: none;
    }

    .pagination .page-item.active .page-link {
        background-color: #0dc5fd;
        color: #fff;
        box-shadow: 0 0 8px rgba(13, 197, 253, 0.5);
    }

    .pagination .page-link:hover {
        background-color: #0dc5fd;
        color: #fff;
    }
    </style>
@endpush
