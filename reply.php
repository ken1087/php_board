<?php
header("Content-Type: application/json; charset=utf-8");
require_once('dbcon.php');

$output = "";
$context = $_POST['context'];
$boardid = $_POST['boardid'];
$userid = $_POST['userid'];
$date = date("Y-m-d H:i:s");

$insertquery = "INSERT INTO comment(context, boardid, userid, date) VALUES('$context','$boardid','$userid','$date')";
$result = mysqli_query($dbc, $insertquery);


$selectquery = "SELECT nickname FROM user WHERE id = '$userid'";
$result = $dbc->query($selectquery);
$row = mysqli_fetch_assoc($result);

$nickname = $row['nickname'];

$selectquery = "SELECT id FROM comment WHERE context='$context' AND boardid='$boardid' AND userid='$userid' AND date='$date'";
$result = $dbc->query($selectquery);
$row = mysqli_fetch_assoc($result);

$cid = $row['id'];

echo(json_encode(array("cid" => $cid, "nickname" => $nickname,"context" => $context, "date" => $date)));


?>


