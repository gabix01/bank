<?php

    session_start();

    require_once "connect.php";

    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    if($polaczenie->connect_errno!=0)
    {
        echo "Error:".$polaczenie->connect_errno;
    }
    else
    {
        $login = $_POST['login'];
        $haslo = $_POST['haslo'];

       
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");

        $sql = "SELECT * FROM customer WHERE email='$login' AND password='$haslo'";
       if ($rezultat = @$polaczenie->query(
        sprintf("SELECT * FROM customer WHERE email='%s' AND password='%s'",
    
        mysqli_real_escape_string($polaczenie,$login),
        mysqli_real_escape_string($polaczenie,$haslo))))
       {
           $ilu_userow = $rezultat->num_rows;
           if($ilu_userow>0)
           {
            $_SESSION['zalogowany'] = true;
           
            $wiersz= $rezultat->fetch_assoc();
            $_SESSION['id'] = $wiersz['id'];
            $_SESSION['name'] = $wiersz['name'];
            $_SESSION['branch'] = $wiersz['branch'];

                        
            $sql="SELECT * FROM passbook".$_SESSION['id'];
            $wiersz= $rezultat->fetch_assoc();
            
            $_SESSION['amount'] = $wiersz['amount'];
            

            unset($_SESSION['blad']);
            $rezultat->free_result();
            header('Location: uzyt.php');
            

           }else{

            $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
            header('Location: login.php');
           }
       }

        $polaczenie->close();
    }


    

?>