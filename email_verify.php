<?php
      include 'database.php';
      $msg = '';
      $email = $_GET['email'];
      $activation_code = $_GET['activation_code'];

      $sql = "SELECT activation_code FROM users WHERE email = ? AND activation_code = ?";
      $stmt = $db->prepare($sql);
      $stmt->execute([$email, $activation_code]);
      $data = $stmt->fetch();

      if(empty($data)) {
        $msg "Ungültiger Aktivierungscode";
      }
      elseif ($data[0] == null) {
        $msg = "Aktivierung bereits erfolgt!S"
      }
      else {
          $sql = "UPDATE users
                  SET activation_code = null
                  WHERE email = ? AND activation_code = ?";
          $stmt = $db->prepare($sql);
          $stmt->execute([$email, $activation_code]);
          $msg = "E-Mail wurde bestätigt."
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

      <h1>E-Mail Bestätigung</h1>

      <?php echo $msg ?>

      <a href= "login.php"> Weiter zu Login</a>

</body>
</html>
