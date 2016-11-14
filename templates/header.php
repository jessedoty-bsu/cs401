<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../handlers/user.php";
//Store current page name
$_SESSION['page'] = $_SERVER['PHP_SELF'];
?>

<header>
    <div id="logo">
        <a href="index.php">
            <img src="images/logo.png" title="Custom logo coming soon">
        </a>
        <h1>Jot Record</h1>
    </div>
    <div id="nav">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="main.php">Main (Logged-in View)</a></li>
            <li><a href="signup.php">Sign-up</a></li>
            <li><a href="settings.php">Settings</a></li>
        </ul>
    </div>


    <?php
    if(isset($_SESSION['access'])) { ?>
        <div id="user_portal">
            <?php echo get_avatar() ?>
            <a href="../settings.php"><button id="settings">Settings</button></a>
            <a href="../handlers/logout.php"><button id="log_out">Log Out</button></a>
        </div>
    <?php }

    else {?>
    <div id="login_signup">
        <form id="login_form" name="login_form" action="handlers/login.php" method="POST">
            <?php if(isset($_SESSION['invalid'])) echo "<p class='error'>" . $_SESSION['invalid'] . "</p>" ?>
            <input type="text" name="login-email" placeholder="email" />
            <input type="password" name="login-password" placeholder="password" />
            <input id="login_button" type="submit" name="login" value="Login" />
        </form>
        <a href="signup.php">
            <button id="signup_button" type="button">Sign-up</button>
        </a>
    </div>
    <?php } ?>
</header>