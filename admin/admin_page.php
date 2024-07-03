<?php
    include ('database.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <link rel="stylesheet" href="../css/style_admin.css">
</head>
<body>
        <section class="header" >
            <a href="admin_page.php" class="logo"> </i>DC Sports</a>
            <nav class="navbar">
                <a class="nav-link click-scroll" href="#section_1">Acasa</a>
                <a href="logout.php">Logout</a>     
            </nav> 
        </section>
        <section class="dashboard">
            <div class="box-container">
                <div class="box">
                    <?php
                         $total_coaches = 0;
                         $query = "SELECT * FROM `antrenori`";
                         if ($result = $conn->query($query)) {
                             $total_coaches = $result->num_rows;
                         }
                    ?>
                    <p>Numărul de antrenori: <span><?= $total_coaches?></span></p>
                    <a href="upload_coaches.php" class="btn">Vezi lista de antrenori & adaugă un antrenor nou</a>
                </div>
                <div class="box">
                    <?php
                         $total_news = 0;
                         $query = "SELECT * FROM `news`";
                         if ($result = $conn->query($query)) {
                             $total_news = $result->num_rows;
                         }
                    ?>
                    <p>Numărul de știri: <span><?= $total_news?></span></p>
                    <a href="upload_news.php" class="btn">Vezi lista de știri & adaugă o știre nouă</a>
                </div>
                <div class="box">
                    <?php
                         $total_reservation = 0;
                         $query = "SELECT * FROM `rezervari`";
                         if ($result = $conn->query($query)) {
                             $total_reservation = $result->num_rows;
                         }
                    ?>
                    <p>Numărul de rezervări: <span><?= $total_reservation?></span></p>
                    <a href="rezervari.php" class="btn">Vezi lista de rezervări</a>
                </div>
                <div class="box">
                    <?php
                         $total_admin_user= 0;
                         $query = "SELECT * FROM `conturi_admin`";
                         if ($result = $conn->query($query)) {
                             $total_admin_user = $result->num_rows;
                         }
                    ?>
                    <p>Numărul conturi admin: <span><?= $total_admin_user?></span></p>
                    <a href="upload_admin.php" class="btn">Adaugă cont admin</a>
                </div>
                <div class="box">
                    <?php
                         $total_content= 0;
                         $query = "SELECT * FROM `content_aboutus`";
                         if ($result = $conn->query($query)) {
                             $total_content = $result->num_rows;
                         }
                    ?>
                    <p>Număr conținuturi despre noi: <span><?= $total_content?></span></p>
                    <a href="upload_content.php" class="btn">Adaugă conținut</a>
                </div>
                <div class="box">
                    <?php
                         $total_image= 0;
                         $query = "SELECT * FROM `slider_imagef`";
                         if ($result = $conn->query($query)) {
                             $total_image = $result->num_rows;
                         }
                    ?>
                    <p>Număr imagini slider:<span><?= $total_image?></span></p>
                    <a href="upload_imagesf.php" class="btn">Adaugă imagini noi in slider</a>
                </div>
                <div class="box">
                    <?php
                         $total_mesaje = 0;
                         $query = "SELECT * FROM `mesaje`";
                         if ($result = $conn->query($query)) {
                             $total_mesaje = $result->num_rows;
                         }
                    ?>
                    <p>Numărul de mesaje: <span><?= $total_mesaje?></span></p>
                    <a href="mesaje.php" class="btn">Vezi lista de mesaje</a>
                </div>
            </div>
        </section>
            
</body>
</html>