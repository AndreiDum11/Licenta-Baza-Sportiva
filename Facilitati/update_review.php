<?php

    include '../admin/database.php';
    session_start();
    function get_curent_date(){
        return date('Y-m-d');
    }
    if(isset($_GET['antrenor_id'])){
        $antrenor_id = $_GET['antrenor_id'];
    }else{
        $antrenor_id = '';
        header('location:Fotbal_Page.php');
        exit();
    }
    $user_id = $_SESSION['user_id'] ?? '';
    if(isset($_POST['submit'])){

        $title = $_POST['title'];
        $title = filter_var($title, FILTER_SANITIZE_STRING);
        $description = $_POST['description'];
        $description = filter_var($description, FILTER_SANITIZE_STRING);
        $rating = $_POST['rating'];
        $rating = filter_var($rating, FILTER_SANITIZE_STRING);
        $data = get_curent_date();

        $update_review = mysqli_prepare($conn, "UPDATE `reviews` SET rating = ?, titlu = ?, descriere = ?, data = ? WHERE user_id = ?");
        mysqli_stmt_bind_param($update_review, 'ssssi', $rating, $title, $description, $data, $user_id);
        mysqli_stmt_execute($update_review);

        if(mysqli_stmt_affected_rows($update_review) > 0){
            $success_msg[] = 'Review-ul s a editat cu succes!';
        } else {
            $warning_msg[] = 'Nu s au facut modificări!';
        }

    mysqli_stmt_close($update_review);
    }

    ?>

    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Editează review-ul</title>
            <link rel="stylesheet" href="../css/review_style.css">
            <link rel="icon" type="image/png" href="../images/fotbal_icon.png"/>
        </head>
        <body>

        <section class="add_review_form">

        <?php
            $select_review = mysqli_prepare($conn, "SELECT * FROM `reviews` WHERE id = ? ");
            mysqli_stmt_bind_param($select_review, 'i', $antrenor_id);
            mysqli_stmt_execute($select_review);
            $result = mysqli_stmt_get_result($select_review);
            if(mysqli_num_rows($result) > 0){
                while($fetch_review = mysqli_fetch_assoc($result)){
        ?>
                    <form action="" method="post">
                        <h3>Editează review-ul tău</h3>
                        <input type="hidden" name="antrenor_id" value="<?= htmlspecialchars($antrenor_id); ?>">
                        <p class="placeholder">Subiectul Review-ului</p>
                        <input type="text" name="title" required maxlength="50" placeholder="Introdu subiectul review-ului" class="box" value="<?= htmlspecialchars($fetch_review['titlu']); ?>">
                        <p class="placeholder">Detaliile Review-ului</p>
                        <textarea name="description" class="box" placeholder="Introdu un review" maxlength="1000" cols="30" rows="10"><?= htmlspecialchars($fetch_review['descriere']); ?></textarea>
                        <p class="placeholder">Review rating</p>
                        <select name="rating" class="box" required>
                            <option value="<?= htmlspecialchars($fetch_review['rating']); ?>"><?= htmlspecialchars($fetch_review['rating']); ?></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <input type="submit" value="Modifică review-ul" name="submit" class="inline-btn">
                        <a href="../acasa.php" class="inline-btn">Întoarce-te la pagina principala</a>
                    </form>
        <?php
                }
            }else{
                echo '<p class="empty">Nu s-a putut edita review-ul!</p>';
            }
            mysqli_stmt_close($select_review);
        ?>

    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <?php 
        include '../alertmessages.php';
    ?>
    </body>
</html>
