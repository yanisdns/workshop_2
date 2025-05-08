<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link href="https://fonts.googleapis.com/css?family=Inter:400,700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-indigo-100 via-blue-50 to-white min-h-screen flex flex-col">
    <?php include 'src/component/header.php'; ?>
    <div class="flex flex-col items-center justify-center min-h-screen py-10">
        <main class="relative bg-white/90 backdrop-blur-lg shadow-2xl rounded-3xl p-12 max-w-lg w-full flex flex-col items-center border border-indigo-100">
            <div class="absolute -top-12 left-1/2 -translate-x-1/2 bg-indigo-600 rounded-full p-4 shadow-lg">
                <i class="fa-solid fa-envelope text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-indigo-700 mb-2 mt-6 text-center tracking-tight">Contactez-moi</h1>
            <p class="text-gray-500 mb-8 text-center">Je réponds rapidement à vos questions et demandes.</p>
            <div class="flex flex-col gap-6 w-full">
                <a href="mailto:yanisjacques22@gmail.com" class="flex items-center gap-4 px-5 py-4 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition group shadow">
                    <span class="bg-indigo-100 text-indigo-700 rounded-full p-3 group-hover:bg-indigo-200 transition">
                        <i class="fa-solid fa-at"></i>
                    </span>
                    <span class="flex flex-col">
                        <span class="font-semibold text-indigo-800">Email</span>
                        <span class="text-indigo-700 text-sm">yanisjacques22@gmail.com</span>
                    </span>
                </a>
                <a href="tel:0497110339" class="flex items-center gap-4 px-5 py-4 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition group shadow">
                    <span class="bg-indigo-100 text-indigo-700 rounded-full p-3 group-hover:bg-indigo-200 transition">
                        <i class="fa-solid fa-phone"></i>
                    </span>
                    <span class="flex flex-col">
                        <span class="font-semibold text-indigo-800">Téléphone</span>
                        <span class="text-indigo-700 text-sm">0497110339</span>
                    </span>
                </a>
            </div>
            <a href="index.php" class="mt-10 px-8 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition text-center w-full block shadow">Retour à l'accueil</a>
        </main>
    </div>
</body>

</html>
<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    .bg-gradient-to-br {
        background: linear-gradient(135deg, #e0e7ff 0%, #f0f9ff 60%, #fff 100%);
    }

    .backdrop-blur-lg {
        backdrop-filter: blur(16px);
    }
</style>