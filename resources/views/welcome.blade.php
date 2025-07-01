<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Terravin Wine - Experience the art of fine winemaking. Taste the feeling of our premium, handcrafted wines from exceptional vineyards.">
    <title>TERRAVIN WINE | Artisanal Wines of Distinction</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400&family=Mrs+Saint+Delafield&display=swap" rel="stylesheet">
    <style>
        :root {
            --burgundy: #5e0f0f;
            --gold: #c8a97e;
            --cream: #f5f0e6;p
            --cream: #f5f0e6;
            --dark-text: #2a2a2a;
            --light-text: #f8f8f8;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--cream);
            color: var(--dark-text);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        .hero {
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                        url('https://images.unsplash.com/photo-1474722883778-792e7990302f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: var(--light-text);
            padding: 0 2rem;
        }
        
        .logo {
            font-family:'Playfair Display', serif;
            font-size: 5rem;
            color: var(--gold);
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .tagline {
            font-family: 'Georgia ', serif;
            font-size: 20px;
            font-weight: 500;
            letter-spacing: 3px;
            margin-bottom: 2rem;
            text-transform: uppercase;
            text-align: center;
            max-width: 900px;
            margin: 30px auto;
            line-height: 1.6;
            padding: 0 20px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.4);
        }
        
        .divider {
            width: 100px;
            height: 2px;
            background: var(--gold);
            margin: 1.5rem auto;
        }
        
        .cta-button {
            display: inline-block;
            background: transparent;
            color: var(--light-text);
            border: 2px solid var(--gold);
            padding: 0.8rem 2.5rem;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 2rem;
            transition: all 0.3s ease;
            text-decoration: none;
            border-radius:12px;
        }
        
        .cta-button:hover {
            background: var(--gold);
            color: var(--burgundy);
        }
        
        .intro-text {
            max-width: 800px;
            margin: 5rem auto;
            text-align: center;
            padding: 0 2rem;
        }
        
        .intro-text h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: var(--burgundy);
            margin-bottom: 1.5rem;
        }
        
        .wine-showcase {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 4rem 2rem;
            background-color: var(--burgundy);
            color: var(--light-text);
        }
        
        .wine-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 5px;
            backdrop-filter: blur(5px);
            transition: transform 0.3s ease;
        }
        
        .wine-card:hover {
            transform: translateY(-10px);
        }
        
        .wine-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: var(--gold);
            margin-bottom: 1rem;
        }
        
        footer {
            background-color: var(--dark-text);
            color: var(--light-text);
            text-align: center;
            padding: 3rem 2rem;
        }
        
        .social-links {
            margin: 1.5rem 0;
        }
        
        .social-links a {
            color: var(--light-text);
            margin: 0 10px;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }
        
        .social-links a:hover {
            color: var(--gold);
        }
        
        @media (max-width: 768px) {
            .logo {
                font-size: 3.5rem;
            }
            
            .tagline {
                font-size: 1.5rem;
            }
        }
        .nav-button {
      padding: 10px 20px;
      margin-left: 15px;
      border: 2px solid var(--gold);
      border-radius: 25px;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s ease, color 0.3s ease;
      display: inline-block;
      background: transparent;
      color: var(--light-text);
    }
    .sign-in {
      background-color: transparent;
      color:white;
      border: 2px solid var(--gold) ;
    }

    .sign-in:hover {
      background: var(--gold);
            color: var(--burgundy);
    }

    .get-started {
      background-color:var(--burgundy);
      color: white;
    }
    .get-started:hover {
      background: var(--gold);
            color: var(--burgundy);
    }
    </style>
