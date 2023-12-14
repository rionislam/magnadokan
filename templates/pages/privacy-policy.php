<?php
use Core\Services\ResourceLoader;
use Core\Services\HtmlGenerator;

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
       <?=HtmlGenerator::generateHead(HtmlGenerator::generateSeoTags('Privacy Policy'))?>
</head>
<body>
      <!-- Load gtag for google services intrigration -->
      <?=ResourceLoader::loadGtag()?>
        
        <!-- Show if there is any user notification -->
        <?=ResourceLoader::loadNotification()?>

        <!-- Load the fixed login-signup form -->
        <?=ResourceLoader::loadComponent('login-signup')?>

        <!-- Load the downloads left -->
        <?=ResourceLoader::loadComponent('downloads-left')?>
    <main>
        <!-- Load the header -->
        <?=ResourceLoader::loadComponent('header')?>
    <section class="max-width center">
        <h1  style="margin: 2rem 0;">Privacy Policy for Magna Dokan</h1>

        <p style="margin: 1rem 0;">Last updated: 9/12/2023</p>

        <p>Welcome to Magna Dokan. This Privacy Policy outlines how Magna Dokan collects, uses, maintains, and discloses information collected from users (each, a "User") of the https://magnadokan.com website ("Site")..</p>

        <h2  style="margin: 1rem 0;">Personal Identification Information</h2>

        <p>We may collect personal identification information from Users in various ways, including but not limited to when Users visit our site, register on the site, subscribe to the newsletter, fill out a form, and in connection with other activities, services, features, or resources we make available on our Site.

            Users may be asked for, as appropriate, name, email address. Users may, however, visit our Site anonymously. We will collect personal identification information from Users only if they voluntarily submit such information to us. Users can always refuse to supply personally identification information, except that it may prevent them from engaging in certain Site-related activities.</p>


        <h2  style="margin: 1rem 0;">Non-personal Identification Information</h2>

        <p>We may collect non-personal identification information about Users whenever they interact with our Site. Non-personal identification information may include the browser name, the type of computer, and technical information about Users' means of connection to our Site, such as the operating system and the Internet service providers utilized, and other similar information.</p>

        <h2  style="margin: 1rem 0;">Web Browser Cookies</h2>

        <p>Our Site may use "cookies" to enhance User experience. Users' web browsers place cookies on their hard drive for record-keeping purposes and sometimes to track information about them. Users may choose to set their web browser to refuse cookies or to alert you when cookies are being sent. If they do so, note that some parts of the Site may not function properly.</p>
        
        <h2  style="margin: 1rem 0;">How We Use Collected Information</h2>

        <p>Magna Dokan may collect and use Users personal information for the following purposes:</p>

        <ul style="margin-top: 0.5rem; margin-left: 1rem;">
            <li>To personalize user experience</li>
            <li>To improve our Site</li>
            <li>To send periodic emails</li>
        </ul>

        <h2  style="margin: 1rem 0;">How We Protect Your Information</h2>

        <p>We adopt appropriate data collection, storage, and processing practices and security measures to protect against unauthorized access, alteration, disclosure, or destruction of your personal information, username, password, and data stored on our Site.</p>

        <h2  style="margin: 1rem 0;">Sharing Your Personal Information</h2>
        <p>We do not sell, trade, or rent Users' personal identification information to others. We may share generic aggregated demographic information not linked to any personal identification information regarding visitors and users with our business partners, trusted affiliates, and advertisers for the purposes outlined above.</p>

        <h2  style="margin: 1rem 0;">Changes to This Privacy Policy</h2>

        <p>Magna Dokan has the discretion to update this privacy policy at any time. When we do, we will revise the updated date at the bottom of this page. We encourage Users to frequently check this page for any changes to stay informed about how we are helping to protect the personal information we collect. You acknowledge and agree that it is your responsibility to review this privacy policy periodically and become aware of modifications.</p>

        <h2  style="margin: 1rem 0;">Your Acceptance of These Terms</h2>

        <p>By using this Site, you signify your acceptance of this policy. If you do not agree to this policy, please do not use our Site. Your continued use of the Site following the posting of changes to this policy will be deemed your acceptance of those changes.</p>
        
        </section>
        
  </main>
   <!-- Load the footer -->
   <?=ResourceLoader::loadComponent('footer')?>
</body>
</html>
