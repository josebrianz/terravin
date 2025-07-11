<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wine Selection | TERRAVIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --burgundy: #5e0f0f;
            --light-burgundy: #8b1a1a;
            --gold: #c8a97e;
            --cream: #f5f0e6;
            --light-cream: #f9f5ed;
            --dark-text: #2a2a2a;
            --gray: #e1e5e9;
            --shadow-sm: 0 2px 8px rgba(94, 15, 15, 0.08);
            --shadow-md: 0 4px 20px rgba(94, 15, 15, 0.12);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light-cream);
            color: var(--dark-text);
            line-height: 1.6;
        }

        .dashboard {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            background: var(--burgundy);
            color: white;
            padding: 2rem 1.5rem;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--gold);
            margin-bottom: 2.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo i {
            font-size: 1.5rem;
        }

        .nav-menu {
            list-style: none;
            margin-top: 2rem;
        }

        .nav-item {
            margin-bottom: 0.8rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem 1rem;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: var(--transition);
        }

        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--gold);
        }

        .nav-link i {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        .user-profile {
            margin-top: auto;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--burgundy);
            font-weight: 600;
        }

        .user-info h4 {
            font-size: 0.95rem;
            margin-bottom: 0.2rem;
        }

        .user-info p {
            font-size: 0.8rem;
            opacity: 0.7;
        }

        /* Main Content */
        .main-content {
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--burgundy);
        }

        .search-cart {
            display: flex;
            gap: 1rem;
        }

        .search-bar {
            position: relative;
        }

        .search-bar input {
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border: 1px solid var(--gray);
            border-radius: 8px;
            width: 250px;
            font-family: inherit;
            background-color: white;
        }

        .search-bar i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--burgundy);
        }

        .cart-btn {
            background: var(--burgundy);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .cart-btn:hover {
            background: var(--light-burgundy);
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--gold);
            color: var(--burgundy);
            width: 20px;
            height: 20px;
            border-radius: 50%;
            font-size: 0.7rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Wine Grid */
        .wine-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .wine-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .wine-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .wine-image {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .wine-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--gold);
            color: var(--burgundy);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .wine-details {
            padding: 1.5rem;
        }

        .wine-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: var(--burgundy);
        }

        .wine-region {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .wine-region i {
            color: var(--gold);
        }

        .wine-description {
            font-size: 0.9rem;
            margin-bottom: 1.2rem;
            color: #555;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .wine-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .wine-price {
            font-weight: 600;
            font-size: 1.2rem;
            color: var(--burgundy);
        }

        .add-to-cart {
            background: var(--burgundy);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .add-to-cart:hover {
            background: var(--light-burgundy);
        }

        /* Filters */
        .filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            background: white;
            border: 1px solid var(--gray);
            padding: 0.6rem 1.2rem;
            border-radius: 20px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
        }

        .filter-btn:hover, .filter-btn.active {
            background: var(--burgundy);
            color: white;
            border-color: var(--burgundy);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .dashboard {
                grid-template-columns: 1fr;
            }

            .sidebar {
                height: auto;
                position: static;
                padding: 1.5rem;
            }

            .nav-menu {
                display: flex;
                gap: 0.5rem;
                overflow-x: auto;
                padding-bottom: 1rem;
            }

            .nav-item {
                margin-bottom: 0;
            }

            .nav-link {
                white-space: nowrap;
            }

            .user-profile {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .search-cart {
                width: 100%;
                justify-content: space-between;
            }

            .search-bar input {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 1.5rem;
            }

            .wine-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <i class="fas fa-wine-glass-alt"></i>
                <span>Terravin</span>
                </div>

            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-wine-bottle"></i>
                        <span>Wine Catalog</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-heart"></i>
                        <span>Favorites</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-history"></i>
                        <span>Order History</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('help.index') }}" class="nav-link">
                        <i class="fas fa-question-circle"></i>
                        <span>Help & Support</span>
                    </a>
                </li>
            </ul>

            <div class="user-profile">
                <div class="user-avatar">JS</div>
                <div class="user-info">
                    <h4>John Smith</h4>
                    <p>Premium Member</p>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h1 class="page-title">Our Wine Selection</h1>
                <div class="search-cart">
                    <div class="search-bar">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search wines...">
                    </div>
                    <button class="cart-btn">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">3</span>
                    </button>
                </div>
            </div>

            <!-- Filters -->
            <div class="filters">
                <button class="filter-btn active">All Wines</button>
                <button class="filter-btn">Red</button>
                <button class="filter-btn">White</button>
                <button class="filter-btn">Sparkling</button>
                <button class="filter-btn">Rosé</button>
                <button class="filter-btn">Under $50</button>
                <button class="filter-btn">Premium</button>
    </div>

            <!-- Wine Grid -->
            <div class="wine-grid">
                <!-- Wine Card 1 -->
                <div class="wine-card">
                    <div class="wine-image" style="background-image: url('https://images.unsplash.com/photo-1558160074-4d7d8bdf4256?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');">
                        <span class="wine-badge">Best Seller</span>
                    </div>
                    <div class="wine-details">
                        <h3 class="wine-name">Château Margaux</h3>
                        <p class="wine-region">
                            <i class="fas fa-map-marker-alt"></i> Bordeaux, France
                        </p>
                        <p class="wine-description">
                            A premier grand cru classé from Margaux with elegant tannins and aromas of blackcurrant, violet, and spice.
                        </p>
                        <div class="wine-footer">
                            <span class="wine-price">$199.99</span>
                            <button class="add-to-cart">
                                <i class="fas fa-plus"></i> Add to Cart
                            </button>
                </div>
            </div>
        </div>

                <!-- Wine Card 2 -->
                <div class="wine-card">
                    <div class="wine-image" style="background-image: url('https://images.unsplash.com/photo-1510812431401-41e2f9c26950?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1374&q=80');">
                        <span class="wine-badge">New</span>
                    </div>
                    <div class="wine-details">
                        <h3 class="wine-name">Cloudy Bay Sauvignon Blanc</h3>
                        <p class="wine-region">
                            <i class="fas fa-map-marker-alt"></i> Marlborough, NZ
                        </p>
                        <p class="wine-description">
                            Vibrant and aromatic with intense passionfruit, citrus and fresh herb flavors. A benchmark New Zealand Sauvignon Blanc.
                        </p>
                        <div class="wine-footer">
                            <span class="wine-price">$39.99</span>
                            <button class="add-to-cart">
                                <i class="fas fa-plus"></i> Add to Cart
                            </button>
                </div>
            </div>
        </div>

                <!-- Wine Card 3 -->
                <div class="wine-card">
                    <div class="wine-image" style="background-image: url('https://images.unsplash.com/photo-1608270586620-248524c67de9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');">
                        <span class="wine-badge">Limited</span>
                    </div>
                    <div class="wine-details">
                        <h3 class="wine-name">Dom Pérignon Vintage</h3>
                        <p class="wine-region">
                            <i class="fas fa-map-marker-alt"></i> Champagne, France
                        </p>
                        <p class="wine-description">
                            The prestige cuvée of Champagne house Moët & Chandon, with fine bubbles and complex aromas of brioche, almond and citrus.
                        </p>
                        <div class="wine-footer">
                            <span class="wine-price">$249.99</span>
                            <button class="add-to-cart">
                                <i class="fas fa-plus"></i> Add to Cart
                            </button>
                </div>
            </div>
        </div>

                <!-- Wine Card 4 -->
                <div class="wine-card">
                    <div class="wine-image" style="background-image: url('https://images.unsplash.com/photo-1608270586620-248524c67de9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');">
                        <span class="wine-badge">Organic</span>
                    </div>
                    <div class="wine-details">
                        <h3 class="wine-name">Bodega Catena Malbec</h3>
                        <p class="wine-region">
                            <i class="fas fa-map-marker-alt"></i> Mendoza, Argentina
                        </p>
                        <p class="wine-description">
                            Rich and full-bodied with flavors of blackberry, plum and dark chocolate. Aged in French oak barrels for 12 months.
                        </p>
                        <div class="wine-footer">
                            <span class="wine-price">$59.99</span>
                            <button class="add-to-cart">
                                <i class="fas fa-plus"></i> Add to Cart
                            </button>
            </div>
        </div>
    </div>

                <!-- Wine Card 5 -->
                <div class="wine-card">
                    <div class="wine-image" style="background-image: url('https://images.unsplash.com/photo-1474722883778-792e7990302f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');">
                        <span class="wine-badge">Sale</span>
                </div>
                    <div class="wine-details">
                        <h3 class="wine-name">Penfolds Grange</h3>
                        <p class="wine-region">
                            <i class="fas fa-map-marker-alt"></i> South Australia
                        </p>
                        <p class="wine-description">
                            Australia's most famous wine, with incredible power and concentration. A blend of Shiraz with a small amount of Cabernet Sauvignon.
                        </p>
                        <div class="wine-footer">
                            <span class="wine-price">$899.99</span>
                            <button class="add-to-cart">
                                <i class="fas fa-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Wine Card 6 -->
                <div class="wine-card">
                    <div class="wine-image" style="background-image: url('https://images.unsplash.com/photo-1590701833281-e6283af0948d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');">
                        <span class="wine-badge">Staff Pick</span>
                    </div>
                    <div class="wine-details">
                        <h3 class="wine-name">Sancerre Rosé</h3>
                        <p class="wine-region">
                            <i class="fas fa-map-marker-alt"></i> Loire Valley, France
                        </p>
                        <p class="wine-description">
                            Delicate salmon pink color with refreshing acidity and flavors of strawberry, citrus and mineral notes.
                        </p>
                        <div class="wine-footer">
                            <span class="wine-price">$34.99</span>
                            <button class="add-to-cart">
                                <i class="fas fa-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
</div>

    <script>
        // Simple interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Filter buttons
            const filterButtons = document.querySelectorAll('.filter-btn');
            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    // Here you would filter the wine cards based on selection
                });
            });

            // Add to cart buttons
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const wineName = this.closest('.wine-card').querySelector('.wine-name').textContent;
                    const winePrice = this.closest('.wine-card').querySelector('.wine-price').textContent;
                    
                    // Update cart count
                    const cartCount = document.querySelector('.cart-count');
                    cartCount.textContent = parseInt(cartCount.textContent) + 1;
                    
                    // Visual feedback
                    this.innerHTML = '<i class="fas fa-check"></i> Added';
                    this.style.backgroundColor = '#4CAF50';
                    
                    setTimeout(() => {
                        this.innerHTML = '<i class="fas fa-plus"></i> Add to Cart';
                        this.style.backgroundColor = '';
                    }, 2000);
                    
                    // In a real app, you would add to cart via AJAX
                    console.log(`Added ${wineName} (${winePrice}) to cart`);
                });
            });
        });
    </script>
</body>
</html>