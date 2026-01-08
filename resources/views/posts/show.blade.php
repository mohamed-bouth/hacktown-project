@extends('layouts.app')

@section('content')
    @php
        $whatsappNumber = preg_replace('/\D+/', '', $post->whatsapp);
        $phoneNumber = $post->phone ? preg_replace('/\D+/', '', $post->phone) : null;
    @endphp

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="badge {{ $post->type === 'lost' ? 'badge-lost' : 'badge-found' }}">
                        {{ ucfirst($post->type) }}
                    </span>
                    <span class="badge bg-secondary">{{ $post->category }}</span>
                    @if ($post->status === 'resolved')
                        <span class="badge bg-success">Resolved</span>
                    @endif
                </div>
                <small class="text-muted">{{ $post->created_at->format('M d, Y') }}</small>
            </div>

            <h1 class="h4 mb-2">{{ $post->location_text }}</h1>
            <p class="text-muted mb-3">{{ $post->city }}</p>

            <p>{{ $post->description }}</p>

            <div class="d-flex flex-wrap gap-2 mt-4">
                <a
                    class="btn btn-success"
                    href="https://wa.me/{{ $whatsappNumber }}"
                    target="_blank"
                    rel="noopener"
                >
                    Contact on WhatsApp
                </a>
                @if ($phoneNumber)
                    <a class="btn btn-outline-dark" href="tel:{{ $phoneNumber }}">Call</a>
                @endif
                @if ($post->status === 'active')
                    <form method="POST" action="{{ route('posts.resolve', $post) }}">
                        @csrf
                        <button class="btn btn-outline-primary">Mark as Resolved</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <a href="{{ route('posts.index') }}" class="btn btn-link">&larr; Back to list</a>
@endsection
