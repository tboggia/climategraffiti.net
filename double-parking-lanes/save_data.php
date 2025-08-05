<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

header('Content-Type: application/json');

// Get the raw POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$response = ['success' => false, 'message' => ''];

if ($data && isset($data['imageData']) && isset($data['latitude']) && isset($data['longitude']) && isset($data['city'])) {
    $imageData = $data['imageData'];
    $latitude = $data['latitude'];
    $longitude = $data['longitude'];
    $city = $data['city'];
    // $uploadsDir = $_ENV['UPLOADS_DIR'] . '/'; // Directory to save images
    $uploadsDir = 'uploads/'; // Directory to save images

    // 1. Decode Base64 image data and save it
    // Example: data:image/png;base64,iVBORw0KGgo...
    list($type, $imageData) = explode(';', $imageData);
    list(, $imageData)      = explode(',', $imageData);
    $imageData = base64_decode($imageData);

    $imageFileName = uniqid() . '.png'; // Generate unique file name
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0777, true);
    }
    $filePath = $uploadsDir . $imageFileName;

    if (file_put_contents($filePath, $imageData)) {
        // 2. Save data to MySQL
        $servername = 'localhost';
        $username = $_ENV['USR_DB_USERNAME'];
        $password = $_ENV['USR_DB_PASSWORD'];
        $dbname = $_ENV['USR_DB_NAME'];

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("INSERT INTO photos (image_path, latitude, longitude, city, created_at) VALUES (:image_path, :latitude, :longitude, :city, NOW())");
            $stmt->bindParam(':image_path', $filePath);
            $stmt->bindParam(':latitude', $latitude);
            $stmt->bindParam(':longitude', $longitude);
            $stmt->bindParam(':city', $city);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Data saved to ' . getenv('USR_DB_NAME') . ' successfully!';

            } else {
                $response['message'] = 'Failed to insert into database.';
            }
        } catch(PDOException $e) {
            $response['message'] = 'Database error when connecting to: ' . $e->getMessage();
        }
        $conn = null; // Close connection
    } else {
        $response['message'] = 'Failed to save image file.';
    }
} else {
    $response['message'] = 'Invalid data received.';
}

echo json_encode($response);
?>