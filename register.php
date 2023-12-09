<?php
include_once "includes/autoload.php";
include_once ("includes/config.php");
include_once ("includes/handlers/login-handler.php");
include_once ("includes/handlers/register-handler.php");
?>

<?php
function outputError($account,$Field,$Msg)
{
    if($account->getError($Msg))
    {
        ?>
        <script>
            var myDiv = document.createElement("div");
            myDiv.textContent = "<?= $Msg ?>";
            myDiv.style.color="red";
            myDiv.style.fontSize="14px";
            var myPara = document.getElementById("<?=$Field?>");
            myPara.appendChild(myDiv);
        </script>
        <?php
    }
}
?>

<html>
<head>
    <title>Welcome to Groovy!</title>
    <link rel="stylesheet" href="assets/css/register.css?version=2">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="assets/js/register.js"> </script>
</head>
<body>
<?php
    if(isset($_POST['registerButton'])){
        echo '<script>
                $(document).ready(function() {
					$("#loginForm").hide();
					$("#registerForm").show();
              });
            </script>';
    }
    else{
         echo '<script>
                $(document).ready(function () {
                $("#loginForm").show();
                $("#registerForm").hide();
              });
            </script>';
    }
?>
<div id="background">
<div class="loginContainer">
    <div id="inputContainer">
        <form id="loginForm" action="register.php" method="POST">
            <h2>Login to your account</h2>
            <p>
                <label for="loginUsername">Username</label>
                <input id="loginUsername" name="loginUsername" type="text" placeholder="Your username" required>
            </p>
            <p id="loginField">
                <label for="loginPassword">Password</label>
                <input id="loginPassword" name="loginPassword" type="password" placeholder="Your password" required>
            </p>
            <?php
            outputError($account,"loginField","Your username or password is invalid");?>

            <br>
            <button type="submit" name="loginButton">Log In</button>
            <hr>
            <div class="hasAccountText">
                <span id="hideLogin"> Don't have an account yet? Signup here.</span>
            </div>
        </form>



        <form id="registerForm" action="register.php" method="POST">
            <h2>Create your free account</h2>
            <p id="usernameField">

                <label for="username">Username</label>
                <input id="username" name="username" type="text" placeholder="Your username" required>
                <?php outputError($account,"usernameField","Your username must be between 5 and 25 characters");
                outputError($account,"usernameField","This username already exists");?>
            </p>

            <p id="firstNameField">
                <label for="firstName">First name</label>
                <input id="firstName" name="firstName" type="text" placeholder="Your first name " required>
                <?php outputError($account,"firstNameField","Your first name must be between 2 and 25 characters");?>

            </p>


            <p id="lastNameField">
                <label for="lastName">Last name</label>
                <input id="lastName" name="lastName" type="text" placeholder="Your last name" required>
                <?php outputError($account,"lastNameField","Your last name must be between 2 and 25 characters");?>

            </p>

            <p id="emailField">

                <label for="email">Email</label>
                <input id="email" name="email" type="email" placeholder="Your email"  required>
                <?php outputError($account,"emailField","Email is invalid");
                outputError($account,"emailField","This email already exists");?>
            </p>

            <p id="emailField2">
                <label for="email2">Confirm email</label>
                <input id="email2" name="email2" type="email" placeholder="Your email"  required>
                <?php outputError($account,"emailField2","Your emails don't match");?>
            </p>

            <p id="passwordField">

                <label for="password">Password</label>
                <input id="password" name="password" type="password" placeholder="Your password" required>
                <?php outputError($account,"passwordField","Your password must be between 5 and 30 characters");
                outputError($account,"passwordField","Your password can only contain numbers and letters");
                ?>
            </p>

            <p id="passwordField2">
                <label for="password2">Confirm password</label>
                <input id="password2" name="password2" type="password" placeholder="Your password" required>
                <?php outputError($account,"passwordField2","Your passwords don't match");?>

            </p>

            <button type="submit" name="registerButton">SIGN UP</button>
            <hr>
            <div class="hasAccountText">
                <span id="hideRegister"> Already have an account? Log in here.</span>
            </div>
        </form>


    </div>

</div>
    <div class="infoContainer">
        <div class="info">
            <div id="offline"  class="feature" style="opacity: 0">
                <img src="assets/images/offline.svg" >

                <h1>Offline Streaming</h1>
                <p>
                    Take your music everywhere with our offline
                    streaming feature! No more interruptions or buffering
                    when you're on the go or in areas with poor internet connection.
                </p>

                <h2>© Groovy 2023</h2>
            </div>
            <div id="unlimitedskips"  class="feature" style="opacity: 0">
                <img src="assets/images/unlimitedskips.svg" >

                <h1>Unlimited Skips</h1>
                <p>
                    Don't settle for less - skip to your heart's content with our Unlimited Skips feature!
                    No more frustrating limits on how many times you can skip a song
                </p>

                <h2>© Groovy 2023</h2>
            </div>
            <div id="custom"  class="feature" style="opacity: 0">
                <img src="assets/images/customplaylist.svg" >

                <h1>Custom Playlist</h1>
                <p>
                    Create your perfect music vibe with our custom playlist feature! Handpick your
                    favorite songs and curate your own personalized music library with ease.
                </p>


                <h2>© Groovy 2023</h2>
            </div>
            <script>
                const divs = ["offline", "unlimitedskips", "custom"];
                let index = 0;

                function toggleDivs() {
                    document.getElementById(divs[index]).style.opacity="0";
                    index = (index + 1) % divs.length;
                    document.getElementById(divs[index]).style.opacity="1";
                }

                toggleDivs(); // Show the first div

                setInterval(toggleDivs, 7000);
            </script>

        </div>
    </div>
</div>

</body>
</html>
