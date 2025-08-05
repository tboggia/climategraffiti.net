<?php
header('Content-Type: application/json');

// Get the raw POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$response = ['success' => false, 'message' => ''];

if ($data && isset($data['imageData']) && isset($data['latitude']) && isset($data['longitude']) && isset($data['address'])) {
    $imageData = $data['imageData'];
    $latitude = $data['latitude'];
    $longitude = $data['longitude'];
    $address = $data['address'];

    // 1. Decode Base64 image data and save it
    // Example: data:image/png;base64,iVBORw0KGgo...
    list($type, $imageData) = explode(';', $imageData);
    list(, $imageData)      = explode(',', $imageData);
    $imageData = base64_decode($imageData);

    $imageFileName = uniqid() . '.png'; // Generate unique file name
    $uploadDir = 'uploads/'; // Directory to save images
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $filePath = $uploadDir . $imageFileName;

    if (file_put_contents($filePath, $imageData)) {
        // 2. Save data to MySQL
        // Replace with your actual database connection details
        $servername = "localhost";
        $username = "your_db_username";
        $password = "your_db_password";
        $dbname = "your_db_name";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("INSERT INTO photos (image_path, latitude, longitude, address, created_at) VALUES (:image_path, :latitude, :longitude, :address, NOW())");
            $stmt->bindParam(':image_path', $filePath);
            $stmt->bindParam(':latitude', $latitude);
            $stmt->bindParam(':longitude', $longitude);
            $stmt->bindParam(':address', $address);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Data saved successfully!';
            } else {
                $response['message'] = 'Failed to insert into database.';
            }
        } catch(PDOException $e) {
            $response['message'] = 'Database error: ' . $e->getMessage();
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