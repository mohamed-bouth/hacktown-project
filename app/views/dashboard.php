<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoundAndLost Card Component</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/navbar.css">
    <?php require_once "./partials/navbar.php" ?>
    
    <style>
        /* --- 1. Design Tokens & Reset --- */
        :root {
            --bg-body: #F9FAFB;
            --bg-card: #FFFFFF;
            --text-primary: #1F2937;
            --text-secondary: #6B7280;
            --status-lost: #EF4444; /* Urgent Coral Red */
            --status-found: #10B981; /* Calming Mint Green */
            --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --radius-card: 16px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            gap: 32px;
            padding: 20px;
            box-sizing: border-box;
        }

        /* --- 2. Card Component Styles --- */
        .post-card {
            background-color: var(--bg-card);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-soft);
            overflow: hidden; /* Keeps image inside rounded corners */
            width: 100%;
            max-width: 340px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
        }

        /* Hover Micro-interaction */
        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        /* Image Container */
        .card-image-wrapper {
            position: relative;
            width: 100%;
            height: 200px; /* Fixed height for consistency */
            background-color: #e5e7eb;
        }

        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Status Badge (Pill) */
        .status-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .status-badge.lost {
            background-color: var(--status-lost);
        }

        .status-badge.found {
            background-color: var(--status-found);
        }

        /* Card Content */
        .card-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            line-height: 1.4;
            /* Truncate text after 1 line */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Meta Data (Location & Date) */
        .card-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* SVG Icon styling */
        .icon {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }
        /* --- Hero Section Styles --- */
    .dashboard-hero {
        /* Background: Very light grey to separate from white navbar */
        background-color: #F9FAFB; 
        padding: 80px 24px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        border-bottom: 1px solid #E5E7EB;
    }

    .hero-content {
        max-width: 700px;
    }

    /* Typography */
    .hero-title {
        font-family: 'Inter', sans-serif;
        font-size: 3rem; /* Large and bold */
        font-weight: 800;
        color: #111827;
        margin: 0 0 16px 0;
        letter-spacing: -0.03em;
    }

    .hero-subtitle {
        font-family: 'Inter', sans-serif;
        font-size: 1.125rem;
        color: #6B7280;
        margin: 0 0 40px 0;
        line-height: 1.6;
    }

    /* Waving Hand Animation */
    .wave {
        display: inline-block;
        animation: wave-animation 2.5s infinite;
        transform-origin: 70% 70%;
    }

    @keyframes wave-animation {
        0% { transform: rotate( 0.0deg) }
        10% { transform: rotate(14.0deg) }
        20% { transform: rotate(-8.0deg) }
        30% { transform: rotate(14.0deg) }
        40% { transform: rotate(-4.0deg) }
        50% { transform: rotate(10.0deg) }
        60% { transform: rotate( 0.0deg) }
        100% { transform: rotate( 0.0deg) }
    }

    /* Buttons Container */
    .hero-actions {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap; /* Stacks on very small screens */
    }

    /* Shared Button Styles */
    .hero-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 16px 32px;
        border-radius: 12px;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        min-width: 160px;
    }

    .hero-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    /* Specific Button Colors */
    
    /* 1. Add Post (Red/Brand Color) */
    .btn-add {
        background-color: #EF4444; /* Brand Red */
        color: white;
        border: 2px solid #EF4444;
    }
    .btn-add:hover {
        background-color: #DC2626;
        border-color: #DC2626;
    }

    /* 2. Search Post (White/Outline) */
    .btn-search {
        background-color: white;
        color: #374151;
        border: 2px solid #E5E7EB;
    }
    .btn-search:hover {
        border-color: #D1D5DB;
        background-color: #F3F4F6;
    }

    /* Responsive Adjustments */
    @media (max-width: 600px) {
        .hero-title { font-size: 2.25rem; }
        .hero-actions { flex-direction: column; }
        .hero-btn { width: 100%; box-sizing: border-box; }
    }

    .allsection {
        display: flex;
        flex-direction: column;
    }

    .section-of-card {
        display: flex;
    }
    </style>
</head>
<body>
    <div class="allsection">
        <section class="dashboard-hero">
            <div class="hero-content">
                <h1 class="hero-title">
                    Hello, Alex! <span class="wave">👋</span>
                </h1>
                <p class="hero-subtitle">
                    Welcome back to FoundAndLost. Let's get things back to where they belong.
                </p>

                <div class="hero-actions">
                    
                    <a href="post.html" class="hero-btn btn-add">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Post
                    </a>

                    <a href="search.html" class="hero-btn btn-search">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Search Post
                    </a>

                </div>
            </div>
        </section>
        <section class="section-of-card">
            <article class="post-card">
                <div class="card-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1547496502-ffa22ed47b72?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Brown Leather Wallet" class="card-image">
                    <span class="status-badge lost">Lost</span>
                </div>
                <div class="card-content">
                    <h3 class="card-title">Vintage Brown Leather Wallet</h3>
                    <div class="card-meta">
                        <div class="meta-item">
                            <svg class="icon" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            <span>Brooklyn, NY</span>
                        </div>
                        <div class="meta-item">
                            <svg class="icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <span>2 hrs ago</span>
                        </div>
                    </div>
                </div>
            </article>

            <article class="post-card">
                <div class="card-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca4?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Macbook Pro" class="card-image">
                    <span class="status-badge found">Found</span>
                </div>
                <div class="card-content">
                    <h3 class="card-title">Silver MacBook Pro (2021)</h3>
                    <div class="card-meta">
                        <div class="meta-item">
                            <svg class="icon" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            <span>Central Station</span>
                        </div>
                        <div class="meta-item">
                            <svg class="icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <span>Yesterday</span>
                        </div>
                    </div>
                </div>
            </article>
                    <article class="post-card">
                <div class="card-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca4?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Macbook Pro" class="card-image">
                    <span class="status-badge found">Found</span>
                </div>
                <div class="card-content">
                    <h3 class="card-title">Silver MacBook Pro (2021)</h3>
                    <div class="card-meta">
                        <div class="meta-item">
                            <svg class="icon" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            <span>Central Station</span>
                        </div>
                        <div class="meta-item">
                            <svg class="icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <span>Yesterday</span>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</body>
</html>