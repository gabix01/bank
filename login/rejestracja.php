<?php

	session_start();
	
	if (isset($_POST['email']))
	{
		
		$wszystko_OK=true;
		
		
		$name = $_POST['name'];
		
		
		if ((strlen($name)<3) || (strlen($name)>40))
		{
			$wszystko_OK=false;
			$_SESSION['e_name']="name musi posiadać od 3 do 40 znaków!";
		}

		
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		
		$password = $_POST['password'];
		
		if ((strlen($password)<8) || (strlen($password)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		

		$haslo_hash = password_hash($password, PASSWORD_DEFAULT);
		
		
		if (!isset($_POST['regulamin']))
		{
			$wszystko_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
		}				
		
		
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_name'] = $name;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_passowrd'] = $password;
		$_SESSION['fr_mobile'] = $mobile;
		$_SESSION['fr_gender'] = $gender;
		$_SESSION['fr_dob'] = $dob;
		if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$rezultat = $polaczenie->query("SELECT id FROM customer WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		

				//Czy name jest już zarezerwowany?
				$rezultat = $polaczenie->query("SELECT id FROM customer WHERE user='$name'");
				
	
				if ($wszystko_OK==true)
				{
					
					
					if ($polaczenie->query("INSERT INTO customer VALUES (NULL, '$name','$gener','$dob','poznan','savings','$mobile','$email','$password','poznan','K421A','0000-00-00 00:00:00','ACTIVE'"))
					{
						$_SESSION['udana rejestracja']=true;
						header('Location: uzyt.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
		
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>
</head>
<body>

	<img class="wave" src="img/wave.png">
	<div class="container">
		<div class="img">
			<img src="img/avatar.svg">
		</div>
		<div class="login-content">
			<form  method="post">
	
				<h2 class="title">Rejestracja</h2>
                <div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Imię i Nazwisko</h5>
           		   		<input type="text" name="name"  value="<?php
			if (isset($_SESSION['fr_name']))
			{
				echo $_SESSION['fr_name'];
				unset($_SESSION['fr_name']);
			}
		?>" name="name" /><br />
		
		<?php
			if (isset($_SESSION['e_name']))
			{
				echo '<div class="error">'.$_SESSION['e_name'].'</div>';
				unset($_SESSION['e_name']);
			}
		?> 
           		   </div>
           		</div>
                   <div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Numer telefonu</h5>
           		   		<input type="text" name="mobile" value="<?php
			if (isset($_SESSION['fr_mobile']))
			{
				echo $_SESSION['fr_mobile'];
				unset($_SESSION['fr_mobile']);
			}
		?>" name="mobile" /><br />
		
		<?php
			if (isset($_SESSION['e_mobile']))
			{
				echo '<div class="error">'.$_SESSION['e_mobile'].'</div>';
				unset($_SESSION['e_mobile']);
			}
		?> 
           		   </div>
           		</div>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>E-mail</h5>
           		   		<input type="text" name="email" value="<?php
			if (isset($_SESSION['fr_email']))
			{
				echo $_SESSION['fr_email'];
				unset($_SESSION['fr_email']);
			}
		?>" name="email" /><br />
		
		<?php
			if (isset($_SESSION['e_email']))
			{
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}
		?> 
           		   </div>
           		</div>
                   <div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Płeć(K-kobiet)/(M-mężczyzna)</h5>
           		   		<input type="text" name="gender" value="<?php
			if (isset($_SESSION['fr_gender']))
			{
				echo $_SESSION['fr_gender'];
				unset($_SESSION['fr_gender']);
			}
		?>" name="gender" /><br />
		
		<?php
			if (isset($_SESSION['e_gender']))
			{
				echo '<div class="error">'.$_SESSION['e_gender'].'</div>';
				unset($_SESSION['e_gender']);
			}
		?> 
           		   </div>
           		</div>
                   <div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Data Urodzenia</h5>
           		   		<input type="text" name="dob" id="datepicker" value="<?php
			if (isset($_SESSION['fr_dob']))
			{
				echo $_SESSION['fr_dob'];
				unset($_SESSION['fr_dob']);
			}
		?>" name="dob" /><br />
		
		<?php
			if (isset($_SESSION['e_dob']))
			{
				echo '<div class="error">'.$_SESSION['e_dob'].'</div>';
				unset($_SESSION['e_dob']);
			}
		?> 
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>HASŁO</h5>
           		    	<input type="password" class="input" name="password" value="<?php
			if (isset($_SESSION['fr_passowrd']))
			{
				echo $_SESSION['fr_passowrd'];
				unset($_SESSION['fr_passowrd']);
			}
		?>" name="password" /><br />
		
		<?php
			if (isset($_SESSION['e_haslo']))
			{
				echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
				unset($_SESSION['e_haslo']);
			}
		?>		
            	   </div>
            	</div>
				<label>
			<input type="checkbox" name="regulamin" <?php
			if (isset($_SESSION['fr_regulamin']))
			{
				echo "checked";
				unset($_SESSION['fr_regulamin']);
			}
				?>/> Akceptuję regulamin
		</label>
		<?php
			if (isset($_SESSION['e_regulamin']))
			{
				echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
				unset($_SESSION['e_regulamin']);
			}
		?>	

            	<input type="submit" class="btn" value="Zarejestruj się">
				
      
            </form>

  </div>
    </div>
    <script type="text/javascript" src="main.js"></script>
</body>
</html>