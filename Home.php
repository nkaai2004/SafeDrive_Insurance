<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>SafeDrive Insurance</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="Home.css"/>
</head>
<body>
    <header>
        <div class="container header-container">
            <div class="logo">SafeDrive Insurance</div>
            <div class="auth-links">
                <a href="Login.php">Sign In</a> /
                <a href="Signup.php">Register</a>
            </div>
        </div>
        <nav>
            <div class="container nav-container">
                <a href="Home.php">Home</a>
                <a href="Policies.php">Policies</a>
                <a href="Claims.php">Claims</a>
                <a href="Contact.php">Contact Us</a>
                <a href="Userdashboard.php">Userdashboard</a>
            </div>
        </nav>
    </header>
    <!-- Rest of the Home.html content remains unchanged -->
    <main class="container main-container">
        <section class="card hero-section">
            <h1>GET YOUR CAR INSURED IN 3 EASY STEPS!</h1>
            <p>Instant Quotes · Flexible Policies · Affordable Rates</p>
            <button class="btn" onclick="location.href='Signup.php'">Get a Quote</button>
            <img alt="Family with car on a road safety scene" src="https://storage.googleapis.com/a1aa/image/ytrHpBBASCgnbh8PBH1CSsVaGULcmW9_lZ5rgIF2GLI.jpg"/>
        </section>
        <!-- Other sections remain static for now -->
    </main>
    <footer>
        <div class="container footer-container">
            <div class="footer-links">
                <a href="#">About Us</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
            <div class="social-links">
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="#4b5563"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H7v-3h3V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3l-.5 3h-2.5v6.8c4.56-.93 8-4.96 8-9.8z"/></svg></a>
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="#4b5563"><path d="M22 4.01c-.81.36-1.68.61-2.59.72A4.51 4.51 0 0 0 21 2.53c-.85.5-1.79.84-2.79 1.03A4.49 4.49 0 0 0 15 8c0 .35.04.69.11 1.02C10.49 8.76 6.34 6.58 3.5 3.14c-.5.85-.78 1.84-.78 2.89 0 1.99.99 3.75 2.5 4.79a4.47 4.47 0 0 1-2.03-.56v.06c0 2.78 1.98 5.09 4.61 5.62-.48.13-.99.21-1.51.21-.37 0-.73-.04-1.08-.11.73 2.27 2.85 3.92 5.36 3.97a9.01 9.01 0 0 1-5.58 1.93c-.36 0-.72-.02-1.08-.06A12.74 12.74 0 0 0 12 22c7.73 0 11.95-6.4 11.95-11.95 0-.18 0-.36-.01-.54A8.56 8.56 0 0 0 22 4.01z"/></svg></a>
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="#4b5563"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm2-9.5c0-.83-.67-1.5-1.5-1.5S8 6.67 8 7.5 8.67 9 9.5 9 11 8.33 11 7.5zM17 17h-2v-4c0-1.1-.9-2-2-2s-2 .9-2 2v4h-2v-7h2v1.17c.48-.73 1.35-1.17 2.25-1.17 1.65 0 3 1.35 3 3v4z"/></svg></a>
            </div>
        </div>
    </footer>
</body>
</html>