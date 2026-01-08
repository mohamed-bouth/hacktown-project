<?php
declare(strict_types=1);

require_once __DIR__ . '/../Core/Database.php';

use App\Core\Database;

session_start();

$errors = [];
$success = isset($_GET['success']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'] ?? null;
    $type = $_POST['type'] ?? '';
    $category = $_POST['category'] ?? '';
    $city = trim($_POST['city'] ?? '');
    $locationText = trim($_POST['location_text'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $whatsapp = trim($_POST['whatsapp'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    $allowedTypes = ['lost', 'found'];
    $allowedCategories = ['CIN', 'Phone', 'Document', 'Wallet', 'Other'];

    if (!in_array($type, $allowedTypes, true)) {
        $errors[] = 'Please select a valid type.';
    }

    if (!in_array($category, $allowedCategories, true)) {
        $errors[] = 'Please select a valid category.';
    }

    if ($city === '') {
        $errors[] = 'City is required.';
    }

    if ($locationText === '') {
        $errors[] = 'Location is required.';
    }

    if ($description === '') {
        $errors[] = 'Description is required.';
    }

    if (strlen($description) > 500) {
        $errors[] = 'Description must be 500 characters or less.';
    }

    if ($whatsapp === '') {
        $errors[] = 'WhatsApp number is required.';
    }

    if (empty($errors)) {
        $db = Database::getInstance();

        if ($userId === null) {
            $guestEmail = 'guest@local.test';
            $stmt = $db->prepare('SELECT id FROM users WHERE email = :email');
            $stmt->execute(['email' => $guestEmail]);
            $row = $stmt->fetch();
            if ($row) {
                $userId = (int) $row['id'];
            } else {
                $stmt = $db->prepare(
                    'INSERT INTO users (name, email, password, phone, created_at)
                     VALUES (:name, :email, :password, :phone, NOW())'
                );
                $stmt->execute([
                    'name' => 'Guest',
                    'email' => $guestEmail,
                    'password' => password_hash('guest', PASSWORD_DEFAULT),
                    'phone' => null,
                ]);
                $userId = (int) $db->lastInsertId();
            }
        }

        $stmt = $db->prepare(
            'INSERT INTO posts (user_id, type, category, city, location_text, description, whatsapp, phone, status, created_at)
             VALUES (:user_id, :type, :category, :city, :location_text, :description, :whatsapp, :phone, :status, NOW())'
        );
        $stmt->execute([
            'user_id' => $userId,
            'type' => $type,
            'category' => $category,
            'city' => $city,
            'location_text' => $locationText,
            'description' => $description,
            'whatsapp' => preg_replace('/\D+/', '', $whatsapp),
            'phone' => $phone !== '' ? preg_replace('/\D+/', '', $phone) : null,
            'status' => 'active',
        ]);

        header('Location: addPost.php?success=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoundAndLost - Add Post</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/navbar.css">
    <?php require_once "./partials/navbar.php" ?>
    <style>
        /* --- 1. Design Variables --- */
        :root {
            --bg-body: #F3F4F6;
            --bg-card: #FFFFFF;
            --text-primary: #111827;
            --text-secondary: #6B7280;
            --border-color: #E5E7EB;

            /* Status Colors */
            --color-lost: #EF4444;
            --color-lost-hover: #DC2626;
            --color-found: #10B981;
            --color-found-hover: #059669;

            /* Dynamic Theme Variable (Default is Lost/Red) */
            --theme-color: var(--color-lost);
            --theme-color-hover: var(--color-lost-hover);

            --radius-input: 8px;
            --radius-card: 16px;
            --shadow-card: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            display: flex;
            justify-content: center;
            padding: 40px 20px;
            min-height: 100vh;
            margin: 0;
        }

        /* --- 2. Main Container --- */
        .form-container {
            margin-top: 50px;
            background: var(--bg-card);
            width: 100%;
            max-width: 600px;
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            transition: border-color 0.3s ease;
            border-top: 6px solid var(--theme-color);
            /* Visual indicator of current mode */
        }

        /* --- 3. The Toggle Section --- */
        .toggle-header {
            display: flex;
            background: #F9FAFB;
            padding: 8px;
            border-bottom: 1px solid var(--border-color);
        }

        .toggle-btn {
            flex: 1;
            border: none;
            background: transparent;
            padding: 14px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            border-radius: var(--radius-input);
            color: var(--text-secondary);
            transition: all 0.2s ease;
        }

        /* State: Active Lost (Red) */
        .form-container[data-theme="lost"] .toggle-btn[data-type="lost"] {
            background-color: #FEF2F2;
            /* Very light red */
            color: var(--color-lost);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        /* State: Active Found (Green) */
        .form-container[data-theme="found"] .toggle-btn[data-type="found"] {
            background-color: #ECFDF5;
            /* Very light green */
            color: var(--color-found);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        /* --- 4. Form Content --- */
        .form-body {
            padding: 32px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        label {
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--text-primary);
        }

        input[type="text"],
        input[type="date"],
        select,
        textarea {
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-input);
            font-size: 1rem;
            font-family: inherit;
            color: var(--text-primary);
            transition: border-color 0.2s, box-shadow 0.2s;
            width: 100%;
            box-sizing: border-box;
            /* Ensures padding doesn't break width */
        }

        /* Focus State uses the Theme Color */
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--theme-color);
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
            /* Subtle ring */
        }

        /* --- 5. File Upload --- */
        .upload-area {
            border: 2px dashed var(--border-color);
            border-radius: var(--radius-input);
            padding: 32px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s;
            background: #FAFAFA;
        }

        .upload-area:hover {
            border-color: var(--theme-color);
            background: #FFFFFF;
        }

        .upload-text {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .upload-icon {
            width: 32px;
            height: 32px;
            margin-bottom: 8px;
            stroke: var(--text-secondary);
        }

        /* --- 6. Contact Checkboxes --- */
        .checkbox-group {
            display: flex;
            gap: 20px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 400;
            cursor: pointer;
        }

        input[type="checkbox"] {
            accent-color: var(--theme-color);
            width: 18px;
            height: 18px;
        }

        /* --- 7. Submit Button --- */
        .submit-btn {
            background-color: var(--theme-color);
            color: white;
            border: none;
            padding: 16px;
            border-radius: var(--radius-input);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 8px;
        }

        .submit-btn:hover {
            background-color: var(--theme-color-hover);
        }
    </style>
</head>

<body>

    <div class="form-container" id="postForm" data-theme="lost">

        <div class="toggle-header">
            <button class="toggle-btn" data-type="lost" onclick="setTheme('lost')">
                I Lost Something
            </button>
            <button class="toggle-btn" data-type="found" onclick="setTheme('found')">
                I Found Something
            </button>
        </div>

        <form class="form-body" method="POST" action="">
            <?php if ($success): ?>
                <p style="color:#059669; font-weight:600;">Your listing has been published.</p>
            <?php endif; ?>
            <?php if (!empty($errors)): ?>
                <div style="color:#B91C1C; font-weight:600;">
                    <?php foreach ($errors as $error): ?>
                        <div><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="title">What is the item?</label>
                <input type="text" name="title" id="title"
                    placeholder="e.g. Black Leather Wallet" required>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category">
                        <option>CIN</option>
                        <option>Phone</option>
                        <option>Document</option>
                        <option>Wallet</option>
                        <option>Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" placeholder="Casablanca" required>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:2fr 1fr; gap:20px;">
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location_text"
                        placeholder="Near central market" required>
                </div>

                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="lost_date" required>
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label>WhatsApp</label>
                <input type="text" name="whatsapp" required>
            </div>

            <div class="form-group">
                <label>Phone (optional)</label>
                <input type="text" name="phone">
            </div>

            <input type="hidden" name="type" value="lost" id="postType">

            <button type="submit" class="submit-btn" id="submitBtn">
                Publish Lost Listing
            </button>
        </form>

    </div>

    <script>
        function setTheme(type) {
            const formContainer = document.getElementById('postForm');
            const submitBtn = document.getElementById('submitBtn');
            const postType = document.getElementById('postType');
            const root = document.documentElement;

            // 1. Update the data attribute on the container
            formContainer.setAttribute('data-theme', type);
            postType.value = type;

            // 2. Update CSS Variables dynamically for the theme colors
            if (type === 'lost') {
                root.style.setProperty('--theme-color', 'var(--color-lost)');
                root.style.setProperty('--theme-color-hover', 'var(--color-lost-hover)');
                submitBtn.innerText = "Publish Lost Listing";
            } else {
                root.style.setProperty('--theme-color', 'var(--color-found)');
                root.style.setProperty('--theme-color-hover', 'var(--color-found-hover)');
                submitBtn.innerText = "Publish Found Listing";
            }
        }
    </script>
</body>

</html>
