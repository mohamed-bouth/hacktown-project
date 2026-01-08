@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h4 mb-3">Create a Post</h1>

            <form method="POST" action="{{ route('posts.store') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="">Select type</option>
                            <option value="lost" @selected(old('type') === 'lost')>Lost</option>
                            <option value="found" @selected(old('type') === 'found')>Found</option>
                        </select>
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                            <option value="">Select category</option>
                            @foreach (['CIN', 'Phone', 'Document', 'Wallet', 'Other'] as $category)
                                <option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>
                            @endforeach
                        </select>
                        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">City</label>
                        <input
                            type="text"
                            name="city"
                            value="{{ old('city') }}"
                            class="form-control @error('city') is-invalid @enderror"
                            required
                        >
                        @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Location</label>
                        <input
                            type="text"
                            name="location_text"
                            value="{{ old('location_text') }}"
                            class="form-control @error('location_text') is-invalid @enderror"
                            required
                        >
                        @error('location_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea
                            name="description"
                            rows="4"
                            maxlength="500"
                            class="form-control @error('description') is-invalid @enderror"
                            required
                        >{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">WhatsApp Number</label>
                        <input
                            type="text"
                            name="whatsapp"
                            value="{{ old('whatsapp') }}"
                            class="form-control @error('whatsapp') is-invalid @enderror"
                            placeholder="+2126..."
                            required
                        >
                        @error('whatsapp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Phone Number (optional)</label>
                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            class="form-control @error('phone') is-invalid @enderror"
                            placeholder="05..."
                        >
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button class="btn btn-primary">Publish</button>
                    <a class="btn btn-outline-secondary" href="{{ route('posts.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
