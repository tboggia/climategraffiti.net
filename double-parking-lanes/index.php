<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo & Location App</title>
    <link rel="stylesheet" href="style.css">

</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="container bg-white p-6 rounded-xl shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Capture & Locate</h1>

        <!-- Message Box for user feedback -->
        <div id="messageBox" class="message-box"></div>

        <div class="space-y-4">
            <button id="requestPermissionsBtn" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg text-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Request Permissions
            </button>

            <button id="openCameraBtn" class="w-full bg-green-600 text-white py-3 px-6 rounded-lg text-lg font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 hidden">
                Open Camera
            </button>

            <video id="video" class="hidden" autoplay playsinline></video>
            <canvas id="canvas" class="hidden"></canvas>
            <img id="photo" class="hidden" alt="Captured Photo">

            <button id="capturePhotoBtn" class="w-full bg-purple-600 text-white py-3 px-6 rounded-lg text-lg font-semibold hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 hidden">
                Capture Photo
            </button>

            <div id="locationInfo" class="mt-6 p-4 bg-gray-50 rounded-lg text-left hidden">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Location Data:</h2>
                <p class="text-gray-600">Latitude: <span id="latitude">N/A</span></p>
                <p class="text-gray-600">Longitude: <span id="longitude">N/A</span></p>
                <p class="text-gray-600">Address: <span id="address">Fetching...</span></p>
            </div>

            <button id="saveDataBtn" class="w-full bg-red-600 text-white py-3 px-6 rounded-lg text-lg font-semibold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 hidden">
                Save Data
            </button>
        </div>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
