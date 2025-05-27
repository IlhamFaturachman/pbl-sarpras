<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SiLaprak</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('/assets/img/logo-removebg.png') }}" rel="icon">
    <link href="{{ asset('Selecao-1.0.0/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('Selecao-1.0.0/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Selecao-1.0.0/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('Selecao-1.0.0/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('Selecao-1.0.0/assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Selecao-1.0.0/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Selecao-1.0.0/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('Selecao-1.0.0/assets/css/main.css') }}" rel="stylesheet">

</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="#" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="{{ asset('/assets/img/logo-removebg.png') }}" alt="assets/img/logo.png" alt="">
                <h1 class="sitename">SiLaprak</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#faq">Support</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="#team">Team</a></li>
                    <li><a href="{{ route('login') }}" class="btn-get-started"
                            style="background-color: #FFA500">Login</a></li>
                    <li><a href="{{ route('register') }}" class="btn-get-started"
                            style="background-color: #FFA500">Register</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">

            <div id="hero-carousel" data-bs-interval="5000" class="container carousel carousel-fade"
                data-bs-ride="carousel">

                <!-- Slide 1 -->
                <div class="container">
                    <div class="row align-items-center justify-content-center text-center"
                        style="; min-height: 75vh; padding-top: 100px;">

                        <!-- Kolom Gambar -->
                        <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                            <img src="{{ asset('/assets/img/logo-outline(white).png') }}"
                                style="width: 100%; max-width: 590px; height: auto;" alt="">
                        </div>

                        <!-- Kolom Teks -->
                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                            <h2 class="animate__animated animate__fadeInDown">Selamat Datang di <span>SiLaprak</span>
                            </h2>
                            <p class="animate__animated animate__fadeInUp">
                                Platform untuk mempermudah pelaporan, pemantauan, dan
                                penanganan kerusakan fasilitas kampus secara cepat, terintegrasi, dan terdokumentasi
                            </p>
                            <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read
                                More</a>
                        </div>

                    </div>
                </div>


                {{-- <!-- Slide 2 -->
        <div class="carousel-item">
          <div class="carousel-container">
            <h2 class="animate__animated animate__fadeInDown">Slide 2 Title</h2>
            <p class="animate__animated animate__fadeInUp">This is the content for Slide 2.</p>
            <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a>
          </div>
        </div>

        <!-- Carousel Controls -->
        <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </a> --}}

            </div>

            <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 24 150 28 " preserveAspectRatio="none">
                <defs>
                    <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
                    </path>
                </defs>
                <g class="wave1">
                    <use xlink:href="#wave-path" x="50" y="3"></use>
                </g>
                <g class="wave2">
                    <use xlink:href="#wave-path" x="50" y="0"></use>
                </g>
                <g class="wave3">
                    <use xlink:href="#wave-path" x="50" y="9"></use>
                </g>
            </svg>

        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up" style="padding-bottom: 40px">
                <h2>About</h2>
                <p>SiLaprak</p>
            </div><!-- End Section Title -->

            <div class="container section-title" data-aos="fade-up" style="padding-bottom: 10px; padding-left: 20px">
                <p style="font-size: 25px; color: #f57c00">Deskripsi dan Latar Belakang</p>
            </div>

            <div class="container">
                <div class="row gy-4">

                    <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                        <p>
                            SiLaprak ini mewakili kebutuhan aktual manajemen fasilitas yang lebih efisien dan transparan
                            di lingkungan kampus, khususnya Jurusan Teknologi Informasi Politeknik Negeri Malang.
                            Inisiatif ini menggambarkan penggunaan teknologi informasi dalam mendukung efisiensi
                            operasional umum di kampus. Sistem ini tidak hanya dirancang sebagai media pelaporan,
                            tetapi juga sebagai dua peralatan komunikasi jalanan antara wartawan dan manajer fasilitas,
                            meningkatkan budaya akuntabilitas dan layanan publik di lingkungan akademik.
                            Terlepas dari aspek fungsional seperti Manajemen Pelaporan dan Peningkatan,
                            SiLaprak ini juga mencerminkan integrasi informasi database dan sistem keputusan.
                            Karena analisis dan karakteristik statistik kerusakan fasilitas, sistem ini memberikan
                            nilai tambah strategis untuk manajemen kampus saat melakukan penilaian perencanaan jangka
                            panjang,
                            penganggaran dan pemeliharaan.
                        </p>

                    </div>

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <p>Selanjutnya, SiLaprak ini berkontribusi pada pengembangan keterampilan lunak dan keras bagi
                            siswa melalui desain sistem yang kompleks dan proses implementasi. Mereka tidak hanya
                            belajar
                            secara teknis, tetapi juga memahami konteks sosial, organisasi, dan kebutuhan nyata pengguna
                            dunia nyata.
                            Yaitu, SiLaprak ini mencerminkan penggunaan prinsip-prinsip kampus pintar, digitalisasi
                            layanan internal,
                            dan penggunaan kolaborasi dengan cross-rolls di komunitas kampus. Ini akan menjadi prototipe
                            yang dapat
                            direplikasi untuk unit lain di kampus dan untuk lembaga pendidikan lainnya yang menghadapi
                            tantangan serupa
                            dalam hal manajemen fasilitas.
                        </p>

                    </div>
                </div>
            </div>

            <div class="container section-title" data-aos="fade-up" style="padding-bottom: 10px; padding-left: 20px">
                <p style="font-size: 25px; color: #f57c00">Visi dan Tujuan</p>
            </div>
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                        <ul>
                            <li><i class="bi bi-check2-circle"></i> <span>Meningkatkan kualitas layanan fasilitas
                                    kampus</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Mendukung proses pembelajaran yang nyaman dan
                                    efisien</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Mewujudkan digitalisasi layanan internal
                                    kampus</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                        <p>
                            <a href="#services" rel="noopener noreferrer" class="read-more">Read Service</a>
                        </p>
                    </div>
                </div>
            </div>
        </section><!-- /About Section -->

        <!-- Services Section -->
        <section id="services" class="services section dark-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Services</h2>
                <p>Layanan yang Kami Tawarkan</p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-exclamation-diamond" style="color: #0dcaf0;"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Pelaporan Kerusakan Fasilitas</h3>
                            </a>
                            <p>Mahasiswa dan staf dapat mengisi formulir kerusakan, melampirkan foto, dan
                                mengirim laporan langsung melalui sistem.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-clock-history" style="color: #fd7e14;"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Manajemen dan Pemantauan Laporan</h3>
                            </a>
                            <p>Sistem menampilkan status setiap laporan: belum, diproses, selesai.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi-lightning-charge" style="color: #20c997;"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Prioritas Perbaikan Otomatis (DSS)</h3>
                            </a>
                            <p>Sistem menganalisis tingkat urgensi berdasarkan data dan memberi
                                rekomendasi prioritas perbaikan.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-gear" style="color: #df1529;"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Penugasan Teknisi</h3>
                            </a>
                            <p>Tim sarana prasarana dapat menugaskan teknisi langsung melalui sistem.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-graph-up-arrow" style="color: #2ecc71;"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Statistik dan Laporan</h3>
                            </a>
                            <p>Admin atau pengelola bisa melihat tren kerusakan, riwayat perbaikan,
                                statistik dan laporan grafik.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-box" style="color: #f3268c;"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Manajemen Fasilitas & Gedung</h3>
                            </a>
                            <p>Admin dapat memperbarui daftar fasilitas, lokasi gedung,
                                dan status kelayakan.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-star" style="color:  #ff9900;"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>Feedback & Rating</h3>
                            </a>
                            <p>Pengguna bisa memberikan umpan balik terhadap hasil perbaikan untuk
                                evaluasi kualitas layanan.</p>
                        </div>
                    </div><!-- End Service Item -->


                </div>

            </div>
            <div class="container" data-aos="fade-up" data-aos-delay="500">
                <a href="#faq" class="read-more"
                    style="display: inline-block; 
            padding: 10px 20px;
            background-color: #f57c00;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease; 
            margin-top: 40px;">
                    <span>Read Support</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>



        </section><!-- /Services Section -->

        <!-- Faq Section -->
        <section id="faq" class="faq section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up" style="padding-bottom: 20px">
                <h2>Support</h2>
                <p>Bantuan Teknis</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-12">
                        <div class="custom-accordion" id="accordion-faq">
                            <div class="accordion-item">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-faq-1">
                                        Bagaimana cara login dan register?
                                    </button>
                                </h2>

                                <div id="collapse-faq-1" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordion-faq">
                                    <div class="accordion-body">
                                        <p style="font-weight: bold; color: #f57c00; font-size: 20px">Untuk login</p>
                                        <ol>
                                            <li>Klik tombol "Login" di kanan atas</li>
                                            <li>Masukkan email dan password</li>
                                            <li>Klik tombol "Login"</li>
                                            <li>Jika berhasil, akan diarahkan ke halaman dashboard sesuai peran kalian
                                                (mahasiswa, dosen, tendik, sarpras, teknisi, dan admin)</li>
                                            <li>Jika gagal, akan muncul pesan kesalahan, periksa kembali data yang
                                                diinput, lanjutkan ke langkah berikutnya jika belum punya akun</li>
                                            <li>Klik "Register" jika belum punya akun, isi formulir dengan data yang
                                                sesuai dengan identitas dan peran kalian</li>
                                            <li>Ulangi langkah diatas hingga berhasil</li>
                                        </ol>
                                        <p style="font-weight: bold; color: #f57c00; font-size: 20px">Untuk register
                                        </p>
                                        <ol>
                                            <li>Klik tombol "Register" di kanan atas</li>
                                            <li>Isi formulir dengan data yang sesuai :
                                                <ul>
                                                    <li>Nama lengkap</li>
                                                    <li>Nomor Induk</li>
                                                    <li>Email</li>
                                                    <li>Password</li>
                                                    <li>Foto Profil</li>
                                                    <li>Foto Kartu Identitas</li>
                                                </ul>
                                            </li>
                                            <li>Klik tombol "sign up" untuk mengirimkan data</li>
                                            <li>Jika berhasil, akan diarahkan ke halaman dashboard sesuai peran kalian
                                                (mahasiswa, dosen, tendik, sarpras, teknisi, dan admin)</li>
                                            <li>Jika gagal, akan muncul pesan kesalahan, periksa kembali data yang
                                                diinput, jika sudah punya akun lanjutkan ke langkah berikutnya</li>
                                            <li>Klik "Login" jika sudah punya akun, isi formulir dengan data yang sesuai
                                                dengan identitas dan peran kalian</li>
                                            <li>Ulangi langkah diatas hingga berhasil</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <!-- .accordion-item -->

                        </div>
                    </div>
                </div>
            </div>
            <div class="container" data-aos="fade-up" data-aos-delay="500">
                <a href="#contact" class="read-more"
                    style="display: inline-block; 
            padding: 10px 20px;
            background-color: #f57c00;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease; 
            margin-top: 40px;">
                    <span>Read Contact</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </section><!-- /Faq Section -->
        <div class="row gy-4 justify-content-center">

            <!-- Contact Section -->
            <p class="text-center">
            <section id="contact" class="contact section dark-background">

                <!-- Section Title -->
                <div class="container section-title" data-aos="fade-up">
                    <h2>Contact</h2>
                    <p>Hubungi Kami</p>
                </div><!-- End Section Title -->

                <div class="container" data-aos="fade" data-aos-delay="100">

                    <div class="row gy-4">
                        <div class="col-lg-6 " style="flex-wrap: wrap; align-content: space-between">
                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300" >
                                <a href="https://wa.me/6288888888888"><i
                                        class="bi bi-telephone flex-shrink-0"></i></a>
                                <div>
                                    <h3>Hubungi Kami</h3>
                                    <p>+62 888-888-888-888</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400" >
                                <i class="bi bi-envelope flex-shrink-0"></i>
                                <div>
                                    <h3>Email Kami</h3>
                                    <p>info@example.com</p>
                                </div>
                            </div><!-- End Info Item -->
                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200" >
                                <a href="https://www.google.com/maps?q=politeknik+negeri+malang" target="_blank"><i
                                        class="bi bi-geo-alt flex-shrink-0"></i></a>
                                <div>
                                    <h3>Alamat</h3>
                                    <p>Jl. Soekarno Hatta No.9, Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141
                                    </p>
                                </div>
                            </div><!-- End Info Item -->
                        </div>
                        <div class="col-lg-6">
                            <div class="map-container" data-aos="fade-up" data-aos-delay="500">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15806.497797965125!2d112.61442606697996!3d-7.934233362695417!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78827687d272e7%3A0x789ce9a636cd3aa2!2sPoliteknik%20Negeri%20Malang!5e0!3m2!1sid!2sid!4v1732764514137!5m2!1sid!2sid"
                                    style="border-radius: 15px" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade" width="100%"
                                    height="243,800"></iframe>

                            </div>
                        </div>
                    </div>
                    <div class="container" data-aos="fade-up" data-aos-delay="500">
                        <a href="#team" class="read-more"
                            style="display: inline-block; 
            padding: 10px 20px;
            background-color: #f57c00;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease; 
            margin-top: 40px;">
                            <span>Read Team</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
            </section>
            <!-- Team Section -->
            <section id="team" class="team section">

                <!-- Section Title -->
                <div class="container section-title" data-aos="fade-up">
                    <h2>Team</h2>
                    <p>Kelompok 4</p>
                </div><!-- End Section Title -->

                <div class="container">

                    <div class="row gy-4">

                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                            data-aos-delay="100">
                            <div class="team-member">
                                <div class="member-img">
                                    <img src="{{ asset('/assets/img/Beryl.jpg') }}" class="img-fluid rounded"
                                        alt="">
                                </div>
                                <div class="member-info">
                                    <h4>Alvanza Saputra</h4>
                                    <span>02/2341720182</span>
                                    <a href="https://github.com/alvnz11"><i class="bi bi-github"></i></a>
                                </div>
                            </div>
                        </div><!-- End Team Member -->

                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                            data-aos-delay="200">
                            <div class="team-member">
                                <div class="member-img">
                                    <img src="{{ asset('/assets/img/Beryl.jpg') }}" class="img-fluid rounded"
                                        alt="">
                                </div>
                                <div class="member-info">
                                    <h4>Anya Callissta Chriswantari</h4>
                                    <span>03/2341720234</span>
                                    <a href="https://github.com/anyacallissta"><i class="bi bi-github"></i></a>
                                </div>
                            </div>
                        </div><!-- End Team Member -->

                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                            data-aos-delay="300">
                            <div class="team-member">
                                <div class="member-img">
                                    <img src="{{ asset('/assets/img/Beryl.jpg') }}" class="img-fluid rounded"
                                        alt="">
                                </div>
                                <div class="member-info">
                                    <h4>Beryl Funky Mubarok</h4>
                                    <span>04/2341720256</span>
                                    <a href="https://github.com/ggyupi"><i class="bi bi-github"></i></a>
                                </div>
                            </div>
                        </div><!-- End Team Member -->

                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                            data-aos-delay="400">
                            <div class="team-member">
                                <div class="member-img">
                                    <img src="{{ asset('/assets/img/Beryl.jpg') }}" class="img-fluid rounded"
                                        alt="">
                                </div>
                                <div class="member-info">
                                    <h4>Gwido Putra Wijaya</h4>
                                    <span>10/2341720103</span>
                                    <a href="https://github.com/GwidoPutra"><i class="bi bi-github"></i></a>
                                </div>
                            </div>
                        </div><!-- End Team Member -->

                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                            data-aos-delay="400">
                            <div class="team-member">
                                <div class="member-img">
                                    <img src="{{ asset('/assets/img/Beryl.jpg') }}" class="img-fluid rounded"
                                        alt="">
                                </div>
                                <div class="member-info">
                                    <h4>Ilham Faturachman</h4>
                                    <span>12/244107023001</span>
                                    <a href="https://github.com/IlhamFaturachman"><i class="bi bi-github"></i></a>
                                </div>
                            </div>
                        </div><!-- End Team Member -->

                    </div>
                    {{-- <div class="col-lg-6 " data-aos="fade-up" data-aos-delay="100">
                        <a href="#hero" class="read-more"
                            style="display: inline-block; 
            padding: 10px 20px;
            background-color: #f57c00;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease; 
            margin-top: 40px;">
                            <span>Kembali ke Halaman Utama</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div> --}}

                </div>

            </section><!-- /Team Section -->

    </main>

    <footer id="footer" class="footer dark-background">
        <div class="container">
            <h3 class="sitename">SiLaprak</h3>
            {{-- <div class="social-links d-flex justify-content-center">
        <a href=""><i class="bi bi-twitter-x"></i></a>
        <a href=""><i class="bi bi-facebook"></i></a>
        <a href=""><i class="bi bi-instagram"></i></a>
        <a href=""><i class="bi bi-skype"></i></a>
        <a href=""><i class="bi bi-linkedin"></i></a> --}}
        </div>
        <div class="container">
            <div class="copyright">
                <span>&copy; Copyright <strong>2023</strong> Politeknik Negeri Malang</span>
            </div>
        </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('Selecao-1.0.0/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('Selecao-1.0.0/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('Selecao-1.0.0/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('Selecao-1.0.0/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('Selecao-1.0.0/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('Selecao-1.0.0/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('Selecao-1.0.0/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('Selecao-1.0.0/assets/js/main.js') }}"></script>


</body>

</html>
