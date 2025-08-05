<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

header('Content-Type: application/json');

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function getAddressFromLatLong($latitude, $longitude) {
  $apiKey = $_ENV['MAPS_API_KEY']; // Use the API key from .env file
  $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$apiKey}";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $response = curl_exec($ch);
  curl_close($ch);

  $data = json_decode($response, true);
  // error_log("Geocoding API response: " . print_r($data, true));
  if ($data && $data['status'] === 'OK' && !empty($data['results'])) {
    // Find a suitable address component, often the formatted_address of the first result

    return json_encode($data['results'][0]);
  }
  return 'Address not found';
}
 
// Get the raw POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

$response = ['success' => false, 'message' => ''];

if ($data && isset($data['latitude']) && isset($data['longitude']) && isset($data['devMode'])) {
    $latitude = $data['latitude'];
    $longitude = $data['longitude'];
    $devMode =  $data['devMode'];

    error_log("Received devMode: $devMode");
    // Get address from latitude and longitude
    if (!$devMode) {
      $address = getAddressFromLatLong($latitude, $longitude);
    } else {
      $address = [
        'address_components' => [
          [
            'long_name' => "1234",
            'short_name' => "1234",
            'types' => ["street_number"]
          ],
          [
            'long_name' => "Purple Street",
            'short_name' => "Purple St",
            'types' => [ "route" ]
          ],
          [
            'long_name' => "South Cityville",
            'short_name' => "South Cityville",
            'types' => [ 'neighborhood', 'political',]

          ],
          [
            'long_name' => "Cityville",
            'short_name' => "Cityville",
            'types' => [ 'locality', 'political',]

          ],
          [
            'long_name' => "Duchy County",
            'short_name' => "Duchy County",
            'types' => [ 'administrative_area_level_2', 'political',]
          ],
          [
            'long_name' => "California",
            'short_name' => "CA",
            'types' => [ 'administrative_area_level_1', 'political',]
          ],
          [
            'long_name' => "United States",
            'short_name' => "US",
            'types' => [ 'country', 'political',]
          ],
          [
            'long_name' => "91234",
            'short_name' => "91234",
            'types' => [ 'postal_code',]

          ],
          [
            'long_name' => "5678",
            'short_name' => "5678",
            'types' => [ 'postal_code_suffix',]
          ],
        ],
        'formatted_address' => "1234 Purple St, South Cityville, Cityville, Duchy County, California, United States, 91234-5678"
      ];
      $address = json_encode($address);
    }

    if ($address) {
        $response['success'] = true;
        $response['message'] = 'Address fetched successfully!';
        $response['address'] = $address;
    } else {
        $response['message'] = 'Failed to fetch address.';
    }
} else {
    $response['message'] = 'Invalid data provided.';
}

echo json_encode($response);

