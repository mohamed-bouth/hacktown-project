<?php
declare(strict_types=1);

require __DIR__ . '/../includes/bootstrap.php';
require __DIR__ . '/../includes/posts.php';

$filters = [
    'q' => trim((string)($_GET['q'] ?? '')),
    'type' => trim((string)($_GET['type'] ?? '')),
    'category' => trim((string)($_GET['category'] ?? '')),
    'city' => trim((string)($_GET['city'] ?? '')),
];

$posts = fetch_posts($filters);
$success = flash_get('success');

render_header('Lost & Found');
?>
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Active Posts</h1>
        <p class="text-sm text-slate-500 mt-1">Browse the latest lost and found listings.</p>
    </div>
    <div class="text-sm text-slate-500"><?= count($posts) ?> items</div>
</div>

<?php if ($success): ?>
    <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
        <?= e($success) ?>
    </div>
<?php endif; ?>

<form method="get" action="/index.php" class="mb-6 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="grid gap-3 md:grid-cols-12">
        <div class="md:col-span-4">
            <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Keyword</label>
            <input
                type="text"
                name="q"
                value="<?= e($filters['q']) ?>"
                class="mt-2 w-full rounded-md border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200"
                placeholder="Search keyword..."
            >
        </div>
        <div class="md:col-span-2">
            <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Type</label>
            <select
                name="type"
                class="mt-2 w-full rounded-md border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200"
            >
                <option value="">All</option>
                <?php foreach (POST_TYPES as $value => $label): ?>
                    <option value="<?= e($value) ?>" <?= $filters['type'] === $value ? 'selected' : '' ?>>
                        <?= e($label) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="md:col-span-3">
            <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">Category</label>
            <select
                name="category"
                class="mt-2 w-full rounded-md border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200"
            >
                <option value="">All</option>
                <?php foreach (POST_CATEGORIES as $category): ?>
                    <option value="<?= e($category) ?>" <?= $filters['category'] === $category ? 'selected' : '' ?>>
                        <?= e($category) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="md:col-span-2">
            <label class="text-xs font-semibold uppercase tracking-wide text-slate-500">City</label>
            <input
                type="text"
                name="city"
                value="<?= e($filters['city']) ?>"
                class="mt-2 w-full rounded-md border border-slate-200 px-3 py-2 text-sm focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200"
                placeholder="City"
            >
        </div>
        <div class="md:col-span-1 flex items-end">
            <button class="w-full rounded-md bg-slate-900 px-3 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                Go
            </button>
        </div>
    </div>
</form>

<?php if (count($posts) === 0): ?>
    <div class="rounded-lg border border-slate-200 bg-white px-4 py-6 text-center text-slate-500">
        No active posts found.
    </div>
<?php else: ?>
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        <?php foreach ($posts as $post): ?>
            <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex items-start justify-between gap-2">
                    <div class="flex flex-wrap gap-2">
                        <span class="<?= $post['type'] === 'lost' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' ?> inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold uppercase tracking-wide">
                            <?= e(ucfirst($post['type'])) ?>
                        </span>
                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                            <?= e($post['category']) ?>
                        </span>
                    </div>
                    <span class="text-xs text-slate-400"><?= e(date('M d, Y', strtotime($post['created_at']))) ?></span>
                </div>
                <h2 class="mt-4 text-lg font-semibold text-slate-900">
                    <?= e($post['location_text']) ?>
                </h2>
                <p class="text-sm text-slate-500"><?= e($post['city']) ?></p>
                <p class="mt-3 text-sm text-slate-600">
                    <?= e(excerpt($post['description'], 120)) ?>
                </p>
                <div class="mt-4">
                    <a
                        class="inline-flex items-center rounded-md border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 hover:border-slate-300 hover:text-slate-900"
                        href="/show.php?id=<?= (int)$post['id'] ?>"
                    >
                        View Details
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php render_footer(); ?>
