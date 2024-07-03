<?php
    include("database.php");
   
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            $_SESSION['admin_id'] = null;
            $sql_command = $conn->prepare("SELECT id, parola FROM conturi_admin WHERE nume = ?");
            $sql_command->bind_param("s", $username);
            $sql_command->execute();
            $sql_command->store_result();

            if ( $sql_command->num_rows > 0) {
                $sql_command->bind_result($id, $hashed_password);
                $sql_command->fetch();
        
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['admin_id'] = $id;
                    echo "<script type='text/javascript'>alert('Te ai conectat cu succes!'); window.location.href='admin_page.php';</script>";
                } else {
                    echo "<script type='text/javascript'>alert('Verifică parola introdusă!'); window.location.href='login_admin.php';</script>";  
                }
            } else {
                echo "<script type='text/javascript'>alert('Verifică numele introdus!'); window.location.href='login_admin.php';</script>";
                
            }
            
        }
        $stmt->close();
?>