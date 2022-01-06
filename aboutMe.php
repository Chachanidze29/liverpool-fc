<?php
require 'inc/header.php';
require_once 'inc/db-conn.php';
if (isset($_POST['imgUpload'])) {
    if (isset($_FILES['pic'])) {
        if ($_FILES['pic']['error'] == 0) {
            $file_type = $_FILES['pic']['type'];
            $allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!in_array($file_type, $allowed)) {
                header('location:aboutMe.php?invalid_fileType');
                exit;
            }
            $dir = './userPics';
            $fileName = strval(time()) . '.' . explode('/', $file_type)[1];
            if (move_uploaded_file($_FILES['pic']['tmp_name'], $dir . '/' . $fileName)) {
                $sql = "INSERT INTO images(image_url) VALUES('$fileName')";
                $statement = $conn->prepare($sql);
                $statement->execute();
                header('location:aboutMe.php?upload_success');
                exit;
            } else {
                header('location:aboutMe.php?upload_error');
                exit;
            }
        } else {
            switch ($_FILES['pic']['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    header('location:aboutMe.php?no_file');
                    exit;
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    header('location:aboutMe.php?limit_fileSize');
                    exit;
                default:
                    throw new RuntimeException('Unknown errors.');
            }
        }
    }
}
?>
<div id="aboutMeMain">
    <img src="./images/pic6.jpg" alt="">
    <h2 class="switchColor">Avtandil Chachanidze</h2>
    <p class="switchColor">
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nostrum, officiis minus quos in, perspiciatis perferendis qui cum odit hic est nobis ipsam quo. Non, cumque sint ab totam accusantium aut.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nostrum, officiis minus quos in, perspiciatis perferendis qui cum odit hic est nobis ipsam quo. Non, cumque sint ab totam accusantium aut.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nostrum, officiis minus quos in, perspiciatis perferendis qui cum odit hic est nobis ipsam quo. Non, cumque sint ab totam accusantium aut.
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nostrum, officiis minus quos in, perspiciatis perferendis qui cum odit hic est nobis ipsam quo. Non, cumque sint ab totam accusantium aut.
    </p>
    <?php
    if (isset($_SESSION['userId'])) {
    ?>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" class="switchMode">
            <p>Send Me Your Favourite Liverpool Picture</p>
            <input type="file" name="pic">
            <input type="submit" id="imgUpload" name="imgUpload" value="Upload">
        <?php
        if (isset($_GET['invalid_fileType'])) {
            echo '<p>Only Images Are Allowed To Upload</p>';
        }
        if (isset($_GET['limit_fileSize'])) {
            echo '<p>Image Is Too Large</p>';
        }
        if (isset($_GET['no_file'])) {
            echo '<p>No Image Was Chosen</p>';
        }
        if (isset($_GET['upload_success'])) {
            echo '<p>Image Was Uploaded Successfully.Thanks</p>';
        }
        if (isset($_GET['upload_error'])) {
            echo "<p>Couldn't Upload File</p>";
        }
    }
        ?>
        </form>
</div>
<script src="./js/swtichMode.mjs"></script>
</body>

</html>