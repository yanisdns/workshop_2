<?php
session_start();
require_once "src/php/conn.php"; // Connexion centralisée

if (!isset($_SESSION['id'])) {
    echo "Vous devez être connecté pour accéder à la conversation.";
    exit;
}

$ticket_id = isset($_GET['ticket_id']) ? intval($_GET['ticket_id']) : 0;
if ($ticket_id <= 0) {
    echo "Ticket invalide.";
    exit;
}

// --- Contrôle d'accès : admin OU créateur du ticket ---
$stmt = $db->prepare("SELECT Created_by, Actif FROM ticket WHERE Id = ?");
$stmt->execute([$ticket_id]);
$ticket = $stmt->fetch();

if (!$ticket) {
    echo "Ticket introuvable.";
    exit;
}

// Récupérer le rôle de l'utilisateur connecté
$stmt = $db->prepare("SELECT Role_id FROM users WHERE Id = ?");
$stmt->execute([$_SESSION['id']]);
$user = $stmt->fetch();

$is_admin = ($user && $user['Role_id'] == 1);
$is_creator = ($_SESSION['id'] == $ticket['Created_by']);
$is_active = ($ticket['Actif'] == 1);

if (!$is_admin && !$is_creator) {
    echo "Accès refusé. Vous n'avez pas le droit d'accéder à ce ticket.";
    exit;
}

// --- Fermeture du ticket ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['close_ticket']) && $is_active && ($is_admin || $is_creator)) {
    $stmt = $db->prepare("UPDATE ticket SET Actif = 0 WHERE Id = ?");
    $stmt->execute([$ticket_id]);
    $is_active = false;
}

// Envoi d'un message (seulement si actif)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message']) && $is_active) {
    $msg = trim($_POST['message']);
    if ($msg !== '') {
        $stmt = $db->prepare("INSERT INTO messages (Ticket_id, Message, Created_by) VALUES (?, ?, ?)");
        $stmt->execute([$ticket_id, $msg, $_SESSION['id']]);
    }
}

// Récupérer les messages du ticket (on ignore le message vide d'init)
$stmt = $db->prepare("SELECT m.*, u.Username FROM messages m LEFT JOIN Users u ON m.Created_by = u.Id WHERE m.Ticket_id = ? AND (m.Message IS NOT NULL AND m.Message != '') ORDER BY m.Created_at ASC");
$stmt->execute([$ticket_id]);
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Messages du ticket</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">
    <main class="bg-white/80 backdrop-blur-md shadow-xl rounded-3xl p-8 max-w-xl w-full flex flex-col items-center">
        <h1 class="text-2xl font-bold text-indigo-700 mb-6 text-center">Conversation du ticket #<?= htmlspecialchars($ticket_id) ?></h1>
        <?php if (!$is_active): ?>
            <div class="mb-4 text-red-600 font-semibold text-center">Cette conversation est fermée.</div>
        <?php endif; ?>
        <div class="w-full mb-6 max-h-96 overflow-y-auto flex flex-col gap-2">
            <?php foreach ($messages as $msg): ?>
                <div class="px-4 py-2 rounded-lg <?= $msg['Created_by'] == $_SESSION['id'] ? 'bg-indigo-100 self-end' : 'bg-gray-100 self-start' ?>">
                    <span class="font-semibold"><?= htmlspecialchars($msg['Username'] ?? 'Utilisateur') ?> :</span>
                    <?= htmlspecialchars($msg['Message']) ?>
                    <div class="text-xs text-gray-400"><?= $msg['Created_at'] ?></div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($messages)): ?>
                <div class="text-gray-400 text-center">Aucun message pour ce ticket.</div>
            <?php endif; ?>
        </div>
        <?php if ($is_active): ?>
            <form method="post" class="w-full flex gap-2">
                <input type="text" name="message" required placeholder="Votre message..."
                    class="flex-1 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                <button type="submit"
                    class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
                    Envoyer
                </button>
            </form>
            <?php if ($is_admin || $is_creator): ?>
                <form method="post" class="w-full mt-4">
                    <button type="submit" name="close_ticket"
                        class="px-6 py-2 bg-red-100 text-red-700 rounded-lg font-semibold hover:bg-red-200 transition text-center w-full block">
                        Fermer la conversation
                    </button>
                </form>
            <?php endif; ?>
        <?php else: ?>
            <div class="w-full text-center text-gray-400 mt-2">Vous ne pouvez plus envoyer de messages.</div>
        <?php endif; ?>
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