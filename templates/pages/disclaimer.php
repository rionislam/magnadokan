<?php

use Core\Application;
use Core\Services\ResourceLoader;
use Core\Services\HtmlGenerator;

require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
       <?=HtmlGenerator::generateHead(HtmlGenerator::generateSeoTags('Disclaimer'))?>
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
      <h1  style="margin: 1rem 0;">Disclaimer for Magna Dokan</h1>

    <p>If you require any more information or have any questions about our site's disclaimer, please feel free to contact us by email at help@magnadokan.com. Our Disclaimer was generated with the help of the <a href="https://www.termsfeed.com/disclaimer-generator/">Free Disclaimer Generator</a>.</p>

    <h2  style="margin: 1rem 0;">Disclaimers for Magna Dokan</h2>

    <p>All the information on this website - https://magnadokan.com - is published in good faith and for general information purpose only. Magna Dokan does not make any warranties about the completeness, reliability and accuracy of this information. Any action you take upon the information you find on this website (Magna Dokan), is strictly at your own risk. Magna Dokan will not be liable for any losses and/or damages in connection with the use of our website.</p>

    <p>From our website, you can visit other websites by following hyperlinks to such external sites. While we strive to provide only quality links to useful and ethical websites, we have no control over the content and nature of these sites. These links to other websites do not imply a recommendation for all the content found on these sites. Site owners and content may change without notice and may occur before we have the opportunity to remove a link which may have gone 'bad'.</p>

    <p>Please be also aware that when you leave our website, other sites may have different privacy policies and terms which are beyond our control. Please be sure to check the Privacy Policies of these sites as well as their "Terms of Service" before engaging in any business or uploading any information.</p>

    <h2  style="margin: 1rem 0;">Consent</h2>

    <p>By using our website, you hereby consent to our disclaimer and agree to its terms.</p>

    <h2  style="margin: 1rem 0;">Update</h2>

    <p>Should we update, amend or make any changes to this document, those changes will be prominently posted here.</p>
    </section>
    
  </main>
   <!-- Load the footer -->
   <?=ResourceLoader::loadComponent('footer')?>
</body>
</html>
