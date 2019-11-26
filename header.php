<?php

	session_start();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,intial-scale=1.0">
	<title>Tic Tac Toe</title>
	<!--link rel="stylesheet" type="text/css" href="style.css"-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="script.js"></script>
	<style type="text/css">
		body {
			background: url(img/bg3.jpg) no-repeat center center fixed;
			background-size: cover;
			-webkit-transition: all 1s ease-in-out;
		}

		a{
			text-decoration: none;
		}

		[ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
		  display: none !important;
		}
		
		.inp:focus, .btn:focus {
			outline: none;
			-webkit-transition: all 0.30s ease-in-out;
			border-color: blue;
			border-width: 2px;
			box-shadow: 0 0 5px rgba(81, 203, 238, 1);
		}

		.container {
			text-align: center;
			width: 300px;
			padding: 25px;
			padding-top: 15px;
			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			background-color: #09ff1047;
			border-radius: 5px;
			z-index: 3;
		}

		.inp {
			padding: 10px;
			border-color: black;
			border-radius: 5px;
			width: 190px;
		}

		.btn {
			padding: 10px;
			border-color: black;
			border-radius: 15px;
			width: auto;
			cursor: grab;
		}
		.btn:focus {
			cursor: grabbing;
		}

		.left {
			float: left;
		}
		.right {
			float: right;
		}
		.center {
			text-align: center;
		}

		.chs {
			font-family: Comic Sans MS;
			font-size: 25px;
			font-weight: bold;
			color: #000000;
		}
		.chs:hover {
			-webkit-transition: all 0.30s ease-in-out;
			text-shadow: 0 0 15px rgba(255, 255, 255, 1);
			cursor: pointer;
		}

		.fontDec {
			font-family:Comic Sans MS;
			font-size:25px;
			font-weight:bold;
		}

		.head {
			position: relative;
			padding:5px;
			color: white;
			z-index: 1;
		}
		.headEle {
			padding:7px;
			font-size: 17px;
			font-weight: bold;
		}
		.headEle:hover {
			-webkit-transition: all 0.25s ease-in-out;
			background-color: #dd1212d9;
			border-radius: 5px;
			cursor: pointer;
		}

		.loginDiv {
			transition: all linear 0.5s;
			position: fixed;
			top: 0px;
			left: 0px;
			width: 100%;
			height: -webkit-fill-available;
			background-color: rgba(0,0,0,0.8);
			z-index: 2;
		}
		.loginDiv .ng-hide {
			height: 0;
			width: 0;
			background-color: transparent;
			top:-200px;
			left: 200px;
		}
		.loginPanel {
			background-color: red;
		}
		.container .nav {
			font-size: 17px;
			font-weight: bold;
		}
		.container .nav .navEle {
			color: #aaaaaa;
			background-color: #e9ebee;
			padding-top: 5px;
			padding-bottom: 5px;
		}
		.container .nav .navEle:hover {
			-webkit-transition: all 0.25s ease-in-out;
			background-color: rgba(14, 142, 24, 0.89);
			cursor: pointer;
		}

		.close {
			padding: 5px;
			color: #aaaaaa;
			font-size: 25px;
			font-weight: bold;
			font-family: monospace;
			text-align: right;
		}
		.closeEle:hover {
			color: #000000;
			cursor: pointer;
			-webkit-transition: all 0.25s ease-in-out;
		}

		.loginDiv .container div .nav input[type="radio"]{
			display: none;
		}

		.loginDiv .container div .nav input:checked + label.navEle {
			color: #555;
			border-top: 2px solid #0f9d58;
			background-color: white;
		}

		.pre-loader {
			width: 100%;
			height: -webkit-fill-available;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			position: absolute;
			z-index: 10;
			background-color: rgba(255, 255, 255, 0.5);
		}
		.pre-ele {
			margin-left: auto;
			margin-right: auto;
			width: 300px;
			height: 300px;
			text-align: center;
			transform: translateY(50%);
			background: url(img/loader.gif) no-repeat center;
		}
		.pre-text {
			transform: translateY(550%);
		}
		
	</style>

<script>
	
</script>
</head>

<body ng-app="body" ng-controller="bodyCtrl" class="ng-cloak">

<div class="pre-loader" ng-show="load">
	<div class="pre-ele fontDec">
		<div class="pre-text">
			Loading....
		</div>
	</div>
</div>

<div class="loginDiv" ng-show="loginPanel">
	<div class="container">
		<div class="close">
			<span class="closeEle" ng-click="close()"> x </span>
		</div>
		<div style="background-color:white; padding:5px; border-radius:2px;">
			<div class="nav">
				<input class="navEle left center" type="radio" name="tabs" id="tab1" ng-click="loginS()" checked>
				<label class="navEle left center" for="tab1" style="width: 50%">Login</label>
				<input class="navEle right center" type="radio" name="tabs" id="tab2" ng-click="signupS()">
				<label class="navEle right center" for="tab2" style="width: 50%">Sign Up</label>
			</div>
			<hr>
			<br>
			<div ng-show="loginD">
				<form>
					<input class="inp" type="text" ng-model="num" placeholder="Email / Mobile No." required>
					<br ng-show="numV"><span style="color: red;" ng-show="numV">Email/Mobile No. Not Found.</span>
					<br><br>
					<input class="inp" type="password" ng-model="pwd" placeholder="Password" required>
					<br ng-show="pwdV"><span style="color: red;" ng-show="pwdV">Password does not match.</span>
					<br><br>
					<input class="btn" style="background-color: #D83F3B;" type="submit" ng-click="login()" value="Login">
					<br><br>
				</form>
			</div>
			<div ng-show="signupD">
				<form method="POST">
					<input class="inp" type="text" ng-model="name" placeholder="Full Name" required>
					<br><br>
					<input class="inp" type="text" ng-model="num" placeholder="Email / Mobile No." required>
					<br ng-show="numV"><span style="color: red;" ng-show="numV">Email/Mobile No. already taken.</span>
					<br><br>
					<input class="inp" type="text" ng-model="uname" placeholder="User Name" required>
					<br ng-show="unameV"><span style="color: red;" ng-show="unameV">User Name already taken.</span>
					<br><br>
					<input class="inp" type="password" ng-model="pwd" placeholder="Password" required>
					<br><br>
					<input class="btn" style="background-color: #D83F3B;" type="submit" ng-click="signup()" value="Sign up">
					<br><br>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="head right">

<?php
if(isset($_SESSION['uname'])) {
?>

	<div class="headEle left"><?php echo $_SESSION['uname']; ?></div>
	<div class="headEle right" ng-click="logout()">Logout</div>

<?php
}
else {
?>

	<button class="btn" style="width: 135px; background-color: #4747C9; color:white;" ng-click="log_up()">Login / Signup</button>

<?php	
}

?>

</div>

<script>

</script>