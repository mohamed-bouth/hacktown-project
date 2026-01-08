<?php
declare(strict_types=1);

require __DIR__ . '/../includes/bootstrap.php';
require __DIR__ . '/../includes/posts.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    redirect('/index.php');
}

$post = fetch_post($id);
if (!$post) {
    redirect('/index.php');
}

$success = flash_get('success');
$whatsapp = preg_replace('/\D+/', '', $post['whatsapp']);
$phone = $post['phone'] ? preg_replace('/\D+/', '', $post['phone']) : '';

render_header('Post Details');
?>
<?php if ($success): ?>
    <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
        <?= e($success) ?>
    </div>
<?php endif; ?>

<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-2">
            <span class="<?= $post['type'] === 'lost' ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' ?> inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold uppercase tracking-wide">
                <?= e(ucfirst($post['type'])) ?>
            </span>
            <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                <?= e($post['category']) ?>
            </span>
            <?php if ($post['status'] === 'resolved'): ?>
                <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                    Resolved
                </span>
            <?php endif; ?>
        </div>
        <span class="text-sm text-slate-400"><?= e(date('M d, Y', strtotime($post['created_at']))) ?></span>
    </div>

    <h1 class="mt-4 text-2xl font-semibold text-slate-900"><?= e($post['location_text']) ?></h1>
    <p class="text-sm text-slate-500"><?= e($post['city']) ?></p>

    <p class="mt-4 text-sm text-slate-700"><?= e($post['description']) ?></p>

    <div class="mt-6 flex flex-wrap gap-3">
        <a
            class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-500"
            href="https://wa.me/<?= e($whatsapp) ?>"
            target="_blank"
            rel="noopener"
        >
            Contact on WhatsApp
        </a>
        <?php if ($phone !== ''): ?>
            <a class="rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-slate-300" href="tel:<?= e($phone) ?>">
                Call
            </a>
        <?php endif; ?>
        <?php if ($post['status'] === 'active'): ?>
            <form method="post" action="/resolve.php">
                <input type="hidden" name="id" value="<?= (int)$post['id'] ?>">
                <button class="rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-slate-300">
                    Mark as Resolved
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>

<div class="mt-6">
    <a class="text-sm font-semibold text-slate-600 hover:text-slate-900" href="/index.php">&larr; Back to list</a>
</div>

<?php render_footer(); ?>
