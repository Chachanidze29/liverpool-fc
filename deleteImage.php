<?php

require_once "inc/db-conn.php";

if (isset($_GET['id'])) {
    $sql = "DELETE FROM galleryimages WHERE id=:id";
    $res = $conn->prepare($sql);
    $res->bindValue(':id', $_GET['id']);
    $res->execute();
    header('location:gallery.php');
}
