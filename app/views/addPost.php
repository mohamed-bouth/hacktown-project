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
            border-top: 6px solid var(--theme-color); /* Visual indicator of current mode */
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
            background-color: #FEF2F2; /* Very light red */
            color: var(--color-lost);
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        /* State: Active Found (Green) */
        .form-container[data-theme="found"] .toggle-btn[data-type="found"] {
            background-color: #ECFDF5; /* Very light green */
            color: var(--color-found);
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
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
            box-sizing: border-box; /* Ensures padding doesn't break width */
        }

        /* Focus State uses the Theme Color */
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--theme-color);
            box-shadow: 0 0 0 3px rgba(0,0,0,0.05); /* Subtle ring */
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

        <form class="form-body" onsubmit="event.preventDefault(); alert('Post Published!');">
            
            <div class="form-group">
                <label for="title">What is the item?</label>
                <input type="text" id="title" placeholder="e.g. Black Leather Wallet" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category">
                        <option>Electronics</option>
                        <option>Wallet / Money</option>
                        <option>Keys</option>
                        <option>Pets</option>
                        <option>Documents</option>
                        <option>Clothing</option>
                        <option>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" placeholder="e.g. New York">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="location">Specific Location (Optional)</label>
                    <input type="text" id="location" placeholder="e.g. Near the Central Fountain">
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" required>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" rows="4" placeholder="Describe distinct features, scratches, contents, etc."></textarea>
            </div>

            <div class="form-group">
                <label>Photos</label>
                <div class="upload-area">
                    <svg class="upload-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <div class="upload-text">Click to upload or drag and drop</div>
                </div>
            </div>

            <div class="form-group">
                <label>Contact Method</label>
                <div class="checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" checked> In-app Chat
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox"> Phone
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox"> Email
                    </label>
                </div>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">Publish Lost Listing</button>

        </form>
    </div>

    <script>
        function setTheme(type) {
            const formContainer = document.getElementById('postForm');
            const submitBtn = document.getElementById('submitBtn');
            const root = document.documentElement;

            // 1. Update the data attribute on the container
            formContainer.setAttribute('data-theme', type);

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