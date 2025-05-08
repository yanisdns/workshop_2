<?php
session_start();
require_once "src/php/conn.php"; // Correction du chemin d'inclusion pour être relatif à ce fichier

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    echo "Vous devez être connecté pour créer un ticket.";
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');

    if ($title === '') {
        $message = "Le titre est obligatoire.";
    } else {
        // Création du ticket
        $stmt = $db->prepare("INSERT INTO Ticket (Title, User_id, Created_by) VALUES (?, ?, ?)");
        $stmt->execute([$title, $_SESSION['id'], $_SESSION['id']]);
        $ticket_id = $db->lastInsertId();

        // Création d'un premier message vide pour initialiser la conversation
        $stmtMsg = $db->prepare("INSERT INTO messages (Ticket_id, Message, Created_by) VALUES (?, '', ?)");
        $stmtMsg->execute([$ticket_id, $_SESSION['id']]);

        // Redirection vers la page de messages du ticket
        header("Location: messages.php?ticket_id=" . $ticket_id);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un ticket</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">
    <main class="bg-white/80 backdrop-blur-md shadow-xl rounded-3xl p-8 max-w-md w-full flex flex-col items-center">
        <h1 class="text-3xl font-bold text-indigo-700 mb-6 text-center">Créer un ticket</h1>
        <?php if ($message): ?>
            <div class="mb-4 px-4 py-2 <?= $message === 'Ticket créé avec succès !' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?> rounded">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <form method="post" class="w-full flex flex-col gap-4">
            <label for="title" class="text-gray-700 font-semibold">Titre du ticket :</label>
            <input type="text" id="title" name="title" required
                class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
            <button type="submit"
                class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
                Créer
            </button>
        </form>
        <a href="index.php" class="mt-4 px-6 py-2 bg-indigo-100 text-indigo-700 rounded-lg font-semibold hover:bg-indigo-200 transition text-center w-full block">Retour à l'accueil</a>
    </main>
</body>

</html>
<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    .bg-gradient-to-br {
        background: linear-gradient(to bottom right, #f0f9ff, #c7d2fe);
    }

    .backdrop-blur-md {
        backdrop-filter: blur(10px);
    }
</style>