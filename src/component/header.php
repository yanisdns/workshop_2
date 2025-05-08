<?php
// Vérifier si l'utilisateur est admin
$isAdmin = false;
if (isset($_SESSION['id'])) {
    require_once __DIR__ . '/../php/conn.php';
    $stmt = $db->prepare("SELECT Role_id FROM users WHERE Id = ?");
    $stmt->execute([$_SESSION['id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && $user['Role_id'] == 1) {
        $isAdmin = true;
    }
}
?>
<header class="bg-white/80 backdrop-blur-md shadow-md rounded-b-2xl px-8 py-5 flex flex-col items-center gap-4 mb-8 md:flex-row md:justify-between md:gap-0">
    <div class="flex items-center gap-3">
        <span class="inline-block w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-xl shadow">
            TM
        </span>
        <a href="index.php" class="text-2xl font-bold text-indigo-700 hover:text-indigo-900 transition">
            TicketMaker
        </a>
    </div>
    <nav class="flex gap-6 mt-2 md:mt-0">
        <!-- Suppression du bouton Accueil -->
        <div class="relative group" id="ticket-dropdown-group">
            <button id="ticket-dropdown-btn" class="text-indigo-600 hover:text-indigo-800 font-medium transition flex items-center gap-1 focus:outline-none">
                Ticket
                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="ticket-dropdown-menu" class="absolute left-0 mt-2 w-44 bg-white/80 backdrop-blur-md border border-indigo-100 rounded-2xl shadow-md opacity-0 group-hover:opacity-100 group-focus:opacity-100 transition pointer-events-none group-hover:pointer-events-auto z-10">
                <ul class="py-2">
                    <?php if (!isset($_SESSION['id'])): ?>
                        <li>
                            <a href="login.php" class="block px-5 py-2 text-indigo-700 hover:bg-indigo-100 hover:text-indigo-900 rounded-xl transition font-medium">Créer un ticket</a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="creer-ticket.php" class="block px-5 py-2 text-indigo-700 hover:bg-indigo-100 hover:text-indigo-900 rounded-xl transition font-medium">Créer un ticket</a>
                        </li>
                        <li>
                            <a href="voir_ticket.php" class="block px-5 py-2 text-indigo-700 hover:bg-indigo-100 hover:text-indigo-900 rounded-xl transition font-medium">Mes tickets</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <a href="contact.php" class="text-indigo-600 hover:text-indigo-800 font-medium transition">Contact</a>
        <?php if ($isAdmin): ?>
            <a href="admin.php" class="text-yellow-600 hover:text-yellow-800 font-medium transition">Admin</a>
        <?php endif; ?>
        <?php if (!isset($_SESSION['id'])): ?>
            <a href="login.php" class="text-indigo-600 hover:text-indigo-800 font-medium transition">Connexion</a>
        <?php endif; ?>
        <?php if (isset($_SESSION['id'])): ?>
            <a href="src/php/logout.php" class="text-red-600 hover:text-red-800 font-medium transition">Déconnexion</a>
        <?php endif; ?>
    </nav>
</header>
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

    /* Dropdown styles */
    .group:hover .group-hover\:opacity-100,
    .group:focus .group-focus\:opacity-100,
    .dropdown-visible {
        opacity: 1 !important;
        pointer-events: auto !important;
    }

    .group-hover\:opacity-100,
    .group-focus\:opacity-100 {
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s;
    }
</style>
<script>
    // Dropdown delay logic
    (function() {
        const group = document.getElementById('ticket-dropdown-group');
        const menu = document.getElementById('ticket-dropdown-menu');
        let hideTimeout;

        function showMenu() {
            clearTimeout(hideTimeout);
            menu.classList.add('dropdown-visible');
        }

        function hideMenu() {
            hideTimeout = setTimeout(() => {
                menu.classList.remove('dropdown-visible');
            }, 500); // 1 seconde
        }

        group.addEventListener('mouseenter', showMenu);
        group.addEventListener('mouseleave', hideMenu);
        menu.addEventListener('mouseenter', showMenu);
        menu.addEventListener('mouseleave', hideMenu);
    })();
</script>