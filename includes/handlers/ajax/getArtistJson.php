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

if(isset($_POST['artistId'])) {
    $artistId = $_POST['artistId'];

    $query = $pdo->prepare("SELECT * FROM artists WHERE id=:artistId");
    $query->bindParam(':artistId', $artistId, PDO::PARAM_INT);
    $query->execute();

    $resultArray = $query->fetch(PDO::FETCH_ASSOC);

    echo json_encode($resultArray);
    exit(); 
}
?>
