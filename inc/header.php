<?php
function active($currect_page)
{
    $url_array = explode('/', $_SERVER['REQUEST_URI']);
    $url = end($url_array);
    if (str_contains($url, $currect_page)) {
        echo 'active';
    }
}
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiverpoolFC</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="icon" href="images/liverpoolLogo.png">
</head>

<body>
    <header>
        <div class="mainHeader">
            <h1>
                Liverpool FC
            </h1>
            <p>You Will Never Walk Alone</p>
        </div>
        <nav>
            <ul>
                <li><a class="<?php active('index.php'); ?>" href="index.php">Home</a></li>
                <li><a class="<?php active('news.php'); ?>" href="news.php">News</a></li>
                <li><a class="<?php active('gallery.php'); ?>" href="gallery.php">Gallery</a></li>
                <li><a class="<?php active('aboutMe.php'); ?>" href="aboutMe.php">About Me</a></li>
                <?php
                if (!isset($_COOKIE['presence'])) {
                ?>
                    <li><a href="login.php">Log In</a></li>
                <?php
                } else {
                ?>
                    <li><a href="#" class="dropDownBtn">Profile &#8681</a>
                        <ul class="dropDownCon switchMode">
                            <li><a href="logout.php">Log Out</a></li>
                            <?php echo '<li><a href="update.php?id=' . $_SESSION['userId'] . '">Update</a></li>'; ?>
                        </ul>
                    </li>
                <?php
                }
                ?>
            </ul>
        </nav>
        <div class="mode">
            <img src="./images/lightTorch.png" alt="">
        </div>
    </header>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
        let hidden = true;
        let dropDownCon = $('.dropDownCon');
        $('.dropDownBtn').on('click', () => {
            if (hidden) {
                dropDownCon.slideDown()
                hidden = false;
            } else {
                dropDownCon.slideUp()
                hidden = true;
            }
        })
    </script>