<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/styles/write.css">
    <title>update</title>
</head>
<body>
    <?php
         require_once('dbcon.php'); 
         $id = $_GET['id']; 
    ?>
    <div class="container">
        <h3>수정 하기</h3>
        <form action="updateproc.php" method="POST" enctype="multipart/form-data">
            <div>
                <input type="text" value="<?php echo $id ?>" name="id" style="display:none"/>
                <input type="text" name="title" class="title form-control" placeholder="제목"/>
            </div>
            <div class="marginbox">
                <textarea id="context" name="context" class="context form-control textarea" rows="10" placeholder="내용"></textarea>
            </div>
            <div class="marginbox"><input type="file" name="imageData" class="imgeData"/></div>
            <div class="marginbox gap">
                <button type="submit" class="btn btn-primary">수 정</button>
                <a href="board.php" class="btn btn-primary">돌 아 가 기</a>
            </div>
        </form>
    </div>
   
    <?php
       
        $query = "SELECT* FROM board WHERE id = '$id'";
        //$result = mysqli_query($dbc, $query);
        $result = $dbc->query($query);
        

        if(isset($result)){ 
            $row = mysqli_fetch_assoc($result);?> 
            <script>
                document.querySelector('.title').value = "<?php echo $row['title'] ?>";
                document.querySelector('.context').value = "<?php echo $row['context'] ?>";
                document.querySelector('.imgeData').value = "<?php echo $row['imgedata'] ?>";
            </script>
    <?php } ?>
</body>
</html>