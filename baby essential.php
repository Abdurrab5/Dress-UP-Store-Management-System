<?php
session_start();
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Image Gallery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="baby essential.css">
</head>
<body>
    <header class="gallery-header">
        <h1>BABY ESSENTIAL</h1>
        <div class="filter-controls">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="Baby">Baby</button>
           
        </div>
    </header>

    <main class="gallery-container">
        <!-- Gallery items will be injected here by JavaScript -->
    </main>

    <div class="lightbox" id="lightbox">
        <div class="lightbox-content">
            <span class="close-lightbox">&times;</span>
            <div class="lightbox-navigation">
                <button class="nav-btn prev-btn"><i class="fas fa-chevron-left"></i></button>
                <div class="lightbox-main">
                    <img id="lightbox-image" src="" alt="">
                    <div class="zoom-controls">
                        <button class="zoom-btn" id="lightbox-zoom-in"><i class="fas fa-search-plus"></i></button>
                        <button class="zoom-btn" id="lightbox-zoom-out"><i class="fas fa-search-minus"></i></button>
                        <button class="zoom-btn" id="lightbox-zoom-reset"><i class="fas fa-sync-alt"></i></button>
                    </div>
                </div>
                <button class="nav-btn next-btn"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="lightbox-info">
                <h2 id="lightbox-title"></h2>
                <p id="lightbox-description"></p>
                <div class="price-section">
                    <span id="lightbox-price"></span>
                    <button class="buy-btn">Add to Cart</button>
                </div>
                <div class="social-share">
                    <button class="share-btn"><i class="fab fa-facebook-f"></i></button>
                    <button class="share-btn"><i class="fab fa-instagram"></i></button>
                </div>
            </div>
        </div>
    </div>
    <script src="baby essential.js"></script>
</body>
</html>