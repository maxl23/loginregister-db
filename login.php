<?php
session_start();
require "database.php";

if(isset($_SESSION['auth']) || $_SESSION['auth'] == true) {
  header("location: welcome.php");
  exit;
}


$email = $pwd = "";
$errors =[];

if(isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $pwd = trim($_POST['pwd']);

    if ($email == '' || $pwd == '') {
        array_push($errors, 'Eingabe fehlt.');
    }

    if (empty($errors)) {
        $sql = "SELECT id, username, password, password FROM users WHERE email = ?;";
        $stmt = $db->prepare($sql);
        $stmt->execute([$email]);
        $data = $stmt-> fetch();

        if (!$data) {
            array_push($errors, 'E-Mail nicht gefunden.');
        }
        else {
              if (password_verify($pwd, $data['password'])) {
                  //Session
                  $_SESSION['auth']= true;
                  $_SESSION['id'] = $data['id'];
                  $_SESSION['username'] = $data['username'];
                  header("location: welcome.php");
              }
              else {
                    array_push($errors, 'Passwort falsch.');
              }
        }
      }
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

    <h1>Login</h1>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <p>
        <label for="email">E-Mail</label>
        <input type="text" id="email" name="email">
        </p>
         <p>
        <label for="pwd">Passwort</label>
        <input type="password" id="pwd" name="pwd">
        </p>
         <p>
        <input type="submit" value="Login" name="login">
        </p>
    </form>

    <p>
        <?php
        foreach($errors as $error) {
            echo $error."<br>";
        }
        ?>
    </p>

</body>

</html>
