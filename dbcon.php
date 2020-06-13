<?php
$host = '127.0.0.1';
$user = 'root';
$password = 'apmsetup'; // 자기 비밀번호로 수정
$database = 'myboard';
$dbc = mysqli_connect($host, $user, $password, $database) or die("connect fail");
mysqli_select_db($dbc, $database) or die('DB 선택 실패');
$dbc->set_charset("SET NAMES utf8");

// 테이블들이 없으면 생성
$sql = "CREATE TABLE IF NOT EXISTS `user` (
        `id` INT AUTO_INCREMENT,
        `email` VARCHAR(50) NOT NULL,
        `nickname` VARCHAR(50) NOT NULL,
        `password` VARCHAR(50) NOT NULL,
        PRIMARY KEY (`id`)
)";

mysqli_query($dbc, $sql);

$sql = "CREATE TABLE IF NOT EXISTS board (
        id INT AUTO_INCREMENT,
        title VARCHAR(50) NOT NULL,
        date VARCHAR(50) NOT NULL,
        context TEXT NOT NULL,
        userid INT(50) NOT NULL,
        cnt INT(50) NOT NULL,
        imageType VARCHAR(50),
        imageData MEDIUMBLOB,
        PRIMARY KEY (`id`)
    )";

mysqli_query($dbc, $sql);

$sql = "CREATE TABLE IF NOT EXISTS comment (
        id INT AUTO_INCREMENT,
        context VARCHAR(50) NOT NULL,
        boardid INT(50) NOT NULL,
        userid INT(50) NOT NULL,
        date VARCHAR(50) NOT NULL,
        PRIMARY KEY (`id`)
    )";

mysqli_query($dbc, $sql);
