<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Levenstein Similarity</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #cookie-consent-banner {
            position: fixed;
            bottom: 540px;
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
        #change-consent {
            margin-top: 20px;
            display: none; /* Initially hidden */
        }
        textarea {
            width: 100%;
            height: 100px;
            margin: 10px 0;
        }
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
        <h1>Levenstein Similarity</h1>
        <textarea name="text1" id="text1" placeholder="Copy text one here..."></textarea>
        <textarea name="text2" id="text2" placeholder="Copy text two here..."></textarea>
        <input type="submit" value="Test Similarity" id="submitbtn">
        <br>
        <h3 id="response"></h3>
    </div>

    <!-- Google Ads Placeholder -->
    <div id="google-ads-placeholder"></div>

    <script>
        function loadGoogleAds() {
    var script = document.createElement('script');
    script.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';
    script.async = true;
    document.head.appendChild(script);

    var ad = document.createElement('ins');
    ad.className = 'adsbygoogle';
    ad.style.display = 'block';
    ad.setAttribute('data-ad-client', 'ca-pub-xxxxxxxxxxxxxxxx');
    ad.setAttribute('data-ad-slot', 'xxxxxxxxxx');
    ad.setAttribute('data-ad-format', 'auto');
    document.getElementById('google-ads-placeholder').appendChild(ad);

    (adsbygoogle = window.adsbygoogle || []).push({});
}
// JavaScript for Cookie Consent
document.getElementById('accept-cookies').addEventListener('click', function() {
    document.getElementById('cookie-consent-banner').style.display = 'none';
    document.getElementById('main-content').style.display = 'block';
    document.getElementById('google-ads-placeholder').style.display = 'block'; // Show Google Ads
    document.cookie = "cookieConsent=true; path=/; max-age=" + 60*60*24*30; // 30 days
    //loadGoogleAds(); // Load Google Ads script
});

document.getElementById('decline-cookies').addEventListener('click', function() {
    document.getElementById('cookie-consent-banner').style.display = 'none';
    document.getElementById('change-consent').style.display = 'block'; // Show change consent link
    document.cookie = "cookieConsent=false; path=/; max-age=" + 60*60*24*30; // 30 days
});

document.getElementById('reaccept-cookies').addEventListener('click', function() {
    document.getElementById('change-consent').style.display = 'none';
    document.getElementById('cookie-consent-banner').style.display = 'block';
    document.cookie = "cookieConsent=true; path=/; max-age=" + 60*60*24*30; // 30 days
    //loadGoogleAds(); // Load Google Ads script
});

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



var consent = checkCookieConsent();
if (consent === 'false') {
    document.getElementById('change-consent').style.display = 'block'; // Show change consent option
} else if (consent === null) {
    document.getElementById('cookie-consent-banner').style.display = 'block'; // Show the initial consent banner
} else {
    document.getElementById('cookie-consent-banner').style.display = 'none'; // Hide if consent is already given
    document.getElementById('main-content').style.display = 'block'; // Show the main content if consent is given
    document.getElementById('google-ads-placeholder').style.display = 'block'; // Show Google Ads
    //loadGoogleAds(); // Load Google Ads script
}
    </script>
    <script src="script.js"></script>
</body>
</html>
