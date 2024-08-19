<?php

include 'connexiondb.php';
// Inclure la bibliothèque PHP QR Code
include 'phpqrcode/qrlib.php';

$message = "";

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Vérifier que l'heure du rendez-vous est entre 7h et 12h
    $appointment_time = $_POST['appointment_time'];
    if ($appointment_time < "07:00" || $appointment_time > "12:00") {
        $message = "Les heures de rendez-vous sont de 07:00 à 12:00.";
    } else {
        // Récupération des données du formulaire
        $appointment_for = $_POST['appointment_for'];
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $phone_number = $_POST['phone_number'];
        $birthdate = $_POST['birth_year'] . '-' . $_POST['birth_month'] . '-' . $_POST['birth_day'];
        $specialist = $_POST['specialist'];
        $symptoms = $_POST['symptoms'];
        $appointment_date = $_POST['appointment_date'];
        $appointment_time = $_POST['appointment_time'];

        // Préparation de la requête SQL pour l'insertion
        $sql = "INSERT INTO users (appointment_for, name, gender, phone_number, birthdate, specialist, symptoms, appointment_date, appointment_time)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Préparation de la déclaration
        $stmt = $conn->prepare($sql);

        // Vérification si la préparation a réussi
        if ($stmt) {
            // Liaison des paramètres et exécution de la requête
            $stmt->bind_param("sssssssss", $appointment_for, $name, $gender, $phone_number, $birthdate, $specialist, $symptoms, $appointment_date, $appointment_time);

            // Exécution de la requête
            if ($stmt->execute()) {
                $message = "Le rendez-vous a été pris avec succès.";

                // Génération du QR Code avec les informations du rendez-vous
                $qr_content = "Rendez-vous pour: $appointment_for\nNom: $name\nSexe: $gender\nTéléphone: $phone_number\nDate de naissance: $birthdate\nSpécialiste: $specialist\nSymptômes: $symptoms\nDate du rendez-vous: $appointment_date\nHeure du rendez-vous: $appointment_time";
                $qr_filename = "qrcodes/" . uniqid() . ".png";
                QRcode::png($qr_content, $qr_filename, QR_ECLEVEL_L, 4);

                // Ajouter un lien de téléchargement pour le QR Code
                $message .= "<br><img src='$qr_filename' alt='QR Code du rendez-vous'><br>";
                $message .= "<a href='$qr_filename' download='qr_code.png' class='btn btn-success'>Télécharger le QR Code</a>";
            } else {
                $message = "Erreur lors de l'insertion : " . $stmt->error;
            }

        } else {
            $message = "Erreur de préparation de la requête : " . $conn->error;
        }

        // Fermeture de la déclaration et de la connexion
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Point-G</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Les Favicons -->
    <link href="assets/img/32.png" rel="icon" />
    <link href="assets/img/180LIM.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i"
      rel="stylesheet"
    />

    <!-- Fichiers vendor -->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet" />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

    <!-- Fichier CSS principal -->
    <link href="assets/css/style.css" rel="stylesheet" />
  </head>

  <body>
    <!-- ======= Barre d'en Haut ======= -->
    <div id="topbar" class="d-flex align-items-center fixed-top">
      <div class="container d-flex align-items-center justify-content-center justify-content-md-between">
        <div class="align-items-center d-none d-md-flex">
          <i class="bi bi-clock"></i> Lundi - Samedi, 24h/24h
        </div>
        <div class="d-flex align-items-center">
          <i class="bi bi-phone"></i> Appelez-nous : +223 .. .. .. ..
        </div>
      </div>
    </div>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
      <div class="container d-flex align-items-center">
        <h1 class="logo me-auto"><a href="index.html">Point-G</a></h1>

        <nav id="navbar" class="navbar order-last order-lg-0">
          <ul>
            <li><a class="nav-link scrollto" href="#hero">Accueil</a></li>
            <li><a class="nav-link scrollto" href="adminxx.php">Connexion</a></li>
          </ul>
          <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>

        <a href="#appointment" class="appointment-btn scrollto">
          <span class="d-none d-md-inline">Prendre</span> rendez-vous
        </a>
      </div>
    </header>
    <!-- Fin Header -->

    <!-- ======= Section Hero ======= -->
    <section id="hero">
      <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

        <div class="carousel-inner" role="listbox">
          <!-- Slide 1 -->
          <div class="carousel-item active" style="background-image: url(assets/img/slide/slide-1.jpg)">
          <div class="container">
              <div class="psts">
                <h2>Qui sommes-nous ?</h2>
                <p>
                  Bienvenue sur notre plateforme de consultation en ligne, 
                  conçue pour simplifier votre accès aux soins. 
                  Au CHU POINT G, nous croyons en un service de santé accessible et efficace, 
                  sans les contraintes des longues attentes. Notre mission est de vous connecter facilement avec des professionnels qualifiés, 
                  pour des consultations rapides et en toute sécurité. Nous sommes dédiés à améliorer votre expérience médicale, 
                  tout en respectant vos besoins et votre temps précieux.
                </p>
                <img class="img-pst" src="3327.jpg" alt="" />
              </div>
            </div>
          </div>

          <!-- Slide 2 -->
          <div
            class="carousel-item"
            style="background-image: url(assets/img/slide/slide-2.jpg)"
          >
            <div class="container">
              <h2>Comment l'utiliser ?</h2>
              <p>
                1. Remplir le formulaire de rendez-vous <br>
                2. Cliquer sur le bouton prendre rendez-vous <br>
                3. Un code QR vous sera généré <br>
                4. Cliquer sur <span class="telecharger">télécharger</span><br>
                5. Votre réservation est faite, rendez-vous à Point-G dans votre département choisi
              </p>
            </div>
          </div>
          <!-- Autres slides ... -->
        </div>

        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
          <span class="visually-hidden">Précédent</span>
        </a>

        <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
          <span class="visually-hidden">Suivant</span>
        </a>
      </div>
    </section>
    <!-- Fin Section Hero -->

    <main id="main">
      <!-- ======= Section Prendre un Rendez-vous ======= -->
      <section id="appointment" class="appointment section-bg">
        <div class="container">
          <div class="section-title">
            <h2>Prendre un rendez-vous</h2>
          </div>

          <?php
            if (!empty($message)) {
                echo "<div class='alert alert-info'>$message</div>";
            }
          ?>

          <form action="index.php" method="post" role="form" class="php-email-form">
            <div class="row">
              <div class="col-md-4 form-group">
                <input type="text" name="appointment_for" class="form-control" id="appointment_for" placeholder="Nom du patient ou membre de la famille" required />
              </div>
              <div class="col-md-4 form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="Nom complet" required />
              </div>
              <div class="col-md-4 form-group">
                <select name="gender" id="gender" class="form-select" required>
                  <option value="">Sexe</option>
                  <option value="M">Masculin</option>
                  <option value="F">Féminin</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 form-group">
                <input type="text" name="phone_number" class="form-control" id="phone_number" placeholder="Numéro de téléphone" required />
              </div>
              <div class="col-md-4 form-group">
                <select name="birth_day" class="form-select" required>
                  <option value="">Jour de naissance</option>
                  <?php for ($i = 1; $i <= 31; $i++) {
                      echo "<option value='$i'>$i</option>";
                  } ?>
                </select>
              </div>
              <div class="col-md-4 form-group">
                <select name="birth_month" class="form-select" required>
                  <option value="">Mois de naissance</option>
                  <?php for ($i = 1; $i <= 12; $i++) {
                      echo "<option value='$i'>$i</option>";
                  } ?>
                </select>
              </div>
              <div class="col-md-4 form-group">
                <select name="birth_year" class="form-select" required>
                  <option value="">Année de naissance</option>
                  <?php
                  $current_year = date('Y');
                  for ($i = 1900; $i <= $current_year; $i++) {
                      echo "<option value='$i'>$i</option>";
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 form-group">
                <select name="specialist" class="form-select" required>
                  <option value="">Spécialiste</option>
                  <option value="Cardiologue">Cardiologue</option>
                  <option value="Neurologue">Neurologue</option>
                  <option value="Pédiatre">Pédiatre</option>
                  <!-- Ajoutez plus de spécialistes ici -->
                </select>
              </div>
              <div class="col-md-8 form-group">
                <textarea name="symptoms" class="form-control" rows="3" placeholder="Décrivez vos symptômes ici" required></textarea>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 form-group">
                <input type="date" name="appointment_date" class="form-control" required />
              </div>
              <div class="col-md-6 form-group">
                <input type="time" name="appointment_time" class="form-control" required />
              </div>
            </div>

            <div class="text-center">
              <button type="submit">Prendre rendez-vous</button>
            </div>
          </form>
        </div>
      </section>
    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer">
      <div class="container">
        <div class="copyright">
          &copy; Copyright <strong><span>Point-G</span></strong>. Tous droits réservés
        </div>
      </div>
    </footer>
    <!-- Fin Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Fichiers JavaScript -->
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Fichier JS principal -->
    <script src="assets/js/main.js"></script>
  </body>
</html>
