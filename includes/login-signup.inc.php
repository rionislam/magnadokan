
<section class="login-signup">
    <div class="forms-container">
        <?php include App\Application::$ROOT_DIR."/imgs/close.svg"?>
        <form id="signup-form" action="<?=App\Application::$HOST?>/controllers/user-signup.controller.php" method="post">
            <div class="input-container">
                <div class="input-name">Full Name</div>
                <input type="text" name="full-name" required>
            </div>
            <div class="input-container">
                <div class="input-name">User Name</div>
                <input type="text" name="username" required>
            </div>
            <div class="input-container">
                <div class="input-name">Email</div>
                <input type="email" name="email"  required>
            </div>
            <div class="input-container">
                <div class="input-name">Password</div>
                <input type="password" name="password" id="password" required>
                <img onclick="togglePassword(this)" src="<?=App\Application::$HOST?>/imgs/visible.svg">
            </div>
            <div class="input-container">
                <div class="input-name">Confirm Password</div>
                <input type="password" name="confirm-password" id="confirm-password">
                <img onclick="togglePassword(this)" src="<?=App\Application::$HOST?>/imgs/visible.svg">
            </div>
            <input type="submit" value="Signup">
        </form>
        <hr>
        <form action="<?=App\Application::$HOST?>/controllers/user-login.controller.php" method="post">
            <div class="input-container">
                <div class="input-name">Email or Username</div>
                <input type="text" name="user-login"  required>
            </div>
            <div class="input-container">
                <div class="input-name">Password</div>
                <input type="password" name="password" required>
                <img onclick="togglePassword(this)" src="<?=App\Application::$HOST?>/imgs/visible.svg">
            </div>
            <input type="submit" value="Login">
        </form>
    </div>
</section>