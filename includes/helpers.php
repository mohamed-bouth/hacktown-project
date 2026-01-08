<?php
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function flash_set(string $key, string $value): void
{
    $_SESSION['_flash'][$key] = $value;
}

function flash_get(string $key, ?string $default = null): ?string
{
    $value = $_SESSION['_flash'][$key] ?? $default;
    unset($_SESSION['_flash'][$key]);
    return $value;
}

function set_form_state(array $errors, array $old): void
{
    $_SESSION['_errors'] = $errors;
    $_SESSION['_old'] = $old;
}

function pull_errors(): array
{
    $errors = $_SESSION['_errors'] ?? [];
    unset($_SESSION['_errors']);
    return $errors;
}

function pull_old(): array
{
    $old = $_SESSION['_old'] ?? [];
    unset($_SESSION['_old']);
    return $old;
}

function excerpt(string $text, int $limit): string
{
    $length = function_exists('mb_strlen') ? mb_strlen($text) : strlen($text);
    if ($length <= $limit) {
        return $text;
    }

    $slice = function_exists('mb_substr') ? mb_substr($text, 0, $limit) : substr($text, 0, $limit);
    return rtrim($slice) . '...';
}

function render_header(string $title): void
{
    ?>
    <!doctype html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title><?= e($title) ?></title>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link
                href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&display=swap"
                rel="stylesheet"
            >
            <script src="https://cdn.tailwindcss.com"></script>
            <style>
                body { font-family: "Manrope", ui-sans-serif, system-ui, -apple-system, sans-serif; }
            </style>
        </head>
        <body class="min-h-screen bg-slate-50 text-slate-900">
            <header class="border-b border-slate-200 bg-white">
                <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
                    <a class="text-lg font-bold tracking-tight text-slate-900" href="/index.php">Lost &amp; Found</a>
                    <a class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800" href="/create.php">
                        Create Post
                    </a>
                </div>
            </header>
            <main class="mx-auto w-full max-w-6xl px-4 py-8">
    <?php
}

function render_footer(): void
{
    ?>
            </main>
        </body>
    </html>
    <?php
}
