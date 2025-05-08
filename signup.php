<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - TicketMaker</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">
    <main class="bg-white/80 backdrop-blur-md shadow-xl rounded-3xl p-8 max-w-md w-full flex flex-col items-center">
        <h1 class="text-3xl font-bold text-indigo-700 mb-6 text-center">Créer un compte</h1>
        <?php if (isset($_GET['error'])): ?>
            <div class="mb-4 px-4 py-2 bg-red-100 text-red-700 rounded">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
        <form method="post" action="src/php/register.php" class="w-full flex flex-col gap-4">
            <input type="text" name="fname" placeholder="Nom complet" required class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                value="<?= isset($_GET['fname']) ? htmlspecialchars($_GET['fname']) : '' ?>" />
            <input type="text" name="uname" placeholder="Nom d'utilisateur" required class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                value="<?= isset($_GET['uname']) ? htmlspecialchars($_GET['uname']) : '' ?>" />
            <input type="email" name="email" placeholder="Adresse e-mail" required class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                value="<?= isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '' ?>" />
            <input type="password" name="pass" placeholder="Mot de passe" required class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">S'inscrire</button>
        </form>
        <p class="mt-4 text-sm text-gray-600">Déjà un compte ? <a href="login.php" class="text-indigo-600 hover:underline">Se connecter</a></p>
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