@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Active Posts</h1>
        <span class="text-muted small">{{ $posts->count() }} items</span>
    </div>

    <form method="GET" action="{{ route('posts.index') }}" class="card card-body mb-4">
        <div class="row g-2">
            <div class="col-12 col-md-4">
                <input
                    type="text"
                    name="q"
                    value="{{ $filters['q'] }}"
                    class="form-control"
                    placeholder="Search keyword..."
                >
            </div>
            <div class="col-6 col-md-2">
                <select name="type" class="form-select">
                    <option value="">Type</option>
                    <option value="lost" @selected($filters['type'] === 'lost')>Lost</option>
                    <option value="found" @selected($filters['type'] === 'found')>Found</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select name="category" class="form-select">
                    <option value="">Category</option>
                    @foreach (['CIN', 'Phone', 'Document', 'Wallet', 'Other'] as $category)
                        <option value="{{ $category }}" @selected($filters['category'] === $category)>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-3">
                <input
                    type="text"
                    name="city"
                    value="{{ $filters['city'] }}"
                    class="form-control"
                    placeholder="City"
                >
            </div>
            <div class="col-12 col-md-1 d-grid">
                <button class="btn btn-dark">Go</button>
            </div>
        </div>
    </form>

    <div class="row g-3">
        @forelse ($posts as $post)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge {{ $post->type === 'lost' ? 'badge-lost' : 'badge-found' }}">
                                {{ ucfirst($post->type) }}
                            </span>
                            <span class="badge bg-secondary">{{ $post->category }}</span>
                        </div>
                        <h2 class="h6">{{ $post->location_text }}</h2>
                        <p class="text-muted small mb-2">{{ $post->city }}</p>
                        <p class="mb-0">{{ \Illuminate\Support\Str::limit($post->description, 120) }}</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('posts.show', $post) }}">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No active posts found.</div>
            </div>
        @endforelse
    </div>
@endsection
