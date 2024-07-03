<?php
include("admin\database.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $new_username = filter_input(INPUT_POST, "username1", FILTER_SANITIZE_STRING);
    $new_password = filter_input(INPUT_POST, "password1", FILTER_SANITIZE_STRING);
    $new_email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING); 


    $check_username = $conn->prepare("SELECT id FROM user WHERE username = ?");
    $check_username->bind_param("s", $new_username);
    $check_username->execute();
    $check_username->store_result();

    if($check_username->num_rows > 0){
        echo "<script type='text/javascript'>alert('Numele de utilizator este deja folosit!'); window.location.href='Page_Log_In.php';</script>";
       
    } else {

        $hash = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user(username, password, email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $new_username, $hash, $new_email);

        if($stmt->execute()){
        
            echo "<script type='text/javascript'>alert('Cont creat cu succes,revino la pagina de autentificare!'); window.location.href='Page_Log_In.php';</script>";
        } else {
            echo "<script type='text/javascript'>alert('A apărut o eroare la înregistrare!'); window.location.href='Page_Log_In.php';</script>";
        }

        
    }
}
$conn->close();
?>
