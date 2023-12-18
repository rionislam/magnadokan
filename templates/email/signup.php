
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&family=system-ui&display=swap" rel="stylesheet">
</head>
<body style="background-color: #679bdd1a;">
    <div style="background-color: white; border-radius:5px; max-width: 40rem; min-width: 30rem; margin: auto; overflow: hidden; padding: 1rem 1.5rem">
        <div style="font-weight: bold; padding: 0.5rem 0; display: flex; align-items: center; font-family: system-ui, sans-serif; font-size: 2rem; height:auto; width: 100%">
            <img style="margin-right: 0.5rem; height:1em; width: 1em;" src="{HOST}/favicon.ico">
            Magnado<span style="color: #679bdd;">kan.</span>
        </div>
        <hr style="height: 1px; width:100%; background-color: #679bdd1a; border: none;">
        <div style="font-family: 'Poppins', sans-serif; padding: 0.25rem 0;">
            <div>Hi {USER NAME},</div>
            <br>
            <div><span style="font-weight: 500;">Thanks for signing up.</span> Your account is ready to log in. Now, you can download any book you want.</div>
            <div style="text-align: center; margin: 1rem 0">
                <a style="
                text-decoration: none; 
                font-family: system-ui, sans-serif; 
                font-size: 1.2rem; 
                background-color: #679bdd;
                color: white;
                padding: 0.3rem 0.5rem;
                border-radius: 3px;
                " href="{HOST}/login">Login</a>
            </div>
            <div>
                If you can't find any book, feel free to submit an request. We will try out best to upload that book on your website.
            </div>
            <br>
            <div style="font-weight: 500;">
                Regards,
            </div>
            <img style="float: left; margin-top: 0.25rem;" src="{HOST}/templates/email/signature.png">
        </div>
    </div>
    <div style="font-family: system-ui, sans-serif; max-width: 40rem; min-width: 30rem; margin: auto; padding: 0.5rem 0; display: flex; justify-content: space-around">
    <a style="color: #b5c2d1bf;" href="">Home</a>
    <a style="color: #b5c2d1bf;"  href="">All Books</a>
    <a style="color: #b5c2d1bf;"  href="">Request Books</a>
    <a style="color: #b5c2d1bf;"  href="">About Us</a>
    </div>
</body>
</html>