<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bank Sampah Digital - Beranda</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <style>
        *, ::after, ::before {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        html {
            scroll-behavior: smooth;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f8faf9;
            color: #2c3e50;
            overflow-x: hidden;
        }

        /* Header */
        .header {
            background: white;
            color: #2e7d32;
            padding: 1.2rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        
        .logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #4CAF50, #66bb6a);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2e7d32;
        }
        
        .nav {
            display: flex;
            gap: 2.5rem;
            align-items: center;
        }
        
        .nav a {
            color: #555;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            padding: 0.5rem 0;
            transition: color 0.3s ease;
        }
        
        .nav a:hover {
            color: #2e7d32;
        }
        
        .nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #4CAF50;
            transition: width 0.3s ease;
        }
        
        .nav a:hover::after {
            width: 100%;
        }

        /* Auth Buttons */
        .auth-buttons {
            display: flex;
            gap: 1rem;
            margin-left: 2rem;
        }
        
        .btn-login {
            padding: 0.6rem 1.8rem;
            background: white;
            color: #2e7d32;
            border: 2px solid #2e7d32;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .btn-login:hover {
            background: #2e7d32;
            color: white;
        }
        
        .btn-register {
            padding: 0.6rem 1.8rem;
            background: #4CAF50;
            color: white;
            border: 2px solid #4CAF50;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .btn-register:hover {
            background: #388e3c;
            border-color: #388e3c;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #4CAF50 0%, #66bb6a 100%);
            padding: 5rem 0;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"><path fill="rgba(255,255,255,0.1)" d="M0,40 Q300,80 600,40 T1200,40 L1200,0 L0,0 Z"/></svg>') repeat-x;
            opacity: 0.3;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero h2 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        
        .hero p {
            font-size: 1.25rem;
            max-width: 700px;
            margin: 0 auto 2.5rem;
            line-height: 1.7;
            opacity: 0.95;
        }
        
        .cta-button {
            display: inline-block;
            padding: 1rem 3rem;
            background: white;
            color: #2e7d32;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }
        
        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.25);
        }

        /* Section */
        .section {
            padding: 5rem 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            color: #2e7d32;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }
        
        .section-subtitle {
            text-align: center;
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }
        
        .content-box {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            margin-bottom: 2rem;
        }
        
        h3 {
            color: #2e7d32;
            margin-bottom: 1rem;
            font-size: 1.4rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        p {
            line-height: 1.8;
            color: #555;
            margin-bottom: 1.5rem;
        }

        /* Grid Cards */
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .card {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(76, 175, 80, 0.15);
            border-color: #4CAF50;
        }
        
        .card-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .card:hover .card-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        .card h3 {
            color: #2e7d32;
            font-size: 1.3rem;
            margin-bottom: 1rem;
            justify-content: center;
        }
        
        .card p {
            color: #666;
            font-size: 1rem;
            line-height: 1.7;
        }

        /* Info Box */
        .info-box {
            background: linear-gradient(135deg, #f1f8f4, #e8f5e9);
            padding: 2rem;
            border-radius: 12px;
            margin: 2rem 0;
            border-left: 4px solid #4CAF50;
        }
        
        .info-box p {
            margin: 0;
            line-height: 2;
        }
        
        .info-box strong {
            color: #1b5e20;
            font-weight: 600;
        }

        /* List Styling */
        .list-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }
        
        .list-item {
            padding: 1.2rem 1.5rem;
            background: white;
            border-radius: 10px;
            border-left: 4px solid #4CAF50;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .list-item:hover {
            background: #f1f8f4;
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .list-item::before {
            content: '✓';
            color: white;
            background: #4CAF50;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            flex-shrink: 0;
        }

        /* Stats Section */
        .stats {
            background: linear-gradient(135deg, #2e7d32, #4CAF50);
            padding: 4rem 0;
            margin: 4rem 0;
            color: white;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            text-align: center;
        }
        
        .stat-item h4 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stat-item p {
            font-size: 1.1rem;
            opacity: 0.9;
            color: white;
        }

        /* Footer */
        .footer {
            background: #1a1a1a;
            color: #ccc;
            padding: 3rem 0 1.5rem;
            margin-top: 5rem;
        }
        
        .footer-content {
            text-align: center;
        }
        
        .footer p {
            margin: 0.5rem 0;
            color: #ccc;
        }
        
        .footer .version {
            color: #666;
            font-size: 0.85rem;
            margin-top: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            
            .nav {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .auth-buttons {
                margin-left: 0;
                margin-top: 1rem;
            }
            
            .hero h2 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
            
            .grid-3 {
                grid-template-columns: 1fr;
            }
            
            .list-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container header-content">
            <div class="logo">
                <div class="logo-icon">♻️</div>
                <h1>Bank Sampah Digital</h1>
            </div>
            <nav class="nav">
                <a href="home">Beranda</a>
                <a href="about">Tentang Kami</a>
                <a href="profile">Profil</a>
                <div class="auth-buttons">
                    <a href="{{ route('login') }}" class="btn-login">Log in</a>
                    <a href="{{ route('register') }}" class="btn-register">Register</a>
                </div>
            </nav>
        </div>
    </header>

    <section id="home" class="hero">
        <div class="container hero-content">
            <h2>Wujudkan Lingkungan Bersih & Berkelanjutan</h2>
            <p>Platform inovatif untuk mengelola sampah dengan cara modern. Tukarkan sampah Anda menjadi nilai ekonomi dan bantu selamatkan bumi!</p>
            <a href="home" class="cta-button">Mulai Sekarang →</a>
        </div>
    </section>

    <main class="container">
        <section id="about" class="section">
            <div class="section-title">
                <h2>Tentang Kami</h2>
                <p class="section-subtitle">Solusi Digital untuk Pengelolaan Sampah yang Lebih Baik</p>
            </div>
            
            <div class="content-box">
                <p>Bank Sampah Digital didirikan dengan visi untuk mengatasi masalah sampah perkotaan dengan cara yang modern dan efisien. Kami percaya bahwa setiap individu dapat menjadi agen perubahan. Platform kami memungkinkan masyarakat untuk menukarkan sampah anorganik (seperti plastik, kertas, dan logam) dengan imbalan berupa tabungan atau poin yang dapat dikonversi.</p>
            </div>

            <div class="grid-3">
                <div class="card">
                    <div class="card-icon">🎯</div>
                    <h3>Misi Kami</h3>
                    <p>Meningkatkan kesadaran dan partisipasi masyarakat dalam pemilahan sampah dari sumbernya untuk masa depan yang lebih hijau.</p>
                </div>
                <div class="card">
                    <div class="card-icon">💎</div>
                    <h3>Nilai Inti</h3>
                    <p>Inovasi, Transparansi, dan Komitmen terhadap Kelestarian Lingkungan sebagai fondasi kami.</p>
                </div>
                <div class="card">
                    <div class="card-icon">🌍</div>
                    <h3>Dampak</h3>
                    <p>Mengurangi volume sampah TPA dan menciptakan nilai ekonomi dari limbah untuk kehidupan yang berkelanjutan.</p>
                </div>
            </div>
        </section>

        <section id="profile" class="section">
            <div class="section-title">
                <h2>Profil Bank Sampah Digital</h2>
                <p class="section-subtitle">Informasi Lengkap Layanan Kami</p>
            </div>
            
            <div class="content-box">
                <h3>📍 Informasi Operasional</h3>
                <div class="info-box">
                    <p>
                        <strong>Lokasi Pusat:</strong> Jl. Ekosistem Hijau No. 12, Kota Bersih<br />
                        <strong>Jam Operasional:</strong> Senin - Jumat, 08:00 - 15:00 WIB<br />
                        <strong>Kontak:</strong> (021) 1234-BANK / info@banksampahdigital.com
                    </p>
                </div>

                <h3>♻️ Jenis Sampah yang Diterima</h3>
                <div class="list-container">
                    <div class="list-item">Kertas (Kardus, HVS, Majalah)</div>
                    <div class="list-item">Plastik (PET, HDPE, PP)</div>
                    <div class="list-item">Logam (Besi, Kaleng Aluminium)</div>
                    <div class="list-item">Minyak Jelantah (Kemasan tertutup)</div>
                </div>

                <p style="text-align: center; margin-top: 2rem; font-style: italic; color: #2e7d32; font-size: 1.05rem;">
                    ✨ Sistem pencatatan digital kami memastikan setiap transaksi tercatat dengan akurat dan transparan
                </p>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container footer-content">
            <p>&copy; 2025 Bank Sampah Digital. Semua Hak Dilindungi.</p>
            <p>Bersama Menuju Masa Depan yang Lebih Hijau 🌱</p>
            <p class="version">Didukung oleh Laravel & PHP</p>
        </div>
    </footer>
</body>
</html>