<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <?php
    if (!isset($_SESSION['id'])) {
        exit('<html><body><a href="main.php">비로그인 상태라 글 작성이 불가능합니다.</a></body></html>');
    }
    

    if (empty($_POST['title']) || empty($_POST['context'])) {
        exit('<a href="javascript:history.go(-1)">게시글 등록에 실패 하였습니다. (입력 폼을 모두 채워주세요).</a>');
    }

    if (isset($_FILES['image'])) {
        exit('<a href="javascript:history.go(-1)">이미지 업로드 에러가 발생했습니다.</a>');
    }

    require_once('dbcon.php');

    $title = mysqli_real_escape_string($dbc, trim($_POST['title']));
    $context = mysqli_real_escape_string($dbc, trim($_POST['context']));
    $userid = $_SESSION['id'];
    $cnt = 0;
    $imageData = $dbc->escape_string(file_get_contents($_FILES['imageData']['tmp_name']));
    $imageProperties = getimageSize($_FILES['imageData']['tmp_name']);
    $mime = $imageProperties["mime"];

    $query = "INSERT into board(title,date,context,userid,cnt,imageType,imageData) values('$title',now(),'$context','$userid','$cnt','$imageData','$mime')";

    $result = mysqli_query($dbc, $query)
            or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($conn), E_USER_ERROR);

    if($result == 1){
    ?>
        <script>
            alert("게시글을 등록하였습니다.");
			window.location.href = "board.php";
        </script>
    <?php
    }else{
        alert("게시글 등록에 실패하였습니다");
    }
        
    ?>
</body>
</html>




