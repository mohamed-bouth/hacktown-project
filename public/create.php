<?php
declare(strict_types=1);

require __DIR__ . '/../includes/bootstrap.php';
require __DIR__ . '/../includes/posts.php';

$errors = pull_errors();
$old = pull_old();

render_header('Create Post');
?>
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-900">Create a Post</h1>
    <p class="mt-1 text-sm text-slate-500">Share details so others can help.</p>
</div>

<form method="post" action="/store.php" class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="grid gap-4 md:grid-cols-12">
        <div class="md:col-span-6">
            <label class="text-sm font-semibold text-slate-700">Type</label>
            <select name="type" class="mt-2 w-full rounded-md border border-slate-200 px-3 py-2 text-sm">
                <option value="">Select type</option>
                <?php foreach (POST_TYPES as $value => $label): ?>
                    <option value="<?= e($value) ?>" <?= ($old['type'] ?? '') === $value ? 'selected' : '' ?>>
                        <?= e($label) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($errors['type'])): ?>
                <p class="mt-1 text-xs text-rose-600"><?= e($errors['type']) ?></p>
            <?php endif; ?>
        </div>

        <div class="md:col-span-6">
            <label class="text-sm font-semibold text-slate-700">Category</label>
            <select name="category" class="mt-2 w-full rounded-md border border-slate-200 px-3 py-2 text-sm">
                <option value="">Select category</option>
                <?php foreach (POST_CATEGORIES as $category): ?>
                    <option value="<?= e($category) ?>" <?= ($old['category'] ?? '') === $category ? 'selected' : '' ?>>
                        <?= e($category) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($errors['category'])): ?>
                <p class="mt-1 text-xs text-rose-600"><?= e($errors['category']) ?></p>
            <?php endif; ?>
        </div>

        <div class="md:col-span-6">
            <label class="text-sm font-semibold text-slate-700">City</label>
            <input
                type="text"
                name="city"
                value="<?= e($old['city'] ?? '') ?>"
                class="mt-2 w-full rounded-md border border-slate-200 px-3 py-2 text-sm"
            >
            <?php if (!empty($errors['city'])): ?>
                <p class="mt-1 text-xs text-rose-600"><?= e($errors['city']) ?></p>
            <?php endif; ?>
        </div>

        <div class="md:col-span-6">
            <label class="text-sm font-semibold text-slate-700">Location</label>
            <input
                type="text"
                name="location_text"
                value="<?= e($old['location_text'] ?? '') ?>"
                class="mt-2 w-full rounded-md border border-slate-200 px-3 py-2 text-sm"
            >
            <?php if (!empty($errors['location_text'])): ?>
                <p class="mt-1 text-xs text-rose-600"><?= e($errors['location_text']) ?></p>
            <?php endif; ?>
        </div>

        <div class="md:col-span-12">
            <label class="text-sm font-semibold text-slate-700">Description</label>
            <textarea
                name="description"
                rows="4"
                class="mt-2 w-full rounded-md border border-slate-200 px-3 py-2 text-sm"
            ><?= e($old['description'] ?? '') ?></textarea>
            <?php if (!empty($errors['description'])): ?>
                <p class="mt-1 text-xs text-rose-600"><?= e($errors['description']) ?></p>
            <?php endif; ?>
        </div>

        <div class="md:col-span-6">
            <label class="text-sm font-semibold text-slate-700">WhatsApp Number</label>
            <input
                type="text"
                name="whatsapp"
                value="<?= e($old['whatsapp'] ?? '') ?>"
                class="mt-2 w-full rounded-md border border-slate-200 px-3 py-2 text-sm"
                placeholder="+2126..."
            >
            <?php if (!empty($errors['whatsapp'])): ?>
                <p class="mt-1 text-xs text-rose-600"><?= e($errors['whatsapp']) ?></p>
            <?php endif; ?>
        </div>

        <div class="md:col-span-6">
            <label class="text-sm font-semibold text-slate-700">Phone Number (optional)</label>
            <input
                type="text"
                name="phone"
                value="<?= e($old['phone'] ?? '') ?>"
                class="mt-2 w-full rounded-md border border-slate-200 px-3 py-2 text-sm"
                placeholder="05..."
            >
            <?php if (!empty($errors['phone'])): ?>
                <p class="mt-1 text-xs text-rose-600"><?= e($errors['phone']) ?></p>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-6 flex flex-wrap gap-3">
        <button class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
            Publish
        </button>
        <a class="rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-slate-300" href="/index.php">
            Cancel
        </a>
    </div>
</form>

<?php render_footer(); ?>
