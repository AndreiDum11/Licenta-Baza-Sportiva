<?php
require_once '../admin/database.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('Page_Log_In.php');
    $user_id = '';
    
}
if (isset($_POST['delete_rezervare'])) {
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_delete = mysqli_prepare($conn, "SELECT * FROM `rezervari` WHERE id = ?");
    mysqli_stmt_bind_param($verify_delete, 'i', $delete_id);
    mysqli_stmt_execute($verify_delete);
    $result_verify_delete = mysqli_stmt_get_result($verify_delete);

    if (mysqli_num_rows($result_verify_delete) > 0) {
        $delete_coach = mysqli_prepare($conn, "DELETE FROM `rezervari` WHERE id = ?");
        mysqli_stmt_bind_param($delete_coach , 'i', $delete_id);
        mysqli_stmt_execute($delete_coach );
        $success_msg[] = 'Rezervarea a fost ștersă!';
    } else {
        $warning_msg[] = 'Rezervarea a fost deja ștersă!';
    }
    mysqli_stmt_close($verify_delete);
}


$criteriu_sortare = "";
if (isset($_POST['sort'])) {
    $criteriu_sortare = $_POST['Sort'];
}

$sql_command = "
    SELECT rezervari.*, antrenori.nume AS Nume_Antrenor, antrenori.tipSport 
    FROM rezervari 
    INNER JOIN antrenori ON rezervari.antrenor_id = antrenori.id
    WHERE rezervari.user_id = ?
";

if ($criteriu_sortare != "") {
    $sql_command .= " ORDER BY ";
    switch ($criteriu_sortare) {
        case "tipSport":
            $sql_command .= "antrenori.tipSport";
            break;
        case "Varsta":
            $sql_command .= "rezervari.varsta";
            break;
        case "Antrenor":
            $sql_command .= "antrenori.nume";
            break;
        case "Nume_user":
            $sql_command .= "rezervari.nume";
            break;
        default:
            $sql_command .= "rezervari.id"; 
    }
}

$stmt = $conn->prepare($sql_command);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_facilitati.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <title>Rezervările tale</title>
</head>
<body>
        <section class="header" >
            <a href="../acasa.php" class="logo"> <i class='bx bx-basketball'></i>DC Sports</a>
            <nav class="navbar">
                <a class="nav-link click-scroll" href="../acasa.php">Acasa</a>
                <a class="nav-link click-scroll" href="../logout.php">Logout</a>
            </nav>
            <div id="btn-meniu" class="fas fa-bars"></div>    
        </section>

    <section class="table" style="margin:25px; padding:15px;">
        <h3>Lista cu rezervări</h3>
        <form method="post" action="">
            <select name="Sort" class="box" required>
                <option value="" disabled selected>Selectează un criteriu de sortare</option>
                <option value="tipSport">tipSport</option>
                <option value="Varsta">Varsta</option>
                <option value="Antrenor">Antrenor</option>
            </select>
            <button type="submit" name="sort" class="btn btn-primary">Sortează</button>
        </form>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nume Antrenor</th>
                    <th>Nume User</th>
                    <th>User Id</th>
                    <th>Descriere</th>
                    <th>Vârstă</th>
                    <th>Data</th>
                    <th>Ora</th>
                    <th>Tip Sport</th>
                    <th>Șterge Rezervare</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!$result) {
                    echo "<h3>Nu sunt rezervări încă!</h3>";
                } else {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $row["id"] . "</td>
                            <td>" . $row["Nume_Antrenor"] . "</td>
                            <td>" . $row["nume"] . "</td>
                            <td>" . $row["user_id"] . "</td>
                            <td>" . $row["descriere"] . "</td>
                            <td>" . $row["varsta"] . "</td>
                            <td>" . $row["date"] . "</td>
                            <td>" . $row["ora"] . "</td>
                            <td>" . $row["tipSport"] . "</td>
                            <td>
                                <form method='post' action=''>
                                    <input type='hidden' name='delete_id' value='" . $row["id"] . "'>
                                    <button type='submit' class='btn btn-danger btn-sm' name='delete_rezervare' onclick='return confirm(\"Ești sigur ca vrei să ștergi această rezervare?\");'>Șterge rezervarea</button>
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
