<?php
    include '../admin/database.php';
    session_start();
    if(isset($_GET['user_id'])){
        $user_id = $_GET['user_id'];
    }else{
        $user_id = '';
        header('Page_Log_In.php');
    }
    if(isset($_GET['antrenor_id'])){
        $antrenor_id = $_GET['antrenor_id'];
    }else{
        $antrenor_id = '';
        header('location:Fotbal_Page.php');
        exit();
    }
    function get_curent_date(){
        return date('Y-m-d');
    }
    function is_future_time($date, $time){
        $current_date = date('Y-m-d');
        $current_time = date('H:i');
    
        if ($date > $current_date) {
            return true;
        } elseif ($date == $current_date && $time > $current_time) {
            return true;
        }
        return false;
    }
    if(isset($_POST['submit'])){

        if($user_id != ''){
            $nume = $_POST['nume'];
            $nume = filter_var($nume, FILTER_SANITIZE_STRING);
            $varsta = $_POST['varsta'];
            $varsta = filter_var($varsta, FILTER_SANITIZE_NUMBER_INT);
            $description = $_POST['description'];
            $description = filter_var($description, FILTER_SANITIZE_STRING);
            $date = $_POST['date'];
            $date = filter_var($date, FILTER_SANITIZE_STRING);
            $time = $_POST['ora'];
            $time = filter_var($time, FILTER_SANITIZE_STRING);
            $data = get_curent_date();
           
            $start_time = date("H:i:s", strtotime($time) - 3600);
            $end_time = date("H:i:s", strtotime($time) + 3600);
            if (strtotime($date) < strtotime($data)) {
                $warning_msg[] = 'Data rezervării trebuie să fie validă!';
            } elseif (!is_future_time($date, $time)) {
                $warning_msg[] = 'Ora rezervării trebuie să fie validă!';
            }else{
                $verify_reservation = mysqli_prepare($conn, "SELECT * FROM `rezervari` WHERE antrenor_id = ? AND user_id = ? AND date = ? AND (ora BETWEEN ? AND ?)");
                mysqli_stmt_bind_param($verify_reservation, 'iisss', $antrenor_id, $user_id, $date, $start_time, $end_time);
                mysqli_stmt_execute($verify_reservation);
                $result_verify_reservation = mysqli_stmt_get_result($verify_reservation);
    
                if (mysqli_num_rows($result_verify_reservation) > 0) {
                    $warning_msg[] = 'Există deja o rezervare în intervalul de o oră înainte și după ora propusă!';
                } else {
                    $add_reservation = mysqli_prepare($conn, "INSERT INTO `rezervari` (antrenor_id, user_id, nume, descriere, date, ora, data, varsta) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    mysqli_stmt_bind_param($add_reservation, 'iisssssi', $antrenor_id, $user_id, $nume, $description, $date, $time, $data, $varsta);
                    mysqli_stmt_execute($add_reservation);
                    $success_msg[] = 'Rezervare adăugată!';
                }
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
            <title>Adaugă o rezervare</title>
            <link rel="stylesheet" href="../css/review_style.css">
            <link rel="icon" type="image/png" href="images/fotbal_icon.png"/>
    </head>
    <body>
    <section class="add_review_form">

    <form action="" method="post">
        <h3>Postează o rezervare</h3>
        <p class="placeholder"><b>Nume și prenume</b></p>
        <input type="text" name="nume" required maxlength="50" placeholder="Introdu nume și prenumele" class="box">
        <p class="placeholder"><b>Vârstă</b></p>
        <input type="number" name="varsta" required maxlength="50" placeholder="Introdu vârsta ta" class="box">
        <p class="placeholder"><b>Detaliile Rezervării</b></p>
        <textarea name="description" class="box" placeholder="Introdu detaliile rezervării" maxlength="1000" cols="30" rows="10"></textarea>
        <p class="placeholder"><b>Data Rezervării</b></p>
        <input type="date" name="date" required class="box">
        <p class="placeholder"><b>Ora Rezervării</b></p>
        <input type="time" name="ora" required class="box">
        <input type="submit" value="Trimite rezervare!" name="submit" class="inline-btn">
        <a href="../acasa.php" class="inline-btn">Întoarce-te la pagina principală!</a>
    </form>

    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php 
            include '../alertmessages.php';
    ?>

    </body>
</html>