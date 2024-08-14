<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webhook Sender</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style for the cookie consent banner */
        #cookie-consent-banner {
            position: fixed;
            bottom: 540px; /* Adjusted to appear at the bottom */
            width: 100%;
            background: #fff;
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
    <div id="main-content">
        <h1>Webhook Sender</h1>
        <!-- Input fields for URL and text -->
        <input type="text" placeholder="url..." id="url">
        <input type="text" placeholder="text..." id="text">
        <br>
        <!-- Submit button -->
        <input type="submit" value="Submit" id="submited">
        <br>
        <!-- Placeholder for response messages -->
        <p id="response"></p>
    </div>

    <!-- Google Ads Placeholder -->
    <div id="google-ads-placeholder"></div>
    <script src="script.js"></script>
    <script>        // JavaScript for Cookie Consent
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

        // Function to load Google Ads (commented out for demonstration purposes)
        
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
        }
        </script>
</body>
</html>
