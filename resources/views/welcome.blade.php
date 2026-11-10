
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MeUI Labs - Digital Creative Agency</title>

    <meta name="description" content="MeUI Labs menyediakan layanan web development, UI/UX design, dan creative digital untuk mengembangkan ide menjadi solusi digital.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #101d38;
            --navy-light: #1c3155;
            --blue: #4169a1;
            --white: #ffffff;
            --bg: #f6f8fc;
            --text: #26334a;
            --muted: #77839a;
            --border: #e7ebf2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--white);
            color: var(--text);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button {
            font-family: inherit;
        }

        .container {
            width: 90%;
            max-width: 1180px;
            margin: auto;
        }

        /* NAVBAR */

        .navbar {
            height: 82px;
            display: flex;
            align-items: center;
            background: rgba(255,255,255,.96);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--border);
        }

        .nav-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 23px;
            font-weight: 800;
            color: var(--navy);
            letter-spacing: -1px;
        }

        .logo span {
            color: #6288bd;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .nav-links a {
            font-size: 13px;
            font-weight: 600;
            color: #637087;
            transition: .3s;
        }

        .nav-links a:hover {
            color: var(--blue);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn {
            padding: 12px 21px;
            border-radius: 7px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            transition: .3s;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: var(--navy);
            color: white;
        }

        .btn-primary:hover {
            background: #29446f;
            transform: translateY(-2px);
        }

        .btn-outline {
            border-color: #dce2ec;
            color: var(--navy);
            background: white;
        }

        .btn-outline:hover {
            border-color: var(--navy);
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 25px;
            color: var(--navy);
            cursor: pointer;
        }

        /* HERO */

        .hero {
            background:
                radial-gradient(circle at 85% 20%, rgba(103,145,201,.22), transparent 28%),
                linear-gradient(130deg, #101d38, #1b3154 65%, #294b77);
            color: white;
            padding: 105px 0 110px;
            overflow: hidden;
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            align-items: center;
            gap: 65px;
        }

        .hero-label {
            display: inline-block;
            padding: 9px 15px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.16);
            border-radius: 30px;
            font-size: 11px;
            letter-spacing: 1px;
            margin-bottom: 25px;
            color: #c9d9f2;
        }

        .hero h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(36px, 5vw, 58px);
            line-height: 1.16;
            letter-spacing: -2px;
            margin-bottom: 23px;
        }

        .hero h1 span {
            color: #91b9ef;
        }

        .hero-description {
            color: #c5d0e2;
            font-size: 15px;
            line-height: 1.9;
            max-width: 510px;
            margin-bottom: 32px;
        }

        .hero-buttons {
            display: flex;
            gap: 13px;
            flex-wrap: wrap;
        }

        .hero .btn-primary {
            background: white;
            color: var(--navy);
        }

        .hero .btn-outline {
            color: white;
            border-color: rgba(255,255,255,.35);
            background: transparent;
        }

        .hero-visual {
            position: relative;
            min-height: 350px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .visual-card {
            width: 100%;
            max-width: 430px;
            background: rgba(255,255,255,.09);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 20px;
            padding: 25px;
            transform: rotate(-3deg);
            box-shadow: 0 30px 70px rgba(0,0,0,.2);
        }

        .visual-top {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .visual-dots {
            display: flex;
            gap: 6px;
        }

        .visual-dots span {
            width: 8px;
            height: 8px;
            background: #a6c4ed;
            border-radius: 50%;
        }

        .visual-label {
            color: #c4d7f1;
            font-size: 11px;
        }

        .visual-heading {
            font-size: 21px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .visual-subtitle {
            font-size: 11px;
            color: #bdcce0;
            margin-bottom: 23px;
        }

        .visual-boxes {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .visual-box {
            min-height: 105px;
            border-radius: 12px;
            padding: 16px;
            background: rgba(255,255,255,.12);
        }

        .visual-box strong {
            display: block;
            font-size: 23px;
            margin-bottom: 7px;
        }

        .visual-box small {
            font-size: 10px;
            color: #d0def0;
        }

        .visual-bottom {
            height: 9px;
            border-radius: 20px;
            background: rgba(255,255,255,.13);
            margin-top: 16px;
            overflow: hidden;
        }

        .visual-bottom div {
            height: 100%;
            width: 75%;
            background: #91b9ef;
            border-radius: 20px;
        }

        /* TRUST BAR */

        .trust {
            padding: 30px 0;
            border-bottom: 1px solid var(--border);
        }

        .trust-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
            flex-wrap: wrap;
            text-align: center;
        }

        .trust-item {
            color: #78859b;
            font-size: 12px;
            font-weight: 600;
        }

        .trust-item span {
            color: var(--navy);
            font-size: 19px;
            margin-right: 7px;
        }

        /* GENERAL SECTION */

        .section {
            padding: 95px 0;
        }

        .section-heading {
            text-align: center;
            max-width: 620px;
            margin: 0 auto 48px;
        }

        .section-tag {
            color: #547caf;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 13px;
        }

        .section-heading h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--navy);
            font-size: 34px;
            letter-spacing: -1px;
            margin-bottom: 14px;
        }

        .section-heading p {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.8;
        }

        /* SERVICES */

        .services-section {
            background: var(--bg);
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .service-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 28px;
            transition: .3s;
        }

        .service-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 15px 35px rgba(16,29,56,.08);
            border-color: #b9cce5;
        }

        .service-icon {
            width: 52px;
            height: 52px;
            background: #edf3fb;
            color: var(--navy);
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 12px;
            font-size: 24px;
            margin-bottom: 22px;
        }

        .service-card h3 {
            color: var(--navy);
            font-size: 17px;
            margin-bottom: 12px;
        }

        .service-card p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
            margin-bottom: 22px;
        }

        .service-link {
            font-size: 12px;
            font-weight: 700;
            color: #41699f;
        }

        .empty-data {
            grid-column: 1 / -1;
            padding: 35px;
            text-align: center;
            color: var(--muted);
            background: white;
            border-radius: 12px;
        }

        /* ABOUT */

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 75px;
        }

        .about-visual {
            background: linear-gradient(145deg, #e9f0fa, #d4e1f3);
            min-height: 370px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .about-visual-inner {
            width: 78%;
            padding: 35px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 45px rgba(16,29,56,.12);
        }

        .about-visual-inner .logo {
            font-size: 27px;
        }

        .about-visual-inner h3 {
            margin-top: 30px;
            color: var(--navy);
            font-size: 22px;
            line-height: 1.4;
        }

        .about-visual-inner p {
            color: var(--muted);
            font-size: 12px;
            margin-top: 12px;
            line-height: 1.7;
        }

        .about-text .section-tag {
            text-align: left;
        }

        .about-text h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--navy);
            font-size: 35px;
            line-height: 1.3;
            margin-bottom: 20px;
        }

        .about-text > p {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.9;
            margin-bottom: 25px;
        }

        .about-points {
            display: grid;
            gap: 15px;
        }

        .about-point {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            font-size: 13px;
            font-weight: 600;
            color: var(--navy);
        }

        .check {
            color: #416da8;
            font-size: 17px;
        }

        /* PORTFOLIO */

        .portfolio-section {
            background: var(--bg);
        }

        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        .portfolio-card {
            background: white;
            border-radius: 13px;
            overflow: hidden;
            border: 1px solid var(--border);
            transition: .3s;
        }

        .portfolio-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(16,29,56,.08);
        }

        .portfolio-image {
            height: 210px;
            background: linear-gradient(135deg, #dce8f7, #aebfda);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .portfolio-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .portfolio-placeholder {
            font-size: 38px;
            color: #37577f;
        }

        .portfolio-info {
            padding: 22px;
        }

        .portfolio-category {
            font-size: 10px;
            color: #5278a8;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .portfolio-info h3 {
            color: var(--navy);
            font-size: 16px;
            margin: 10px 0;
        }

        .portfolio-info p {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.7;
            margin-bottom: 17px;
        }

        /* WHY US */

        .why-section {
            background: var(--navy);
            color: white;
        }

        .why-section .section-heading h2 {
            color: white;
        }

        .why-section .section-heading p {
            color: #bdcce0;
        }

        .why-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .why-card {
            padding: 28px;
            border: 1px solid rgba(255,255,255,.15);
            background: rgba(255,255,255,.05);
            border-radius: 12px;
        }

        .why-card span {
            font-size: 26px;
        }

        .why-card h3 {
            margin: 18px 0 10px;
            font-size: 16px;
        }

        .why-card p {
            font-size: 12px;
            color: #bdcce0;
            line-height: 1.8;
        }

        /* FAQ */

        .faq-container {
            max-width: 800px;
            margin: auto;
        }

        .faq-item {
            border-bottom: 1px solid var(--border);
        }

        .faq-question {
            width: 100%;
            background: white;
            border: none;
            padding: 22px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: left;
            cursor: pointer;
            color: var(--navy);
            font-size: 14px;
            font-weight: 700;
        }

        .faq-icon {
            font-size: 21px;
            color: #547caf;
        }

        .faq-answer {
            display: none;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.9;
            padding: 0 25px 20px 0;
        }

        .faq-item.active .faq-answer {
            display: block;
        }

        /* CTA */

        .cta {
            padding: 70px 0;
            background: #edf3fa;
        }

        .cta-content {
            text-align: center;
            max-width: 650px;
            margin: auto;
        }

        .cta h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 34px;
            color: var(--navy);
            margin-bottom: 15px;
        }

        .cta p {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.8;
            margin-bottom: 25px;
        }

        /* FOOTER */

        footer {
            background: #0b1529;
            color: white;
            padding: 55px 0 25px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            gap: 45px;
            margin-bottom: 45px;
        }

        footer .logo {
            color: white;
            margin-bottom: 15px;
            display: inline-block;
        }

        .footer-description {
            color: #aab8cd;
            font-size: 12px;
            line-height: 1.9;
            max-width: 330px;
        }

        .footer-column h4 {
            font-size: 14px;
            margin-bottom: 18px;
        }

        .footer-column a {
            display: block;
            color: #aab8cd;
            font-size: 12px;
            margin-bottom: 13px;
            transition: .3s;
        }

        .footer-column a:hover {
            color: white;
        }

        .footer-bottom {
            padding-top: 23px;
            border-top: 1px solid rgba(255,255,255,.12);
            color: #8d9bb1;
            text-align: center;
            font-size: 11px;
        }

        /* RESPONSIVE */

        @media (max-width: 900px) {
            .nav-links {
                gap: 15px;
            }

            .hero-content,
            .about-content {
                gap: 35px;
            }

            .service-grid,
            .portfolio-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 700px) {
            .navbar {
                height: 70px;
            }

            .menu-toggle {
                display: block;
            }

            .nav-content {
                position: relative;
            }

            .nav-links {
                display: none;
                position: absolute;
                top: 55px;
                left: 0;
                right: 0;
                background: white;
                padding: 22px;
                border: 1px solid var(--border);
                border-radius: 10px;
                flex-direction: column;
                align-items: flex-start;
                box-shadow: 0 15px 30px rgba(0,0,0,.08);
            }

            .nav-links.active {
                display: flex;
            }

            .nav-actions {
                display: none;
            }

            .hero {
                padding: 75px 0;
            }

            .hero-content,
            .about-content {
                grid-template-columns: 1fr;
            }

            .hero-visual {
                min-height: 300px;
            }

            .hero h1 {
                font-size: 39px;
            }

            .section {
                padding: 70px 0;
            }

            .section-heading h2,
            .about-text h2,
            .cta h2 {
                font-size: 28px;
            }

            .service-grid,
            .portfolio-grid,
            .why-grid {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

            .footer-grid > div:first-child {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 420px) {
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .footer-grid > div:first-child {
                grid-column: auto;
            }

            .hero h1 {
                font-size: 34px;
            }
        }
    </style>
</head>

<body>

@php
    $orderUrl = route('login');

    if (auth()->check()) {
        if (auth()->user()->role == 'customer' || auth()->user()->role == 'admin') {
            $orderUrl = route('customer.orders.create');
        } elseif (auth()->user()->role == 'designer') {
            $orderUrl = route('orders.index');
        }
    }

    $dashboardUrl = route('login');

    if (auth()->check()) {
        $role = auth()->user()->role;

        if ($role == 'admin') {
            $dashboardUrl = route('admin.dashboard');
        } elseif ($role == 'designer') {
            $dashboardUrl = route('designer.dashboard');
        } elseif ($role == 'customer') {
            $dashboardUrl = route('customer.dashboard');
        }
    }
@endphp

<!-- NAVBAR -->
<nav class="navbar">
    <div class="container nav-content">

        <a href="{{ route('home') }}" class="logo">
            MeUI<span>Labs.</span>
        </a>

        <button class="menu-toggle" id="menuToggle" aria-label="Buka menu">
            ☰
        </button>

        <div class="nav-links" id="navLinks">
            <a href="#home">Home</a>
            <a href="#services">Layanan</a>
            <a href="#about">Tentang Kami</a>
            <a href="#portfolio">Portfolio</a>
            <a href="#faq">FAQ</a>
        </div>

        <div class="nav-actions">
            @auth
                <a href="{{ $dashboardUrl }}" class="btn btn-outline">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline">
                    Login
                </a>
            @endauth

            <a href="{{ $orderUrl }}" class="btn btn-primary">
                Mulai Pesanan
            </a>
        </div>

    </div>
</nav>


<!-- HERO -->
<section class="hero" id="home">
    <div class="container hero-content">

        <div>
            <span class="hero-label">
                CREATIVE DIGITAL SOLUTIONS
            </span>

            <h1>
                Transform Your Ideas Into <span>Digital Reality.</span>
            </h1>

            <p class="hero-description">
                Selamat datang di MeUI Labs. Kami membantu mewujudkan
                ide kreatif menjadi solusi digital melalui pengembangan
                website, desain antarmuka, dan layanan kreatif lainnya.
            </p>

            <div class="hero-buttons">
                <a href="{{ $orderUrl }}" class="btn btn-primary">
                    Mulai Project
                </a>

                <a href="#portfolio" class="btn btn-outline">
                    Jelajahi Portfolio
                </a>
            </div>
        </div>

        <div class="hero-visual">
            <div class="visual-card">

                <div class="visual-top">
                    <div class="visual-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <div class="visual-label">MEUI CREATIVE SPACE</div>
                </div>

                <div class="visual-heading">
                    Let's Create Something Great.
                </div>

                <div class="visual-subtitle">
                    Creative ideas. Digital solutions.
                </div>

                <div class="visual-boxes">
                    <div class="visual-box">
                        <strong>01</strong>
                        <small>Web Development</small>
                    </div>

                    <div class="visual-box">
                        <strong>02</strong>
                        <small>UI/UX Design</small>
                    </div>

                    <div class="visual-box">
                        <strong>03</strong>
                        <small>Creative Design</small>
                    </div>

                    <div class="visual-box">
                        <strong>04</strong>
                        <small>Digital Solutions</small>
                    </div>
                </div>

                <div class="visual-bottom">
                    <div></div>
                </div>

            </div>
        </div>

    </div>
</section>


<!-- TRUST BAR -->
<section class="trust">
    <div class="container trust-content">

        <div class="trust-item">
            <span>✦</span> Creative Ideas
        </div>

        <div class="trust-item">
            <span>⌘</span> Digital Innovation
        </div>

        <div class="trust-item">
            <span>◈</span> Modern Design
        </div>

        <div class="trust-item">
            <span>✓</span> Quality Solutions
        </div>

    </div>
</section>


<!-- SERVICES -->
<section class="section services-section" id="services">
    <div class="container">

        <div class="section-heading">
            <div class="section-tag">OUR SERVICES</div>

            <h2>Solusi Digital untuk Setiap Ide</h2>

            <p>
                Temukan layanan yang sesuai dengan kebutuhanmu.
                Kami siap membantu mengembangkan ide menjadi karya digital.
            </p>
        </div>

        <div class="service-grid">

            @forelse($services as $service)

                <div class="service-card">

                    <div class="service-icon">
                        ✦
                    </div>

                    <h3>{{ $service->nama_jasa }}</h3>

                    <p>
                        {{ $service->deskripsi ?? 'Layanan kreatif dan solusi digital untuk membantu mewujudkan kebutuhan project kamu.' }}
                    </p>

                    <a href="{{ route('services.show', $service->id) }}"
                       class="service-link">
                        Lihat Detail
                    </a>

                </div>

            @empty

                <div class="empty-data">
                    Belum ada layanan aktif yang tersedia.
                </div>

            @endforelse

        </div>

    </div>
</section>


<!-- ABOUT -->
<section class="section" id="about">
    <div class="container about-content">

        <div class="about-visual">

            <div class="about-visual-inner">

                <div class="logo">
                    MeUI<span>Labs.</span>
                </div>

                <h3>
                    Ideas Start Here.<br>
                    Innovation Happens Here.
                </h3>

                <p>
                    We believe every great digital product begins
                    with a great idea.
                </p>

            </div>

        </div>

        <div class="about-text">

            <div class="section-tag">ABOUT MEUI LABS</div>

            <h2>
                Mengenal Lebih Dekat MeUI Labs
            </h2>

            <p>
                MeUI Labs merupakan platform layanan kreatif digital
                yang berfokus pada pengembangan website, desain UI/UX,
                serta kebutuhan desain kreatif lainnya.
            </p>

            <p>
                Kami percaya bahwa setiap ide memiliki potensi untuk
                berkembang menjadi sesuatu yang luar biasa.
                Melalui proses kreatif dan teknologi, kami membantu
                menghadirkan solusi digital yang fungsional dan menarik.
            </p>

            <div class="about-points">

                <div class="about-point">
                    <span class="check">✓</span>
                    Solusi sesuai kebutuhan project.
                </div>

                <div class="about-point">
                    <span class="check">✓</span>
                    Desain modern dan fungsional.
                </div>

                <div class="about-point">
                    <span class="check">✓</span>
                    Proses pengerjaan yang terorganisir.
                </div>

            </div>

        </div>

    </div>
</section>


<!-- PORTFOLIO -->
<section class="section portfolio-section" id="portfolio">

    <div class="container">

        <div class="section-heading">
            <div class="section-tag">OUR PORTFOLIO</div>

            <h2>Karya yang Telah Kami Buat</h2>

            <p>
                Jelajahi berbagai karya dan project yang menjadi
                bagian dari perjalanan kreatif MeUI Labs.
            </p>
        </div>

        <div class="portfolio-grid">

            @forelse($portfolios as $portfolio)

                <a href="{{ route('portfolios.show', $portfolio->id) }}"
                   class="portfolio-card">

                    <div class="portfolio-image">

                        @if(!empty($portfolio->gambar))
                            <img
                                src="{{ asset($portfolio->gambar) }}"
                                alt="{{ $portfolio->judul }}"
                                loading="lazy"
                            >
                        @else
                            <div class="portfolio-placeholder">
                                ◈
                            </div>
                        @endif

                    </div>

                    <div class="portfolio-info">

                        <span class="portfolio-category">
                            {{ $portfolio->kategori }}
                        </span>

                        <h3>{{ $portfolio->judul }}</h3>

                        <p>
                            {{ \Illuminate\Support\Str::limit($portfolio->deskripsi, 105) }}
                        </p>

                        <span class="service-link">
                            Lihat Project
                        </span>

                    </div>

                </a>

            @empty

                <div class="empty-data">
                    Belum ada portfolio yang ditampilkan.
                </div>

            @endforelse

        </div>

    </div>

</section>


<!-- WHY CHOOSE US -->
<section class="section why-section">

    <div class="container">

        <div class="section-heading">
            <div class="section-tag">WHY CHOOSE US</div>

            <h2>Mengapa Memilih MeUI Labs?</h2>

            <p>
                Kami mengutamakan kualitas, kreativitas, dan
                pengalaman yang baik dalam setiap project.
            </p>
        </div>

        <div class="why-grid">

            <div class="why-card">
                <span>✧</span>
                <h3>Creative Approach</h3>
                <p>
                    Mengembangkan ide dengan pendekatan kreatif
                    untuk menghasilkan solusi yang menarik.
                </p>
            </div>

            <div class="why-card">
                <span>⌘</span>
                <h3>Modern Technology</h3>
                <p>
                    Memanfaatkan teknologi digital untuk
                    membangun produk yang fungsional.
                </p>
            </div>

            <div class="why-card">
                <span>◈</span>
                <h3>User Focused</h3>
                <p>
                    Mengutamakan kebutuhan pengguna dalam
                    setiap proses perancangan dan pengembangan.
                </p>
            </div>

        </div>

    </div>

</section>


<!-- FAQ -->
<section class="section" id="faq">

    <div class="container">

        <div class="section-heading">
            <div class="section-tag">FREQUENTLY ASKED QUESTIONS</div>

            <h2>Pertanyaan yang Sering Ditanyakan</h2>

            <p>
                Beberapa informasi yang mungkin ingin kamu ketahui
                sebelum memulai project bersama MeUI Labs.
            </p>
        </div>

        <div class="faq-container">

            <div class="faq-item">
                <button class="faq-question">
                    Apa saja layanan yang tersedia di MeUI Labs?
                    <span class="faq-icon">+</span>
                </button>

                <div class="faq-answer">
                    MeUI Labs menyediakan berbagai layanan kreatif digital
                    seperti web development, UI/UX design, dan desain kreatif
                    sesuai layanan yang tersedia di katalog.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    Bagaimana cara memesan layanan?
                    <span class="faq-icon">+</span>
                </button>

                <div class="faq-answer">
                    Kamu dapat membuat akun, login, memilih layanan,
                    kemudian mengisi formulir pemesanan yang tersedia.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    Apakah saya bisa memantau project?
                    <span class="faq-icon">+</span>
                </button>

                <div class="faq-answer">
                    Ya. Setelah project dibuat, customer dapat memantau
                    informasi dan perkembangan project melalui dashboard.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">
                    Bagaimana mengetahui status pesanan?
                    <span class="faq-icon">+</span>
                </button>

                <div class="faq-answer">
                    Status pesanan dapat dilihat melalui halaman
                    pesanan pada akun masing-masing.
                </div>
            </div>

        </div>

    </div>

</section>


<!-- CTA -->
<section class="cta">

    <div class="container cta-content">

        <h2>Ready to Build Something Great?</h2>

        <p>
            Punya ide atau project yang ingin diwujudkan?
            Mari mulai perjalanan kreatifmu bersama MeUI Labs.
        </p>

        <a href="{{ $orderUrl }}" class="btn btn-primary">
            Mulai Project Sekarang
        </a>

    </div>

</section>


<!-- FOOTER -->
<footer>

    <div class="container">

        <div class="footer-grid">

            <div>
                <a href="{{ route('home') }}" class="logo">
                    MeUI<span>Labs.</span>
                </a>

                <p class="footer-description">
                    Creative digital solutions for your next big idea.
                    Mengubah ide menjadi solusi digital yang kreatif,
                    modern, dan fungsional.
                </p>
            </div>

            <div class="footer-column">
                <h4>Navigasi</h4>

                <a href="#home">Home</a>
                <a href="#services">Layanan</a>
                <a href="#about">Tentang Kami</a>
                <a href="#portfolio">Portfolio</a>
            </div>

            <div class="footer-column">
                <h4>Akun</h4>

                <a href="{{ route('login') }}">Login</a>
                <a href="{{ $orderUrl }}">Mulai Pesanan</a>
                <a href="{{ $dashboardUrl }}">Dashboard</a>
            </div>

        </div>

        <div class="footer-bottom">
            © {{ date('Y') }} MeUI Labs. All Rights Reserved.
        </div>

    </div>

</footer>


<!-- JAVASCRIPT -->
<script>

    // Mobile navigation
    const menuToggle = document.getElementById('menuToggle');
    const navLinks = document.getElementById('navLinks');

    menuToggle.addEventListener('click', function () {
        navLinks.classList.toggle('active');

        menuToggle.innerHTML =
            navLinks.classList.contains('active') ? '✕' : '☰';
    });

    // Close mobile menu after clicking a link
    document.querySelectorAll('.nav-links a').forEach(function(link) {
        link.addEventListener('click', function() {
            navLinks.classList.remove('active');
            menuToggle.innerHTML = '☰';
        });
    });

    // FAQ accordion
    document.querySelectorAll('.faq-question').forEach(function(button) {

        button.addEventListener('click', function() {

            const item = button.parentElement;
            const isActive = item.classList.contains('active');

            document.querySelectorAll('.faq-item').forEach(function(faq) {
                faq.classList.remove('active');
                faq.querySelector('.faq-icon').textContent = '+';
            });

            if (!isActive) {
                item.classList.add('active');
                button.querySelector('.faq-icon').textContent = '−';
            }

        });

    });

</script>

</body>
</html>
