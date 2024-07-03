
<?php
require_once 'database.php';


if(isset($_POST['submit'])){
    require 'news.php';
    $file = new news;
    $file->setName($_FILES['fisier']['name']);
    $file->setType($_FILES['fisier']['type']);
    $file->settipSport($_POST['tipSport']);  
    $file->setdescriere($_POST['descriere']);  
    $file->setUploadedDate(date("Y-m-d"));
    if($file->insert()){
        if(move_uploaded_file($_FILES['fisier']['tmp_name'],'../images_news/'.$_FILES['fisier']['name'])){
            $success_msg[]="Știre salvata";
        }else{
            $warning_msg[]= 'Upload esuat';
        }
    }else{
        $error_msg[]='Insertul a esuat';
    }
}

if (isset($_POST['delete_news'])) {
    $delete_id = $_POST['delete_id'];
    $delete_id= filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_delete = mysqli_prepare($conn, "SELECT * FROM `news` WHERE id = ?");
    mysqli_stmt_bind_param($verify_delete, 'i', $delete_id);
    mysqli_stmt_execute($verify_delete);
    $result_verify_delete = mysqli_stmt_get_result($verify_delete);

    if (mysqli_num_rows($result_verify_delete) > 0) {
        $delete_news = mysqli_prepare($conn, "DELETE FROM `news` WHERE id = ?");
        mysqli_stmt_bind_param($delete_news, 'i', $delete_id);
        mysqli_stmt_execute($delete_news);
        $success_msg[] = 'Știrea selectată a fost ștearsă';
    } else {
        $warning_msg[] = 'Știrea selectată a fost deja ștearsă';
    }
    mysqli_stmt_close($verify_delete);
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Upload_Știri</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="../css/style_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>

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
            <h3>Aici poti pune detaliile pentru sectiunea de news!</h3>
            <input type="file" name="fisier" id="file" required class="box">
            <textarea name="descriere" class="box" placeholder="Introdu articolul în limita a 250 de cuvinte" maxlength="1000" cols="30" rows="10" class="box"></textarea>
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
        <div class="heading"><h1>Lista noastră de știri!</h1></div>
        <div class="box-container">
            <?php
                $select_news = mysqli_query($conn, "SELECT * FROM `news`");
                if (mysqli_num_rows( $select_news) > 0) {
                    while ($news = mysqli_fetch_assoc( $select_news)) {
                        
            ?>
            <div class="box">
                <img src="../images_news/<?= $news['nume']; ?>" alt="" class="image">
                <h3 class="title"><?= $news['nume']; ?></h3>
                <h3 class="title" style="font-size:18px"><?= $news['tipSport']; ?></h3>
               
                <form action="" method="post">
                    <input type="hidden" name="delete_id" value="<?= $news['id']; ?>">
                    <button type="submit" class="inline-delete-btn" name="delete_news" onclick="return confirm('Ești sigur ca vrei să ștergi această știre?');">Șterge știrea</button>
                </form>
               
            </div>
            <?php
                    }
                } else {
                    echo '<p class="empty">Deocamdată nu avem antrenori pentru acest tip de sport!</p>';
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