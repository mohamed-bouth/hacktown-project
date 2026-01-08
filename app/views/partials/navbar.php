<?php session_start(); ?>

<nav class="main-navbar">
    <div class="nav-container">
        <a href="index.html" class="nav-logo">
            Found<span class="logo-accent">And</span>Lost
        </a>

        <div class="nav-links">
            <a href="./dashboard.php" class="nav-link">Home</a>
            <a href="./postManagement.php" class="nav-link">Add Post</a>
            <a href="./searchPost.php" class="nav-link">How it Works</a>
        </div>
        <div>
            <a href="./addPost.php" class="nav-cta">Post an Item</a>
            <a href="./auth/logout.php" class="nav-cta2">logout</a>
        </div>

        <button class="mobile-toggle" onclick="toggleMenu()">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
    </div>

    <div class="mobile-menu" id="mobileMenu">
        <a href="./dashboard.php" class="nav-link">Home</a>
        <a href="./postManagement.php" class="nav-link">Add Post</a>
        <a href="./searchPost.php" class="nav-link">How it Works</a>
    </div>
</nav>

<script>
    function toggleMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('active');
    }
</script>