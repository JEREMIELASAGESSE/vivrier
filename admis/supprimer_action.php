<?php
require "../config/config.php";
$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM actions WHERE id = ?");
$stmt->execute([$id]);
echo "<p style='color:red;'>🗑️ Action supprimée.</p>";
header("Location: tbaction.php");
