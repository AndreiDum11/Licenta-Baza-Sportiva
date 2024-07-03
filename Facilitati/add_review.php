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

        if($user_id != ''){
            $title = $_POST['title'];
            $title = filter_var($title, FILTER_SANITIZE_STRING);
            $description = $_POST['description'];
            $description = filter_var($description, FILTER_SANITIZE_STRING);
            $rating = $_POST['rating'];
            $rating = filter_var($rating, FILTER_SANITIZE_STRING);
            $data = get_curent_date();

            $verify_review = mysqli_prepare($conn, "SELECT * FROM `reviews` WHERE antrenor_id = ? AND user_id = ?");
            mysqli_stmt_bind_param($verify_review, 'ii', $antrenor_id, $user_id);
            mysqli_stmt_execute($verify_review);
            $result_verify_review = mysqli_stmt_get_result($verify_review);

            if(mysqli_num_rows($result_verify_review) > 0){
                $warning_msg[] = 'Review-ul tău a fost deja introdus!';
            }else{
                $add_review = mysqli_prepare($conn, "INSERT INTO `reviews` (antrenor_id, user_id, rating, titlu, descriere,data) VALUES ( ?, ?, ?, ?, ?,?)");
                mysqli_stmt_bind_param($add_review, 'iissss', $antrenor_id, $user_id, $rating, $title, $description,$data);
                mysqli_stmt_execute($add_review);
                $success_msg[] = 'Review adăugat!';
            }

            

        }else{
            $warning_msg[] = 'Te rog sa te înregistrezi înainte de a lăsa un review!';
    }

    }

    ?>

    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Adaugă un review</title>
            <link rel="stylesheet" href="../css/review_style.css">
            <link rel="icon" type="image/png" href="../images/fotbal_icon.png"/>
    </head>
    <body>
    <section class="add_review_form">

        <form action="" method="post">
            <h3>Postează un review</h3>
            <p class="placeholder"><b>Subiectul Review-ului</b></p>
            <input type="text" name="title" required maxlength="50" placeholder="Introdu subiectul review-ului" class="box">
            <p class="placeholder"><b>Detaliile Review-ului</b></p>
            <textarea name="description" class="box" placeholder="Introdu un review" maxlength="1000" cols="30" rows="10"></textarea>
            <p class="placeholder"><b>Review rating</b></p>
            <select name="rating" class="box" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <input type="submit" value="Trimite review!" name="submit" class="inline-btn">
            <a href="antrenor_profile.php?antrenor_id=<?= $antrenor_id; ?>" class="inline-btn">Întoarce-te la pagina de review uri a antrenorului!</a>
        </form>

    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php 
        include '../alertmessages.php';
    ?>
    </body>
</html>
