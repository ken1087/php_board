<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
require_once('dbcon.php');

if (empty($_POST['title']) || empty($_POST['context'])) {
    exit('<a href="javascript:history.go(-1)">게시글 등록에 실패 하였습니다. (입력 폼을 모두 채워주세요).</a>');
}

if (isset($_FILES['image'])) {
    exit('<a href="javascript:history.go(-1)">이미지 업로드 에러가 발생했습니다.</a>');
}

$id = $_POST['id'];
$selectquery = "SELECT * FROM board WHERE id = '$id'";
$result = $dbc->query($selectquery);

if(isset($result)){
    $row = mysqli_fetch_assoc($result);
    $title = mysqli_real_escape_string($dbc, trim($_POST['title']));
    $context = mysqli_real_escape_string($dbc, trim($_POST['context']));
    $imageData = $dbc->escape_string(file_get_contents($_FILES['imageData']['tmp_name']));
    $imageProperties = getimageSize($_FILES['imageData']['tmp_name']);
    $mime = $imageProperties["mime"];

    $insertquery = "UPDATE board SET title='$title', context='$context', imageType='$imageData', imageData='$mime' WHERE id = '$id'";
    $insertresult = mysqli_query($dbc, $insertquery)
            or trigger_error("Query Failed! SQL: $insertquery - Error: " . mysqli_error($conn), E_USER_ERROR);

    if($insertresult == 1){
    ?>
        <script>
            alert("게시글을 등록하였습니다.");
            window.location.href = "board.php";
        </script>
    <?php
    }else{?>
        <script>
            alert("게시글 등록에 실패하였습니다");
        </script>
    <?php } 
} ?>
</body>
</html>



