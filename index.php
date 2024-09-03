<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blum Token Generator</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600" rel="stylesheet">
<style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #ffffff, #a1c4fd, #c2e9fb); /* Light gradient */
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            animation: fadeIn 0.5s ease-in; /* Fade-in animation for body */
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .container {
            background: #ffffff;
            border-radius: 0px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 90%; /* Responsive width */
            max-width: 400px; /* Max width for larger screens */
            position: relative;
            transition: transform 0.3s ease; /* Transform animation */
        }
        .container:hover {
             /* Slight scaling on hover */
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #0072ff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }
        hr {
            border: 0;
            height: 2px;
            background-image: linear-gradient(to right, #0072ff, #00c6ff);
            margin: 20px 0;
        }
        input, button {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #0072ff;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
            background: rgba(255, 255, 255, 0.8);
            color: #333;
        }
        input:focus {
            border-color: #00c6ff;
            box-shadow: 0 0 5px rgba(0, 198, 255, 0.5);
            outline: none;
        }
        button {
            background-color: #0072ff;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
        }
        button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .guide {
            margin-top: 20px;
            font-size: 14px;
            color: #333;
            text-align: left;
        }
        .notification {
            display: none;
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            z-index: 999;
            animation: fadeInUp 0.3s ease-in-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translate(-50%, 20px); }
            to { opacity: 1; transform: translate(-50%, 0); }
        }
        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8); /* Black with opacity */
            padding-top: 60px;
            animation: fadeIn 0.5s ease-in; /* Fade-in animation for modal */
        }
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px; /* Max width for the modal */
            border-radius: 10px;
            animation: slideIn 0.5s ease-in; /* Slide-in animation for modal content */
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        /* Full-width button for Telegram link */
        .telegram-button {
            background-color: #0088cc;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
            margin-top: 20px;
        }
        .telegram-button:hover {
            background-color: #0072a3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Blum Token Generator</h1>
        
            <form action="" method="POST">
                <input type="url" name="url" placeholder="Paste Your URL Here" required>
                <button type="submit" name="submit">Submit</button>
            </form>
        <div id="notification" class="notification">
            <p id="notificationMessage"></p>
        </div>

        <div class="guide">
            <h2>Quick Guide</h2>
            <ol>
                <li>Open Telegram And Launch The Blum Bot.</li>
                <li>Tap "Launch Blum Instantly" And Disable Your Internet Connection.</li>
                <li>Refresh The Page To Obtain A Large URL. Paste It Here.</li>
                <li>Then Click Continue, Paste Your Jwt Token And Enter The Point Range (e.g., 200-280, Max Limit: 280).</li>
            </ol>
            <button onclick="openModal()">Watch Video Guide</button>
        </div>

        <!-- Modal for Video Guide -->
        <div id="videoModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Video Guide</h2>
                <iframe width="100%" height="193" src="https://www.youtube.com/embed/KxzdXfTEewU" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>

        <a href="https://telegram.me/BackupRedirect" target="_blank">
            <button class="telegram-button">Created By Saeed Ahmed</button>
        </a>
    </div>

    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("referlink");
            copyText.select();
            document.execCommand("copy");
            document.getElementById("notificationMessage").innerText = 'Token copied to clipboard!';
            showNotification();

            // Trigger vibration if supported
            if ("vibrate" in navigator) {
                navigator.vibrate(200); // Vibrate for 200 milliseconds
            }
        }

        function showNotification() {
            var notification = document.getElementById("notification");
            notification.style.display = "block";
            setTimeout(function() {
                notification.style.display = "none";
            }, 3000);
        }

        function openModal() {
            document.getElementById("videoModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("videoModal").style.display = "none";
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            var modal = document.getElementById("videoModal");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>