<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html>

<head>
        <meta charset='utf-8'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="styles/index.css">
</head>

<body>
        <?php
        require_once('dbcon.php');
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
        <div style="text-align: center; margin-bottom: 30px">
                <img src="images/front.png" width="70%"></img>
        </div>
        <div>
                <div style="display: inline-grid; grid-template-columns: 1fr 1fr 1fr; font-size: 14px">
                        <div>
                                목숨을 같으며, 되는 아름다우냐? 하는 곳이 몸이 있는가? 하여도 예가 풀밭에 눈이 인간에 보라. 꽃 얼음이 창공에 전인 하는 부패뿐이다.
                        </div>
                        <div>
                                것은 인간이 너의 힘차게 것이다. 거친 하여도 가슴이 천지는 가진 청춘은 무엇을 내는 힘있다. 투명하되 봄바람을 맺어, 더운지라 있다.
                        </div>
                        <div>
                                품에 가진 생명을 풀밭에 과실이 봄바람을 피가 품고 뿐이다. 피가 놀이 스며들어 약동하다. 이것이야말로 피가 물방아 인생의 그러므로 산야에 생의 봄바람이다.
                        </div>
                </div>
                <div style="text-align: center; margin-top: 40px">출처: <a href="http://hangul.thefron.me/">한글입숨 생성기</a></div>
        <footer></footer>         
</body>

</html>