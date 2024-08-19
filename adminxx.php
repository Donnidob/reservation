<?php
session_start();
include 'connexiondb.php'; // Assurez-vous que ce fichier est correctement inclus

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    // Validation rapide
    if (empty($email) || empty($password)) {
        $error_message = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "L'adresse email n'est pas valide.";
    } else {
        try {
            // Rechercher l'utilisateur par email
            $sql = "SELECT id, email, password FROM utilisateurs WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            // Vérifier si un utilisateur correspondant a été trouvé
            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();

                // Vérifier le mot de passe
                if (password_verify($password, $user['password'])) {
                    // Démarrer une session et stocker les informations de l'utilisateur
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];

                    // Rediriger l'utilisateur vers la page d'accueil
                    header("Location: vue.php");
                    exit();
                } else {
                    $error_message = "Mot de passe incorrect.";
                }
            } else {
                $error_message = "Email non trouvé.";
            }

            $stmt->close(); // Fermer la requête préparée
        } catch (Exception $e) {
            $error_message = "Erreur : " . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.8;
        }
        .container {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-container {
            max-width: 400px;
            width: 100%;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .form {
            width: 100%;
        }
        .form h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .form .form-group {
            margin-bottom: 15px;
        }
        .form .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .form .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: #3498db;
            color: white;
            font-size: 16px;
        }
        .form .btn:hover {
            background: #2980b9;
        }
        .form .text-center {
            margin-top: 10px;
        }
        .form .text-center a {
            color: #3498db;
            text-decoration: none;
        }
        .form .text-center a:hover {
            text-decoration: underline;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="form-container">
            <form class="form bg-light p-4 rounded shadow" method="post" action="">
                <h2 class="text-center mb-4">Connexion</h2>
                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Connexion</button>
                <div class="text-center mt-3">
                    Pas de compte ? Veuillez vous <a href="inscription.php">inscrire</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
