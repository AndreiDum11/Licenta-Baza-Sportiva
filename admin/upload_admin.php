<?php
require_once 'database.php';

$warning_msg = [];
$success_msg = [];
$error_msg = [];

if(isset($_POST['add'])){
    $new_username = filter_input(INPUT_POST, "nume", FILTER_SANITIZE_STRING);
    $new_password = filter_input(INPUT_POST, "parola", FILTER_SANITIZE_STRING);
    
    $check_username = $conn->prepare("SELECT id FROM conturi_admin WHERE nume = ?");
    $check_username->bind_param("s", $new_username);
    $check_username->execute();
    $check_username->store_result();

    if($check_username->num_rows > 0){
        $warning_msg[] = 'Numele pentru contul de admin este deja folosit';
    } else {

        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO conturi_admin(nume, parola) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $new_username, $hash); 

        if($stmt->execute()){
            $success_msg[] = 'Cont creat cu succes!';
        } else {
            $error_msg[] = 'A apărut o eroare la înregistrare: ' . $stmt->error;
        }
    }

    $check_username->close(); 

}

if (isset($_POST['delete_cont_admin'])) {
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_delete = $conn->prepare("SELECT * FROM conturi_admin WHERE id = ?");
    $verify_delete->bind_param('i', $delete_id);
    $verify_delete->execute();
    $result_verify_delete = $verify_delete->get_result();

    if ($result_verify_delete->num_rows > 0) {
        $delete_admin = $conn->prepare("DELETE FROM conturi_admin WHERE id = ?");
        $delete_admin->bind_param('i', $delete_id);
        $delete_admin->execute();
        $success_msg[] = 'Contul a fost șters!';
    } else {
        $warning_msg[] = 'Contul a fost deja șters!';
    }
    $verify_delete->close();
}

$sql_command = "SELECT * FROM conturi_admin";
$result = $conn->query($sql_command);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <title>Conturi_Admin</title>
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
        <form action="" method="post" enctype="multipart/form-data"> <!-- corectat method -->
            <h3>Aici poți adauga un cont de admin nou!</h3>
            <input type="text" name="nume" placeholder="Introdu numele" required class="box">
            <input type="password" name="parola" placeholder="Introdu parola" required class="box">
            <div>
                <button type="submit" name="add" class="btn btn-primary">Adaugă</button> <!-- corectat name -->
            </div>
        </form>
    </section>
    <section class="table" style="margin:25px; padding:15px;">
        <h3>Lista conturi admin</h3>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nume Admin</th>
                    <th>Șterge cont</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!$result) {
                    echo "<h3>Nu sunt conturi de admin încă!</h3>";
                } else {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $row["id"] . "</td>
                            <td>" . $row["nume"] . "</td>
                            <td>
                                <form method='post' action=''>
                                    <input type='hidden' name='delete_id' value='" . $row["id"] . "'>
                                    <button type='submit' class='btn btn-danger btn-sm' name='delete_cont_admin' onclick='return confirm(\"Ești sigur ca vrei să ștergi aceast cont de admin?\");'>Șterge cont!</button>
                                </form>
                            </td>
                        </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php 
        include '../alertmessages.php';
    ?>
</body>
</html>