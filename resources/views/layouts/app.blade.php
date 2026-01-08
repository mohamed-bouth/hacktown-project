<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Lost & Found</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
        >
        <style>
            body { background: #f7f7f7; }
            .badge-lost { background: #dc3545; }
            .badge-found { background: #198754; }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-white border-bottom">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('posts.index') }}">Lost & Found</a>
                <a class="btn btn-primary btn-sm" href="{{ route('posts.create') }}">Create Post</a>
            </div>
        </nav>

        <main class="container my-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @yield('content')
        </main>
    </body>
</html>
