<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bpjs</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/lp/style.css'); ?>" />
</head>

<body>
    <header id="header">
        <div class="header-content-div" style="display: flex; align-items: center; justify-content: space-between;">
            <a href="#home-sec">
                <img src="<?php echo base_url('assets/images/bpjs2.png'); ?>" alt="Company Logo" id="header-img" />
            </a>

            <nav id="nav-bar" style="display: flex; gap: 15px; align-items: center;">
                <a href="#about" class="nav-link">ABOUT</a>
                <a href="#keunggulan" class="nav-link">KEUNGGULAN</a>
                <a href="#informasi" class="nav-link">INFORMASI</a>
                <a href="#panduan" class="nav-link">PANDUAN</a>
                <a href="<?php echo site_url('auth/login'); ?>">
                    <button class="btn btn-primary" style="padding: 8px 15px; border: none; cursor: pointer;">Login Admin</button>
                </a>
            </nav>
        </div>
    </header>


    <main>
        <section id="home-sec" class="flexible home-sec">
            <div class="eye-grabber-img">
                <img src="<?php echo base_url('assets/images/bpjs.png'); ?>" alt="Image of Apples" />
            </div>
            <div class="eye-grabber">
                <h1>BPJS KESEHATAN</h1>
                <h2>
                    BADAN PENYELENGGARA JAMINAN SOSIAL
                </h2>
                <button class="btn" onclick="window.location.href = '<?php echo site_url('auth/register'); ?>';">
                    Daftar Sekarang
                </button>
            </div>
        </section>
        <section id="about" class="sec-padding">
            <h3 class="section-heading">ABOUT US</h3>
            <div class="sec-content-div flexible">
                <p>
                    BPJS Kesehatan adalah Badan Penyelenggara Jaminan Sosial yang bertugas mengelola
                    program jaminan kesehatan di Indonesia. BPJS Kesehatan merupakan bagian dari sistem
                    jaminan sosial yang dikelola oleh pemerintah, dan tujuannya adalah untuk memberikan
                    akses layanan kesehatan yang merata bagi seluruh rakyat Indonesia, baik yang mampu
                    maupun tidak mampu, dengan biaya yang terjangkau.
                    <br>
                    Sistem Pendaftaran Mandiri BPJS Kesehatan adalah sebuah sistem yang memungkinkan
                    calon peserta untuk mendaftar secara online tanpa perlu datang ke kantor BPJS Kesehatan
                    atau puskesmas. Sistem ini dirancang untuk mempermudah proses pendaftaran bagi peserta
                    yang ingin bergabung dengan program jaminan kesehatan yang dikelola oleh BPJS
                    Kesehatan. Dengan sistem ini, peserta dapat mendaftar, memilih kelas rawat inap, dan
                    melakukan pembayaran iuran dengan lebih cepat dan efisien.

                </p>
                <!-- <img src="https://i.ibb.co/SyKVC8M/about-img.jpg" alt="A man plucking apples from the tree" /> -->
            </div>
        </section>
        <section id="keunggulan" class="sec-padding">
            <h3 class="section-heading">Keunggulan pendaftaran online</h3>
            <div class="sec-content-div">
                <div class="bars">
                    <!-- <div class="icon-container">
                        <img src="https://i.ibb.co/w6H542X/Fresh.png" alt="" />
                    </div> -->
                    <div class="txt-container">
                        <h5>o Proses cepat dan mudah</h5>
                    </div>
                </div>
                <div class="bars">
                    <div class="txt-container">
                        <h5>o Bisa dilakukan dari mana saja</h5>
                    </div>
                </div>
                <div class="bars">
                    <div class="txt-container">
                        <h5>o Notifikasi</h5>
                    </div>
                </div>
            </div>
        </section>
        <section id="informasi" class="sec-padding">
            <h3 class="section-heading">Informasi Kepesertaan</h3>
            <div class="sec-content-div flexible">
                <div class="tile">
                    <!-- <img src="https://i.ibb.co/t2x706V/amber.jpg" alt="photo of amber apples" /> -->
                    <h4>kelas 1 : 150.000/ bln</h4>
                    <p>Manfaat:</p>
                    <ul>
                        <li>Mendapatkan pelayanan kesehatan dengan prioritas lebih tinggi di rumah sakit.</li>
                        <li>Fasilitas rawat inap yang lebih baik dan lebih nyaman dibandingkan kelas lainnya.</li>
                        <li>Pilihan fasilitas pelayanan di rumah sakit rujukan dengan kualitas terbaik.</li>
                        <li>Akses kepada dokter spesialis dan fasilitas medis yang lebih cepat dan memadai.</li>
                    </ul>

                </div>
                <div class="tile">
                    <!-- <img
                        src="https://i.ibb.co/H4Cnh7v/american-trel.png"
                        alt="photo of american trel apples" /> -->
                    <h4>kelas 2: 100.000/bln</h4>

                    <p>Manfaat:</p>
                    <ul>
                        <li>Pelayanan rawat inap yang cukup nyaman dengan ruang yang lebih luas
                            dibandingkan dengan kelas III.</li>
                        <li>Akses ke rumah sakit rujukan dan dokter spesialis dengan sedikit waktu
                            tunggu.</li>
                        <li>Mendapatkan layanan kesehatan yang berkualitas meskipun dengan
                            fasilitas yang sedikit lebih sederhana dibandingkan kelas I</li>
                    </ul>
                </div>
                <div class="tile">
                    <!-- <img src="https://i.ibb.co/jTDgqYB/red-delicious.png" alt="photo of red delicious apple" /> -->
                    <h4>kelas 3: 35.000/bln</h4>
                    <p>Manfaat:</p>
                    <ul>
                        <li>Mendapatkan pelayanan kesehatan yang tidak kalah penting meskipun
                            dengan fasilitas yang lebih sederhana.</li>
                        <li>Fasilitas rawat inap lebih padat dan ruang lebih kecil.</li>
                        <li>Akses ke rumah sakit dan dokter spesialis, namun waktu tunggu untuk
                            pelayanan bisa lebih lama dibandingkan kelas lainnya.</li>
                        <li>Bagi peserta PBI (Penerima Bantuan Iuran), kelas III menjadi pilihan
                            utama karena iuran ditanggung oleh pemerintah.</li>
                    </ul>
                </div>
            </div>
        </section>
        <section id="panduan" class="sec-padding">
            <h3 class="section-heading">Panduan</h3>
            <div class="sec-content-div flexible">
                <div class="tile">
                    <h4>Cara Pendaftaran BPJS Kesehatan Online</h4>
                    <p>Langkah-langkah dari registrasi hingga aktivasi:</p>
                    <ul>
                        <li>Mengisi data pribadi yang diperlukan</li>
                        <li>Melengkapi dokumen yang dibutuhkan</li>
                        <li>Memilih fasilititas Kesehatan sesuai dengan daerahnya</li>
                        <li>Memilih kelas yang diinginkan</li>
                    </ul>
                </div>
                <div class="tile">
                    <h4>Cara Pembayaran Iuran BPJS
                    </h4>
                    <ul>
                        <li>Akses menu pembayaran iuran</li>
                        <li>Lakukan pembayaran sesuai nominal yang tertera</li>
                        <li>Konfirmasi pembayaran</li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- <section class="sec-padding" id="contact">
            <h3 class="section-heading">CONTACT</h3>
            <div class="sec-content-div flexible">
                <h6>To make an order or just to know more contact us :</h6>
                <form
                    id="form"
                    action="https://www.freecodecamp.com/email-submit"
                    method="POST">
                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Your Email Address"
                        required />
                    <input type="submit" class="btn" id="submit" value="Know More" />
                </form>
            </div>
        </section> -->
    </main>
    <footer>
        Created by
        <a href="#">BPJS KESEHATAN</a>
    </footer>
</body>

</html>