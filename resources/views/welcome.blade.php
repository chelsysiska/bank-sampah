<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TRASH2CASH</title>
    <link rel="icon" type="image/x-icon" href="/path/to/your/favicon.ico">
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
            background: linear-gradient(to bottom, #f0f9ff 0%, #ffffff 100%);
            color: #334155;
            overflow-x: hidden;
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            color: #0f766e;
            padding: 1.2rem 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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
            gap: 2rem;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #14b8a6, #06b6d4);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            box-shadow: 0 4px 15px rgba(20, 184, 166, 0.3);
        }
        
        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .nav {
            display: flex;
            gap: 2.5rem;
            align-items: center;
        }
        
        .nav a {
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            padding: 0.5rem 0;
            transition: all 0.3s ease;
        }
        
        .nav a:hover {
            color: #0f766e;
        }
        
        .nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #14b8a6, #06b6d4);
            transition: width 0.3s ease;
            border-radius: 2px;
        }
        
        .nav a:hover::after {
            width: 100%;
        }

        /* Auth Buttons */
        .auth-buttons {
            display: flex;
            gap: 1rem;
        }
        
        .btn-login {
            padding: 0.7rem 2rem;
            background: white;
            color: #0f766e;
            border: 2px solid #14b8a6;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .btn-login:hover {
            background: #f0fdfa;
            border-color: #0f766e;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(20, 184, 166, 0.2);
        }
        
        .btn-register {
            padding: 0.7rem 2rem;
            background: linear-gradient(135deg, #14b8a6, #06b6d4);
            color: white;
            border: 2px solid transparent;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            box-shadow: 0 4px 15px rgba(20, 184, 166, 0.3);
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(20, 184, 166, 0.4);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #0f766e 0%, #14b8a6 50%, #06b6d4 100%);
            padding: 6rem 0;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-30px); }
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero h2 {
            font-size: 3.2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .hero p {
            font-size: 1.3rem;
            max-width: 700px;
            margin: 0 auto 2.5rem;
            line-height: 1.8;
            opacity: 0.95;
        }
        
        .cta-button {
            display: inline-block;
            padding: 1.1rem 3.5rem;
            background: white;
            color: #0f766e;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }
        
        .cta-button:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            background: #f0fdfa;
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
            font-size: 2.8rem;
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }
        
        .section-subtitle {
            text-align: center;
            color: #64748b;
            font-size: 1.15rem;
            margin-bottom: 3.5rem;
        }
        
        .content-box {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            border: 1px solid rgba(20, 184, 166, 0.1);
        }
        
        h3 {
            color: #0f766e;
            margin-bottom: 1.2rem;
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }
        
        p {
            line-height: 1.9;
            color: #475569;
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
            padding: 2.8rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(20, 184, 166, 0.1);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #14b8a6, #06b6d4);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .card:hover::before {
            transform: scaleX(1);
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 45px rgba(20, 184, 166, 0.2);
        }
        
        .card-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ccfbf1, #a5f3fc);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            margin: 0 auto 1.5rem;
            transition: all 0.4s ease;
            box-shadow: 0 4px 15px rgba(20, 184, 166, 0.2);
        }
        
        .card:hover .card-icon {
            transform: scale(1.15) rotate(10deg);
            box-shadow: 0 8px 25px rgba(20, 184, 166, 0.3);
        }
        
        .card h3 {
            color: #0f766e;
            font-size: 1.35rem;
            margin-bottom: 1rem;
            justify-content: center;
        }
        
        .card p {
            color: #64748b;
            font-size: 1rem;
            line-height: 1.8;
        }

        /* Info Box */
        .info-box {
            background: linear-gradient(135deg, #ecfeff, #cffafe);
            padding: 2.5rem;
            border-radius: 16px;
            margin: 2rem 0;
            border-left: 5px solid #14b8a6;
            box-shadow: 0 4px 15px rgba(20, 184, 166, 0.1);
        }
        
        .info-box p {
            margin: 0;
            line-height: 2.2;
            color: #0f766e;
        }
        
        .info-box strong {
            color: #0e7490;
            font-weight: 600;
        }

        /* List Styling */
        .list-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.2rem;
            margin: 2rem 0;
        }
        
        .list-item {
            padding: 1.4rem 1.8rem;
            background: white;
            border-radius: 14px;
            border-left: 4px solid #14b8a6;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #475569;
        }
        
        .list-item:hover {
            background: linear-gradient(135deg, #ecfeff, #ffffff);
            transform: translateX(8px);
            box-shadow: 0 6px 20px rgba(20, 184, 166, 0.15);
        }
        
        .list-item::before {
            content: '✓';
            color: white;
            background: linear-gradient(135deg, #14b8a6, #06b6d4);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            flex-shrink: 0;
            box-shadow: 0 2px 10px rgba(20, 184, 166, 0.3);
        }

        /* Stats Section */
        .stats {
            background: linear-gradient(135deg, #0f766e, #14b8a6, #06b6d4);
            padding: 5rem 0;
            margin: 5rem 0;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stats::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            text-align: center;
            position: relative;
            z-index: 1;
        }
        
        .stat-item h4 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .stat-item p {
            font-size: 1.15rem;
            opacity: 0.95;
            color: white;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #cbd5e1;
            padding: 3rem 0 1.5rem;
            margin-top: 5rem;
        }
        
        .footer-content {
            text-align: center;
        }
        
        .footer p {
            margin: 0.5rem 0;
            color: #cbd5e1;
        }
        
        .footer .version {
            color: #64748b;
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
                font-size: 2.2rem;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .section-title h2 {
                font-size: 2.2rem;
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
                <a href="#home">Beranda</a>
                <a href="#about">Tentang Kami</a>
                <a href="#profile">Profil</a>
            </nav>
            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="btn-login">Log in</a>
                <a href="{{ route('register') }}" class="btn-register">Register</a>
            </div>
        </div>
    </header>

    <section id="home" class="hero">
        <div class="container hero-content">
            <h2>Wujudkan Lingkungan Bersih & Berkelanjutan</h2>
            <p>Platform inovatif untuk mengelola sampah dengan cara modern. Tukarkan sampah Anda menjadi nilai ekonomi dan bantu selamatkan bumi!</p>
            <a href="{{ route('login') }}" class="cta-button">Mulai Sekarang →</a>
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
                        <strong>Lokasi Pusat:</strong> Jl. Cilosari Dalam RT 04 RW 06, Kemijen, Semarang Timur<br />
                        <strong>Jam Operasional:</strong> Senin - Jumat, 08:00 - 15:00 WIB<br />
                        <strong>Kontak:</strong> (021) 9872345610 <br>
                        <strong>Email :</strong> trash2cash@gmail.com
                    </p>
                </div>

                <h3>♻️ Jenis Sampah yang Diterima</h3>
                <div class="list-container">
                    <div class="list-item">Kertas (Kardus, HVS, Majalah)</div>
                    <div class="list-item">Plastik (PET, HDPE, PP)</div>
                    <div class="list-item">Logam (Besi, Kaleng Aluminium)</div>
                    <div class="list-item">Minyak Jelantah (Kemasan tertutup)</div>
                </div>

                <p style="text-align: center; margin-top: 2rem; font-style: italic; color: #0f766e; font-size: 1.05rem;">
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
        </footer>
</body>
</html>