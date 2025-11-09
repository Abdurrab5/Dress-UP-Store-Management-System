<?php
session_start();
include 'connection.php';
  
 
?> 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DressUp Studio- Your Online Shopping Destination</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <h1>DressUp Studio</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#sale">Sale</a></li>
                    <li><a href="#testimonials">Testimonials</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                  
                </ul>
            </nav>
            <div class="header-icons">
                
                <a href="search page.html" class="fas fa-search"></a>
                <?php
if(isset($_SESSION['user_name'])){
    $alpha = strtoupper(substr($_SESSION['user_name'], 0, 1));
    echo "<div class='user-alpha' onclick=\"window.location.href='customer_dashboard.php'\">$alpha</div>";
} else {
    echo "<a href='signup.php' class='fas fa-user'></a>";
}
?>

        

        
              <a href="cart.php" class="fas fa-shopping-cart"></a>
             <span id="cart-count" class="cart-count">0</span>

            </div>
    
            </div>
            <div class="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    <section class="hero" id="home">
        <div class="video-background">
        <video autoplay muted loop playsinline>
            <source src="Pink final.mp4" type="video/mp4">
       
            Your browser does not support the video tag.
        </video>
    </div>
        <div class="container">
            <div class="hero-content">
                <h1>One Stop Shop For All</h1>
                <p >Your Perfect Look Start Here</p>
                <a href="#products" class="btn">Shop Now</a>
            </div>
           
</div>
        </div>
    </section>
<?php
// Fetch categories
$sql = "SELECT id, name FROM categories"; // include image in query
$result = $conn->query($sql);
?>

<section class="categories">
    <div class="container">
        <h2>Shop by Category</h2>
        <div class="category-grid">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="category-card">
                        <a href="allproducts.php?category_id=<?php echo $row['id']; ?>">
                            <img src=" " alt="<?php echo htmlspecialchars($row['name']); ?>">
                            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align:center; color:#555;">No categories found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php $conn->close(); ?>


    
    <section class="sale" id="sale"></section>
    <section class="banner">
        <div class="container">
            <h2>Summer Sale - Up to 50% Off</h2>
            <p>Limited time offer. Shop now before it's gone!</p>
            <a href="#products" class="btn">View Deals</a>
        </div>
    </section>

    <section class="features" id="features">
        <div class="container">
            <h2>Why Choose Us</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-truck"></i>
                    <h3>Free Shipping</h3>
                    <p>On all orders over Rs 50</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-undo"></i>
                    <h3>Easy Returns</h3>
                    <p>30-day return policy</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-lock"></i>
                    <h3>Secure Payment</h3>
                    <p>100% secure checkout</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-headset"></i>
                    <h3>24/7 Support</h3>
                    <p>Dedicated support</p>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials" id="testimonials">
        <div class="container">
            <h2>What Our Customers Say</h2>
            <div class="testimonial-slider">
                <div class="testimonial active">
                    <p>"Great products and excellent customer service. Will definitely shop here again!"</p>
                    <div class="customer">
                        <img src="areeba.jpg" alt="Customer">
                        <h4>Areeba</h4>
                    </div>
                </div>
                <div class="testimonial">
                    <p>"Fast delivery and high-quality products. Very satisfied with my purchase."</p>
                    <div class="customer">
                        <img src="ayesha.jpg" alt="Customer">
                        <h4>Ayesha</h4>
                    </div>
                </div>
                <div class="testimonial">
                    <p>"The best online shopping experience I've had. Highly recommended!"</p>
                    <div class="customer">
                        <img src="huma.jpg" alt="Customer">
                        <h4>Huma khan</h4>
                    </div>
                </div>
                <div class="slider-controls">
                   <button class="prev"><i class="fas fa-chevron-left"></i></button>
                    <button  class="next"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </section>

    <section class="newsletter">
        <div class="container">
            <h2>Subscribe to Our Newsletter</h2>
            <p>Get the latest updates on new products and special offers.</p>
            <form id="newsletter-form">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit" class="btn">Subscribe</button>
            </form>
        </div>
    </section>

    <footer id="contact">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>DressUp Studio</h3>
                    <p>Your one-stop shop for all your needs. Quality products at affordable prices.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#products">Products</a></li>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#testimonials">Testimonials</a></li>
                        <li><a href="#contact Us">Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Customer Service</h3>
                    <ul>
                        <li><a href="#">My Account</a></li>
                        <li><a href="#">Order Tracking</a></li>
                        <li><a href="#">Wishlist</a></li>
                        <li><a href="#">Returns</a></li>
                        <li><a href="#">Shipping Policy</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Contact Us</h3>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> Main GT Road, Nowshera, Pakistan</li>
                        <li><i class="fas fa-phone"></i> +92332 9008616</li>
                        <li><i class="fas fa-envelope"></i> nomansharif6@gmail.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 DressUp Studio. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="index.js"></script>
</body>
</html>
</div></form>
