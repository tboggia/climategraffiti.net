// Get references to DOM elements
const requestPermissionsBtn = document.getElementById('requestPermissionsBtn');
const openCameraBtn = document.getElementById('openCameraBtn');
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photo = document.getElementById('photo');
const capturePhotoBtn = document.getElementById('capturePhotoBtn');
const locationInfo = document.getElementById('locationInfo');
const latitudeSpan = document.getElementById('latitude');
const longitudeSpan = document.getElementById('longitude');
const addressSpan = document.getElementById('address');
const saveDataBtn = document.getElementById('saveDataBtn');
const messageBox = document.getElementById('messageBox');

let currentStream; // To hold the camera stream
let currentLatitude = null;
let currentLongitude = null;
let capturedImageData = null; // To store the base64 image data

/**
 * Displays a message in the message box.
 * @param {string} message The message to display.
 * @param {string} type The type of message ('success', 'error', or default).
 */
function showMessage(message, type = '') {
  messageBox.textContent = message;
  messageBox.className = 'message-box'; // Reset classes
  if (type) {
    messageBox.classList.add(type);
  }
  messageBox.style.display = 'block';
  setTimeout(() => {
    messageBox.style.display = 'none';
  }, 5000); // Hide after 5 seconds
}

/**
 * Requests both geolocation and camera permissions from the user.
 */
async function requestPermissions() {
  showMessage('Requesting permissions...', '');
  try {
    // Request Geolocation permission
    const geoPermissionStatus = await navigator.permissions.query({ name: 'geolocation' });
    if (geoPermissionStatus.state === 'granted') {
      showMessage('Geolocation permission granted.', 'success');
    } else if (geoPermissionStatus.state === 'prompt') {
      showMessage('Please allow geolocation access when prompted.', '');
    } else {
      showMessage('Geolocation permission denied. Location features will not work.', 'error');
    }

    // Request Camera permission
    const cameraPermissionStatus = await navigator.permissions.query({ name: 'camera' });
    if (cameraPermissionStatus.state === 'granted') {
      showMessage('Camera permission granted.', 'success');
      openCameraBtn.classList.remove('hidden');
    } else if (cameraPermissionStatus.state === 'prompt') {
      showMessage('Please allow camera access when prompted.', '');
    } else {
      showMessage('Camera permission denied. Camera features will not work.', 'error');
    }

    // Try to get location immediately after permissions are queried
    getLocation();
    requestPermissionsBtn.classList.add('hidden'); // Hide after attempting permissions
  } catch (error) {
    showMessage(`Error requesting permissions: ${error.message}`, 'error');
    console.error('Error requesting permissions:', error);
  }
}

/**
 * Gets the current geolocation of the user.
 */
function getLocation() {
  if (navigator.geolocation) {
    locationInfo.classList.remove('hidden');
    latitudeSpan.textContent = 'Fetching...';
    longitudeSpan.textContent = 'Fetching...';
    addressSpan.textContent = 'Fetching...'; // Indicate that address is being fetched

    navigator.geolocation.getCurrentPosition(
      async (position) => {
        currentLatitude = position.coords.latitude;
        currentLongitude = position.coords.longitude;
        latitudeSpan.textContent = currentLatitude.toFixed(6);
        longitudeSpan.textContent = currentLongitude.toFixed(6);
        showMessage('Location obtained successfully!', 'success');
        saveDataBtn.classList.remove('hidden'); // Show save button once location is available

        // Simulate reverse geocoding
        await simulateReverseGeocoding(currentLatitude, currentLongitude);
      },
      (error) => {
        console.error('Error getting location:', error);
        latitudeSpan.textContent = 'Error';
        longitudeSpan.textContent = 'Error';
        addressSpan.textContent = 'Error';
        showMessage(`Error getting location: ${error.message}. Please enable location services.`, 'error');
        saveDataBtn.classList.add('hidden'); // Hide save button if location fails
      },
      { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
    );
  } else {
    showMessage('Geolocation is not supported by this browser.', 'error');
    locationInfo.classList.add('hidden');
  }
}

/**
 * Simulates a reverse geocoding API call.
 * In a real application, this would be a fetch request to a server-side endpoint
 * that securely calls a geocoding API (e.g., Google Geocoding API).
 * @param {number} lat Latitude.
 * @param {number} lon Longitude.
 */
async function simulateReverseGeocoding(lat, lon) {
  addressSpan.textContent = 'Fetching address...';
  try {
    // In a real app, you would make a fetch request to your backend here:
    // const response = await fetch('/api/reverse-geocode', {
    //     method: 'POST',
    //     headers: { 'Content-Type': 'application/json' },
    //     body: JSON.stringify({ lat, lon })
    // });
    // const data = await response.json();
    // addressSpan.textContent = data.address || 'Address not found';

    // For this demo, we'll just show a placeholder address after a delay
    await new Promise(resolve => setTimeout(resolve, 1500)); // Simulate network delay
    addressSpan.textContent = `Simulated Address for Lat: ${lat.toFixed(2)}, Lon: ${lon.toFixed(2)}`;
    showMessage('Simulated address fetched.', 'success');
  } catch (error) {
    console.error('Error simulating reverse geocoding:', error);
    addressSpan.textContent = 'Failed to get address (Simulated)';
    showMessage('Failed to get address (Simulated).', 'error');
  }
}

/**
 * Opens the device camera and displays the stream in the video element.
 */
async function openCamera() {
  showMessage('Opening camera...', '');
  try {
    // Stop any existing stream
    if (currentStream) {
      currentStream.getTracks().forEach(track => track.stop());
    }

    const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } }); // Prefer rear camera
    currentStream = stream;
    video.srcObject = stream;
    video.classList.remove('hidden');
    capturePhotoBtn.classList.remove('hidden');
    openCameraBtn.classList.add('hidden');
    showMessage('Camera opened successfully!', 'success');
  } catch (error) {
    showMessage(`Error accessing camera: ${error.message}. Please ensure camera access is granted.`, 'error');
    console.error('Error accessing camera:', error);
    video.classList.add('hidden');
    capturePhotoBtn.classList.add('hidden');
    openCameraBtn.classList.remove('hidden'); // Allow retry
  }
}

