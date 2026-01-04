<?php
header('Content-Type: application/json');
require 'connector.php'; 

function getMenuStats($pdo) {
    $stmt = $pdo->query('SELECT COUNT(*) AS total_menu FROM menu'); 
    $menuStats = $stmt->fetch(PDO::FETCH_ASSOC);
    return $menuStats['total_menu'];
}

// Fungsi untuk mengambil jumlah pengguna
function getUserStats($pdo) {
    // Query untuk menghitung total pengguna
    $stmt = $pdo->query('SELECT COUNT(*) AS total_users FROM user'); 
    $userStats = $stmt->fetch(PDO::FETCH_ASSOC);
    return $userStats['total_users'];
}

$totalMenu = getMenuStats($pdo);
$totalUsers = getUserStats($pdo);

echo json_encode([
    'totalMenu' => $totalMenu,
    'totalUsers' => $totalUsers
]);
?>
