<!DOCTYPE html>
<html>

<head>
	<title>회원 가입</title>
	<meta charset="utf-8" />
</head>

<body>
	<?php
	require_once('dbcon.php');
	
	if (empty($_POST['nickname']) || empty($_POST['pass']) || empty($_POST['passcon'])) {
		exit('<a href="javascript:history.go(-1)">로그인 실패 하였습니다. (입력 폼을 모두 채워주세요).</a>');
	}

	// echo $_FILES['userimg']['tmp_name'];

	// $imagepath="./images/". uniqid("img").".".pathinfo($_FILES['userimg']['name'],PATHINFO_EXTENSION); 
	// if (!move_uploaded_file($_FILES['userimg']['tmp_name'], $imagepath)){
	// exit('<a href="javascript:history.go(-1)">이미지 에러가 발생했습니다.</a>');
	// }

	$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
	$nickname = mysqli_real_escape_string($dbc, trim($_POST['nickname']));
	$pass = mysqli_real_escape_string($dbc, trim($_POST['pass']));
	$passcon = mysqli_real_escape_string($dbc, trim($_POST['passcon']));
	//$passHash = PASSWORD_HASH($pass, PASSWORD_DEFAULT);
	if ($pass != $passcon) {
		exit('<a href="javascript:history.go(-1)">비밀번호 확인이 틀렸습니다.</a>');
	}


	$query = "SELECT id FROM user WHERE nickname='$nickname'";
	$result = mysqli_query($dbc, $query)
		or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($conn), E_USER_ERROR);

	if (mysqli_num_rows($result) != 0) {
		exit('<a href="javascript:history.go(-1)">이미 등록된 닉네임 입니다.</a>');
	}

	mysqli_free_result($result);

	//mysqli_query($dbc, 'set names utf8');

	$query = "INSERT INTO user (`email`, `nickname`, `password`) VALUES ('$email', '$nickname', '$pass')";

	$result = mysqli_query($dbc, $query)
		or trigger_error("Query Failed! SQL: $query - Error: " . mysqli_error($conn), E_USER_ERROR);

	echo $result;

	//echo "<img src='userimg.php?nickname=$nickname' alt='User Image' style='width:80px;height:80px;'/><br/>";
	//echo "$nickname" . "님의 회원 가입을 축하드립니다. <br/><br/>";
	//echo '<a href="/board.php">Main으로</a>';

	if($result == 1){ ?>
		<script>
			alert("<?php echo $nickname ?>님의 회원 가입을 축하 드립니다.");
			window.location.href = '/index.php';
		</script>
	<?php } ?>
	
</body>

</html>