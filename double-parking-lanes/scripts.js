// Get references to DOM elements

/**
 * Move save data button after photo is taken
 * Remove permisisons button if permissions are granted
 * Open camera by default after permissions check
 */
const requestPermissionsBtn = document.getElementById('requestPermissionsBtn');
const openCameraBtn = document.getElementById('openCameraBtn');
const capturePhotoBtn = document.getElementById('capturePhotoBtn');
const saveDataBtn = document.getElementById('saveDataBtn');
const purgeDataBtn = document.getElementById('purgeDataBtn');

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photo = document.getElementById('photo');
const locationInfo = document.getElementById('locationInfo');
const citySpan = document.getElementById('city');
const messageBox = document.getElementById('messageBox');
const devMode = new URLSearchParams(window.location.search).get('dev') === 'true'; // Check if dev mode is enabled

let currentStream; // To hold the camera stream
let currentLatitude = null;
let currentLongitude = null;
let currentCity = null;
let capturedImageData = null; // To store the base64 image data


/**
 * Displays a message in the message box.
 * @param {string} message The message to display.
 * @param {string} type The type of message ('success', 'error', or default).
 */
function showMessage(message, type = '') {
  messageBox.dataset.used = 'true'; // Mark message box as used
  let newMessage = document.createElement('p');
  newMessage.textContent = message;
  messageBox.appendChild(newMessage);
  if (type) {
    newMessage.dataset.type = type;
  }
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
      openCamera();
    } else if (cameraPermissionStatus.state === 'prompt') {
      showMessage('Please allow camera access when prompted.', '');
    } else {
      showMessage('Camera permission denied. Camera features will not work.', 'error');
    }

    // Try to get location immediately after permissions are queried
    getLocation();
    if (geoPermissionStatus.state === 'granted' || cameraPermissionStatus.state === 'granted') requestPermissionsBtn.classList.add('hidden'); // Hide after permissions are requested

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
    citySpan.textContent = 'Fetching...';

    navigator.geolocation.getCurrentPosition(
      async (position) => {
        currentLatitude = position.coords.latitude;
        currentLongitude = position.coords.longitude;
        showMessage('Location obtained successfully!', 'success');

        // Simulate reverse geocoding
        await getReverseGeocoding(currentLatitude, currentLongitude);
      },
      (error) => {
        console.error('Error getting location:', error);
        citySpan.textContent = 'Error';
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
async function getReverseGeocoding(lat, lon) {
  citySpan.textContent = 'Fetching city...';

  try {
    // This is the fetch request to your PHP backend
    const response = await fetch('get_address.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ latitude: lat, longitude: lon, devMode: devMode })
    });

    const result = await response.json(); // Assuming your PHP returns JSON

    if (response.ok && result.success) {
      showMessage(result.message, 'success');
      const returnedAddressObject = JSON.parse(result.address);
      console.log(returnedAddressObject)
      const addressComponents = returnedAddressObject.address_components;
      const componentsMap = addressComponents.map((components) => {
        return components.types[0]
      });

      currentCity = addressComponents[componentsMap.indexOf('locality')].long_name;
      citySpan.textContent = currentCity;

      if (capturedImageData) saveDataBtn.classList.remove('hidden'); // Show save button once location is available

    } else {
      showMessage(`Failed to get city: ${result.message || 'Unknown error'}`, 'error');
      citySpan.textContent = "Failed to get city";
      console.error('Server error:', result);
    }

  } catch (error) {
    showMessage(`Error during city fetch: ${error.message}`, 'error');
    console.error('Error during data save:', error);
  }
}

/**
 * Opens the device camera and displays the stream in the video element.
 */
async function openCamera() {
  showMessage('Opening camera...', '');
  capturedImageData = null;
  photo.classList.add('hidden');

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

  showMessage('Photo captured!', 'success');
  if (currentLatitude) saveDataBtn.classList.remove('hidden'); // Show save button once location is available

}

/**
 * Sends the captured data (photo, lat/long, address) to a PHP backend for saving.
 */
async function saveData() {
  if (!capturedImageData) {
    showMessage('No photo captured yet. Please capture a photo.', 'error');
    return;
  }
  if ( currentCity === null ) {
    showMessage('Location data not available. Please ensure location services are enabled.', 'error');
    return;
  }

  showMessage('Saving data...', '');

  const dataToSave = {
    imageData: capturedImageData,
    latitude: currentLatitude,
    longitude: currentLongitude,
    city: currentCity,
    public: 0
  };

  console.log('Data prepared for saving:', dataToSave);

  try {
    // This is the fetch request to your PHP backend
    const response = await fetch('save_data.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(dataToSave)
    });

    const result = await response.json(); // Assuming your PHP returns JSON
    console.log('Server response:', result);
    console.log('Server response:', response);
    if (response.ok && result.success) {
      showMessage(result.message, 'success');
      console.log('Server response:', result);
      // Optionally reset UI or provide further feedback
    } else {
      showMessage(`Failed to save data: ${result.message || 'Unknown error'}`, 'error');
      console.error('Server error:', result);
    }

  } catch (error) {
    showMessage(`Error during data save: ${error.message}`, 'error');
    console.error('Error during data save:', error);
  }
}

async function purgeData() {
  showMessage('Purging data...', '');
  try {
    // This is the fetch request to your PHP backend
    const response = await fetch('purge_data.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      }
    });

    const result = await response.json(); // Assuming your PHP returns JSON
    if (response.ok && result.success) {
      showMessage(result.message, 'success');
      console.log('Data purged successfully:', result);
      // Optionally reset UI or provide further feedback
    } else {
      showMessage(`Failed to purge data: ${result.message || 'Unknown error'}`, 'error');
      console.error('Server error:', result);
    }

  } catch (error) {
    showMessage(`Error during data purge: ${error.message}`, 'error');
    console.error('Error during data purge:', error);
  }
} 

// Event Listeners
requestPermissionsBtn.addEventListener('click', requestPermissions);
openCameraBtn.addEventListener('click', openCamera);
capturePhotoBtn.addEventListener('click', capturePhoto);
saveDataBtn.addEventListener('click', saveData);
purgeDataBtn.addEventListener('click', purgeData);

// Initial setup on page load
window.onload = () => {
  // Attempt to get location if permission is already granted.
  requestPermissions();
  if (devMode) {
    purgeDataBtn.classList.remove('hidden'); // Show purge button in dev mode
  }
};
