<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>작성글 보기</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="styles/view.css">
</head>
<body>
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

	
	if (empty($_GET['id'])) {
		exit('<script>alert("잘못된 번호입니다.");history.go(-1);</script>');
	}
	$id = $_GET['id'];

	$cntplust = "UPDATE board SET cnt = cnt + 1 WHERE id = '$id'";
	mysqli_query($dbc, $cntplust);

	$query = "select b.id as id, b.title as title, b.context as context, b.cnt as cnt, b.date as date, b.imageType, b.imageData, u.id as userid, u.nickname as nickname from user as u right outer join board as b on u.id = b.userid where b.id='$id'";
	$result = $dbc->query($query);
	if (!$result) {
		exit('<script>alert("글이 없습니다.");history.go(-1);</script>');
	}
	$row = mysqli_fetch_assoc($result);

	$reply = "SELECT u.nickname as nickname, c.context as context, c.date as date, c.id as id, c.userid as cuserid FROM comment as c right outer join user as u on c.userid = u.id WHERE c.boardid = '$id' order by date desc";
	$result = $dbc->query($reply);
    $total = mysqli_num_rows($result);
	?>
	
	<div class="container">
		<div>
			<div class="usernickname">글쓴이 : <?php echo $row['nickname'] ?></div>
			<div><input type="text" class="title form-control" readOnly/></div>
		</div>
		
		<div class="margintextarea"><textarea name="" cols="30" rows="10" class="context form-control" readOnly></textarea></div>
		<div>
			<table class="table">
				<thead>
					<tr text-align="center">
						<td>댓 글</td>
					</tr>
				</thead>
				<tbody class="commentbox">
					<?php
					while ($rows = mysqli_fetch_assoc($result)) { //DB에 저장된 데이터 수 (열 기준)
						$cid = $rows['id'];
						$userid = $rows['cuserid'];
						if ($total % 2 == 0) {
					?> <tr class="cid<?php echo $cid ?>">
							<?php   } else { ?>
							
							<?php } ?>
								<td><?php echo $rows['nickname'] ?>
								<td><input type='text' class="form-control commentcontext<?php echo $cid ?>" id="class<?php echo $cid?>" value='<?php echo $rows['context'] ?>' readonly/></td>
								<td class="date<?php echo $cid?>"><?php echo $rows['date'] ?></td>

							<?php if($_SESSION['id'] == $userid) {?>
								<td class="style1<?php echo $cid?>">
									<button type="button" onclick='javascript:cupdate(<?php echo $cid ?>)' class="btn btn-primary">수정</butto>
									<button type="button" onclick='javascript:cdelete(<?php echo $cid ?>)' class="btn btn-primary" style="margin-left:10px;">삭제</butto>
								</td>
								<td class="style2<?php echo $cid?>" style="display:none">
									<button type="button" onclick='javascript:updateajax(<?php echo $cid ?>)' class="btn btn-primary">수정</butto>
								</td>
							<?php } ?>
							</tr>
						<?php
					// $total--;
					}
						?>
				</tbody>
			</table>
			<div class="cbox">
				<input type="text" class="comment form-control" name="comment">
				<button type="button" onclick="javascript:commentinsert()" class="btn btn-primary">등록</button>
			</div>
		</div>
		
		<?php if($row['userid'] == $_SESSION['id']){?>
		<div class="usercon">
			<button type="button" onclick="javascript:updatepage()" class="btn btn-primary">수정</button>
			<button type="button" onclick="javascript:boarddelete()" class="btn btn-primary">삭제</button>
		</div>
		<?php }?>
	</div>
	<footer></footer>

	<script>
		let title = document.querySelector('.title');
		let context = document.querySelector('.context');
		let commentbox = document.querySelector('.commentbox');

		title.value = "<?php echo $row['title'] ?>";
		context.value = "<?php echo $row['context'] ?>";


		function boarddelete(){
			window.location.href = "boarddelete.php?id=<?php echo $id ?>";
		}
		
		function updatepage() {
			window.location.href = "update.php?id=<?php echo $id ?>";
		}

		function commentinsert(){
			var commentbox = document.querySelector('.commentbox');
			let context = document.querySelector('.comment').value;
			let boardid = "<?php echo $row['id'] ?>";
			let userid = "<?php echo $_SESSION['id'] ?>";

			$.ajax({
				url:'http://localhost/reply.php',
				type:'post',
				data: { 
					'context' : context,
					'boardid' : boardid,
					'userid': userid
				},
				dataType : 'json',
				success: function (res) {
					let title = res.nickname;
					let context = res.context;
					let date = res.date;
					let cid = res.cid;

					var str = "<td>"+title+"</td><td><input type='text' class='form-control commentcontext"+cid+"' id='class"+cid+"' value="+context+" readonly/></td><td>"+date+"</td><td class='style1"+cid+"'><button onclick='javascript:cupdate("+cid+")' class='btn btn-primary' type='button'>수정</button><button class='btn btn-primary' onclick='javascript:cdelete("+cid+")' style='margin-left:10px;' type='button'>삭제</button></td><td class='style2"+cid+"' style='display:none'><button type='button' class='btn btn-primary' onclick='javascript:updateajax("+cid+")'>수정</button></td>";
					let newTr = document.createElement('tr');
					newTr.innerHTML = str;
					newTr.className = 'cid'+cid;
					commentbox.prepend(newTr);
					document.querySelector('.comment').value = "";
				},
				error: function (request,status,error) {               
					alert("등록할 수 없습니다.");      
					alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);           
				}
			});

		}


		function cupdate(commentid){
			let cid = 'class'+commentid;
			let style11 = 'style1'+commentid;
			let style22 = 'style2'+commentid;
			
			let classcid = document.getElementById(cid);
			let style1 = document.getElementsByClassName(style11);
			let style2 = document.getElementsByClassName(style22);

			classcid.readOnly = false;

			$(style1).css("display","none");
			$(style2).css("display","block");
		}

		function updateajax(commentid){
			let cid = 'class'+commentid;
			let style11 = 'style1'+commentid;
			let style22 = 'style2'+commentid;

			let classcid = document.getElementById(cid);
			let style1 = document.getElementsByClassName(style11);
			let style2 = document.getElementsByClassName(style22);

			let context = classcid.value;

			$.ajax({
				url:'http://localhost/replyupdate.php',
				type:'post',
				data: { 
					'id' : commentid,
					'context' : context
				},
				dataType : 'json',
				success: function (res) {
					let dateclass = 'date'+commentid;
					let datebox = document.getElementsByClassName(dateclass);
					datebox.innerHTML = res.date;
					classcid.readOnly = true;
					$(style1).css("display","block");
					$(style2).css("display","none");
				},
				error: function (request,status,error) {               
					alert("등록할 수 없습니다.");      
					alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);           
				}
			});
		}

		function cdelete(commentid){
			let cid = 'cid'+commentid;
			let classcid = document.getElementsByClassName(cid);
			$(classcid).remove();
		}
	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</body>
</html>
