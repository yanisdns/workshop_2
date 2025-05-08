<?php
session_start();
require_once "src/php/conn.php";

if (!isset($_SESSION['id'])) {
    echo "Vous devez être connecté pour voir vos tickets.";
    exit;
}

// Récupérer uniquement les tickets créés par l'utilisateur connecté
$stmt = $db->prepare("SELECT Id, Title, Created_at FROM Ticket WHERE Created_by = ? ORDER BY Created_at DESC");
$stmt->execute([$_SESSION['id']]);
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mes tickets</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">
    <main class="bg-white/80 backdrop-blur-md shadow-xl rounded-3xl p-8 max-w-lg w-full flex flex-col items-center">
        <h1 class="text-3xl font-bold text-indigo-700 mb-6 text-center">Mes tickets</h1>
        <?php if (empty($tickets)): ?>
            <p class="text-gray-600">Vous n'avez créé aucun ticket.</p>
            <a href="creer-ticket.php" class="mt-4 px-6 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition text-center w-full block">Créer un ticket</a>
        <?php else: ?>
            <ul class="w-full flex flex-col gap-3">
                <?php foreach ($tickets as $ticket): ?>
                    <li class="bg-indigo-50 rounded-lg px-4 py-3 flex justify-between items-center">
                        <span class="font-semibold text-indigo-800"><?= htmlspecialchars($ticket['Title']) ?></span>
                        <span class="text-xs text-gray-500"><?= htmlspecialchars($ticket['Created_at']) ?></span>
                        <a href="messages.php?ticket_id=<?= $ticket['Id'] ?>" class="ml-4 px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">Voir</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <a href="index.php" class="mt-6 px-6 py-2 bg-indigo-100 text-indigo-700 rounded-lg font-semibold hover:bg-indigo-200 transition text-center w-full block">Retour à l'accueil</a>
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