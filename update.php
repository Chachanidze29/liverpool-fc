<?php
require_once 'inc/db-conn.php';
$id = $_GET['id'];
$sql = "SELECT * FROM user WHERE id=:id";
$prepared = $conn->prepare($sql);
$prepared->bindValue(':id', $id);
$prepared->execute();
if ($prepared->rowCount() > 0) {
    $user = $prepared->fetch(PDO::FETCH_ASSOC);
    $firstName = $user['first_name'];
    $lastName = $user['last_name'];
    $password = $user['password'];
} else {
    die("Couldn't find such record");
}

if (isset($_POST['deleteBtn'])) {
    $sql = "DELETE FROM user WHERE id=:id";
    $prepared = $conn->prepare($sql);
    $prepared->bindValue(':id', $id);
    $prepared->execute();
    header('refresh:1;url=logout.php');
}

if (isset($_POST['updateBtn'])) {
    if ($_POST['firstName'] !== '') {
        $firstName = trim(htmlspecialchars($_POST['firstName']));
    }
    if ($_POST['lastName'] !== '') {
        $lastName = trim(htmlspecialchars($_POST['lastName']));
    }
    if ($_POST['password'] != '') {
        $password = password_hash(trim(htmlspecialchars($_POST['password'])), PASSWORD_BCRYPT);
    }
    $sql = "UPDATE user SET first_name=:firstName,last_name=:lastName,password=:password WHERE id=:id";
    $prepared = $conn->prepare($sql);
    $prepared->bindValue(':firstName', $firstName);
    $prepared->bindValue(':lastName', $lastName);
    $prepared->bindValue(':password', $password);
    $prepared->bindValue(':id', $id);
    $prepared->execute();
    header('refresh:0');
} else {

    require 'inc/header.php';
?>
    <main id="updateMain">
        <form action="" method="post">
            <fieldset>
                <legend>
                    <h2>Update Info</h2>
                </legend>
                <div class="firstLastName">
                    <input type="text" name="firstName" autocomplete="off" minlength="1" placeholder="<?php echo $firstName ?>">
                    <input type="text" name="lastName" autocomplete="off" minlength="1" placeholder="<?php echo $lastName ?>">
                </div>
                <input type="password" name="password" autocomplete="off" minlength="8" placeholder="New Pass">
                <input type="hidden" value="<?php echo $id ?>">
                <input type="submit" value="Update" name="updateBtn" id="updateBtn">
                <input type="submit" value="Delete Account" name="deleteBtn" id="deleteBtn">
            </fieldset>
        </form>

    </main>
    <script src="js/swtichMode.mjs"></script>
    </body>

    </html>
<?php
}
?>