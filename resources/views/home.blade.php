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
            font-family: 'Mrs Saint Delafield', cursive;
            font-size: 5rem;
            color: var(--gold);
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .tagline {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 300;
            letter-spacing: 3px;
            margin-bottom: 2rem;
            text-transform: uppercase;
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
    </style>
</head>
<body>
    <section class="hero">
        <h1 class="logo">Terravin</h1>
        <div class="divider"></div>
        <p class="tagline">Taste the feeling</p>
        <a href="#wines" class="cta-button">Explore Our Wines</a>
    </section>
    
    <section class="intro-text">
        <h2>Artisanal Wines of Distinction</h2>
        <p>Since our founding, Terravin has been dedicated to crafting exceptional wines that express the unique character of our vineyards. Each bottle tells a story of the land, the climate, and the passionate hands that nurtured it from grape to glass.</p>
    </section>
    
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
        <p>123 Vineyard Lane • Napa Valley, CA</p>
        <div class="social-links">
            <a href="#">⌚</a>
            <a href="#">📸</a>
            <a href="#">👍</a>
            <a href="#">📌</a>
        </div>
        <p>&copy; 2023 Terravin Wines. All rights reserved.</p>
    </footer>
</body>
</html>