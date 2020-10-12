<?php
session_start();

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>bank tam tam tam</title>
</head>

<body> 

<?php
    echo "<p>Witaj ".$_SESSION['name'].'![ <a href="logout.php">Wyloguj się!</a>]</p>';
    echo "</br> <b>kasa</b>:".$_SESSION['amount']."</p>";
    echo "</br> <b>odział banku</b>:".$_SESSION['branch']."</p>";
?>

</body>
</html>