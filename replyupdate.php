<?php
header("Content-Type: application/json; charset=utf-8");
require_once('dbcon.php');

$id = $_POST['id'];
$context = $_POST['context'];
$date = date("Y-m-d H:i:s");

$updatequery = "UPDATE comment SET context='$context' WHERE id ='$id'";
$result = mysqli_query($dbc, $updatequery);

echo(json_encode(array("cid" => $id,"context" => $context, "date" => $date)));
?>
