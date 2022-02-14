<?php

require_once 'inc/db-conn.php';

require 'inc/header.php';

if (isset($_GET['id'])) {
    $sql = "SELECT * FROM news WHERE id=:id";
    $res = $conn->prepare($sql);
    $res->bindValue(':id', $_GET['id']);
    $res->execute();
    if ($res->rowCount() > 0) {
        $news = $res->fetch(PDO::FETCH_ASSOC);
        if (isset($_POST['editNews'])) {
            if (isset($_POST['header'])) {
                $newsHeader = trim(htmlspecialchars($_POST['header']));
            } else {
                $newsHeader = $news['header'];
            }
            if (isset($_POST['content'])) {
                $content = trim(htmlspecialchars($_POST['content']));
            } else {
                $content = $news['content'];
            }
            if ($_FILES['img']['size'] != 0) {
                print_r($_FILES['img']);
                if ($_FILES['img']['error'] == 0) {
                    $file_type = $_FILES['img']['type'];
                    $allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if (!in_array($file_type, $allowed)) {
                        header('location:editNews.php?invalid_type');
                        exit;
                    }
                    $dir = './newsImages';
                    $fileName = strval(time()) . '.' . explode('/', $file_type)[1];
                    move_uploaded_file($_FILES['img']['tmp_name'], $dir . '/' . $fileName);
                } else {
                    switch ($_FILES['img']['error']) {
                        case UPLOAD_ERR_OK:
                            header('location:editNews.php?upload_error');
                            exit;
                        case UPLOAD_ERR_NO_FILE:
                            header('location:editNews.php?no_file');
                            exit;
                        case UPLOAD_ERR_INI_SIZE:
                        case UPLOAD_ERR_FORM_SIZE:
                            header('location:editNews.php?limit_fileSize');
                            exit;
                        default:
                            throw new RuntimeException('Unknown errors.');
                    }
                }
            } else {
                $fileName = $news['image_url'];
            }
            $sql = "UPDATE news SET id={$_GET['id']}, image_url='$fileName',header='$newsHeader',content='$content' WHERE id={$_GET['id']}";
            $statement = $conn->prepare($sql);
            $statement->execute();
            header('location:editNews.php?update_success');
            exit;
        }
    }
}
?>
<main id="editNewsMain" class="updateAddNews">
    <form action="" method="POST" enctype="multipart/form-data" class="switchMode">
        <input type="text" name="header" id="header" placeholder="Header" autocomplete="off" value="<?php if (isset($news['header'])) {
                                                                                                        echo $news['header'];
                                                                                                    } ?>">
        <textarea name="content" id="content" placeholder="Content" cols="40" rows="5"><?php if (isset($news['content'])) {
                                                                                            echo $news['content'];
                                                                                        } ?></textarea>
        <input type="file" name="img">
        <input type="submit" id="editNews" name="editNews" value="Submit">
        <a href='news.php' class="backTo">Back To All News</a>
    </form>
</main>
<?php
if (isset($_GET['update_success'])) {
    echo "<p class='message'>News Was Updated Successfully<button type='button'>X</button></p>";
}
if (isset($_GET['invalid_type'])) {
    echo "<p class='message'>Invalid File Type<button type='button'>X</button></p>";
}
?>
<script src="js/exitBtn.mjs"></script>
<script src="js/swtichMode.mjs"></script>
</body>

</html>