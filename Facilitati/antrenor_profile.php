<?php
    include '../admin/database.php';
    session_start();
    if(isset($_GET['antrenor_id'])){
        $antrenor_id = $_GET['antrenor_id'];
    }else{
        $antrenor_id = '';
        header('location:acasa.php');
    }
    $user_id = $_SESSION['user_id'] ?? '';
    if (isset($_POST['delete_review'])) {

        $delete_id = $_POST['delete_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    
        
        $verify_delete = mysqli_prepare($conn, "SELECT * FROM `reviews` WHERE id = ?");
        mysqli_stmt_bind_param($verify_delete, 'i', $delete_id);
        mysqli_stmt_execute($verify_delete);
        $result_verify_delete = mysqli_stmt_get_result($verify_delete);
    
        if (mysqli_num_rows($result_verify_delete) > 0) {
           
            $delete_review = mysqli_prepare($conn, "DELETE FROM `reviews` WHERE id = ?");
            mysqli_stmt_bind_param($delete_review, 'i', $delete_id);
            mysqli_stmt_execute($delete_review);
            $success_msg[] = 'Review șters!';
        } else {  
            $warning_msg[] = 'Review-ul a fost deja șters!';
        }
    
        mysqli_stmt_close($verify_delete);
        mysqli_stmt_close($delete_review);
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Antrenor</title>
    <link rel="stylesheet" href="../css/style_antrenor.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel='stylesheet'href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' >
    <link rel="icon" type="image/png" href="../images/fotbal_icon.png"/>
</head>
<body>
    <section class="profil_antrenor">
        <div class="heading">
            <h1>Profilul Antrenorului</h1>
            <a href="../acasa.php" class="inline-btn">Pagina Principală</a>
        </div>
        <?php
            $select_coaches = mysqli_query($conn,"SELECT * FROM `antrenori` WHERE id = $antrenor_id ");
            if(mysqli_num_rows($select_coaches) > 0){
                while($coach = mysqli_fetch_assoc($select_coaches)){

                    $total_ratings = 0;
                    $rating_1 = 0;
                    $rating_2 = 0;
                    $rating_3 = 0;
                    $rating_4 = 0;
                    $rating_5 = 0;
            
                    $select_ratings = mysqli_prepare($conn, "SELECT * FROM `reviews` WHERE antrenor_id = ?");
                    mysqli_stmt_bind_param($select_ratings, 'i', $coach['id']);
                    mysqli_stmt_execute($select_ratings);
                    $result_ratings = mysqli_stmt_get_result($select_ratings);
                    $total_reviews = mysqli_num_rows($result_ratings);
            
                    while ($fetch_rating = mysqli_fetch_assoc($result_ratings)) {
                        $total_ratings += $fetch_rating['rating'];
                        if ($fetch_rating['rating'] == 1) {
                            $rating_1 += 1;
                        }
                        if ($fetch_rating['rating'] == 2) {
                            $rating_2 += 1;
                        }
                        if ($fetch_rating['rating'] == 3) {
                            $rating_3 += 1;
                        }
                        if ($fetch_rating['rating'] == 4) {
                            $rating_4 += 1;
                        }
                        if ($fetch_rating['rating'] == 5) {
                            $rating_5 += 1;
                        }
                    }
            
                    if ($total_reviews != 0) {
                        $average = round($total_ratings / $total_reviews, 1);
                    } else {
                        $average = 0;
                    }     
            ?>
    <div class="row">
        <div class="col">
            <img src="../<?= $coach['poza']; ?>" alt="" class="image">
            <h3 class="title"><?= $coach['nume']; ?></h3>
            <h3 class="title">Vârsta antrenorului: <?= $coach['varsta'];?> de ani</h3>
      </div>
      <div class="col">
         <div class="flex">
            <div class="total-reviews">
               <h3><?= $average; ?><i class="fas fa-star"></i></h3>
               <p><?= $total_reviews; ?> Reviews</p>
            </div>
            <div class="total-ratings">
               <p>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <span><?= $rating_5; ?></span>
               </p>
               <p>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <span><?= $rating_4; ?></span>
               </p>
               <p>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <span><?= $rating_3; ?></span>
               </p>
               <p>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <span><?= $rating_2; ?></span>
               </p>
               <p>
                  <i class="fas fa-star"></i>
                  <span><?= $rating_1; ?></span>
               </p>
            </div>
         </div>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Nu s a gasit antrenorul cu id ul respectiv!</p>';
      }
   ?>
    </section>
    <section class="review_antrenor">
        <div class="heading">
            <h1>user's reviews</h1> 
            <a href="add_review.php?antrenor_id=<?= $antrenor_id; ?>" class="inline-btn" style="margin-top: 0;">Adaugă un review</a>
        </div>

        <div class="box-container">
        <?php
            $select_reviews = mysqli_prepare($conn, "SELECT * FROM `reviews` WHERE antrenor_id = ?");
            mysqli_stmt_bind_param($select_reviews, 'i', $antrenor_id);
            
            mysqli_stmt_execute($select_reviews);
            $result_reviews = mysqli_stmt_get_result($select_reviews);

            if (mysqli_num_rows($result_reviews) > 0) {
                while ($fetch_review = mysqli_fetch_assoc($result_reviews)) {
        ?>
            <div class="box" 
                <?php 
                    if($fetch_review['user_id'] == $user_id){
                        echo 'style="order: -1;"';
                        };
                ?>>
                <?php
                    $select_user = mysqli_prepare($conn, "SELECT * FROM `user` WHERE id = ?");
                    mysqli_stmt_bind_param($select_user, 'i', $fetch_review['user_id']);
                    mysqli_stmt_execute($select_user);
                    $result_user = mysqli_stmt_get_result($select_user);
                    while ($fetch_user = mysqli_fetch_assoc($result_user)) {
                ?>
                    <div class="user">
                        <div>
                            <p><?= $fetch_user['username']; ?></p>
                            <span><?= $fetch_review['data']; ?></span>
                        </div>
                    </div>
                <?php 
                    };
                ?>
            <div class="ratings">
                <?php if($fetch_review['rating'] == 1){ ?>
                    <p style="background:#df1b3f;"><i class="fas fa-star"></i> <span><?= $fetch_review['rating']; ?></span></p>
                <?php }; ?> 
                <?php if($fetch_review['rating'] == 2){ ?>
                    <p style="background:#19204e;"><i class="fas fa-star"></i> <span><?= $fetch_review['rating']; ?></span></p>
                <?php }; ?>
                <?php if($fetch_review['rating'] == 3){ ?>
                    <p style="background:#19204e;"><i class="fas fa-star"></i> <span><?= $fetch_review['rating']; ?></span></p>
                <?php }; ?>   
                <?php if($fetch_review['rating'] == 4){ ?>
                    <p style="background:#19204e;"><i class="fas fa-star"></i> <span><?= $fetch_review['rating']; ?></span></p>
                <?php }; ?>
                <?php if($fetch_review['rating'] == 5){ ?>
                    <p style="background:#19204e;"><i class="fas fa-star"></i> <span><?= $fetch_review['rating']; ?></span></p>
                <?php }; ?>
            </div>
            <h3 class="title"><?= $fetch_review['titlu']; ?></h3>
            <?php if($fetch_review['descriere'] != ''){ ?>
                <p class="description"><?= $fetch_review['descriere']; ?></p>
            <?php }; ?>  
            <?php if($fetch_review['user_id'] == $user_id){ ?>
                <form action="" method="post" class="flex-btn">
                    <input type="hidden" name="delete_id" value="<?= $fetch_review['id']; ?>">
                    <a href="update_review.php?antrenor_id=<?= $fetch_review['id']; ?>" class="inline-option-btn">Editează-ți review-ul</a>
                    <input type="submit" value="Șterge review" class="inline-delete-btn" name="delete_review" onclick="return confirm('Ești sigur ca vrei să ștergi acest review?');">
                </form>
            <?php }; ?>   
        </div>
        <?php
            }
        } else {
            echo '<p class="empty">Nu există niciun review despre acest antrenor!</p>';
        }
        ?>

        </div>

    </section>
</body>
</html>