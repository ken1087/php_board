<?php
	session_start();
	ob_start();
	if(!isset($_SESSION['id'])){
		if(isset($_COOKIE['id']) && isset($_COOKIE['email'])){
			$userid=$_COOKIE['id'];
			$_SESSION['id']=$userid;
		}
	}
?>