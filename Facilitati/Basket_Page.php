<?php
require_once '../admin/database.php';
require_once '../admin/files.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('Page_Log_In.php');
    $user_id = '';
    
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DC SPORT</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' >
        <link rel="stylesheet" href="../css/style_facilitati.css">
        <link rel="icon" type="image/png" href="../images/basket_icon.png"/>
    </head>
   
    
   
    <body >
    
        <section class="header" >
            <a href="../acasa.php" class="logo"> <i class='bx bx-basketball'></i>DC Sports</a>
            <nav class="navbar">
                <a class="nav-link click-scroll" href="../acasa.php">Acasa</a>
                <a class="nav-link click-scroll" href="#section_2">Despre Noi</a>
                <a class="nav-link click-scroll" href="#section_3">Antrenori</a>
                <a class="nav-link click-scroll" href="#section_4">Noutăți</a>
                <a class="nav-link click-scroll" href="profil.php">Rezervările tale</a>
                <a class="nav-link click-scroll" href="../logout.php">Logout</a>
            </nav>
            <div id="btn-meniu" class="fas fa-bars"></div>    
        </section>
        <section class="home" id="section_1">
           
            <div class="swiper home-slider">
                <div class="swiper-wrapper">
                    <?php  
                        require_once  '../admin/files.php';
                        $files = new files();
                        $tipSport = 'Baschet'; 
                        $filesBySport = $files->getFilesBySport($tipSport);
                        foreach ($filesBySport as $filesItem): ?>
                        <div class="swiper-slide slide" style="background:url('../images/<?= htmlspecialchars($filesItem['nume']); ?>') no-repeat">
                            <div class="content">
                                <span style="color:#19204e"><?= htmlspecialchars($filesItem['titlu']); ?></span>
                                <h3 style="color:#19204e"><?= htmlspecialchars($filesItem['subtitlu']); ?></h3>
                                <a href="#section_2" class="btn">Descoperă mai multe!</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </section>
        <section class="despre_noi" id="section_2">
                <div class="image">
                    <?php
                        require_once '../admin/content_aboutus.php';
                        $content = new content();
                        $tipSport = 'Baschet';
                        $contentImage = $content->getContentBySport($tipSport); 
                        echo '<img src="../images/' . htmlspecialchars($contentImage['nume']) . '" alt="">';
                    ?>    
                </div>
                <div class="content">
                    <h3>Despre noi</h3>
                    <p>
                        <?php
                            $contentdescriere = $content->getContentBySport($tipSport);
                            echo htmlspecialchars($contentdescriere['descriere']);
                        ?>
                    </p>
                </div>
            
        </section>
        <section class="antrenori" id="section_3">
        <div class="heading"><h1>Lista noastră de antrenori!</h1></div>
            <div class="box-container">
                <?php
                $select_coaches = mysqli_query($conn, "SELECT * FROM `antrenori` WHERE tipSport = 'Baschet'");
                if (mysqli_num_rows($select_coaches) > 0) {
                    while ($coach = mysqli_fetch_assoc($select_coaches)) {
                    $coach_id = $coach['id'];
                    $count_reviews = mysqli_query($conn, "SELECT * FROM `reviews` WHERE antrenor_id = $coach_id");
                    $total_reviews = mysqli_num_rows($count_reviews);
                ?>
                <div class="box">
                <img src="../<?= $coach['poza']; ?>" alt="" class="image">
                <h3 class="title"><?= $coach['nume']; ?></h3>
                <p class="total-reviews"><i class="fas fa-star"></i> <span><?= $total_reviews; ?></span></p>
                <a href="antrenor_profile.php?antrenor_id=<?= $coach_id; ?>" class="inline-btn">Vezi profilul antrenorului</a>
                <a href="Rezervare_Page.php?user_id=<?= $user_id; ?>&antrenor_id=<?= $coach_id; ?>" class="inline-btn">Rezervă o ședință</a>
                </div>
                <?php
                    }
                } else {
                    echo '<p class="empty">Nu există momentan antrenori disponibili!</p>';
                }
                ?>

            </div>
           

        </section>
        <section class="noutati" id="section_4"> 
            <div class="slide-container swiper">
                <div class="slide-content">
                    <div class="card-wrapper swiper-wrapper">
                    <?php
                         require_once  '../admin/news.php';
                        $news = new news();
                        $tipSport = 'Baschet'; 
                        $newsBySport = $news->getNewsBySport($tipSport);
                        foreach ($newsBySport as $newsItem) {
                            echo '<div class="card swiper-slide">';
                            echo '<div class="image-content">';
                            echo '<span class="overlay"></span>';
                            echo '<div class="card-image">';
                            echo '<img src="../images_news/' . htmlspecialchars($newsItem['nume']) . '" alt="" class="card-img">';
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="card-content">';
                            echo '<h2 class="nume">' . htmlspecialchars($newsItem['tipSport']) . '</h2>';
                            echo '<p class="descriere">' . htmlspecialchars($newsItem['descriere']) . '</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                    ?>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </section>
        <section class="footer">
            <div class="box-container">
                <div class="box">
                    <h2>Link uri utile</h2>
                    <a href="../acasa.php"><i class="fas fa-angle-right"></i>Acasa</a>
                    <a href="#section_2"><i class="fas fa-angle-right"></i>Despre Noi</a>
                    <a href="#section_3"><i class="fas fa-angle-right"></i>Antrenori</a>
                    <a href="#section_4"><i class="fas fa-angle-right"></i>Noutăți</a>
                    <a href="../Contact.php"><i class="fas fa-angle-right"></i>Contact</a>
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
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="../js/animatie_news.js"></script>
        <script src="../js/script.js"></script>
        <script src="../js/click-scroll.js"></script>
    </body>
</html>