</head>
<body>
    <section class="hero">
     <div class="navbar">
    <a href="{{ route('login') }}" class="nav-button sign-in">Login</a>
    <a href="{{ route('register') }}" class="nav-button get-started">Register</a>

  </div>
        <h1 class="logo"> Welcome To Terravin Winery</h1>
        <p class="tagline">Manage your wine supply chain from vineyard to consumer. Track inventory, shipments, and quality control in one system.</p>
        <a href="#wines" class="cta-button">Explore Our Wines</a>
    </section>
    
    <section class="intro-text">
        <h2>Artisanal Wines of Distinction</h2>
        <p>Since our founding, Terravin has been dedicated to crafting exceptional wines that express the unique character of our vineyards. Each bottle tells a story of the land, the climate, and the passionate hands that nurtured it from grape to glass.</p>
    </section>
    

<section class="about-section">
    <div class="section-header">
        <h2>About Us</h2>
        <div class="divider"></div>
        <h3>Our Ugandan Roots</h3>
    </div>
    
    <div class="about-container">
        <div class="about-image">
            <div class="image-overlay"></div>
            <div class="floating-bottle">
                <img src="https://images.unsplash.com/photo-1558160074-4d7d8bdf4256?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Terravin Premium Wine Bottle">
            </div>
        </div>
        <div class="about-content">
            <p class="lead">Founded in 2015, Terravin Uganda brings world-class winemaking to the shores of Lake Victoria.</p>
            <p>Our unique microclimate near Entebbe creates exceptional conditions for cultivating hybrid grapes that thrive in the African sun.</p>
            
            <!-- Insert this in your About Us section, where your contact info should appear -->
<div class="contact-info">
    <h4>Connect With Us</h4>
    <div class="divider-small"></div>
    <p class="contact-item">
        <span class="contact-icon">📞</span>
        <a href="tel:+256770480745" class="contact-link">0770 480 745</a>
    </p>
    <p class="contact-item">
        <span class="contact-icon">✉️</span>
        <a href="mailto:info@terravinuganda.com" class="contact-link">info@terravinuganda.com</a>
    </p>

                <div class="social-platforms">
    <a href="#" class="social-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
            <path fill="currentColor" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
        WhatsApp
    </a>
    <a href="#" class="social-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
            <path fill="currentColor" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
        </svg>
        Instagram
    </a>
    <a href="#" class="social-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
            <path fill="currentColor" d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116c.73 0 1.323-.593 1.323-1.325V1.325C24 .593 23.407 0 22.675 0z"/>
        </svg>
        Facebook
    </a>
</div>

<style>
    .social-platforms {
        display: flex;
        gap: 12px;
        margin-top: 1.5rem;
    }

    .social-icon {
        background: rgba(200, 169, 126, 0.2);
        color: var(--burgundy);
        padding: 0.6rem 1.2rem;
        border-radius: 30px;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        text-decoration: none;
        gap: 8px;
    }

    .social-icon:hover {
        background: var(--gold);
        color: white;
        transform: translateY(-2px);
    }

    .social-icon svg {
        width: 18px;
        height: 18px;
    }
</style>
            </div>
        </div>
    </div>
</section>

