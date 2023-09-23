<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
  header("location: login.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

  <h1>Willkommen</h1>

  Hallo <?php echo $_SESSION['username']; ?><br>
  <p></p>
  <a href="logout.php">Ausloggen</a>

</body>
</html>
