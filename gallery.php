<?php
require 'inc/header.php';
require 'inc/db-conn.php';
if (isset($_POST['pic'])) {
    if (isset($_FILES['pic'])) {
        if ($_FILES['pic']['error'] == 0) {
            $file_type = $_FILES['pic']['type'];
            $allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!in_array($file_type, $allowed)) {
                header('location:gallery.php?invalid_fileType');
                exit;
            }
            $dir = './galleryimages';
            $fileName = strval(time()) . '.' . explode('/', $file_type)[1];
            if (move_uploaded_file($_FILES['pic']['tmp_name'], $dir . '/' . $fileName)) {
                $sql = "INSERT INTO galleryimages(image_url) VALUES('$fileName')";
                $statement = $conn->prepare($sql);
                $statement->execute();
                header('location:gallery.php?upload_success');
                exit;
            } else {
                header('location:gallery.php?upload_error');
                exit;
            }
        } else {
            switch ($_FILES['pic']['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    header('location:gallery.php?no_file');
                    exit;
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    header('location:gallery.php?limit_fileSize');
                    exit;
                default:
                    throw new RuntimeException('Unknown errors.');
            }
        }
    }
}
?>
<main id="galleryMain">
    <div class="full-img">
        <img class="displayed-img" src="#" alt="No Img">
        <div class="overlay"></div>
    </div>
    <div class="thumb-bar">
        <?php
        $sql = "SELECT * FROM galleryImages ORDER BY id DESC LIMIT 20";
        $res = $conn->prepare($sql);
        $res->execute();
        if ($res->rowCount() > 0) {
            $i = 0;
            while ($img = $res->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <div class="imgs">
                    <?php
                    if ($i > 4) { ?>
                        <img class="private" src="galleryImages/<?= $img['image_url'] ?>">
                    <?php } else { ?>
                        <img src="galleryImages/<?= $img['image_url'] ?>">
                    <?php }
                    if (isset($_COOKIE['isAdmin'])) { ?>
                        <a href="deleteImage.php?id=<?php echo $img['id'] ?>">X</a>
                    <?php } ?>
                </div>
            <?php $i++;
            }
            ?>
        <?php }
        if (isset($_COOKIE['isAdmin'])) { ?>
            <form class="switchMode" action="" method="post" enctype="multipart/form-data">
                <input type="file" name="pic">
                <input type="submit" name="pic" value="Submit">
            </form>
        <?php } ?>
    </div>
    <?php
    if (isset($_GET['invalid_fileType'])) {
        echo "<p class='message'>Only Images Are Allowed To Upload<button type='button'>X</button></p>";
    }
    if (isset($_GET['limit_fileSize'])) {
        echo "<p class='message'>Image Is Too Large<button type='button'>X</button></p>";
    }
    if (isset($_GET['no_file'])) {
        echo "<p class='message'>No Image Was Chosen<button type='button'>X</button></p>";
    }
    if (isset($_GET['upload_success'])) {
        echo "<p class='message'>Image Was Uploaded Successfully. Thanks ;)<button type='button'>X</button></p>";
    }
    if (isset($_GET['upload_error'])) {
        echo "<p class='message'>Couldn't Upload File<button type='button'>X</button></p>";
    }
    ?>
</main>
<script src="js/exitBtn.mjs"></script>
<script src="js/swtichMode.mjs"></script>
<script src="js/gallery.js"></script>
</body>

</html>