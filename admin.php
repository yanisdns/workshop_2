<?php
session_start();
require_once "src/php/conn.php";

// Vérification admin : seul un utilisateur avec Role_id = 1 peut accéder
if (!isset($_SESSION['id'])) {
    echo "Accès refusé. Veuillez vous connecter.";
    exit;
}
$stmt = $db->prepare("SELECT Role_id FROM users WHERE Id = ?");
$stmt->execute([$_SESSION['id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user || $user['Role_id'] != 1) {
    echo "Accès refusé. Vous n'êtes pas administrateur.";
    exit;
}

// Soft-delete ou réactivation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_ticket_id'])) {
        $ticketId = intval($_POST['delete_ticket_id']);
        $stmt = $db->prepare("UPDATE Ticket SET Actif = 0 WHERE Id = ?");
        $stmt->execute([$ticketId]);
        $_SESSION['success'] = "Le ticket a été désactivé avec succès.";
        header("Location: admin.php");
        exit;
    }
    if (isset($_POST['reactivate_ticket_id'])) {
        $ticketId = intval($_POST['reactivate_ticket_id']);
        $stmt = $db->prepare("UPDATE Ticket SET Actif = 1 WHERE Id = ?");
        $stmt->execute([$ticketId]);
        $_SESSION['success'] = "Le ticket a été réactivé avec succès.";
        header("Location: admin.php");
        exit;
    }
}

// Récupérer tous les tickets (actifs et inactifs)
$stmt = $db->query("SELECT Ticket.Id, Ticket.Title, Ticket.Created_at, Ticket.Actif, users.username AS Auteur
                    FROM Ticket
                    LEFT JOIN users ON Ticket.Created_by = users.id
                    ORDER BY Ticket.Created_at DESC");
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
require_once "./src/component/header.php";
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion des tickets</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- La navbar est incluse juste ici via header.php -->
    <div class="flex flex-col items-center justify-center min-h-screen pt-8">
        <main class="bg-white/80 backdrop-blur-md shadow-xl rounded-3xl p-8 max-w-3xl w-full flex flex-col items-center">
            <h1 class="text-3xl font-bold text-indigo-700 mb-8 text-center">Panneau d'administration</h1>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded-lg shadow text-center w-full">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            <?php if (empty($tickets)): ?>
                <p class="text-gray-600">Aucun ticket trouvé.</p>
            <?php else: ?>
                <div class="w-full">
                    <div class="overflow-y-auto max-h-[1800px] md:max-h-[1400px] lg:max-h-[1100px] xl:max-h-[900px]" style="max-height: 36rem; min-height: 18rem;">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php foreach ($tickets as $ticket): ?>
                                <div class="bg-white rounded-2xl shadow-md border border-indigo-100 p-6 flex flex-col gap-3 relative">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="text-xl font-bold text-indigo-800"><?= htmlspecialchars($ticket['Title']) ?></span>
                                        <span class="ml-2 px-2 py-1 rounded text-xs <?= $ticket['Actif'] ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' ?>">
                                            <?= $ticket['Actif'] ? 'Actif' : 'Inactif' ?>
                                        </span>
                                    </div>
                                    <div class="flex flex-col gap-1 text-sm text-gray-600">
                                        <span><span class="font-semibold">Auteur :</span> <?= htmlspecialchars($ticket['Auteur'] ?? 'Inconnu') ?></span>
                                        <span><span class="font-semibold">Créé le :</span> <?= htmlspecialchars($ticket['Created_at']) ?></span>
                                    </div>
                                    <div class="flex gap-2 mt-4">
                                        <a href="messages.php?ticket_id=<?= $ticket['Id'] ?>"
                                            class="flex-1 px-3 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm text-center transition">
                                            Voir la discussion
                                        </a>
                                        <?php if ($ticket['Actif']): ?>
                                            <form method="post" class="flex-1">
                                                <input type="hidden" name="delete_ticket_id" value="<?= $ticket['Id'] ?>">
                                                <button type="submit"
                                                    class="w-full px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 text-sm transition">
                                                    Désactiver
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <form method="post" class="flex-1">
                                                <input type="hidden" name="reactivate_ticket_id" value="<?= $ticket['Id'] ?>">
                                                <button type="submit"
                                                    class="w-full px-3 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 text-sm transition">
                                                    Réactiver
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <a href="index.php" class="mt-10 px-8 py-3 bg-indigo-100 text-indigo-700 rounded-lg font-semibold hover:bg-indigo-200 transition text-center w-full block">Retour à l'accueil</a>
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

    /* Box scrollable pour 4 tickets (2 lignes de 2 colonnes) */
    @media (min-width: 768px) {
        .overflow-y-auto {
            max-height: 36rem;
            /* ~4 cartes de 8rem de haut + marges */
        }
    }

    @media (max-width: 767px) {
        .overflow-y-auto {
            max-height: 36rem;
            /* 4 cartes en colonne */
        }
    }
</style>