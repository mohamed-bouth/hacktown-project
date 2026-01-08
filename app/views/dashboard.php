<?php 
require_once '../repositories/PostRepository.php';

$posts = new PostRepository();
$results = $posts->getAllPosts();


// Auth Check
// if (!isset($_SESSION['user_id'])) {
//     header("Location: ./auth/login.php");
//     exit();
// }
?>
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

        .category-badge {
            position: absolute;
            top: 12px;
            right: 12px;
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
        padding: 80px 0px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
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
        width: 100%;
    }

    .section-of-card {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 16px;
    }

    .button_details {
        width: 100%;
        border: none;
        height: 30px;
        border-radius: 10px;
        color: white;
        background-color: #DC2626;
    }
    </style>
</head>
<body>
    <div class="allsection">
        <section class="dashboard-hero">
            <div class="hero-content">
                <h1 class="hero-title">
                    Hello, <?=  $_SESSION['user_name'] ?>! <span class="wave">👋</span>
                </h1>
                <p class="hero-subtitle">
                    Welcome back to FoundAndLost. Let's get things back to where they belong.
                </p>

                <div class="hero-actions">
                    
                    <a href="./addPost.php" class="hero-btn btn-add">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Post
                    </a>

                    <a href="./searchPost.php" class="hero-btn btn-search">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Search Post
                    </a>

                </div>
            </div>
        </section>
        <section class="section-of-card">
            <?php foreach ($posts as $post) { ?>
            <article class="post-card">
                <div class="card-image-wrapper">
                    <img src="https://imgs.search.brave.com/qVXQkEpAKMNKCv_eCmNVq_1_Keb5-xJaU5pDjSxINis/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4u/bW9zLmNtcy5mdXR1/cmVjZG4ubmV0L1g0/dFpWeVRhOXJteXJW/d3Q3Z2lUd1UuanBn" alt="Brown Leather Wallet" class="card-image">
                    <span class="status-badge lost">Lost</span>
                    <span class="category-badge">phone</span>
                </div>
                <div class="card-content">
                    <h3 class="card-title">iphone 15 pro</h3>
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
                    <form action="">
                        <input type="text" hidden>
                        <button class="button_details" type="submit">see details</button>
                    </form>
                </div>
            </article>
            <?php } ?>

            <article class="post-card">
                <div class="card-image-wrapper">
                    <img src="https://imgs.search.brave.com/OLNuRjC8lxfTQnvBGQwMrhMYdKaTYwKPIRtjxpvml_g/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9pLnBp/bmltZy5jb20vb3Jp/Z2luYWxzL2JkLzAw/LzM4L2JkMDAzODdl/ZGQwYjU5YTA5MmVj/NTY2NGI2NWIwZDBk/LmpwZw" alt="Macbook Pro" class="card-image">
                    <span class="status-badge found">Found</span>
                    <span class="category-badge">wallet</span>
                </div>
                <div class="card-content">
                    <h3 class="card-title">broun wallet</h3>
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
                    <form action="">
                        <input type="text" hidden>
                        <button class="button_details" type="submit">see details</button>
                    </form>
                </div>
            </article>
            <article class="post-card">
                <div class="card-image-wrapper">
                    <img src="https://imgs.search.brave.com/AUZqlDblyKnXNpJnHeFlCcZIUwba1sCafSCo2rK1oDw/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5pc3RvY2twaG90/by5jb20vaWQvMTM2/OTA5NjA5MS9waG90/by9ibGFuay1zY3Jl/ZW4tbW9kZXJuLWxh/cHRvcC1vbi10YWJs/ZS5qcGc_cz02MTJ4/NjEyJnc9MCZrPTIw/JmM9bDdYTUk0QzE5/SHZ5R0ZqaEF3WDRl/cW1wcjV3dWh3b0FM/V1Z3eVVZNkhCUT0" alt="Macbook Pro" class="card-image">
                    <span class="status-badge found">Found</span>
                    <span class="category-badge">pc</span>
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
                    <form action="">
                        <input type="text" hidden>
                        <button class="button_details" type="submit">see details</button>
                    </form>
                </div>
            </article>
                        <article class="post-card">
                <div class="card-image-wrapper">
                    <img src="https://imgs.search.brave.com/Vnl7KwO9usQbfFQtK6_q6ck0qexqMbAzwuKE7HfHegQ/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9tZWRp/YS5nZXR0eWltYWdl/cy5jb20vaWQvODQ2/Njg4NzQ4L3Bob3Rv/L2JvbWJlci1qYWNr/ZXQuanBnP3M9NjEy/eDYxMiZ3PTAmaz0y/MCZjPXVtYV84V3ZM/M0E3cFJrQk13eEV0/clg4SlF3ZHNmY3Fp/aEhMQy0yX3NWdjA9" alt="Macbook Pro" class="card-image">
                    <span class="status-badge lost">lost</span>
                    <span class="category-badge">phone</span>
                </div>
                <div class="card-content">
                    <h3 class="card-title">broun jacket</h3>
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
                    <form action="">
                        <input type="text" hidden>
                        <button class="button_details" type="submit">see details</button>
                    </form>
                </div>
            </article>
                        <article class="post-card">
                <div class="card-image-wrapper">
                    <img src="https://imgs.search.brave.com/fX3JvXyEPnOZa-4l7NYIbNl3cglhf6Ru-H5fb59smhE/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/ZHhvbWFyay5jb20v/d3AtY29udGVudC91/cGxvYWRzL21lZGlh/cy9wb3N0LTEwNjY4/OC9TYW1zdW5nLUdh/bGF4eS1TMjItVWx0/cmEtZmVhdHVyZWQt/aW1hZ2UtcGFja3No/b3QtcmV2aWV3LVJl/Y292ZXJlZC5qcGc" alt="Macbook Pro" class="card-image">
                    <span class="status-badge lost">lost</span>
                    <span class="category-badge">phone</span>
                </div>
                <div class="card-content">
                    <h3 class="card-title">s 22 ultra</h3>
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
                    <form action="">
                        <input type="text" hidden>
                        <button class="button_details" type="submit">see details</button>
                    </form>
                </div>
            </article>
                        <article class="post-card">
                <div class="card-image-wrapper">
                    <img src="https://imgs.search.brave.com/IKnCpzta98IDd3bGG8PpqjpLBhbZwe708C7WnKgq-0M/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9zdGF0/aWMudmVjdGVlenku/Y29tL3N5c3RlbS9y/ZXNvdXJjZXMvdGh1/bWJuYWlscy8wNzIv/NDQ4LzE3OC9zbWFs/bC9zbGVlay1ibGFj/ay1zbWFydHdhdGNo/LXdpdGgtdmlicmFu/dC1zY3JlZW4tZGlz/cGxheXMtbW9kZXJu/LXRlY2hub2xvZ3kt/YW5kLWNvbm5lY3Rp/dml0eS1pbi1zdHls/aXNoLWRlc2lnbi1l/bGVtZW50LXBob3Rv/LmpwZw" alt="Macbook Pro" class="card-image">
                    <span class="status-badge found">Found</span>
                    <span class="category-badge">Smart watch</span>
                </div>
                <div class="card-content">
                    <h3 class="card-title">a smart watch</h3>
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
                    <form action="">
                        <input type="text" hidden>
                        <button class="button_details" type="submit">see details</button>
                    </form>
                </div>
            </article>
        </section>
    </div>
</body>
</html>