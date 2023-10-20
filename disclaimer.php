<?php

@session_start();
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
new App\Application;
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="var(--accent-1)" />
        <title>Magna Dokan - Disclaimer</title>
        <meta name="description" content="We provide free pdf version of books to those people who can't affort to buy the original copy of the books. You can 
                pdf of any book from our website for free. Although we always suggest to buy the real copy of the book.
                We do it all for educational purpous only. We also promote the original copy of the books we provide through our
                website. Most of the writters and pubblisher don't mind if their books are distributed to the underprivileged people
                for free. If anyone mind and don't want their content to be distributed for free they can place a request and we will 
                remove their content according to the DMCA policy.">
        <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
        <link rel="manifest" href="<?=App\Application::$HOST?>/menifest.json">
        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="js/functions.js"></script>
</head>
<body>
      <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-3WSYCE6MPG"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-3WSYCE6MPG');
</script>
<?php include "includes/login-signup.inc.php"?>
  <main>
    <?php include "includes/header.inc.php"?>
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
  <?php include "includes/footer.inc.php"?>
</body>
</html>
