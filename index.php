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
        $sql = "INSERT INTO users (appointment_for,name, gender, phone_number, birthdate, specialist, symptoms, appointment_date, appointment_time)
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
                  Chez [Nom de l'entreprise], nous croyons en un service de santé accessible et efficace, 
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
              <h2>Comment l'utilisée ?</h2>
              <p>
                1. Remplir le formulaire de rendez-vous <br>
                2. Cliquer sur le boutton prendre rendez-vous <br>
                3. Un code QR vous sera régenerer <br>
                4. Cliquer sur <span class="telecharger">télecharger</span><br>
                5. Votre reservation est faite, rendez-vous à Point-G dans votre département choisi
              </p>
            </div>
          </div>
          <!-- Autres slides ... -->
        </div>

        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
        </a>
      </div>
    </section>
    <!-- Fin Hero -->

    <main id="main">
      <!-- ======= Formulaire de Prise de Rendez-vous ======= -->
      <section id="appointment" class="appointment">
        <div class="containerp">
          <h2>Formulaire de prise de rendez-vous médecin traitant</h2>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="appointment_for">Pour qui prenez-vous ce rendez-vous ?</label>
            <div class="items_prise">
              <input type="radio" id="myself" name="appointment_for" value="myself" required />
              <label for="myself">Moi-même</label>
              <input type="radio" id="someone_else" name="appointment_for" value="someone_else" required />
              <label for="someone_else">Un proche</label>
            </div>

            <label for="name">Nom complet</label>
            <input type="text" id="name" name="name" required />

            <label for="gender">Sexe</label>
            <select id="gender" name="gender" required>
              <option value="">Veuillez choisir</option>
              <option value="male">Masculin</option>
              <option value="female">Féminin</option>
            </select>

            <label for="phone_number">Numéro de téléphone</label>
            <input type="tel" id="phone_number" name="phone_number" required />

            <label for="birthdate">Date de naissance</label>
            <div class="date_fields">
              <select id="birth_year" name="birth_year" required>
              <option value="" disabled>Année</option>
                <?php
                $current_year = date("Y");
                $oldest_year = $current_year - 150;
                for ($i = $current_year; $i >= $oldest_year; $i--) {
                  echo "<option value=\"$i\">$i</option>";
                }
                ?>
              </select>
              <select id="birth_month" name="birth_month" required>
              <option value="" disabled>Mois</option>
                <option value="jan">Jan</option>
                <option value="feb">Fév</option>
                <option value="mar">Mar</option>
                <option value="apr">Avr</option>
                <option value="may">Mai</option>
                <option value="jun">Juin</option>
                <option value="jul">Juil</option>
                <option value="aug">Août</option>
                <option value="sep">Sep</option>
                <option value="oct">Oct</option>
                <option value="nov">Nov</option>
                <option value="dec">Déc</option>
              </select>
              <select id="birth_day" name="birth_day" required>
                <option value="" disabled>Année</option>
                <?php
                $current_year = date("Y");
                $oldest_year = $current_year - 150;
                for ($i = $current_year; $i >= $oldest_year; $i--) {
                  echo "<option value=\"$i\">$i</option>";
                }
                ?>
              </select>
            </div>

            <label for="specialist">Spécialiste à consulter</label>
            <select id="specialist" name="specialist" required>
              <option value="">Veuillez choisir</option>
              <option value="cardiologue">Cardiologue</option>
              <option value="dermatologue">Dermatologue</option>
              <option value="généraliste">Généraliste</option>
              <!-- Ajoutez d'autres options ici -->
            </select>

            <label for="symptoms">Décrivez vos symptômes</label>
            <textarea id="symptoms" name="symptoms" required></textarea>

            <label for="appointment_date">Date du rendez-vous</label>
            <input type="date" id="appointment_date" name="appointment_date" required />

            <label for="appointment_time">Heure du rendez-vous</label>
            <input type="time" id="appointment_time" name="appointment_time" required />

            <button type="submit">Prendre rendez-vous</button>
          </form>

          <?php if (!empty($message)) : ?>
            <p><?php echo $message; ?></p>
          <?php endif; ?>
        </div>
      </section>
      <!-- Fin du Formulaire de Prise de Rendez-vous -->
       
    </main>
  <!-- Debut Section service -->
  <section id="service" class="service">
        <h2 class="title">Nos Services</h2>
        <div class="Boite">
          <div class="card">
            <h4>Pneumologie</h4>
            <img src="assets/img/Img-Service/Pneumologie.png" alt="">
            <p>10:00 AM - 10:00 PM</p>
          </div>
          <div class="card">
            <h4>Ophtalmologie</h4>
            <img src="assets/img/Img-Service/Ophtalmologie.png" alt="">
            <p>10:00 AM - 10:00 PM</p>
          </div>
          <div class="card">
            <h4>Infectiologie</h4>
            <img src="assets/img/Img-Service/Infectiologie.png" alt="">
            <p>10:00 AM - 10:00 PM</p>
          </div>
          <div class="card">
            <h4>Urologie</h4>
            <img src="assets/img/Img-Service/Urologie.png" alt="">
            <p>10:00 AM - 10:00 PM</p>
          </div>
          <div class="card">
            <h4>Orthopedie</h4>
            <img src="assets/img/Img-Service/Orthopedie.png" alt="">
            <p>10:00 AM - 10:00 PM</p>
          </div>
          <div class="card">
            <h4>Neurologie</h4>
            <img src="assets/img/Img-Service/Neurologie.png" alt="">
            <p>10:00 AM - 10:00 PM</p>
          </div>
          <div class="card">
            <h4>Cardiologie</h4>
            <img src="assets/img/Img-Service/Cardiologie.png" alt="">
            <p>10:00 AM - 10:00 PM</p>
          </div>
          <div class="card">
            <h4>Dermatologie</h4>
            <img src="assets/img/Img-Service/Dermatologie.png" alt="">
            <p>10:00 AM - 10:00 PM</p>
          </div>
          <div class="card">
            <h4>Pediatrie</h4>
            <img src="assets/img/Img-Service/Pediatrie.png" alt="">
            <p>10:00 AM - 10:00 PM</p>
          </div>
          <div class="card">
            <h4>Odontologie</h4>
            <img src="assets/img/Img-Service/Odontologie.png" alt="">
            <p>10:00 AM - 10:00 PM</p>
          </div>
        </div>
      </section>
      <!-- Fin Section service -->
      <div>
          <iframe
            style="border: 0; width: 100%; height: 350px"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d477.0855616423508!2d-7.857858629011413!3d12.587969052701895!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xe51d7cbb650e1c3%3A0x13d85af044cf9e3f!2s%C3%89glise%20Chr%C3%A9tienne%20%C3%89vang%C3%A9lique%20de%20N&#39;tabacoro%20ATTbougou!5e1!3m2!1sen!2sml!4v1710770612191!5m2!1sen!2sml"
            frameborder="0"
            allowfullscreen
          ></iframe>
        <br>
   <!-- ======= Footer ======= -->
   <footer id="footer">
      <div class="container">
        <div class="footer-info">
          <h3>CHU-POINT G</h3>
          <div class="info">
            <p>Bamako, Mali</p>
            <p>POINT G, BAMAKO</p>
            <p><strong>Téléphone:</strong> +223 00 11 22 33</p>
            <p><strong>Email:</strong> chupointg@gmail.com</p>
          </div>
          <div class="social-links mt-3">
            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
          </div>
        </div>
    
        <div class="container">
          <div class="copyright">
            &copy; Copyright <strong><span>POINT G</span></strong>. Tous droits réservés.
          </div>
          <IN class="credits">Designed by <a href="#">DIIAAB</a></div>
        </div>
      </div>
    </footer>

    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Script principal -->
    <script src="assets/js/main.js"></script>

  </body>
</html>