/**
 * Captures a photo from the video stream and displays it.
 */
function capturePhoto() {
  if (!currentStream) {
    showMessage('Camera not active. Please open the camera first.', 'error');
    return;
  }

  showMessage('Capturing photo...', '');
  // Set canvas dimensions to match video stream
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;

  // Draw the current video frame onto the canvas
  const context = canvas.getContext('2d');
  context.drawImage(video, 0, 0, canvas.width, canvas.height);

  // Get the image data as a base64 string
  capturedImageData = canvas.toDataURL('image/png'); // You can also use 'image/jpeg'

  // Display the captured photo
  photo.src = capturedImageData;
  photo.classList.remove('hidden');
  canvas.classList.add('hidden'); // Hide canvas after drawing
  video.classList.add('hidden'); // Hide video after capturing

  // Stop the camera stream after capturing
  if (currentStream) {
    currentStream.getTracks().forEach(track => track.stop());
    currentStream = null;
  }

  capturePhotoBtn.classList.add('hidden');
  openCameraBtn.classList.remove('hidden'); // Allow opening camera again
  saveDataBtn.classList.remove('hidden'); // Ensure save button is visible
  showMessage('Photo captured!', 'success');
}

/**
 * Simulates saving the captured data (photo, lat/long, address) to a database.
 * In a real application, this would send the data to your PHP backend.
 */
async function saveData() {
  if (!capturedImageData) {
    showMessage('No photo captured yet. Please capture a photo.', 'error');
    return;
  }
  if (currentLatitude === null || currentLongitude === null) {
    showMessage('Location data not available. Please ensure location services are enabled.', 'error');
    return;
  }

  showMessage('Simulating data save...', '');

  const dataToSave = {
    imageData: capturedImageData,
    latitude: currentLatitude,
    longitude: currentLongitude,
    address: addressSpan.textContent // Use the displayed address
  };

  console.log('Data prepared for saving:', dataToSave);

  try {
    // In a real PHP/MySQL app, you would send this data via a fetch request:
    /*
    const response = await fetch('your_php_backend_endpoint.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' // Or 'application/x-www-form-urlencoded' if using form data
        },
        body: JSON.stringify(dataToSave) // Send as JSON
        // For file upload, you might use FormData if sending actual file blobs
    });

    const result = await response.json();
    if (response.ok) {
        showMessage('Data saved successfully (Simulated)!', 'success');
        console.log('Server response:', result);
        // Reset UI or provide further feedback
    } else {
        showMessage(`Failed to save data (Simulated): ${result.message || 'Unknown error'}`, 'error');
        console.error('Server error:', result);
    }
    */

    // Simulate success after a delay
    await new Promise(resolve => setTimeout(resolve, 2000));
    showMessage('Data saved successfully (Simulated)!', 'success');
    console.log('Simulated save complete.');

    // Optionally reset the app for a new capture
    // photo.classList.add('hidden');
    // capturedImageData = null;
    // latitudeSpan.textContent = 'N/A';
    // longitudeSpan.textContent = 'N/A';
    // addressSpan.textContent = 'Fetching...';
    // saveDataBtn.classList.add('hidden');

  } catch (error) {
    showMessage(`Error during simulated save: ${error.message}`, 'error');
    console.error('Error during simulated save:', error);
  }
}

// Event Listeners
requestPermissionsBtn.addEventListener('click', requestPermissions);
openCameraBtn.addEventListener('click', openCamera);
capturePhotoBtn.addEventListener('click', capturePhoto);
saveDataBtn.addEventListener('click', saveData);

// Initial setup on page load
window.onload = () => {
  // No need to call requestPermissions here, user will click the button
  // to initiate the flow, giving them control.
  // However, we can still try to get location if permission is already granted.
  getLocation(); // Attempt to get location if allowed
};