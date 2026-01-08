<?php
declare(strict_types=1);

require_once __DIR__ . '/../Core/Database.php';

use App\Core\Database;

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function timeAgo(string $timestamp): string
{
    $created = new DateTime($timestamp);
    $now = new DateTime();
    $diff = $now->getTimestamp() - $created->getTimestamp();

    if ($diff < 3600) {
        $minutes = max(1, (int) floor($diff / 60));
        return $minutes . 'm ago';
    }

    if ($diff < 86400) {
        $hours = (int) floor($diff / 3600);
        return $hours . 'h ago';
    }

    if ($diff < 604800) {
        $days = (int) floor($diff / 86400);
        return $days . 'd ago';
    }

    return $created->format('M j, Y');
}

$filters = [
    'keyword' => trim($_GET['keyword'] ?? ''),
    'type' => $_GET['type'] ?? '',
    'city' => trim($_GET['city'] ?? ''),
    'date' => $_GET['date'] ?? '',
    'sort' => $_GET['sort'] ?? 'newest',
    'categories' => $_GET['category'] ?? [],
];

$allowedTypes = ['lost', 'found'];
$allowedCategories = ['CIN', 'Phone', 'Document', 'Wallet', 'Other'];
$allowedDate = ['24h', '7d', '30d'];
$allowedSort = ['newest', 'oldest'];

$db = Database::getInstance();
$sql = 'SELECT * FROM posts WHERE status = :status';
$params = ['status' => 'active'];

if (in_array($filters['type'], $allowedTypes, true)) {
    $sql .= ' AND type = :type';
    $params['type'] = $filters['type'];
}

if ($filters['city'] !== '') {
    $sql .= ' AND city LIKE :city';
    $params['city'] = '%' . $filters['city'] . '%';
}

if ($filters['keyword'] !== '') {
    $sql .= ' AND (description LIKE :kw OR location_text LIKE :kw OR city LIKE :kw OR category LIKE :kw)';
    $params['kw'] = '%' . $filters['keyword'] . '%';
}

$selectedCategories = array_values(array_intersect($allowedCategories, (array) $filters['categories']));
if (!empty($selectedCategories)) {
    $placeholders = [];
    foreach ($selectedCategories as $index => $category) {
        $key = 'cat' . $index;
        $placeholders[] = ':' . $key;
        $params[$key] = $category;
    }
    $sql .= ' AND category IN (' . implode(', ', $placeholders) . ')';
}

if (in_array($filters['date'], $allowedDate, true)) {
    if ($filters['date'] === '24h') {
        $sql .= ' AND created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY)';
    } elseif ($filters['date'] === '7d') {
        $sql .= ' AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)';
    } else {
        $sql .= ' AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)';
    }
}

$sql .= $filters['sort'] === 'oldest' ? ' ORDER BY created_at ASC' : ' ORDER BY created_at DESC';

$stmt = $db->prepare($sql);
$stmt->execute($params);
$posts = $stmt->fetchAll();

