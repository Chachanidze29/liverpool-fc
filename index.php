<?php
require 'inc/header.php';
require_once 'inc/db-conn.php';
?>
<main>
    <div class="container switchMode">
        <a href="news.php" class="heading">
            <h2>News</h2>
        </a>
        <?php
        $sql = "SELECT * FROM news ORDER BY id DESC LIMIT 2";
        $res = $conn->prepare($sql);
        $res->execute();
        if ($res->rowCount() > 0) {
            while ($news = $res->fetch(PDO::FETCH_ASSOC)) {  ?>
                <div class="news">
                    <h3><a href="news.php?id=<?php echo $news['id'] ?>"><?php echo $news['header'] ?></a></h3>
                    <img src="newsImages/<?= $news['image_url'] ?>">
                </div>
        <?php }
        } ?>
        <div class="gallery">
            <a href="gallery.php" class="heading">
                <h2>Gallery</h2>
            </a>
            <div class="images">
                <?php
                $sql = "SELECT * FROM galleryImages ORDER BY id DESC LIMIT 4";
                $res = $conn->prepare($sql);
                $res->execute();
                if ($res->rowCount() > 0) {
                    while ($news = $res->fetch(PDO::FETCH_ASSOC)) {  ?>
                        <img src="galleryimages/<?= $news['image_url'] ?>">
                <?php }
                } ?>
            </div>
        </div>
    </div>
    <div class="aboutMe switchMode">
        <a href="aboutMe.php" class="heading">
            <h2>About Me</h2>
        </a>
        <img src="./images/pic6.jpg" alt="">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta necessitatibus magnam laborum aut
            autem
            vero explicabo suscipit? Sapiente, quod voluptates nostrum dolor obcaecati neque, eos nemo provident
            ipsum quam doloremque.<a href="aboutMe.php" class="continue">Continue Reading</a></p>
    </div>
</main>
<script src="js/swtichMode.mjs"></script>

</body>

</html>