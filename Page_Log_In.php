<!DOCTYPE html>
<html>
<head>  
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name ="viewport" content="width=device-width,initial-scale = 1.0">
    <title>DC Sports</title>
    <link rel="stylesheet" href="css/style_log.css">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   
</head>
<body>
   <?include 'alertmessages.php'?>
    <div class="wrapper">
        <span class="css-animation"></span>
        <span class="css-animation2"></span>
         <div class="row">
            <div class="col-lg-6 col-12">  
                <div class="form-box-login" class="col-lg-6 col-md-6 col-12">
                    <h2 class="animation" style="--i:0;">Autentificare</h2>
                    <form action="http://localhost:8888/Licenta2.0/SignIn.php" method="post" >
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">       
                                <div class="input-box animation" style="--i:1;">
                                     <input type="text" name="username" id="username" required>
                                     <label>Nume utilizator</label>
                                     <i class='bx bx-user-circle'></i>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">  
                                <div class="input-box animation" style="--i:2;">
                                    <input type="password" name="password" id="password" required>
                                    <label>Parola</label>
                                    <i class='bx bx-lock' id="togglePassword"></i>
                                </div>
                            </div>
                        
                            <button type="submit" id="login "class="btn animation" style="--i:3;">Autentificare</button>
                            <div class="logreg-link animation" style="--i:4;">
                                    <p>Nu ai încă un cont? <a href="#" onclick="refresh()"  class="register-link">Înregistrează-te</a></p>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="description-info login">
                    <h2 class="animation" style="--i:0">DC Sports</h2>
                    <p class="animation" style="--i:1">Succesul este suma micilor eforturi repetate zi de zi!</p>
                </div>

            </div>
            <div class="form-box-register">
                <h2 class="animation" style="--j:17">Înregistrează-te</h2>
                <form action="http://localhost:8888/Licenta2.0/Register.php" method="post" >
                    <div class="input-box animation" style="--j:18">
                        <input type="text" name="username1" id="username1" required>
                        <label>Nume utilizator</label>
                        <i class='bx bx-user-circle'></i>
                    </div>
                    <div class="input-box animation" style="--j:19">
                        <input type="password" name="password1" id="password1" required>
                        <label>Parola</label>
                        <i class='bx bx-lock' id="togglePassword1"></i>
                    </div>
                    <div class="input-box animation" style="--j:20">
                        <input type="email" name="email" id="email" required>
                        <label>Email</label>
                        <i class='bx bx-envelope'></i>
                    </div>
        
                    <button type="submit" id="register" class="btn animation" style="--j:21">Înregistrează-te</button>
                    <div class="logreg-link animation" style="--i:22;">
                        <p>Ai deja un cont? <a href="#" onclick="refresh()" class="login-link" style="--j:22">Autentifică-te</a></p>
                    </div>
                </form>
            </div>
            <div class="description-info register">
                <h2 class="animation" style="--j:23">DC Sports</h2>
                <p class="animation" style="--j:24">Bine ai venit la baza noastră sportivă!</p>
            </div>
       
        </div>
    </div>
    <script src="js/transition.js"></script>
    <script src="js/password.js"></script>
    <script src="js/refreshpage.js"></script>
      
            

    
   
    
</body>
</html>