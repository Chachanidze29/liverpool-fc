<?php
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
            $sql = "INSERT INTO userPics(image_url) VALUES('$fileName')";
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
