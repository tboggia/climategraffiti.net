<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Double Parking Lanes</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="container bg-white p-6 rounded-xl shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Double Parking Lanes</h1>

        <div class="space-y-4">
            <video id="video" class="hidden" autoplay playsinline></video>
            <canvas id="canvas" class="hidden"></canvas>
            <img id="photo" class="hidden" alt="Captured Photo">

            <button id="capturePhotoBtn" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg text-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 hidden">
                Capture Photo
            </button>

            <button id="saveDataBtn" class="w-full bg-green-600 text-white py-3 px-6 rounded-lg text-lg font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 hidden">
                Save Data
            </button>

            <button id="openCameraBtn" class="w-auto bg-orange-600 text-white py-3 px-3 rounded-md text-md font-semibold hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50 hidden">
                Take another photo
            </button>

            <div id="locationInfo" class="mt-6 p-4 bg-gray-50 rounded-lg text-left hidden">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">Location:</h2>
                <p class="text-gray-600">City: <span id="city">Fetching...</span></p>
            </div>
        </div>

        <button id="requestPermissionsBtn" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg text-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Re-request Permissions
        </button>
        <button id="purgeDataBtn" class="w-full bg-red-600 text-white py-3 px-6 rounded-lg text-lg font-semibold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 hidden">
            Purge Data
        </button>

        <div id="messageBox" class="message-box"></div>

    </div>

    <script src="scripts.js"></script>
</body>
</html>
