<?php
require 'inc/functions.php';
session_start();
if (filter_has_var(INPUT_POST, 'register')) {
    $firstName = trim(htmlspecialchars($_POST['firstName']));
    $lastName = trim(htmlspecialchars($_POST['lastName']));
    $regMail = strtolower(trim(htmlspecialchars($_POST['regMail'])));
    $regPass = trim(htmlspecialchars($_POST['regPass']));
    $activationCode = generate_activation_code();
    if (verifyEmail($regMail, $activationCode)) {
        if (register_user($firstName, $lastName, $regMail, $regPass, $activationCode)) {
            header('location:login.php?verify');
            exit;
        } else {
            header('location:login.php?registration_error');
            exit;
        }
    }
}

if (filter_has_var(INPUT_POST, 'logIn')) {
    [$id, $isAdmin] = login_user($_POST['authMail'], $_POST['authPass']);
    if (isset($id)) {
        $_SESSION['userId'] = $id;
        setcookie('presence', 1);
        if (isset($isAdmin)) {
            setcookie('isAdmin', 1);
        }
        header('location:index.php');
        exit;
    }
}

if (isset($_GET['verify'])) {
    echo "<p class='message'>Verification Code Was Sent. Check Your Email<button type='button'>X</button></p>";
}

if (isset($_GET['mailing_error'])) {
    echo "<p class='message'>Couldn't Send Verification Code. Try Again<button type='button'>X</button></p>";
    echo "";
}

if (isset($_GET['link_expired'])) {
    echo "<p class='message'>Activation Link Expired<button type='button'>X</button></p>";
}

if (isset($_GET['already_verified'])) {
    echo "<p class='message'>Already Verified Or Invalid User<button type='button'>X</button></p>";
}

if (isset($_GET['registration_error'])) {
    echo "<p class='message'>Registration Error.Try Again<button type='button'>X</button></p>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiverpoolFC</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" href="images/liverpoolLogo.png">
</head>

<body>
    <header id="loginHeader">
        <div class="mainHeader">
            <img src="./images/ball.png" alt="" id="icon">
            <h1>
                <a href="index.php">Liverpool FC</a>
            </h1>
            <p>You Will Never Walk Alone</p>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="authorization">
            <input type="email" name="authMail" id="authMail" placeholder="Email" autocomplete="off">
            <?php if (isset($_GET['invalid_authMail'])) {
                echo "<p class='message absMessage'>Invalid Email<button type='button'>X</button></p>";
            } ?>
            <input type="password" name="authPass" id="authPass" placeholder="Password" autocomplete="off">
            <?php if (isset($_GET['invalid_authPass'])) {
                echo "<p class='message absMessage'>Invalid Password<button type='button'>X</button></p>";
            } ?>
            <input type="submit" name="logIn" id="logIn" class="loginBtn" value="Log In">
        </form>
        <div class="mode">
            <img src="./images/lightTorch.png" alt="">
        </div>
    </header>
    <main>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="registration" class="switchMode">
            <h1>Sign Up</h1>
            <p>And Join Us</p>
            <div class="firstLastName">
                <input type="text" required placeholder="First name" name="firstName" id="firstName" autocomplete="off" minlength="1">
                <input type="text" required placeholder="Last name" name="lastName" id="lastName" autocomplete="off" minlength="1">
            </div>
            <input type="email" required name="regMail" id="regMail" placeholder="Email" autocomplete="off">
            <?php
            if (isset($_GET['email_repetition'])) {
                echo "<p class='message'>Such Email Already Exists<button type='button'>X</button></p>";
            }
            if (isset($_GET['invalid_regMail'])) {
                echo "<p class='message'>Invalid Email<button type='button'>X</button></p>";
            }
            ?>
            <input type="password" required name="regPass" id="regPass" placeholder="Password" autocomplete="off" minlength="8">
            <label for="showPass">Show password</label>
            <input type="checkbox" id="showPass" name="showPass">
            <input type="submit" name="register" id="register" class="loginBtn">
        </form>
    </main>
    <script src="js/login.js"></script>
    <script src="js/swtichMode.mjs"></script>
    <script src="js/exitBtn.mjs"></script>
</body>

</html>
<?php
