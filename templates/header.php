<header>
    <div id="logo">
        <a href="index.html">
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
    <!-- TODO Add logic to change this to a signed in view if the user is signed in -->
    <div id="login_signup">
        <form id="header_form">
            <input type="text" name="login-email" placeholder="email" />
            <input type="text" name="login-password" placeholder="password" />
            <input type="submit" name="login" value="Login" />

            <a href="signup.php">
                <button id="signup_button" type="button">Sign-up</button>
            </a>
        </form>
    </div>
</header>