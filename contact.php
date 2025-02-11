<?php header("Content-Type: text/html; charset=UTF-8"); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - SMAN 1 Sungai Pandan</title>
    <link rel="icon" type="image/png" href="assets/logonobackground.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container-fluid {
            flex: 1;
        }
        .contact-container {
            max-width: 1100px;
            margin: auto;
            padding: 40px 20px;
            display: flex;
            justify-content: space-between;
            gap: 40px;
        }
        .contact-info, .contact-form {
            flex: 1;
        }
        .contact-form {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
        .contact-form input,
        .contact-form textarea,
        .contact-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .contact-form button {
            background: green;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .contact-form button:hover {
            background: darkgreen;
        }
        @media (max-width: 768px) {
            .contact-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<?php
// Menampilkan notifikasi jika ada status dari pengiriman formulir
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        echo "<script>alert('Aspirasi berhasil dikirim!');</script>";
    } elseif ($_GET['status'] == 'error') {
        echo "<script>alert('Gagal mengirim aspirasi. Silakan coba lagi.');</script>";
    }
}
?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $jenis = htmlspecialchars($_POST['jenis-info']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Validasi Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.php?status=error&message=Email tidak valid");
        exit;
    }

    // Validasi nomor HP (10-13 digit)
    if (!preg_match('/^[0-9]{10,13}$/', $phone)) {
        header("Location: contact.php?status=error&message=Nomor HP tidak valid");
        exit;
    }

    // Konfigurasi PHPMailer
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Sesuai SMTP provider
        $mail->SMTPAuth   = true;
        $mail->Username   = 'emailanda@gmail.com'; // Ganti dengan email pengirim
        $mail->Password   = 'app_password_dari_google'; // Ganti dengan App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = 587;

        // Set Pengirim dan Penerima
        $mail->setFrom('emailanda@gmail.com', 'SMAN 1 Sungai Pandan');
        $mail->addReplyTo($email, $name);
        $mail->addAddress('sman1sp.web@gmail.com', 'Admin SMAN 1 Sungai Pandan');

        // Debugging (hapus jika sudah berhasil)
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';

        // Konten Email
        $mail->isHTML(true);
        $mail->Subject = "[$jenis] $subject";
        $mail->Body    = "
            <h3>Formulir Aspirasi</h3>
            <p><strong>Nama:</strong> $name</p>
            <p><strong>No HP:</strong> $phone</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Kategori:</strong> $jenis</p>
            <p><strong>Pesan:</strong> $message</p>
        ";

        $mail->send();
        header("Location: contact.php?status=success");
        exit;
    } catch (Exception $e) {
        header("Location: contact.php?status=error&message=" . $mail->ErrorInfo);
        exit;
    }
}
?>

} else {
    header("Location: contact.php");
    exit;
}



<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="contact.php">
            <img src="assets/logonobackground.png" alt="Logo" style="height: 40px; margin-right: 10px;">
            SMAN 1 Sungai Pandan
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.html">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="about.html">Profil</a></li>
                <li class="nav-item"><a class="nav-link" href="gallery.html">Galeri</a></li>
                <li class="nav-item"><a class="nav-link active" href="contact.php">Kontak</a></li>
                <li class="nav-item"><a class="nav-link" href="register.html">Sign Up</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="contact-container">
    <!-- Informasi Kontak -->
    <div class="contact-info">
        <h2>Hubungi Kami</h2>
        <p><strong>SMAN 1 Sungai Pandan</strong></p>
        <p><i class="fas fa-map-marker-alt"></i> Jl. Banyu Tajun Pangkalan, Sungai Pandan, Kalimantan Selatan</p>
        <p><i class="fas fa-phone"></i> (+62) 81351442733</p>
        <p><i class="fas fa-envelope"></i> sman1sp.web@gmail.com</p>
    </div>

    <!-- Form Kritik dan Saran -->
    <div class="contact-form">
        <h2>Kritik dan Saran</h2>
        <form action="contact.php" method="POST">
    <input type="text" name="name" placeholder="Nama" required>
    <div style="display: flex; gap: 10px;">
        <input type="text" name="phone" placeholder="No. HP / WA" required>
        <input type="email" name="email" placeholder="Email" required>
    </div>
    <select name="jenis-info" required>
        <option value="" disabled selected>Pilih Kategori</option>
        <option value="informasi">Informasi Sekolah</option>
        <option value="pengaduan">Pengaduan</option>
        <option value="saran">Saran & Masukan</option>
    </select>
    <input type="text" name="subject" placeholder="Subject" required>
    <textarea name="message" placeholder="Pesan Anda" rows="5" required></textarea>
    <button type="submit" name="submit"><i class="fas fa-paper-plane"></i> Kirim Aspirasi</button>
</form>

    </div>
</div>

<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2025 SMAN 1 Sungai Pandan. All Rights Reserved.</p>
</footer>

<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.querySelector("form").addEventListener("submit", function(event) {
        let phone = document.querySelector("input[name='phone']").value;
        let email = document.querySelector("input[name='email']").value;
        let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        let phonePattern = /^[0-9]{10,13}$/;
        let message = document.querySelector("textarea[name='message']").value.trim();

        if (!email.match(emailPattern)) {
            alert("Email tidak valid! Gunakan format yang benar, contoh: example@email.com");
            event.preventDefault();
        }

        if (!phone.match(phonePattern)) {
            alert("Nomor HP/WA tidak valid! Masukkan hanya angka dengan panjang 10-13 digit.");
            event.preventDefault();
        }

        if (message.length < 5) {
        alert("Pesan harus lebih dari 5 karakter!");
        event.preventDefault();
    }
        
    });
</script>

</body>
</html>
