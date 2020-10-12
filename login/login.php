<?php

    session_start();

    if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
    {
        header('Location: uzyt.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<title>Orion Bank login</title>
	<meta name="description" content="Orion bank - najlepszy bank w Polsce" />
	<meta name="keywords" content=" bank,Orio,konto,pieniądze,kredy,rata" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<a href="/bank">Powrót do strony głównej </a>
	<img class="wave" src="img/wave.png">
	<div class="container">
		<div class="img">
			<img src="img/avatar.svg">
		</div>
		<div class="login-content">
			<form action="zaloguj.php" method="post">
				<img src="img/bg.svg">
				<h2 class="title">Zaloguj się</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>E-mail</h5>
           		   		<input type="text" name="login" />
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>HASŁO</h5>
           		    	<input type="password" class="input" name="haslo">
            	   </div>
            	</div>
				<a href="rejestracja.php">Zarejestruj się!</a>
            	<a href="zapomniałem.php">Zapomniałeś hasła?</a>
            	<input type="submit" class="btn" value="Login">
				<?php
   if(isset($_SESSION['blad']))  echo $_SESSION['blad'];
?>
      
            </form>

  </div>
    </div>
    <script type="text/javascript" src="main.js"></script>
</body>
</html>