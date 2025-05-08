<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - TicketMaker</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">
    <main class="bg-white/80 backdrop-blur-md shadow-xl rounded-3xl p-8 max-w-md w-full flex flex-col items-center">
        <h1 class="text-3xl font-bold text-indigo-700 mb-6 text-center">Connexion</h1>
        <?php if (isset($_GET['error'])): ?>
            <div class="mb-4 px-4 py-2 bg-red-100 text-red-700 rounded">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
        <form method="post" action="src/php/login.php" class="w-full flex flex-col gap-4">
            <input type="text" name="uname" placeholder="Nom d'utilisateur" required class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                value="<?= isset($_GET['uname']) ? htmlspecialchars($_GET['uname']) : '' ?>" />
            <input type="password" name="pass" placeholder="Mot de passe" required class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">Se connecter</button>
        </form>
        <a href="signup.php" class="mt-4 px-6 py-2 bg-indigo-100 text-indigo-700 rounded-lg font-semibold hover:bg-indigo-200 transition text-center w-full block">Créer un compte</a>
    </main>
</body>

</html>