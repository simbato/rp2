<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title> <?php echo $title; ?> </title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<h1>Chat!</h1>
	<div class="username">@<?php echo $_SESSION['username']; ?> </div>
	<br />
	<div class= "navbar">
		<a href="index.php?rt=channel/index">My channels</a>
		<a href="index.php?rt=channel/all">All channels</a>
		<a href="index.php?rt=channel/startNew">Start a new channel</a>
		<a href="index.php?rt=message/userMessages">My messages</a>
		<a href="index.php?rt=logout">Logout</a>
	</div>
	<br />
