<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Posts - FoundAndLost</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../../assets/css/navbar.css">
<?php require_once "./partials/navbar.php" ?>
<style>
:root {
    --bg-body: #F3F4F6;
    --bg-card: #FFFFFF;
    --text-primary: #111827;
    --text-secondary: #6B7280;
    --border-color: #E5E7EB;

    --color-lost: #EF4444;
    --color-found: #10B981;
    --radius-card: 16px;
    --shadow-card: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
}

body {
    font-family: 'Inter', sans-serif;
    background-color: var(--bg-body);
    margin: 0;
    padding: 40px 20px;
    display: flex;
    justify-content: center;
}

.container {
    width: 100%;
    max-width: 900px;
}

h2 {
    text-align: center;
    margin-bottom: 30px;
    color: var(--text-primary);
}

.post-card {
    display: flex;
    flex-direction: column;
    background: var(--bg-card);
    border-radius: var(--radius-card);
    box-shadow: var(--shadow-card);
    overflow: hidden;
    margin-bottom: 25px;
    transition: transform 0.2s, box-shadow 0.2s;
}

.post-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px -5px rgba(0,0,0,0.15), 0 10px 15px -6px rgba(0,0,0,0.1);
}

.post-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

.post-body {
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.badge {
    display: inline-block;
    padding: 6px 14px;
    font-size: 0.8rem;
    font-weight: 600;
    border-radius: 999px;
    width: fit-content;
    text-transform: uppercase;
}

.badge.lost {
    background: #FEF2F2;
    color: var(--color-lost);
}

.badge.found {
    background: #ECFDF5;
    color: var(--color-found);
}

h3 {
    margin: 0;
    font-size: 1.4rem;
    color: var(--text-primary);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin-top: 10px;
}

.info-item {
    background: #F9FAFB;
    border-radius: 12px;
    padding: 10px 14px;
    font-size: 0.9rem;
    border: 1px solid var(--border-color);
}

.info-item span {
    display: block;
    font-size: 0.75rem;
    color: var(--text-secondary);
    margin-bottom: 4px;
}

.description {
    margin-top: 10px;
    font-size: 0.95rem;
    color: var(--text-primary);
    line-height: 1.5;
}

.map {
    margin-top: 20px;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid var(--border-color);
}

iframe {
    width: 100%;
    height: 240px;
    border: 0;
}

@media (max-width: 600px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
}
.dashboard-hero {
    /* Background: Very light grey to separate from white navbar */
    padding: 80px 0px;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}
</style>
</head>
<body>

<div class="container">
    <section class="dashboard-hero">
            <div class="hero-content">
                <h1 class="hero-title">
                    Your Post <span class="wave">?</span>
                </h1>
                <p class="hero-subtitle">
                    your can add any post your think just by one click
                </p>
            </div>
    </section>

    <!-- Example Post 1 -->
    <div class="post-card">
        <img src="https://picsum.photos\400\300" class="post-image" alt="Item">
        <div class="post-body">
            <span class="badge lost">Lost</span>
            <h3>Black Leather Wallet</h3>
            <div class="info-grid">
                <div class="info-item"><span>Category</span>Wallet / Money</div>
                <div class="info-item"><span>City</span>Casablanca</div>
                <div class="info-item"><span>Location</span>Near Central Fountain</div>
                <div class="info-item"><span>Date</span>2026-01-07</div>
            </div>
            <div class="description">
                Lost my black leather wallet with ID and some documents. Please contact if found.
            </div>
            <div class="map">
                <iframe src="https://www.google.com/maps?q=casablanca&output=embed" loading="lazy"></iframe>
            </div>
        </div>
    </div>

    <!-- Example Post 2 -->
    <div class="post-card">
        <img src="https://picsum.photos\400\300" class="post-image" alt="Item">
        <div class="post-body">
            <span class="badge found">Found</span>
            <h3>iPhone 13 Pro</h3>
            <div class="info-grid">
                <div class="info-item"><span>Category</span>Electronics</div>
                <div class="info-item"><span>City</span>Casablanca</div>
                <div class="info-item"><span>Location</span>Airport Lounge</div>
                <div class="info-item"><span>Date</span>2026-01-06</div>
            </div>
            <div class="description">
                Found an iPhone 13 Pro near airport lounge. Contact if it's yours.
            </div>
            <div class="map">
                <iframe src="https://www.google.com/maps?q=casablanca&output=embed" loading="lazy"></iframe>
            </div>
        </div>
    </div>

</div>

</body>
</html>
