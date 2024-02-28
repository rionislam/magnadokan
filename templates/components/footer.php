<?php

use Core\Application;
use Core\Services\ResourceLoader;
$pageUrl = Application::$HOST.$_SERVER['REQUEST_URI'];
?>
<?=ResourceLoader::loadComponentCss('footer')?>
<footer>
        <div class="footer-container max-width center">
            <div class="left">
                <div class="pages">
                    <div class="title">Pages</div>
                    <ul>
                        <li><a href="books/1" target="_blank">All Books</a></li>
                        <li><a href="disclaimer" target="_blank">Disclaimer</a></li>
                        <li><a href="privacy-policy" target="_blank">Privacy Policy</a></li>
                        <li><a href="fairuse" target="_blank">Fair use</a></li>
                        <li><a href="dmca" target="_blank">DMCA</a></li>
                        <li><a href="about" target="_blank">About us</a></li>
                        <li><a href="mailto: support@magnadokan.com">Contact us</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="right">
                <div class="title">Protected by DMCA</div>
                <a href="https://www.dmca.com/Protection/Status.aspx?ID=ebc956f3-9020-40ff-a348-2136f89638be&refurl=<?=$pageUrl?>" title="DMCA.com Protection Status" class="dmca-badge"> <img loading="lazy" src ="assets/images/backgrounds/dmca-badge.png"  alt="DMCA.com Protection Status" /></a>
            </div>
        </div>
        <div class="copyright max-width center">
            <p>Copyright &copy; 2023 - All Rights Reserved.</p>
            <p>All content belong to their respective owners</p>
        </div>
</footer>
<?=ResourceLoader::loadComponentCss('footer')?>