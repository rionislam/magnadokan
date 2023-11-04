<?php

@session_start();
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
new App\Application;
$book = new App\Book;
$row = $book->getByName($_GET['name']);
$book->download($_GET['name']);
$category = new App\Category;
$category->download($row['bookCategory']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="var(--accent-1)" />
    <title>Downloading - <?=$row['bookName']?></title>
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="<?=App\Application::$HOST?>/menifest.json">
    <base href="<?=App\Application::$HOST?>/"/>
    <link rel="stylesheet" href="<?=App\Application::$HOST?>/css/global.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/download.css">
    <script src="js/functions.js"></script>
</head>
<body>
<main>
        <?php include 'includes/header.inc.php'?>
        <section class="book-container max-width center">
            <div class="left">
                <img src="<?=App\Application::$HOST?>/uploads/<?=$row['bookCover']?>" alt="<?=$row['bookName']?>">
            </div>
            <div class="right">
                <h1 class="title"><?=$row['bookName']?></h1>
                <div class="download_text">
                    <div class="download_text-container">Downloading</div>
                </div>
            </div>
        </section>
    </main>
    <?php include 'includes/footer.inc.php'?>
    <script src="js/script.js"></script>
    <script>
        let download_textContainer= document.getElementsByClassName('download_text-container')[0];

        download_textContainer.style.opacity = 0;
        let i = 0;
            let interval = setInterval(function () {
        i++;
        switch (i) {
            case 1:
                download_textContainer.innerHTML = 'Downloading';
                break;
            case 2:
                download_textContainer.innerHTML = 'Downloading.';
            break;
            case 3:
                download_textContainer.innerHTML = 'Downloading..';
            break;
            case 4:
                download_textContainer.innerHTML = 'Downloading...';
                break;
            default:
                i = 0;
        }
        download_textContainer.style.opacity = 1;
        }, 500);

        setTimeout(function () {
        clearInterval(interval);
        download_textContainer.parentElement.innerHTML = "<span>Thanks for downloading. If the download hasn't started autometically, then <a href='https://drive.google.com/uc?export=download&id=<?=$row['bookPdf']?>'>click here.</a></span>"
          url = 'https://drive.google.com/uc?export=download&id=<?=$row['bookPdf']?>';
          window.location.assign(url);
        }, 10000);
    </script>
</body>
</html>
</body>
</html>