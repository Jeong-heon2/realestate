<?php
require("connection.php");
if(isset($_GET['image_id'])) {
    $sql = "SELECT image FROM image WHERE image_id=" . $_GET['image_id'];
    $result = mysqli_query($conn, $sql) or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>" . mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    echo $row["image"];
}
mysqli_close($conn);
?>