<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
  header("location: index.php");
  exit;
}

?>

<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Bestellungsportal Lizenzverwaltung</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:500&display=swap" rel="stylesheet">
    </head>
    <body>
        <header>
              <font>
            <a>Bestellungsportal Lizenzverwaltung</a>
                    </font>
                          <nav>
                <ul class="nav__links">
                    <li><a href="#">  Lizenziert für <?php echo $_SESSION['username']; ?></a></li>
                    <li><a href="homepage.php">  Zurück zur Startseite</a></li>

                </ul>
            </nav>
            <a class="cta" href="logout.php">Abmelden</a>
            <p class="menu cta">Angemeldet als </p>
        </header>
        <div class="overlay">
            <a class="close">&times;</a>
            <div class="overlay__content">
                <a href="#">Services</a>
            </div>
        </div>
        <script type="text/javascript" src="mobile.js"></script>
    </body>
</html>
