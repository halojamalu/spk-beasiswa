<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Beasiswa - MI Daarul Ishlah Batam</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #059669;
            --secondary-color: #0891b2;
            --accent-color: #eab308;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            background: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--dark-color) !important;
            font-size: 1.5rem;
        }

        .nav-link {
            font-weight: 500;
            margin: 0 0.5rem;
            color: var(--dark-color) !important;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .btn-login {
            background: var(--primary-color);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            border: 2px solid var(--primary-color);
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: white;
            color: var(--primary-color);
        }

        /* Hero Section */
        /* .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        } */
        .hero-section {
            background: url('/img/pexels-pamanjoe-35548842.jpg') no-repeat center center/cover;
            /* background: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover; */
            color: white;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,213.3C672,192,768,128,864,128C960,128,1056,192,1152,197.3C1248,203,1344,149,1392,122.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .hero-subtitle {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .hero-buttons .btn {
            padding: 12px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            margin: 0 10px;
            transition: all 0.3s;
        }

        .btn-hero-primary {
            background: white;
            color: var(--primary-color);
            border: 2px solid white;
        }

        .btn-hero-primary:hover {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-hero-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-hero-outline:hover {
            background: white;
            color: var(--primary-color);
        }

        /* Section Styles */
        section {
            padding: 80px 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #64748b;
            margin-bottom: 3rem;
        }

        /* About Section */
        .about-section {
            background: var(--light-color);
        }

        .about-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            height: 100%;
        }

        .about-icon {
            width: 80px;
            height: 80px;
            /* background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); */
            background: var(--primary-color);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .about-icon i {
            font-size: 2.5rem;
            color: white;
        }

        /* Features Section */
        .feature-card {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s;
            height: 100%;
            border-top: 4px solid var(--primary-color);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: var(--light-color);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .feature-icon i {
            font-size: 2rem;
            color: var(--primary-color);
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        /* Flow Section */
        .flow-section {
            background: var(--light-color);
        }

        .flow-item {
            position: relative;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }

        .flow-number {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 60px;
            background: var(--dark-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .flow-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        /* CTA Section */
        .cta-section {
            background: var(--primary-color) 100%;
            /* background: linear-gradient(135deg, var(--dark-color) 0%, var(--primary-color) 100%); */
            color: white;
            padding: 60px 0;
        }

        /* Footer */
        footer {
            background: var(--dark-color);
            color: white;
            padding: 40px 0 20px;
        }

        .footer-link {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-link:hover {
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .hero-buttons .btn {
                display: block;
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <!-- <i class="fas fa-graduation-cap"></i>  -->
                SPK Beasiswa
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#alur">Alur Kerja</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="btn btn-login" href="{{ route('home') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-login" href="{{ route('login') }}">
                                <!-- <i class="fas fa-sign-in-alt"></i> -->
                                 Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center hero-content mt-5" data-aos="fade-up">
                    <div class="mb-4">
                        <!-- <i class="fas fa-award" style="font-size: 5rem; opacity: 0.9;"></i> -->
                    </div>
                    <h1 class="hero-title">Sistem Pendukung Keputusan<br>Seleksi Penerima Beasiswa</h1>
                    <p class="hero-subtitle">
                        Menggunakan Metode Hibrid Fuzzy-AHP dan MOORA<br>
                        untuk Seleksi yang Objektif, Transparan, dan Akurat
                    </p>
                    <!-- <div class="hero-buttons">
                        @auth
                            <a href="{{ route('home') }}" class="btn btn-hero-primary">
                                <i class="fas fa-tachometer-alt"></i> Masuk Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-hero-primary">
                                <i class="fas fa-sign-in-alt"></i> Login Sistem
                            </a>
                        @endauth
                        <a href="#tentang" class="btn btn-hero-outline">
                            <i class="fas fa-info-circle"></i> Selengkapnya
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="about-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                    <h2 class="section-title">Tentang Sistem</h2>
                    <p class="section-subtitle">
                        Sistem Pendukung Keputusan berbasis web untuk membantu proses seleksi penerima beasiswa
                        di Madrasah Ibtidaiyah Daarul Ishlah Batam
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="about-card">
                        <div class="about-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h4>Fuzzy-AHP (Analytical Hierarchy Process)</h4>
                        <p class="text-muted">
                            Metode untuk menentukan bobot kepentingan setiap kriteria penilaian dengan menangani 
                            ketidakpastian dalam penilaian perbandingan berpasangan menggunakan logika fuzzy.
                        </p>
                        <ul class="text-muted">
                            <li>Menangani subjektivitas penilaian</li>
                            <li>Consistency Ratio (CR) < 0.1</li>
                            <li>Bobot objektif dan terukur</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="about-card">
                        <div class="about-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>MOORA (Multi-Objective Optimization)</h4>
                        <p class="text-muted">
                            Metode untuk meranking alternatif (siswa) berdasarkan nilai kriteria dan bobot yang telah 
                            ditentukan, dengan mempertimbangkan kriteria benefit dan cost secara bersamaan.
                        </p>
                        <ul class="text-muted">
                            <li>Perhitungan sederhana dan cepat</li>
                            <li>Hasil ranking yang objektif</li>
                            <li>Mudah divalidasi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                    <h2 class="section-title">Fitur Utama Sistem</h2>
                    <p class="section-subtitle">
                        Fitur lengkap untuk mendukung proses seleksi beasiswa yang efektif dan efisien
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card text-center">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-database"></i>
                        </div>
                        <h5 class="feature-title">Master Data</h5>
                        <p class="text-muted">
                            Manajemen data kriteria penilaian dan data siswa calon penerima beasiswa dengan interface yang mudah.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card text-center">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <h5 class="feature-title">Fuzzy-AHP</h5>
                        <p class="text-muted">
                            Perhitungan bobot kriteria dengan metode Fuzzy-AHP untuk menangani ketidakpastian penilaian.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card text-center">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-ranking-star"></i>
                        </div>
                        <h5 class="feature-title">MOORA Ranking</h5>
                        <p class="text-muted">
                            Sistem ranking otomatis menggunakan MOORA untuk menentukan siswa yang layak menerima beasiswa.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card text-center">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h5 class="feature-title">Hasil & Laporan</h5>
                        <p class="text-muted">
                            Laporan lengkap hasil perhitungan dan ranking siswa yang dapat dicetak untuk dokumentasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Flow Section -->
    <section id="alur" class="flow-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                    <h2 class="section-title">Alur Kerja Sistem</h2>
                    <p class="section-subtitle">
                        4 Langkah mudah untuk melakukan seleksi penerima beasiswa
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="row g-4">
                        <div class="col-md-6" data-aos="fade-right" data-aos-delay="100">
                            <div class="flow-item text-center">
                                <div class="flow-number">1</div>
                                <div class="flow-icon">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <h5 class="fw-bold">Input Data Master</h5>
                                <p class="text-muted mb-0">
                                    Masukkan data kriteria penilaian (6 kriteria) dan data siswa calon penerima beasiswa.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                            <div class="flow-item text-center">
                                <div class="flow-number">2</div>
                                <div class="flow-icon">
                                    <i class="fas fa-balance-scale"></i>
                                </div>
                                <h5 class="fw-bold">Hitung Bobot (Fuzzy-AHP)</h5>
                                <p class="text-muted mb-0">
                                    Lakukan perbandingan berpasangan kriteria dan sistem akan menghitung bobot secara otomatis.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6" data-aos="fade-right" data-aos-delay="300">
                            <div class="flow-item text-center">
                                <div class="flow-number">3</div>
                                <div class="flow-icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <h5 class="fw-bold">Ranking Siswa (MOORA)</h5>
                                <p class="text-muted mb-0">
                                    Sistem akan meranking siswa berdasarkan nilai kriteria dan bobot yang telah dihitung.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6" data-aos="fade-left" data-aos-delay="400">
                            <div class="flow-item text-center">
                                <div class="flow-number">4</div>
                                <div class="flow-icon">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <h5 class="fw-bold">Hasil & Keputusan</h5>
                                <p class="text-muted mb-0">
                                    Lihat hasil ranking lengkap dengan status (layak/cadangan/tidak layak) dan cetak laporan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <!-- <section class="cta-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
                    <h2 class="mb-4">Siap Menggunakan Sistem?</h2>
                    <p class="lead mb-4">
                        Mulai proses seleksi beasiswa yang objektif dan transparan dengan sistem kami
                    </p>
                    @auth
                        <a href="{{ route('home') }}" class="btn btn-light btn-lg px-5">
                            <i class="fas fa-tachometer-alt"></i> Masuk Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg px-5">
                            <i class="fas fa-sign-in-alt"></i> Login Sekarang
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section> -->

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-graduation-cap"></i> SPK Beasiswa
                    </h5>
                    <p class="text-muted" style="color: white !important;">
                        Sistem Pendukung Keputusan untuk Seleksi Penerima Beasiswa<br>
                        Madrasah Ibtidaiyah Daarul Ishlah Batam
                    </p>
                </div>
                <div class="col-md-3 mb-4">
                    <h6 class="fw-bold mb-3">Menu</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#home" class="footer-link">Beranda</a></li>
                        <li class="mb-2"><a href="#tentang" class="footer-link">Tentang</a></li>
                        <li class="mb-2"><a href="#fitur" class="footer-link">Fitur</a></li>
                        <li class="mb-2"><a href="#alur" class="footer-link">Alur Kerja</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h6 class="fw-bold mb-3">Kontak</h6>
                    <ul class="list-unstyled text-muted" style="color: white
                    !important;">
                        <li class="mb-2"><i class="fas fa-map-marker-alt"></i> Batam, Kepulauan Riau</li>
                        <li class="mb-2"><i class="fas fa-envelope"></i> info@tunasidea.com</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255, 255, 255, 0.93);">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0 text-muted;" style="color: white">
                        &copy; {{ date('Y') }} MI Daarul Ishlah Batam | Tunasidea. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 5px 20px rgba(0,0,0,0.15)';
            } else {
                navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
            }
        });
    </script>
</body>
</html>