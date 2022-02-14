<?php 
require_once 'inc/header.php';
require 'inc/db-conn.php';

if(isset($_POST['addNews'])){
    require_once 'inc/uploadNews.php';
}

?>
    <main id="addNewsMain" class="updateAddNews">
        <form action="" method="POST" class="switchMode" enctype="multipart/form-data">
            <input type="text" name="header" id="header" required autocomplete="off" placeholder="Header">
            <textarea name="content" id="content" cols="40" rows="5" required placeholder="Content"></textarea>
            <input type="file" name="img" id="img">
            <input type="submit" id="addNews" name="addNews" value="Submit">
            <a href='news.php' class="backTo">Back To All News</a>
        </form>
    </main> 
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
    <script src="js/exitBtn.mjs"></script>      
    <script src="js/swtichMode.mjs"></script>      
</body>
</html>