$categoryImages = [
    'CIN' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=800&q=80',
    'Phone' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=800&q=80',
    'Document' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=800&q=80',
    'Wallet' => 'https://images.unsplash.com/photo-1512412046876-f386342eddb3?auto=format&fit=crop&w=800&q=80',
    'Other' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=800&q=80',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoundAndLost - Search Results</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/navbar.css">
    <?php require_once "./partials/navbar.php" ?>
    
    <style>
        /* --- 1. Global Variables & Reset --- */
        :root {
            --bg-body: #F9FAFB;
            --bg-surface: #FFFFFF;
            --text-primary: #111827;
            --text-secondary: #6B7280;
            --border-color: #E5E7EB;
            --primary-accent: #3B82F6;
            
            --status-lost: #EF4444;
            --status-found: #10B981;
            
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            
            --header-height: 70px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-primary);
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- 2. Sticky Header --- */
        .site-header {
            height: var(--header-height);
            background: var(--bg-surface);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            padding: 0 24px;
            box-shadow: var(--shadow-sm);
        }

        .logo {
            font-weight: 700;
            font-size: 1.25rem;
            margin-right: 40px;
            color: var(--text-primary);
            text-decoration: none;
        }

        .header-search {
            flex: 1;
            max-width: 500px;
            position: relative;
        }

        .header-search input {
            width: 100%;
            padding: 10px 16px 10px 40px;
            border-radius: 99px;
            border: 1px solid var(--border-color);
            background: #F3F4F6;
            font-size: 0.95rem;
        }

        .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            stroke: var(--text-secondary);
        }

        /* --- 3. Main Layout Grid --- */
        .layout-container {
            display: grid;
            grid-template-columns: 260px 1fr; /* Sidebar width | Content width */
            gap: 32px;
            max-width: 1280px;
            margin: 0 auto;
            padding: 32px 24px;
            width: 100%;
            box-sizing: border-box;
        }

        /* --- 4. Sidebar Filters --- */
        .sidebar {
            position: sticky;
            top: calc(var(--header-height) + 32px); /* Stick below header */
            height: fit-content;
            background: var(--bg-surface);
            padding: 24px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .filter-group {
            margin-bottom: 24px;
        }

        .filter-title {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: var(--text-primary);
            display: flex;
            justify-content: space-between;
        }

        /* Custom Radio Buttons for Status */
        .status-toggle {
            display: flex;
            gap: 10px;
        }
        
        .status-option {
            flex: 1;
        }

        .status-option input {
            display: none;
        }

        .status-option label {
            display: block;
            text-align: center;
            padding: 8px;
            font-size: 0.875rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            color: var(--text-secondary);
        }

        /* Active Logic for Status */
        .status-option input[value="lost"]:checked + label {
            background: #FEF2F2;
            border-color: var(--status-lost);
            color: var(--status-lost);
        }
        
        .status-option input[value="found"]:checked + label {
            background: #ECFDF5;
            border-color: var(--status-found);
            color: var(--status-found);
        }

        /* Checkboxes */
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
            font-size: 0.9rem;
            color: var(--text-secondary);
            cursor: pointer;
        }
        
        input[type="checkbox"] {
            accent-color: var(--primary-accent);
            width: 16px; 
            height: 16px;
        }

        /* --- 5. Results Grid --- */
        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 20px;
        }

        .results-count {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .sort-select {
            padding: 6px 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: var(--text-secondary);
        }

        .cards-grid {
            display: grid;
            /* Auto-fit creates responsive columns, min width 280px */
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 24px;
        }

        /* --- 6. Post Card Component (Reused) --- */
        .post-card {
            background-color: var(--bg-surface);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
        }

        .post-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .card-image-wrapper {
            position: relative;
            height: 180px;
            background-color: #E5E7EB;
        }

        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .status-pill {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            color: white;
        }
        .status-pill.lost { background-color: var(--status-lost); }
        .status-pill.found { background-color: var(--status-found); }

        .card-content { padding: 16px; }

        .category-pill {
            display: inline-block;
            margin-left: 8px;
            padding: 2px 8px;
            font-size: 0.7rem;
            border-radius: 999px;
            background: #F3F4F6;
            color: var(--text-secondary);
            font-weight: 600;
        }

        .card-desc {
            margin: 8px 0 12px;
            font-size: 0.85rem;
            color: var(--text-secondary);
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 600;
            margin: 0 0 8px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-meta {
            font-size: 0.85rem;
            color: var(--text-secondary);
            display: flex;
            justify-content: space-between;
        }

        /* --- Responsive Design --- */
        @media (max-width: 768px) {
            .layout-container {
                grid-template-columns: 1fr; /* Stack sidebar on top */
            }
            .sidebar {
                position: static; /* No longer sticky on mobile */
                margin-bottom: 24px;
            }
            .header-search { display: none; } /* Hide header search on mobile for simplicity */
        }
    </style>
</head>
<body>

    <form method="GET" action="">
    <header class="site-header">
        <a href="#" class="logo">FoundAndLost</a>
        <div class="header-search">
            <svg class="search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" name="keyword" value="<?= e($filters['keyword']) ?>" placeholder="Search by item name, location, or keyword...">
        </div>
    </header>

    <main class="layout-container">
        
        <aside class="sidebar">
            <div class="filter-group">
                <div class="filter-title">Status</div>
                <div class="status-toggle">
                    <div class="status-option">
                        <input type="radio" name="type" id="s-lost" value="lost" <?= $filters['type'] === 'lost' ? 'checked' : '' ?>>
                        <label for="s-lost">Lost</label>
                    </div>
                    <div class="status-option">
                        <input type="radio" name="type" id="s-found" value="found" <?= $filters['type'] === 'found' ? 'checked' : '' ?>>
                        <label for="s-found">Found</label>
                    </div>
                </div>
            </div>

            <div class="filter-group">
                <div class="filter-title">City</div>
                <input type="text" name="city" value="<?= e($filters['city']) ?>" placeholder="e.g. Casablanca" style="width: 100%; padding: 8px; border: 1px solid var(--border-color); border-radius: 6px;">
            </div>

            <div class="filter-group">
                <div class="filter-title">Category</div>
                <label class="checkbox-label"><input type="checkbox" name="category[]" value="CIN" <?= in_array('CIN', $selectedCategories, true) ? 'checked' : '' ?>> CIN</label>
                <label class="checkbox-label"><input type="checkbox" name="category[]" value="Phone" <?= in_array('Phone', $selectedCategories, true) ? 'checked' : '' ?>> Phone</label>
                <label class="checkbox-label"><input type="checkbox" name="category[]" value="Document" <?= in_array('Document', $selectedCategories, true) ? 'checked' : '' ?>> Document</label>
                <label class="checkbox-label"><input type="checkbox" name="category[]" value="Wallet" <?= in_array('Wallet', $selectedCategories, true) ? 'checked' : '' ?>> Wallet</label>
                <label class="checkbox-label"><input type="checkbox" name="category[]" value="Other" <?= in_array('Other', $selectedCategories, true) ? 'checked' : '' ?>> Other</label>
            </div>

            <div class="filter-group">
                <div class="filter-title">Date Posted</div>
                <label class="checkbox-label"><input type="radio" name="date" value="" <?= $filters['date'] === '' ? 'checked' : '' ?>> Any time</label>
                <label class="checkbox-label"><input type="radio" name="date" value="24h" <?= $filters['date'] === '24h' ? 'checked' : '' ?>> Last 24 Hours</label>
                <label class="checkbox-label"><input type="radio" name="date" value="7d" <?= $filters['date'] === '7d' ? 'checked' : '' ?>> Last Week</label>
                <label class="checkbox-label"><input type="radio" name="date" value="30d" <?= $filters['date'] === '30d' ? 'checked' : '' ?>> Last Month</label>
            </div>
            
            <button type="submit" style="width: 100%; padding: 10px; background: #111827; border: 1px solid #111827; cursor: pointer; border-radius: 6px; color: #FFFFFF; margin-bottom: 8px;">Apply Filters</button>
            <a href="searchPost.php" style="display:block; text-align:center; width: 100%; padding: 10px; background: transparent; border: 1px solid var(--border-color); border-radius: 6px; color: var(--text-secondary); text-decoration:none;">Reset Filters</a>
        </aside>

        <section class="results-area">
            <div class="results-header">
                <div class="results-count">Showing <?= count($posts) ?> Results</div>
                <select class="sort-select" name="sort" onchange="this.form.submit()">
                    <option value="newest" <?= $filters['sort'] === 'newest' ? 'selected' : '' ?>>Newest First</option>
                    <option value="oldest" <?= $filters['sort'] === 'oldest' ? 'selected' : '' ?>>Oldest First</option>
                </select>
            </div>

            <div class="cards-grid">
                <?php if (empty($posts)): ?>
                    <div style="color: var(--text-secondary); font-weight: 600;">No results found. Try adjusting filters.</div>
                <?php endif; ?>

                <?php foreach ($posts as $post): ?>
                    <?php
                        $category = $post['category'] ?? 'Other';
                        $image = $categoryImages[$category] ?? $categoryImages['Other'];
                        $description = trim((string) ($post['description'] ?? ''));
                        $location = trim((string) ($post['location_text'] ?? $post['city'] ?? ''));
                    ?>
                    <article class="post-card">
                        <div class="card-image-wrapper">
                            <img src="<?= e($image) ?>" alt="<?= e($category) ?>" class="card-image">
                            <span class="status-pill <?= e($post['type']) ?>"><?= e($post['type']) ?></span>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title"><?= e($category) ?><span class="category-pill"><?= e($post['city']) ?></span></h3>
                            <p class="card-desc"><?= e($description !== '' ? $description : 'No description provided.') ?></p>
                            <div class="card-meta">
                                <span><?= e($location) ?></span>
                                <span><?= e(timeAgo($post['created_at'])) ?></span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    </form>
</body>
</html>