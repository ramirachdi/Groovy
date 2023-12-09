<?php
$dsn = "mysql:host=localhost;dbname=groovy;charset=utf8mb4";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if(isset($_POST['songId'])) {
    $songId = $_POST['songId'];

    $query = $pdo->prepare("UPDATE songs SET plays = plays + 1 WHERE id = :songId");
    $query->bindParam(':songId', $songId, PDO::PARAM_INT);
    $query->execute();
}
?>
