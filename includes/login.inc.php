<?php

include_once 'dbh.inc.php';
session_start();

if(!isset($_GET['page']))
	exit();

function genNodeId($len) {
	$id = '';
	$code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . 'abcdefghijklmnopqrstuvwxyz' . '0123456789';

	for($i=0 ; $i<$len ; $i++)
		$id .= $code[random_int(0, 61)];

	return $id;
}

$data = json_decode(file_get_contents("php://input"));

if($_GET['page'] == 'login') {
	$num = $data->num;
	$pwd = $data->pwd;

	if(empty($num) || empty($pwd)) {
		echo 'empty';
		exit();
	}

	echo '{ ';

	$sql = "SELECT * FROM user WHERE num='$num'";
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) != 1) {
		echo '"num" : 1, "pwd" : 0, "status": "num" }';
		exit();
	}
	else
		echo '"num" : 0, ';

	$row = mysqli_fetch_assoc($result);

	if($pwd != $row['pwd']) {
		echo '"pwd" : 1, "status" : "pwd" }';
		exit();
	}
	else
		echo '"pwd" : 0, ';

	if(!isset($_SESSION['nodeId'])) 
		$_SESSION['nodeId'] = genNodeId(10);

	$nodeId = $_SESSION['nodeId'];

	$sql = "UPDATE user SET node='$nodeId', active=1 WHERE num='$num'";
	mysqli_query($conn, $sql);

	$sql = "SELECT * FROM user WHERE num='$num'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if($row['node'] != $nodeId)
		echo '"status" : "error" ';
	else {
		echo '"status" : "success" ';

		$_SESSION['uname'] = $row['uname'];
		$_SESSION['name'] = $row['name'];

		$arr = explode(',', $row['single']);
	}

	echo '}';
}

else if($_GET['page'] == 'signup') {
	$name = $data->name;
	$num = $data->num;
	$uname = $data->uname;
	$pwd = $data->pwd;
	$valid = true;

	if(empty($name) || empty($num) || empty($uname) || empty($pwd)) {
		echo 'empty';
		exit();
	}

	echo '{ ';

	$sql = "SELECT * FROM user WHERE num='$num'";
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) > 0){
		echo '"num" : 1, ';
		$valid = false;
	}
	else
		echo '"num" : 0, ';

	$sql = "SELECT * FROM user WHERE uname='$uname'";
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) > 0){
		echo '"uname" : 1, ';
		$valid = false;
	}
	else
		echo '"uname" : 0, ';

	if($valid) {

		if(!isset($_SESSION['nodeId'])) 
			$_SESSION['nodeId'] = genNodeId(10);

		$nodeId = $_SESSION['nodeId'];

		$sql = "INSERT INTO user(name, num, uname, pwd, node, active) VALUES('$name', '$num', '$uname', '$pwd', '$nodeId', 1);";
		mysqli_query($conn, $sql);

		$sql = "SELECT * FROM user WHERE uname='$uname'";
		$result = mysqli_query($conn, $sql);

		if(mysqli_num_rows($result) == 1) {
			echo '"status" : "success" ';

			$_SESSION['uname'] = $uname;
			$_SESSION['name'] = $name;
		}
		else
			echo '"status" : "error"';
	}
	else
		echo '"status" : "invalid"';

	echo ' }';
}

else if($_GET['page'] == 'check') {
	if(!isset($_SESSION['uname'])) {
		echo 'success';
		exit();
	}

	$uname = $_SESSION['uname'];

	$sql = "SELECT * FROM user WHERE uname='$uname'";
	$result = mysqli_query($conn, $sql);

	if(mysqli_fetch_assoc($result)['node'] != $_SESSION['nodeId'])
		echo 'error';
	else {
		echo 'success';
		
		$sql = "UPDATE user SET active=1 WHERE uname='$uname';";
		mysqli_query($conn, $sql);
	}
}

?>