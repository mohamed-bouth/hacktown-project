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

    <header class="site-header">
        <a href="#" class="logo">FoundAndLost</a>
        <div class="header-search">
            <svg class="search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" placeholder="Search by item name, location, or keyword...">
        </div>
    </header>

    <main class="layout-container">
        
        <aside class="sidebar">
            <div class="filter-group">
                <div class="filter-title">Status</div>
                <div class="status-toggle">
                    <div class="status-option">
                        <input type="radio" name="status" id="s-lost" value="lost" checked>
                        <label for="s-lost">Lost</label>
                    </div>
                    <div class="status-option">
                        <input type="radio" name="status" id="s-found" value="found">
                        <label for="s-found">Found</label>
                    </div>
                </div>
            </div>

            <div class="filter-group">
                <div class="filter-title">City</div>
                <input type="text" placeholder="e.g. Chicago" style="width: 100%; padding: 8px; border: 1px solid var(--border-color); border-radius: 6px;">
            </div>

            <div class="filter-group">
                <div class="filter-title">Category</div>
                <label class="checkbox-label"><input type="checkbox" checked> Electronics</label>
                <label class="checkbox-label"><input type="checkbox"> Wallets / ID</label>
                <label class="checkbox-label"><input type="checkbox"> Keys</label>
                <label class="checkbox-label"><input type="checkbox"> Pets</label>
                <label class="checkbox-label"><input type="checkbox"> Clothing</label>
            </div>

            <div class="filter-group">
                <div class="filter-title">Date Posted</div>
                <label class="checkbox-label"><input type="radio" name="date"> Last 24 Hours</label>
                <label class="checkbox-label"><input type="radio" name="date" checked> Last Week</label>
                <label class="checkbox-label"><input type="radio" name="date"> Last Month</label>
            </div>
            
            <button style="width: 100%; padding: 10px; background: transparent; border: 1px solid var(--border-color); cursor: pointer; border-radius: 6px; color: var(--text-secondary);">Reset Filters</button>
        </aside>

        <section class="results-area">
            <div class="results-header">
                <div class="results-count">Showing 14 Results</div>
                <select class="sort-select">
                    <option>Newest First</option>
                    <option>Oldest First</option>
                </select>
            </div>

            <div class="cards-grid">
                <article class="post-card">
                    <div class="card-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1547496502-ffa22ed47b72?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Item" class="card-image">
                        <span class="status-pill lost">Lost</span>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Brown Leather Wallet</h3>
                        <div class="card-meta">
                            <span>Brooklyn, NY</span>
                            <span>2h ago</span>
                        </div>
                    </div>
                </article>

                <article class="post-card">
                    <div class="card-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca4?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Item" class="card-image">
                        <span class="status-pill found">Found</span>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">MacBook Pro 13"</h3>
                        <div class="card-meta">
                            <span>Central Station</span>
                            <span>5h ago</span>
                        </div>
                    </div>
                </article>

                <article class="post-card">
                    <div class="card-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1582233479366-6d38bc390a08?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Item" class="card-image">
                        <span class="status-pill lost">Lost</span>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Golden Retriever (Rex)</h3>
                        <div class="card-meta">
                            <span>Austin, TX</span>
                            <span>1d ago</span>
                        </div>
                    </div>
                </article>

                <article class="post-card">
                    <div class="card-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1589578228447-e1a4e481c6c8?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Item" class="card-image">
                        <span class="status-pill found">Found</span>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Set of House Keys</h3>
                        <div class="card-meta">
                            <span>Main St. Park</span>
                            <span>1d ago</span>
                        </div>
                    </div>
                </article>

                <article class="post-card">
                    <div class="card-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1621600411688-4be93cd68504?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Item" class="card-image">
                        <span class="status-pill lost">Lost</span>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">iPhone 13 - Blue Case</h3>
                        <div class="card-meta">
                            <span>Chicago, IL</span>
                            <span>2d ago</span>
                        </div>
                    </div>
                </article>

                 <article class="post-card">
                    <div class="card-image-wrapper">
                        <img src="https://images.unsplash.com/photo-1559563458-527698bf5295?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Item" class="card-image">
                        <span class="status-pill found">Found</span>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Black Tote Bag</h3>
                        <div class="card-meta">
                            <span>Metro Line 4</span>
                            <span>3d ago</span>
                        </div>
                    </div>
                </article>
            </div>
        </section>
    </main>
</body>
</html>