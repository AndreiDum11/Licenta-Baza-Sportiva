<?php

include("admin\database.php");
include("alertmessages.php");
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('Page_Log_In.php');
}

if (isset($_POST['submit'])) {
    $nume = filter_var($_POST['nume'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $numar = filter_var($_POST['numar'], FILTER_SANITIZE_STRING);
    $msg = filter_var($_POST['mesaj'], FILTER_SANITIZE_STRING);

   
    $sql = "SELECT COUNT(*) FROM mesaje WHERE email = ? AND trimis_la >= NOW() - INTERVAL 1 DAY";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $message_count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($message_count >= 5) {
        $warning_msg[] = 'Ai atins limita de 5 mesaje pe zi. Te rugăm să încerci mâine din nou.';
    } else {
        $sql = "SELECT * FROM mesaje WHERE nume = ? AND email = ? AND numartelefon = ? AND msg = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $nume, $email, $numar, $msg);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) < 1) {
            mysqli_stmt_close($stmt);

    
            $sql = "INSERT INTO mesaje (user_id, nume, email, numartelefon, msg, trimis_la) VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "issss", $user_id, $nume, $email, $numar, $msg);

            if (mysqli_stmt_execute($stmt)) {
                $success_msg[] = 'Mesajul a fost trimis cu succes';
            } else {
                $error_msg[] = 'Exista o eroare la baza de date. Te rugăm să încerci mai târziu!';
            }
        } else {
            $warning_msg[] = 'Ai m-ai trimis acest mesaj';
        }

        mysqli_stmt_close($stmt);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DC SPORT Contact</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <link rel='stylesheet'href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' >
        <link rel="stylesheet" href="css/style1.css">
        <link rel="icon" type="image/png" href="images/fotbal_icon.png"/>
    </head>
    <body >
    
    <section class="header" >
        <a href="acasa.php" class="logo"> <i class='bx bx-basketball'></i>DC Sports</a>
        <nav class="navbar">
            <a class="nav-link click-scroll" href="acasa.php">Acasa</a>
            <a href="Contact.php">Contact</a>
            <a href="logout.php">Logout</a>
        </nav>
        <div id="btn-meniu" class="fas fa-bars"></div>    
    </section>
    <div class="heading">
        <h3>Lăsați un mesaj</h3>
        <p>Contact/<a href="acasa.php">Acasa</a></p>

    </div>
    <section class="contact">
        <div class="row">
            <div class="image">
                <img src="images/contact.jpg" alt="">
            </div>
            <form action="" method="POST">
                <h3>Spune-ne părerea ta!</h3>
                <input type="text" required placeholder="Introdu numele tău" maxlength="50" 
                name="nume" class="box">
                <input type="email" required placeholder="Introdu email-ul tău" maxlength="50" 
                name="email" class="box">
                <input type="number" required placeholder="Introdu numărul tău de telefon" maxlength="10" 
                 name="numar" class="box">
                <textarea name="mesaj" class="box" required maxlength="500" cols="30" rows="10" 
                placeholder="Introdu mesajul tău..."></textarea>
                <input type="submit" value="Trimite mesaj!" name="submit" class="btn">
            </form>

        </div>
    </section>
    <section class="footer">
            <div class="box-container">
                <div class="box">
                    <h2>Link uri utile</h2>
                    <a href="acasa.php"><i class="fas fa-angle-right"></i>Acasa</a>
                    <a href="DespreNoi.php"><i class="fas fa-angle-right"></i>Despre Noi</a>
                    <a href="Facilitati.php"><i class="fas fa-angle-right"></i>Facilități</a>
                    <a href="Evenimente.php"><i class="fas fa-angle-right"></i>Evenimente</a>
                    <a href="Contact.php"><i class="fas fa-angle-right"></i>Contact</a>
                </div>
                <div class="box">
                    <h2>Aici ne poți găsi:</h2>
                    <h2>Pitești, Str.Nicolae Dobrin Nr.10 </h2>
                    <h2>0791-154-371</h2>
                    <h2>dcsport@gmail.com</h2>
                    
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2828.765270190551!2d24.865127727766136!3d44.84671344297892!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40b2bc99cc500bd7%3A0xc0022c3c132fd5ac!2sBaza%20Sportiv%C4%83%20Constantin%20C%C3%A2rstea!5e0!3m2!1sro!2sro!4v1714753967635!5m2!1sro!2sro" width="" height="" style="border:1;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                   
                </div>
                <div class="box">
                    <h2>Urmărește-ne pe social media:</h2>
                    <a href="https://ro-ro.facebook.com" ><i class='bx bxl-facebook-circle'></i>DC Sports Facebook</a>
                    <a href="https://ro.pinterest.com/pin/225320787578795949"><i class='bx bxl-pinterest' ></i>DC Sports Pinterest</a>
                    <a href="https://twitter.com/?lang=ro"><i class="fab fa-twitter"></i>DC Sports X</a>
                    <a href="https://www.youtube.com" ><i class='bx bxl-youtube'></i>DC Sports Youtube</a>
                </div>

            </div>
        </section>
        
        <script src="../js/script.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <?php 
            include 'alertmessages.php';
        ?>
    </body>
</html>