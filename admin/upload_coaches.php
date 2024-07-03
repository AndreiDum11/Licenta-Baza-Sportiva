<?php
require_once 'database.php';


if (isset($_POST['submit'])) {
    require 'coaches.php';
    $coach = new coaches;
    $coach->setName($_POST['nume']);
    $coach->setPoza('images_antrenori/'.$_FILES['fisier']['name']);
    $coach->setVarsta($_POST['varsta']);
    $coach->settipSport($_POST['tipSport']);

    if ($coach->insert()) {
        if (move_uploaded_file($_FILES['fisier']['tmp_name'], '../images_antrenori/'.$_FILES['fisier']['name'])) {
            $success_msg[]= 'Profil salvat';
        } else {
            $warning_msg[]= 'Upload esuat';
        }
    } else {
        $error_msg[]='Insertul a esuat';
    }
}

if (isset($_POST['delete_coach'])) {
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_delete = mysqli_prepare($conn, "SELECT * FROM `antrenori` WHERE id = ?");
    mysqli_stmt_bind_param($verify_delete, 'i', $delete_id);
    mysqli_stmt_execute($verify_delete);
    $result_verify_delete = mysqli_stmt_get_result($verify_delete);

    if (mysqli_num_rows($result_verify_delete) > 0) {
        $delete_coach = mysqli_prepare($conn, "DELETE FROM `antrenori` WHERE id = ?");
        mysqli_stmt_bind_param($delete_coach , 'i', $delete_id);
        mysqli_stmt_execute($delete_coach );
        $success_msg[] = 'Profilul antrenorului a fost șters!';
    } else {
        $warning_msg[] = 'Profilul antrenorului a fost deja șters!';
    }
    mysqli_stmt_close($verify_delete);
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <title>Upload_Antrenori</title>
</head>
<body>
    <section class="header" >
            <a href="admin_page.php" class="logo"> </i>DC Sports</a>
            <nav class="navbar">
                <a class="nav-link click-scroll" href="admin_page.php">Acasa</a>
                <a href="logout.php">Logout</a>     
            </nav> 
    </section>
    <section class="add">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Aici poți adauga un antrenor nou!</h3>
            <input type="text" name="nume" placeholder="Introdu numele antrenorului" required class="box">
            <input type="file" name="fisier" id="file" required class="box">
            <input type="text" name="varsta" id="varsta" placeholder="Introdu varsta" required class="box">
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
        <div class="heading"><h1>Lista noastră de antrenori!</h1></div>
        <div class="box-container">
            <?php
                $select_coaches = mysqli_query($conn, "SELECT * FROM `antrenori`");
                if (mysqli_num_rows($select_coaches) > 0) {
                    while ($coach = mysqli_fetch_assoc($select_coaches)) {
                        $coach_id = $coach['id'];
                        $count_reviews = mysqli_query($conn, "SELECT * FROM `reviews` WHERE antrenor_id = $coach_id");
                        $total_reviews = mysqli_num_rows($count_reviews);
            ?>
            <div class="box">
                <img src="../<?= $coach['poza']; ?>" alt="" class="image">
                <h3 class="title"><?= $coach['nume']; ?></h3>
                <h3 class="title" style="font-size:18px"><?= $coach['tipSport']; ?></h3>
                <p class="total-reviews"><i class="fas fa-star"></i> <span><?= $total_reviews; ?></span></p>
                <form action="" method="post">
                    <input type="hidden" name="delete_id" value="<?= $coach['id']; ?>">
                    <button type="submit" class="inline-delete-btn" name="delete_coach" onclick="return confirm('Ești sigur ca vrei să ștergi profilul acestui antrenor?');">Șterge profilul antrenorului</button>
                </form>
                
            </div>
            <?php
                    }
                } else {
                    echo '<p class="empty">Deocamdată nu avem antrenori înregistrați!</p>';
                }
            ?>
        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php 
        include '../alertmessages.php';
    ?>
</body>
</html>
