<?php
require_once('dbcon.php');
$sql = "DROP TABLE IF EXISTS user";
$dbc->query($sql);
$sql = "DROP TABLE IF EXISTS board";
$dbc->query($sql);
$sql = "DROP TABLE IF EXISTS comment";
$dbc->query($sql);

echo "Drop 완료!";
