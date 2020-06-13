<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
</head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="styles/board.css">
<body>
    <?php
        $URL = "./login.html";
        if(!isset($_SESSION['id'])) {
    ?>
        <script>
                alert("로그인이 필요합니다");
                location.replace("<?php echo $URL?>");
        </script>
    <?php
        }
    ?>
    <div class="main">
        my board
    </div>
    <div class="menu">
        <div><a href="index.php">Home</a></div>

        <?php if(!isset($_SESSION['id'])) { ?>
                <div><a href="login.html"> 로그인</a></div>
        <?php } else {?>
                <div><a href="logout.php"><?php echo $_SESSION['nickname']?>님 환영합니다 로그아웃</a></div>
        <?php } ?>

        <div><a href="board.php">게시판</a></div>
    </div>
    <?php
    require_once('dbcon.php');

    if(isset($_GET['search'])){
        $search = $_GET['search'];
        $query = "select b.id as id, b.title as title, b.context as context, b.cnt as cnt, b.date as date, b.imageType, b.imageData, u.id as userid, u.nickname as nickname from user as u right outer join board as b on u.id = b.userid where b.title like '%$search%' order by b.id";
        $result = $dbc->query($query);
        if(!$result){
            $total = mysqli_num_rows($result);
        }
    }else{
        $query = "select b.id as id, b.title as title, b.context as context, b.cnt as cnt, b.date as date, b.imageType, b.imageData, u.id as userid, u.nickname as nickname from user as u right outer join board as b on u.id = b.userid order by b.id";
        $result = $dbc->query($query);
        $total = mysqli_num_rows($result);
    }
    ?>
    
    <div class="container boardcon">
        <div class="main boardpagetitle">게시판</div>
        <table text-align="center" class="table table-striped" style="width: 100%">
            <thead text-align="center">
                <tr class="postmenu">
                    <td style="width: 20%">번호</td>
                    <td style="width: 20%">제목</td>
                    <td style="width: 20%">작성자</td>
                    <td style="width: 20%">날짜</td>
                    <td style="width: 20%">조회수</td>
                </tr>
            </thead>

            <tbody>
                <?php
                while ($rows = mysqli_fetch_assoc($result)) { //DB에 저장된 데이터 수 (열 기준)
                    if ($total % 2 == 0) {
                ?> <tr class="even">
                        <?php   } else { ?>
                        <tr>
                        <?php } ?>
                            <td width="20%"><?php echo $rows['id'] ?></td>
                            <td width="20%"><a href="view.php?id=<?php echo $rows['id'] ?>"><?php echo $rows['title'] ?></a></td>
                            <td width="20%"><?php echo $rows['nickname'] ?></td>
                            <td width="20%"><?php echo $rows['date'] ?></td>
                            <td width="20%"><?php echo $rows['cnt'] ?></td>
                        </tr>
                    <?php
                // $total--;
                }
                    ?>
            </tbody>
        </table>

        <form action="board.php?search=search" method="GET">
           <div class="searchbox"><input type="text" name="search" class="form-control"><button type="submit" class="btn btn-primary">검색</button></div>
        </form>
        

        <form action="write.html" method="GET">
            <div  class="writemove"><input type="submit" value="글쓰기" class="btn btn-primary"/></div>
        </form>
    </div>
    <footer></footer>
</body>

</html>