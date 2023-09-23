<?php
global $db;
include "database.php";

$username = $email = $pwd = $confirm_pwd = '';
$errors =[];

    if(isset($_POST['register'])) {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $pwd = trim($_POST['pwd']);
        $confirm_pwd = trim($_POST['confirm_pwd']);

        if ($username == '' || $email == '' || $pwd == '' || $confirm_pwd == '') {
            array_push($errors, 'Eingabe fehlt.');
        }
        else {
            $sql = "SELECT id FROM users WHERE username = ? OR email = ? ";
            $stmt = $db->prepare($sql);
            $stmt->execute([$username, $email]);
            $data = $stmt->fetchAll();

            if(!empty($data)){
                array_push($errors, 'Username/Email bereits vorhanden.');
            }

            if ($pwd != $confirm_pwd) {
                array_push($errors, 'Username/Email bereits vorhanden.');
            }
        }
        if (empty($errors)) {

            $activation_code = md5(rand());
            $sql = "INSERT INTO users (username, email, password, activation_code) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            if ($stmt->execute([$username, $email, password_hash($pwd, PASSWORD_DEFAULT), $activation_code])) {

                 //header("location: login.php");

                $mail_link = "http://localhost/email_verify.php";
                $mail_link .= '?email=' .$email;
                $mail_link .= '&activation_code=' .$activation_code;

                if(mail($email, 'Anmeldebestätigung', $mail_link, "From: Webmaster")){
                  echo "Anmeldung erfolgreich. Bitte bestätige deinen E-Mail Link.";
                }
                else {
                    $sql = "DELETE FROM users WHERE email = ?";
                    $stmt = $db->prepare($sql);
                    $stmt->execute([$email]);
                    array_push($errors, 'Fehler beim Speichern der Bestätigungsemail.');
                }
            }
            else{
                array_push($errors, 'Es ist ein Fehler aufgetretern.');
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

    <h1>Regestrierung</h1>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

        <p>
            <label for="username">Benutzername</label>
            <input type="text" id="username" name="username">
        </p>

        <p>
            <label for="email">E-Mail</label>
            <input type="text" id="email" name="email">
        </p>

        <p>
            <label for="pwd">Passwort</label>
            <input type="password" id="pwd" name="pwd">
        </p>

        <p>
            <label for="confirm_pwd">Passwort bestätigen</label>
            <input type="password" id="confirm_pwd" name="confirm_pwd">
        </p>


        <p>
            <input type="submit" value="Registrieren" name="register">
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
