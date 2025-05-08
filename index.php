<?php
session_start();
require_once 'src/component/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['creer_ticket'])) {
    if (!isset($_SESSION['id'])) {
        header('Location: login.php');
        exit;
    } else {
        header('Location: creer-ticket.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Création de Ticket</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <?php require_once 'src/component/header.php'; ?>
    <div class="flex flex-col items-center justify-center min-h-screen">
        <main class="bg-white/80 backdrop-blur-md shadow-xl rounded-3xl p-10 max-w-lg w-full flex flex-col items-center">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded-lg shadow text-center">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            <h1 class="text-4xl font-extrabold text-indigo-700 mb-4 text-center">Bienvenue sur TicketMaker</h1>
            <p class="text-gray-700 text-lg mb-8 text-center">
                Créez, gérez et suivez vos tickets facilement avec notre plateforme moderne et intuitive.
            </p>
            <form method="post" class="w-full flex justify-center">
                <button type="submit" name="creer_ticket"
                    class="inline-block px-8 py-3 bg-indigo-600 text-white font-semibold rounded-xl shadow-md hover:bg-indigo-700 transition">
                    Créer un ticket
                </button>
            </form>
            <div class="mt-10 w-full flex flex-col gap-4">
                <div class="flex items-center gap-3">
                    <span class="inline-block w-3 h-3 bg-green-400 rounded-full"></span>
                    <span class="text-gray-600">Suivi en temps réel</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-block w-3 h-3 bg-blue-400 rounded-full"></span>
                    <span class="text-gray-600">Interface simple et rapide</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-block w-3 h-3 bg-purple-400 rounded-full"></span>
                    <span class="text-gray-600">Support 24/7</span>
                </div>
            </div>
        </main>
    </div>
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