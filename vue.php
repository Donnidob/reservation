<?php
session_start(); // Start the session
require_once 'connexiondb.php'; // Inclure le fichier de connexion à la base de données

// Gérer la déconnexion
if (isset($_POST['logout'])) {
    session_destroy(); // Détruire la session
    header("Location: adminxx.php"); // Rediriger vers la page de connexion
    exit();
}

$selectedDay = isset($_GET['day']) ? $_GET['day'] : null;
$selectedTime = isset($_GET['time']) ? $_GET['time'] : null;

// Base de la requête SQL
$sql = "SELECT id, name, gender, appointment_time, phone_number, specialist, appointment_date FROM users WHERE 1=1";

// Filtrer par jour de la semaine si sélectionné
if ($selectedDay) {
    $sql .= " AND DAYNAME(appointment_date) = '$selectedDay'";
}

// Filtrer par heure si sélectionnée
if ($selectedTime) {
    $sql .= " AND HOUR(appointment_time) = '$selectedTime'";
}

$sql .= " ORDER BY appointment_time ASC";

$result = $conn->query($sql);

if ($result === false) {
    die("Erreur lors de l'exécution de la requête SQL : " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs par jour et heure de RDV</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 1.5rem;
            text-align: center;
        }
        .days {
            margin-bottom: 20px;
            text-align: center;
        }
        .days .btn {
            margin: 5px;
            padding: 10px 15px;
            font-size: 0.9rem;
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
            border-radius: 20px;
        }
        .days .btn:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
            font-size: 0.875rem;
        }
        td {
            font-size: 0.875rem;
        }
        .form-inline {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .form-inline label {
            font-size: 0.875rem;
            margin-right: 10px;
        }
        .form-inline input {
            font-size: 0.875rem;
            margin-right: 10px;
            border-radius: 20px;
            padding: 5px 10px;
            width: 100px;
            border: 1px solid #ced4da;
        }
        .form-inline button {
            font-size: 0.875rem;
            padding: 5px 15px;
            background-color: #28a745;
            border-color: #28a745;
            color: white;
            border-radius: 20px;
        }
        .form-inline button:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .logout-form {
            text-align: right;
            margin-bottom: 20px;
        }
        .logout-form button {
            padding: 10px 20px;
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
            border-radius: 20px;
            font-size: 0.9rem;
        }
        .logout-form button:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Formulaire de déconnexion -->
        <div class="logout-form">
            <form method="post">
                <button type="submit" name="logout" class="btn">Déconnexion</button>
            </form>
        </div>

        <h1>Liste des Réservations par Jour et Heure de RDV</h1>

        <div class="days">
            <!-- Boutons pour les jours de la semaine -->
            <?php 
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            foreach ($days as $day): ?>
                <a href="?day=<?= $day ?>" class="btn"><?= $day ?></a>
            <?php endforeach; ?>
        </div>

        <!-- Formulaire pour entrer l'heure -->
        <form class="form-inline">
            <label for="time">Filtrer par Heure:</label>
            <input type="number" min="0" max="23" class="form-control" id="time" name="time" placeholder="Entrez l'heure">
            <button type="submit" class="btn">Filtrer</button>
        </form>

        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Genre</th>
                            <th>Heure de RDV</th>
                            <th>Numéro de Téléphone</th>
                            <th>Spécialiste</th>
                            <th>Date de RDV</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['gender']) ?></td>
                                <td><?= htmlspecialchars($row['appointment_time']) ?></td>
                                <td><?= htmlspecialchars($row['phone_number']) ?></td>
                                <td><?= htmlspecialchars($row['specialist']) ?></td>
                                <td><?= htmlspecialchars($row['appointment_date']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center">Aucun utilisateur trouvé pour ce jour ou cette heure.</p>
        <?php endif; ?>

        <?php $conn->close(); // Fermer la connexion à la base de données ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
