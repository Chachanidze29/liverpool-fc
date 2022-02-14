<?php
require 'inc/db-conn.php';

require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function verifyEmail($email, $activationCode): bool
{
    global $conn;
    $expiration_time = time() + 24 * 3600;
    $activation_link = "localhost/www/activate.php?email=$email&activation_code=$activationCode&expiration_time=$expiration_time";
    $searchSql = "SELECT * FROM `user` WHERE email='$email'";
    $prepared = $conn->prepare($searchSql);
    $prepared->execute();
    if ($prepared->rowCount() > 0) {
        header('location:login.php?email_repetition');
        exit;
    }
    $domain = ltrim(stristr($email, '@'), '@') . '.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !checkdnsrr($domain)) {
        header('location:login.php?invalid_regMail');
        exit;
    }
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Port = "587";
    $mail->Username = "chachanidzee29m@gmail.com";
    $mail->Password = "ynwa1234";
    $mail->Subject = "Email Verification-LiverpoolFC";
    $mail->setFrom('chachanidzee29m@gmail.com');
    $mail->isHTML(true);
    $mail->Body = <<<MESSAGE
    Hi,
    <a href='$activation_link'>Please click the following link to activate your account</a>
    MESSAGE;
    $mail->addAddress($email);
    if($mail->send()){
        return true;
    }
    return false;
    $mail->smtpClose();
}

function register_user($firstName, $lastName, $email, $password, $activation_code): bool
{
    global $conn;
    $sql = 'INSERT INTO user(email, first_name, last_name, password, activation_code)
    VALUES(:email, :firstName, :lastName, :password, :activation_code)';

    $statement = $conn->prepare($sql);

    $statement->bindValue(':email', $email);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
    $statement->bindValue(':activation_code', password_hash($activation_code, PASSWORD_DEFAULT));

    return $statement->execute();
}

function login_user($email, $password)
{
    global $conn;
    $searchSql = "SELECT * FROM user WHERE email=:email";
    $prepared = $conn->prepare($searchSql);
    $prepared->bindValue(':email', $email);
    $prepared->execute();
    if ($prepared->rowCount() > 0) {
        $user = $prepared->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user['password']) && is_user_active($user)) {
            return [$user['id'],$user['isAdmin']];
        } else {
            header("Location:login.php?invalid_authPass");
            exit;
        }
    } else {
        header("Location:login.php?invalid_authMail");
        exit;
    }
    return [null,null];
}

function find_unverified_user($activation_code, $email)
{
    global $conn;
    $sql = 'SELECT id, activation_code
            FROM user
            WHERE active=0 AND email=:email';

    $statement = $conn->prepare($sql);

    $statement->bindValue(':email', $email);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($activation_code, $user['activation_code'])) {
        return $user;
    }
    return null;
}

function delete_user_by_email($email, $active = 0)
{
    global $conn;
    $sql = 'DELETE FROM user
            WHERE email =:email and active=:active';
    $statement = $conn->prepare($sql);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':active', $active, PDO::PARAM_INT);

    return $statement->execute();
}

function activate_user(int $user_id): bool
{
    global $conn;
    $sql = 'UPDATE user
            SET active = 1
            WHERE id=:id';

    $statement = $conn->prepare($sql);
    $statement->bindValue(':id', $user_id, PDO::PARAM_INT);

    return $statement->execute();
}

function is_user_active($user)
{
    return (int)$user['active'] === 1;
}

function generate_activation_code(): string
{
    return bin2hex(random_bytes(16));
}