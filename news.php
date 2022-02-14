<?php
require 'inc/header.php';
require_once 'inc/db-conn.php';

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM news WHERE id=:id";
    $statement = $conn->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $news = $statement->fetch(PDO::FETCH_ASSOC); ?>
        <div class="specNews">
            <?php if (isset($_COOKIE['isAdmin'])) { ?>
                <div class="changeNews">
                    <a href="editNews.php?id=<?php echo $news['id'] ?>">Edit News</a>
                    <a href="deleteNews.php?id=<?php echo $news['id'] ?>">Delete News</a>
                </div>
            <?php } ?>
            <h3 class="switchColor"><?php echo $news['header'] ?></h3>
            <img src="newsImages/<?= $news['image_url'] ?>">
            <p class="switchColor">
                <?php echo $news['content']; ?>
                <a href='news.php' class="backTo">Back To All News</a>
            </p>
        </div>
        <script src="./js/swtichMode.mjs"></script>
    <?php
    }
} else {
    ?>
    <div id="newsMain">
        <?php if (isset($_COOKIE['isAdmin'])) { ?>
            <a href="addNews.php">Add New News</a>
            <?php
        }
        $sql = "SELECT * FROM news";
        $res = $conn->prepare($sql);
        $res->execute();
        if ($res->rowCount() > 0) {
            while ($news = $res->fetch(PDO::FETCH_ASSOC)) {  ?>
                <div class="container switchMode">
                    <?php if (isset($_COOKIE['isAdmin'])) { ?>
                        <div class="changeNews">
                            <a href="editNews.php?id=<?php echo $news['id'] ?>">Edit News</a>
                            <a href="deleteNews.php?id=<?php echo $news['id'] ?>">Delete News</a>
                        </div>
                    <?php } ?>
                    <h3><a href="news.php?id=<?php echo $news['id'] ?>"><?php echo $news['header'] ?></a></h3>
                    <img src="newsImages/<?= $news['image_url'] ?>">
                    <p>
                        <?php echo substr($news['content'], 0, 200) . '...' ?><a class="continue" href="news.php?id=<?php echo $news['id'] ?>">Continue Reading</a>
                    </p>
                </div>
        <?php }
        } ?>
    </div>
    <script src="js/swtichMode.mjs"></script>
    </body>

    </html>
<?php } ?>