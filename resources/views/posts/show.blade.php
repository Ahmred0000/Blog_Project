@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="container">
        <article class="mb-5">
            <h1 class="mb-3">{{ $post->title }}</h1>
            <p class="text-muted">
                {{ $post->published_at->translatedFormat('M d, Y H:i') }} |
                <span class="badge bg-secondary">{{ $post->category->name }}</span>
            </p>

            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                    class="img-fluid rounded mb-2 mb-md-0 ms-md-3" style="max-width:200px; max-height:200px;">
            @endif

            <div class="fs-5 lh-lg">
                {!! nl2br(e($post->body)) !!}
            </div>
        </article>

        <hr>
        <section class="mt-5">
            <h3 class="mb-4">{{ __('post.comments') }}</h3>

            @forelse($post->comments as $comment)
                <div class="mb-4 p-3 border rounded shadow-sm bg-light">
                    <div class="d-flex justify-content-between mb-2">
                        <strong>{{ $comment->author_name }}</strong>
                        <small class="text-muted">{{ $comment->created_at->translatedFormat('M d, Y H:i') }}</small>
                    </div>
                    <p class="mb-0">{{ $comment->body }}</p>
                </div>
            @empty
                <p class="text-muted fst-italic">{{ __('post.no_comments') }}</p>
            @endforelse

            <div class="card mt-5">
                <div class="card-body">
                    <h5 class="card-title">{{ __('post.leave_comment') }}</h5>
                    <form action="{{ route('posts.comments.store', $post) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="author_name" class="form-label">{{ __('post.your_name') }}</label>
                            <input type="text" class="form-control @error('author_name') is-invalid @enderror"
                                id="author_name" name="author_name" value="{{ old('author_name') }}" required>
                            @error('author_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="body" class="form-label">{{ __('post.comment') }}</label>
                            <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" rows="4"
                                required>{{ old('body') }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-chat-dots"></i> {{ __('post.post_comment') }}
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('styles')
<style>
    body {
        background: #f8fafc;
    }

    /* Post container */
    article {
        background: #fff;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }

    article h1 {
        font-size: 2rem;
        font-weight: bold;
        color: #212529;
    }

    article img {
        display: block;
        max-width: 100%;
        max-height: 400px;
        border-radius: 1rem;
        margin: 1.5rem auto;
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    }

    article .fs-5 {
        line-height: 1.8;
        color: #444;
    }

    /* Comments section */
    section h3 {
        font-weight: bold;
        color: #0dc5fd;
        border-left: 5px solid #0dc5fd;
        padding-left: 10px;
    }

    .comment-card {
        background: #ffffff;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid #e9ecef;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .comment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(13,197,253,0.2);
    }

    .comment-card strong {
        color: #212529;
    }

    .comment-card small {
        color: #6c757d;
    }

    /* Comment form */
    .card {
        border-radius: 1rem;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .card-title {
        color: #007bff;
        font-weight: bold;
    }

    .form-label {
        font-weight: 500;
        color: #333;
    }

    .btn-primary {
        background: linear-gradient(45deg, #0dc5fd, #007bff);
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(45deg, #007bff, #0dc5fd);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13,197,253,0.4);
    }
</style>
@endpush