<style>

    .about-section {
        padding: 5rem 2rem;
        background-color: var(--cream);
        position: relative;
    }

    .about-image {
        flex: 1;
        min-width: 300px;
        height: 500px;
        background: 
            linear-gradient(rgba(94, 15, 15, 0.3), rgba(94, 15, 15, 0.3)),
            url('https://images.unsplash.com/photo-1466637574441-749b8f19452f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
        border-radius: 8px;
        position: relative;
        overflow: hidden;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(200, 169, 126, 0.1) 0%, rgba(94, 15, 15, 0.2) 100%);
    }

    .floating-bottle {
        position: absolute;
        bottom: -30px;
        right: -30px;
        width: 200px;
        height
<style>
    
    .about-section {
        padding: 5rem 2rem;
        background-color: var(--cream);
    }

    .contact-info {
        padding: 1.4rem;
    }
    .contact-item {
        font-size: 1rem;
    }
}
    .contact-info {
        margin-top: 2.5rem;
        padding: 1.5rem;
        background: rgba(200, 169, 126, 0.1);
        border-left: 3px solid var(--gold);
        border-radius: 0 5px 5px 0;
    }

    .contact-info h4 {
        font-family: 'Playfair Display', serif;
        color: var(--burgundy);
        margin-bottom: 0.5rem;
    }

    .contact-info p {
        margin: 0.8rem 0;
        display: flex;
        align-items: center;
    }

    .icon {
        margin-right: 10px;
        color: var(--gold);
    }

    .contact-info a {
        color: var(--burgundy);
        text-decoration: none;
        transition: color 0.3s;
    }

    .contact-info a:hover {
        color: var(--gold);
    }

    .social-platforms {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 1.5rem;
    }

    .social-icon {
        background: rgba(200, 169, 126, 0.2);
        color: var(--burgundy);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s;
        text-decoration: none;
    }

    .social-icon:hover {
        background: var(--gold);
        color: white;
    }

    .divider-small {
        width: 50px;
        height: 1px;
        background: var(--gold);
        margin: 0.8rem 0 1.2rem;
    }
</style>
/* </section> 

<style>
    
    .about-section {
        padding: 6rem 2rem;
        background-color: var(--cream);
        position: relative;
    }

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.8rem;
        color: var(--burgundy);
        letter-spacing: 1px;
    }

    .about-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    .about-image {
        flex: 1;
        min-width: 300px;
        height: 500px;
        background: 
            linear-gradient(rgba(94, 15, 15, 0.2), rgba(94, 15, 15, 0.2)),
            url('https://images.unsplash.com/photo-1601584115197-04ecc0da31e8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
    }

    .about-content {
        flex: 1;
        min-width: 300px;
        padding: 3rem;
        background-color: var(--light-text);
    }

    .about-content h3 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: var(--burgundy);
        margin-bottom: 1rem;
    }

    .about-content .highlight {
        color: var(--gold);
    }

    .divider-small {
        width: 60px;
        height: 2px;
        background: var(--gold);
        margin: 1.2rem 0;
    }

    .about-content p {
        margin-bottom: 1.5rem;
        line-height: 1.8;
    }

    .about-content .lead {
        font-size: 1.1rem;
        font-weight: 500;
    }

    .about-content .emphasis {
        font-style: italic;
        color: var(--burgundy);
        position: relative;
        padding-left: 2rem;
    }

    .about-content .emphasis::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        height: 2px;
        width: 30px;
        background: var(--gold);
    }

    @media (max-width: 768px) {
        .about-image {
            height: 350px;
            min-width: 100%;
        }
        
        .about-content {
            padding: 2rem;
        }
        
        .section-header h2 {
            font-size: 2.2rem;
        }
    }
</style>
    <section class="wine-showcase" id="wines">
        <div class="wine-card">
            <h3>Reserve Cabernet</h3>
            <p>A bold, full-bodied red with notes of black cherry, cassis, and a hint of vanilla from oak aging. Perfect for special occasions.</p>
        </div>
        <div class="wine-card">
            <h3>Chardonnay</h3>
            <p>Our elegant white wine offers a beautiful balance of ripe pear, citrus, and subtle oak. Crisp yet creamy on the palate.</p>
        </div>
        <div class="wine-card">
            <h3>Pinot Noir</h3>
            <p>Delicate and complex, with aromas of red berries, earth, and spice. A versatile red that pairs beautifully with many dishes.</p>
        </div>
    </section>
    <footer>
    <h3>Terravin Wine Estate</h3>
    <p>Plot 42 Lakeside Drive • Entebbe, Uganda</p>
    <div class="social-links">
        <a href="#">⌚</a>
        <a href="#">📸</a>
        <a href="#">👍</a>
        <a href="#">📌</a>
    </div>
    <p>&copy; 2025 Terravin Wines. All rights reserved.</p>
</footer>
    <
</body>
</html>