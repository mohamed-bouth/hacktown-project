<nav class="main-navbar">
    <div class="nav-container">
        <a href="index.html" class="nav-logo">
            Found<span class="logo-accent">And</span>Lost
        </a>

        <div class="nav-links">
            <a href="./dashboard.php" class="nav-link">Home</a>
            <a href="./addPost.php" class="nav-link">Add Post</a>
            <a href="./searchPost.php" class="nav-link">How it Works</a>
        </div>

        <a href="./addPost.php" class="nav-cta">Post an Item</a>

        <button class="mobile-toggle" onclick="toggleMenu()">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
    </div>

    <div class="mobile-menu" id="mobileMenu">
        <a href="index.html">Home</a>
        <a href="search.html">Browse Items</a>
        <a href="#">How it Works</a>
        <a href="#">Log In</a>
    </div>
</nav>

<script>
    function toggleMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('active');
    }
</script>