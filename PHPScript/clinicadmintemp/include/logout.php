<?php
	session_start();
	session_destroy();
	unset($_SESSION['uid']);
	unset($_SESSION['username']);
	header("location:../index.php");
?>