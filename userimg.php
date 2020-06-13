<?php
if (isset($_GET['nickname'])) {
    $sql = "SELECT image FROM user WHERE nickname=" . $_GET['nickname'];
    $result = mysqli_query($conn, $sql) or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>" . mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    header("Content-type: " . $row["imageType"]);
    echo $row["imageData"];
}
