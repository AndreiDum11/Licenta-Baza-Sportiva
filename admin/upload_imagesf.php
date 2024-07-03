<?php
require_once 'database.php';

if (isset($_POST['submit'])) {
    require 'files.php';
    $file = new files;
    $file->setName($_FILES['fisier']['name']);
    $file->setType($_FILES['fisier']['type']);
    $file->setTitlu($_POST['titlu']);
    $file->setSubtitlu($_POST['subtitlu']);
    $file->setTipSport($_POST['tipSport']);
    $file->setUploadedDate(date("Y-m-d"));
    if ($file->insert()) {
        if (move_uploaded_file($_FILES['fisier']['tmp_name'], '../images/' . $_FILES['fisier']['name'])) {
            $success_msg[] = "Imagine salvată";
        } else {
            $warning_msg[] = 'Upload eșuat';
        }
    } else {
        $error_msg[] = 'Insertul a eșuat';
    }
}

if (isset($_POST['delete_image'])) {
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_delete = mysqli_prepare($conn, "SELECT * FROM `slider_imagef` WHERE id = ?");
    mysqli_stmt_bind_param($verify_delete, 'i', $delete_id);
    mysqli_stmt_execute($verify_delete);
    $result_verify_delete = mysqli_stmt_get_result($verify_delete);

    if (mysqli_num_rows($result_verify_delete) > 0) {
        $delete_image = mysqli_prepare($conn, "DELETE FROM `slider_imagef` WHERE id = ?");
        mysqli_stmt_bind_param($delete_image, 'i', $delete_id);
        mysqli_stmt_execute($delete_image);
        $success_msg[] = 'Imaginea selectată a fost ștearsă';
    } else {
        $warning_msg[] = 'Imaginea selectată a fost deja ștearsă';
    }
    mysqli_stmt_close($verify_delete);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload_ImagesFotball</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="../css/style_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
</head>
<body>
    <section class="header">
        <a href="admin_page.php" class="logo">DC Sports</a>
        <nav class="navbar">
            <a class="nav-link click-scroll" href="admin_page.php">Acasa</a>
            <a href="logout.php">Logout</a>     
        </nav> 
    </section>
    <section class="add">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Aici poti pune pozele pentru secțiunea de slider!</h3>
            <input type="file" name="fisier" id="file" required class="box">
            <input type="text" name="titlu" class="box" placeholder="Introdu titlul" required>
            <input type="text" name="subtitlu" class="box" placeholder="Introdu subtitlul" required>
            <select name="tipSport" class="box" required>
                <option value="" disabled selected>selectează tipul de sport</option>
                <option value="Fotbal">Fotbal</option>
                <option value="Baschet">Baschet</option>
                <option value="Tenis">Tenis</option>
                <option value="Înot">Înot</option>
            </select>
            <div>
                <button type="submit" name="submit" class="btn">Upload</button>
            </div>
        </form>
    </section>
    <section class="antrenori" style="padding-top: 0;">
        <div class="heading"><h1>Lista noastră de imagini!</h1></div>
        <div class="box-container">
            <?php
                $select_images = mysqli_query($conn, "SELECT * FROM `slider_imagef`");
                if (mysqli_num_rows($select_images) > 0) {
                    while ($image = mysqli_fetch_assoc($select_images)) {
            ?>
            <div class="box">
                <img src="../images/<?= $image['nume']; ?>" alt="" class="image">
                <h3 class="title"><?= $image['titlu']; ?></h3>
                <h3 class="title" style="font-size:18px"><?= $image['subtitlu']; ?></h3>
                <h3 class="title" style="font-size:18px"><?= $image['tipSport']; ?></h3>
                <form action="" method="post">
                    <input type="hidden" name="delete_id" value="<?= $image['id']; ?>">
                    <button type="submit" class="inline-delete-btn" name="delete_image" onclick="return confirm('Ești sigur că vrei să ștergi această imagine?');">Șterge imaginea</button>
                </form>
              
            </div>
            <?php
                    }
                } else {
                    echo '<p class="empty">Deocamdată nu avem imagini adaugate in slider!</p>';
                }
            ?>
        </div>
    </section>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php 
        include '../alertmessages.php';
    ?>
    <script src="../js/animatie_news.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/click-scroll.js"></script>
</body>
</html>
