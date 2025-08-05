<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

$servername = 'localhost';
$username = $_ENV['USR_DB_USERNAME'];
$password = $_ENV['USR_DB_PASSWORD'];
$dbname = $_ENV['USR_DB_NAME'];
$uploadsDir = $_ENV['UPLOADS_DIR'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("TRUNCATE TABLE photos");

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Data purged successfully!';
        $files = glob($uploadsDir . '/*'); // get all file names
        foreach($files as $file){ // iterate files
          if(is_file($file)) {
            unlink($file); // delete file
          }
        }
    } else {
        $response['message'] = 'Failed to insert into database.';
    }
} catch(PDOException $e) {
    $response['message'] = 'Database error when connecting to: ' . $e->getMessage();
}
$conn = null; // Close connection

echo json_encode($response);
?>