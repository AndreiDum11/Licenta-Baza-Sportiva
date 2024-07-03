<?php
require_once 'database.php';

if (isset($_POST['submit'])) {
    require 'content_aboutus.php';
    $file = new content;
    $file->setName($_FILES['fisier']['name']);
    $file->setType($_FILES['fisier']['type']);
    $file->settipSport($_POST['tipSport']);  
    $file->setdescriere($_POST['descriere']);  
    $file->setUploadedDate(date("Y-m-d H:i:s"));
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

if (isset($_POST['delete_content'])) {
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_delete = mysqli_prepare($conn, "SELECT * FROM `content_aboutus` WHERE id = ?");
    mysqli_stmt_bind_param($verify_delete, 'i', $delete_id);
    mysqli_stmt_execute($verify_delete);
    $result_verify_delete = mysqli_stmt_get_result($verify_delete);

    if (mysqli_num_rows($result_verify_delete) > 0) {
        $delete_content = mysqli_prepare($conn, "DELETE FROM `content_aboutus` WHERE id = ?");
        mysqli_stmt_bind_param($delete_content, 'i', $delete_id);
        mysqli_stmt_execute($delete_content);
        $success_msg[] = 'Conținutul selectat a fost șters';
    } else {
        $warning_msg[] = 'Conținutul selectat a fost deja șters';
    }
    mysqli_stmt_close($verify_delete);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload_Content</title>
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
            <h3>Aici poti pune pozele pentru sectiunea despre noi!</h3>
            <input type="file" name="fisier" id="file" required class="box">
            <textarea name="descriere" class="box" placeholder="Introdu detalii despre sportul ales" maxlength="" cols="30" rows="10" class="box"></textarea>
            <select name="tipSport" class="box" required>
                <option value="" disabled selected>selectează tipul de sport--</option>
                <option value="Fotbal">Fotbal</option>
                <option value="Baschet">Baschet</option>
                <option value="Tenis">Tenis</option>
                <option value="Înot">Înot</option>
            </select>
            <div>
                <button type="submit" name="submit" class="btn">Adaugă</button>
            </div>
        </form>
    </section>
    <section class="antrenori" style="padding-top: 0;">
        <div class="heading"><h1>Lista noastră de conținut!</h1></div>
        <div class="box-container">
            <?php
                $select_content = mysqli_query($conn, "SELECT * FROM `content_aboutus`");
                if (mysqli_num_rows($select_content) > 0) {
                    while ($content = mysqli_fetch_assoc($select_content)) {
            ?>
                    <div class="box">
                        <img src="../images/<?= $content['nume']; ?>" alt="" class="image">
                       
                        <h3 class="title" style="font-size:18px"><?= $content['tipSport']; ?></h3>
                        <h3 class="title" style="font-size:18px">Id: <?= $content['id']; ?></h3>
                        <form action="" method="post">
                            <input type="hidden" name="delete_id" value="<?= $content['id']; ?>">
                            <button type="submit" class="inline-delete-btn" name="delete_content" onclick="return confirm('Ești sigur ca vrei să ștergi acest conținut?');">Șterge conținutul</button>
                        </form>
                       
                    </div>
                    <?php
                    }
                } else {
                    echo '<p class="empty">Deocamdată nu avem conținut pentru acest tip de sport!</p>';
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

