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
</head>
<body>
<script>

    <?php 
    require_once('dbcon.php');
    $id = $_GET['id'];
    $deletequery = "DELETE from board where id = '$id'";
    $result = mysqli_query($dbc, $deletequery);
    
    if($result == 1){?>
        alert("삭제 하였습니다");
        window.location.href = "board.php";
    <?php
    }else{?>
        alert('삭제 오류');
    <?php } ?>
</script>
</body>
</html>


