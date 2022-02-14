<?php
$header = trim(htmlspecialchars($_POST['header']));
$content = trim(htmlspecialchars($_POST['content']));
if (isset($_FILES['img'])) {
    if ($_FILES['img']['error'] == 0) {
        $file_type = $_FILES['img']['type'];
        $allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!in_array($file_type, $allowed)) {
            header('location:addNews.php?invalid_fileType');
            exit;
        }
        $dir = './newsImages';
        $fileName = strval(time()) . '.' . explode('/', $file_type)[1];
        if (move_uploaded_file($_FILES['img']['tmp_name'], $dir . '/' . $fileName)) {
            $sql = "INSERT INTO news(image_url,header,content) VALUES('$fileName','$header','$content')";
            $statement = $conn->prepare($sql);
            $statement->execute();
            header('location:addNews.php?upload_success');
            exit;
        } else {
            header('location:addNews.php?upload_error');
            exit;
        }
    } else {
        switch ($_FILES['img']['error']) {
            case UPLOAD_ERR_OK:
                header('location:addNews.php?upload_error');
                exit;
            case UPLOAD_ERR_NO_FILE:
                header('location:addNews.php?no_file');
                exit;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                header('location:addNews.php?limit_fileSize');
                exit;

            default:
                throw new RuntimeException('Unknown errors.');
        }
    }
} else {
    header('location:addNews.php?no_file');
    exit;
}
