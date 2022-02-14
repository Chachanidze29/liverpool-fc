<?php
require 'inc/header.php';
require_once 'inc/db-conn.php';
if (isset($_POST['imgUpload'])) {
    require 'inc/uploadImg.php';
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
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" class="uploadForm switchMode">
            <p>Send Me Your Favourite Liverpool Picture</p>
            <input type="file" name="pic">
            <input type="submit" id="imgUpload" name="imgUpload" value="Upload">
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
    }
        ?>
        </form>
</div>
<script src="./js/swtichMode.mjs"></script>
<script src="./js/exitBtn.mjs"></script>
</body>

</html>