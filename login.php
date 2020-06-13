<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html>

<head>
	<title>로그인</title>
	<meta charset="utf-8" />
</head>

<body>
	<?php
	require_once('dbcon.php');

	if (isset($_SESSION['id'])) {
		exit('<a href="index.php">세션을 통해서 로그인 정보를 확인했습니다.</a></body></html>');
	}

	if (empty($_POST['email']) || empty($_POST['pass'])) {
		exit('<a href="#" onclick="history.go(-1);">로그인 폼을 모두 채워주세요.</a>');
	}

	$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
	$pass = mysqli_real_escape_string($dbc, trim($_POST['pass']));
	//$passHash = PASSWORD_HASH($pass, PASSWORD_DEFAULT);

	$query = "select id,nickname from user where email='$email' and password='$pass'";
	$result = mysqli_query($dbc, $query)
		or die("Error Querying database.");

	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_assoc($result);
		$_SESSION['id'] = $row['id'];
		$_SESSION['nickname'] = $row['nickname'];
		setcookie('id', $row['id'], time() + (60 * 60 * 24));
		setcookie('nickname', $row['nickname'], time() + (60 * 60 * 24));
	?>
		<script>
			alert("<?php echo $_SESSION['nickname'] ?>님의 로그인에 성공했습니다.");
			window.location.href = 'index.php';
		</script>
	<?php
	} else {
	?>
		<script>
			alert("로그인에 실패했습니다.");
			window.location.href = "login.html";
		</script>
	<?php
	}
	//mysqli_free_result($resutl);
	?>
</body>

</html>