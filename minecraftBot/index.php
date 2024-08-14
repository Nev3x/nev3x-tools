<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minecraft Bot</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Style for the cookie consent banner */
        #cookie-consent-banner {
            position: fixed;
            bottom: 540px; /* Adjusted to appear at the bottom */
            width: 100%;
            background: #000;
            color: #fff;
            text-align: center;
            padding: 15px;
            z-index: 1000;
            display: none; /* Initially hidden */
        }
        #cookie-consent-banner button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        #cookie-consent-banner .decline {
            background: #dc3545;
            margin-left: 10px;
        }
        /* Style for the change consent link */
        #change-consent {
            margin-top: 20px;
            display: none; /* Initially hidden */
        }
        /* Style for the main content of the page */
        #main-content {
            display: none; /* Hide content until consent is given */
        }
    </style>
</head>
<body>
    <!-- Cookie Consent Banner -->
    <div id="cookie-consent-banner">
        <p>We use cookies to enhance your experience on our website. By continuing to browse the site, you agree to our use of cookies. For more details, please read our <a href="/cookie-policy" style="color: #00f;">Cookie Policy</a>.</p>
        <button id="accept-cookies">Accept</button>
        <button id="decline-cookies" class="decline">Decline</button>
    </div>

    <!-- Change Cookie Consent Link -->
    <div id="change-consent">
        <p>You previously declined cookies. If you want to change your preferences, click the button below:</p>
        <button id="reaccept-cookies">Accept Cookies</button>
    </div>

    <!-- Main Content -->
    <div id="main-content" class="container">
        <h1>Minecraft Bot</h1>
        <section class="connection">
            <h2>Connection Settings</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Your Minecraft username">
            <br><br>
            <label for="host">Host:</label>
            <input type="text" id="host" name="host" placeholder="Minecraft server host">
            <br><br>
            <label for="port">Port:</label>
            <input type="number" id="port" name="port" placeholder="Minecraft server port">
            <input type="submit" value="Connect" class="send-button" id="conbtn">
        </section>
        <section class="chat">
            <h2>Chat Message</h2>
            <label for="message">Message:</label>
            <input type="text" id="message" name="message" placeholder="Type your message...">
            <br><br>
            <input type="submit" value="Send" class="send-button" id="sendbtn">
        </section>
        <section class="attack">
            <h2>Attack Player</h2>
            <label for="attack">Player nickname:</label>
            <input type="text" id="attack" name="player" placeholder="Type player nickname...">
            <br><br>
            <input type="submit" value="Attack" class="send-button" id="attackbtn">
            <input type="submit" value="Stop attacking" class="send-button" id="stopattackbtn">
            <input type="submit" value="Equip armor and weapon" class="send-button" id="armor">
        </section>
        <section class="follow-player">
            <h2>Follow Player</h2>
            <label for="follow">Player nickname:</label>
            <input type="text" id="follow" name="player" placeholder="Type player nickname...">
            <br><br>
            <input type="submit" value="Follow" class="send-button" id="followbtn">
            <input type="submit" value="Stop Following" class="send-button" id="unfollowbtn">
        </section>
        <br>
        <section class="logs">
            <h2>Logs</h2>
            <div id="log-container">
                <!-- Logs will be displayed here -->
            </div>
        </section>
        <input type="submit" value="Disconnect" class="send-button" id="discbtn">
    </div>

    <!-- Google Ads Placeholder -->
    <div id="google-ads-placeholder"></div>

    <script src="script.js"></script>
    <script>
        // JavaScript for Cookie Consent
        // Function to load Google Ads (commented out for demonstration purposes)
        function loadGoogleAds() {
            var script = document.createElement('script');
            script.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';
            script.async = true;
            document.head.appendChild(script);

            var ad = document.createElement('ins');
            ad.className = 'adsbygoogle';
            ad.style.display = 'block';
            ad.setAttribute('data-ad-client', 'ca-pub-xxxxxxxxxxxxxxxx'); // Replace with your Google AdSense client ID
            ad.setAttribute('data-ad-slot', 'xxxxxxxxxx'); // Replace with your Google AdSense slot ID
            ad.setAttribute('data-ad-format', 'auto');
            document.getElementById('google-ads-placeholder').appendChild(ad);

            (adsbygoogle = window.adsbygoogle || []).push({});
        }
        // Function to check cookie consent status
        function checkCookieConsent() {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i].trim();
                if (cookie.startsWith('cookieConsent=')) {
                    return cookie.split('=')[1];
                }
            }
            return null;
        }

        // Function to handle user accepting cookies
        function handleAcceptCookies() {
            document.getElementById('cookie-consent-banner').style.display = 'none';
            document.getElementById('main-content').style.display = 'block'; // Show main content
            document.getElementById('google-ads-placeholder').style.display = 'block'; // Show Google Ads
            document.cookie = "cookieConsent=true; path=/; max-age=" + 60*60*24*30; // Set cookie for 30 days
            //loadGoogleAds(); // Load Google Ads script
        }

        // Function to handle user declining cookies
        function handleDeclineCookies() {
            document.getElementById('cookie-consent-banner').style.display = 'none';
            document.getElementById('change-consent').style.display = 'block'; // Show change consent option
            document.cookie = "cookieConsent=false; path=/; max-age=" + 60*60*24*30; // Set cookie for 30 days
        }

        // Function to handle user re-accepting cookies
        function handleReacceptCookies() {
            document.getElementById('change-consent').style.display = 'none';
            document.getElementById('cookie-consent-banner').style.display = 'block';
            document.cookie = "cookieConsent=true; path=/; max-age=" + 60*60*24*30; // Set cookie for 30 days
            // loadGoogleAds(); // Load Google Ads script
        }



        // Event listeners for cookie consent buttons
        document.getElementById('accept-cookies').addEventListener('click', handleAcceptCookies);
        document.getElementById('decline-cookies').addEventListener('click', handleDeclineCookies);
        document.getElementById('reaccept-cookies').addEventListener('click', handleReacceptCookies);

        // Check cookie consent status on page load
        var consent = checkCookieConsent();
        if (consent === 'false') {
            document.getElementById('change-consent').style.display = 'block'; // Show change consent option
        } else if (consent === null) {
            document.getElementById('cookie-consent-banner').style.display = 'block'; // Show the initial consent banner
        } else {
            document.getElementById('cookie-consent-banner').style.display = 'none'; // Hide if consent is already given
            document.getElementById('main-content').style.display = 'block'; // Show the main content if consent is given
            document.getElementById('google-ads-placeholder').style.display = 'block'; // Show Google Ads
            // loadGoogleAds(); // Load Google Ads script
        }</script>
</body>
</html>
