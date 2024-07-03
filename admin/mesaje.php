<?php
require_once 'database.php';

if (isset($_POST['delete_mesaj'])) {
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_delete = mysqli_prepare($conn, "SELECT * FROM `mesaje` WHERE id = ?");
    mysqli_stmt_bind_param($verify_delete, 'i', $delete_id);
    mysqli_stmt_execute($verify_delete);
    $result_verify_delete = mysqli_stmt_get_result($verify_delete);

    if (mysqli_num_rows($result_verify_delete) > 0) {
        $delete_msg = mysqli_prepare($conn, "DELETE FROM `mesaje` WHERE id = ?");
        mysqli_stmt_bind_param($delete_msg , 'i', $delete_id);
        mysqli_stmt_execute($delete_msg );
        $success_msg[] = 'Mesajul a fost șters!';
    } else {
        $warning_msg[] = 'Mesajul a fost deja șters!';
    }
    mysqli_stmt_close($verify_delete);
}


$criteriu_sortare = "";
if (isset($_POST['sort'])) {
    $criteriu_sortare = $_POST['Sort'];
}

$sql_command = " SELECT * FROM mesaje";
$sql_command2 = "SELECT COUNT(*) FROM mesaje";
if ($criteriu_sortare != "") {
    $sql_command .= " ORDER BY ";
    switch ($criteriu_sortare) {
        case "id":
            $sql_command .= "mesaje.id";
            break;
        case "nume":
            $sql_command .= "mesaje.nume";
            break;
        default:
            $sql_command .= "mesaje.id"; 
    }
}

$result = $conn->query($sql_command);

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
    <title>Lista_Mesaje</title>
</head>
<body>
    <section class="header">
        <a href="admin_page.php" class="logo">DC Sports</a>
        <nav class="navbar">
            <a class="nav-link click-scroll" href="admin_page.php">Acasa</a>
            <a href="logout.php">Logout</a>
        </nav>
    </section>
    <section class="table" style="margin:25px; padding:15px;">
        <h3>Lista cu mesaje</h3>
        <form method="post" action="">
            <select name="Sort" class="box" required>
                <option value="" disabled selected>Selectează un criteriu de sortare</option>
                <option value="nume">Nume</option>
                <option value="id">Id-ul mesajelor</option>
            </select>
            <button type="submit" name="sort" class="btn btn-primary">Sortează</button>
        </form>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nume User</th>
                    <th>Email</th>
                    <th>Număr Telefon</th>
                    <th>Mesaj</th>
                    <th>Trimis la</th>
                    <th>Șterge Rezervare</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!$result) {
                    echo "<h3>Nu sunt mesaje încă!</h3>";
                } else {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $row["id"] . "</td>
                            <td>" . $row["nume"] . "</td>
                            <td>" . $row["email"] . "</td>
                            <td>" . $row["numartelefon"] . "</td>
                            <td>" . $row["msg"] . "</td>
                            <td>" . $row["trimis_la"] . "</td>
                            <td>
                                <form method='post' action=''>
                                    <input type='hidden' name='delete_id' value='" . $row["id"] . "'>
                                    <button type='submit' class='btn btn-danger btn-sm' name='delete_mesaj' onclick='return confirm(\"Ești sigur ca vrei să ștergi aceast mesaj?\");'>Șterge mesajul</button>
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
