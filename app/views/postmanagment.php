

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoundAndLost - Post Preview</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

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
            --radius-input: 8px;
            --shadow-card: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            display: flex;
            justify-content: center;
            padding: 40px 20px;
        }

        .container {
            width: 100%;
            max-width: 800px;
        }

        .post-card {
            background: var(--bg-card);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }

        /* --- Image Section --- */
        .post-image {
            width: 100%;
            height: 320px;
            object-fit: cover;
            background: #E5E7EB;
        }

        /* --- Content --- */
        .post-body {
            padding: 28px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .badge {
            display: inline-block;
            padding: 6px 14px;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 999px;
            width: fit-content;
        }

        .badge.lost {
            background: #FEF2F2;
            color: var(--color-lost);
        }

        .badge.found {
            background: #ECFDF5;
            color: var(--color-found);
        }

        h1 {
            margin: 0;
            font-size: 1.5rem;
            color: var(--text-primary);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .info-item {
            background: #F9FAFB;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-input);
            padding: 12px 14px;
            font-size: 0.9rem;
        }

        .info-item span {
            display: block;
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-bottom: 4px;
        }

        .description {
            font-size: 0.95rem;
            line-height: 1.6;
            color: var(--text-primary);
        }

        /* --- Actions --- */
        .actions {
            display: flex;
            gap: 12px;
            margin-top: 10px;
        }

        .btn {
            flex: 1;
            text-align: center;
            padding: 14px;
            border-radius: var(--radius-input);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: transform 0.1s ease, box-shadow 0.1s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .btn.whatsapp {
            background: #10B981;
            color: white;
        }

        .btn.call {
            background: #2563EB;
            color: white;
        }

        .btn.resolve {
            background: #F3F4F6;
            color: #374151;
            border: 1px solid var(--border-color);
        }

        /* --- Map --- */
        .map {
            margin-top: 20px;
            border-radius: var(--radius-input);
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
    </style>
</head>
<body>

<div class="container">

    <div class="post-card">

        <!-- Image -->
        <img src="https://picsum.photos/400/300"
             alt="Item Image" class="post-image">

        <!-- Content -->
        <div class="post-body">

            <!-- Status -->
            <span class="badge lost">LOST</span>
            <!-- بدل lost بـ found إلا بغيتي -->

            <!-- Title -->
            <h1>Black Leather Wallet</h1>

            <!-- Info -->
            <div class="info-grid">
                <div class="info-item">
                    <span>Category</span>
                    Wallet / Money
                </div>
                <div class="info-item">
                    <span>City</span>
                    Casablanca
                </div>
                <div class="info-item">
                    <span>Location</span>
                    Near Central Fountain
                </div>
                <div class="info-item">
                    <span>Date</span>
                    2026-01-07
                </div>
            </div>

            <!-- Description -->
            <div class="description">
                I lost my black leather wallet near the central fountain.
                It contains my ID card and some important documents.
                Please contact me if you find it.
            </div>

            <!-- Actions -->
            <div class="actions">
                <a href="#" class="btn whatsapp">Contact on WhatsApp</a>
                <a href="#" class="btn call">Call</a>
            </div>

            <a href="#" class="btn resolve">Mark as Resolved</a>

            <!-- Map -->
            <div class="map">
                <iframe 
                    src="https://www.google.com/maps?q=casablanca&output=embed"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

        </div>
    </div>

</div>

</body>
</html>
