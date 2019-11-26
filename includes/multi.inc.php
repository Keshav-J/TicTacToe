<?php

session_start();

if(!isset($_SESSION['uname']) || !isset($_GET['page'])) {
	echo 'error';
	exit();
}

include_once 'dbh.inc.php';

$data = json_decode(file_get_contents("php://input"));

if($_GET['page'] == 'stats')
{
	$uname = $data->uname;

	if(empty($uname))
		$uname = $_SESSION['uname'];
	
	$sql = "SELECT * FROM user WHERE uname='$uname';";
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) != 1)
	{
		echo 'error';
		exit();
	}

	$row = mysqli_fetch_assoc($result);

	$name = $row['name'];
	$num = $row['num'];
	$uname = $row['uname'];
	$single= explode(',', $row['single']);
	$multi= explode(',', $row['multi']);

	echo '{
		"name" : "'.$name.'",
		"num" : "'.$num.'",
		"uname" : "'.$uname.'",
		"sw" : '.$single[0].',
		"sd" : '.$single[1].',
		"sl" : '.$single[2].',
		"mw" : '.$multi[0].',
		"md" : '.$multi[1].',
		"ml" : '.$multi[2].',
		"status": "success"
	}';
}

else if($_GET['page'] == 'upd') {
	$res = $data->res;

	$uname = $_SESSION['uname'];

	$sql = "SELECT * FROM user WHERE uname='$uname';";
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) != 1)
	{
		echo 'error';
		exit();
	}

	$row = mysqli_fetch_assoc($result);

	$arr = explode(',', $row['single']);

	if($res == 'you')
		$arr[0]++;
	else if($res == 'ai')
		$arr[2]++;
	else if($res == 'draw')
		$arr[1]++;

	$arr = join(',', $arr);

	$sql = "UPDATE user SET single='$arr' WHERE uname='$uname';";
	mysqli_query($conn, $sql);

	echo 'success';
}

else if($_GET['page'] == 'create') {

	$uname = $_SESSION['uname'];
	$pwd = $data->pwd;

	$sql = "INSERT INTO room(pwd, p1) VALUES('$pwd', '$uname');";
	mysqli_query($conn, $sql);

	$sql = "SELECT id FROM room WHERE p1='$uname' ORDER BY id DESC LIMIT 1;";
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) != 1)
		echo '{
			"status": "error"
		}';
	else
		echo ' {
			"id"    : '.mysqli_fetch_assoc($result)['id'].',
			"status": "success"
		}';
}

else if($_GET['page'] == 'waitForMatch') {

	$id = $data->id;

	$sql = "SELECT * FROM room WHERE id='$id';";
	$result = mysqli_query($conn, $sql);

	$row = mysqli_fetch_assoc($result);

	if(empty($row['p1']) || empty($row['p2']))
		echo '{
			"status": "error"
		}';
	else if($row['p1'] == $_SESSION['uname']) {
		if($row['turn']%2==1)	$pid = 1 ^ $row['start'];
		else 					$pid = 0 ^ $row['start'];
		echo '{
			"id" : "'. $row['p2'] .'",
			"turn": '.$row['turn'].',
			"pid": '.$pid.',
			"status": "success"
		}';
	}
	else {
		if($row['turn']%2==0)	$pid = 1 ^ $row['start'];
		else 					$pid = 0 ^ $row['start'];
		echo '{
			"id" : "'. $row['p1'] .'",
			"turn": '.$row['turn'].',
			"pid": '.$pid.',
			"status": "success"
		}';
	}
}

else if($_GET['page'] == 'enter') {
	
	$id = $data->id;
	$pwd = $data->pwd;
	$uname = $_SESSION['uname'];

	$sql = "SELECT * FROM room WHERE id='$id';";
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) != 1)
		echo '{	"room" : "notFound" }';
	else {
		$row = mysqli_fetch_assoc($result);
		
		if(!empty($row['p1']) && !empty($row['p2']))
			echo '{	"room" : "full" }';
		else {
			if($pwd != $row['pwd'])
				echo '{
					"room" : "success",
					"pwd"  : "wrng"
				}';
			else {
				if(!empty($row['p1']))
					$opuname = $row['p1'];
				else if(!empty($row['p2']))
					$opuname = $row['p2'];
				else
					$opuname = '';

				if(empty($row['p1']))
					$sql = "UPDATE room SET p1='$uname' WHERE id='$id';";
				else
					$sql = "UPDATE room SET p2='$uname' WHERE id='$id';";
				mysqli_query($conn, $sql);
			
				echo '{
					"room" : "success",
					"pwd"  : "success",
					"uname": "'.$opuname.'",
					"status": "success"
				}';
			}
		}
	}
}

else if($_GET['page'] == 'makeChange') {

	$id = $data->id;
	$move = $data->move;

	$sql = "SELECT * FROM room WHERE id='$id';";
	$result = mysqli_query($conn, $sql);

	$row = mysqli_fetch_assoc($result);

	$turn = $row['turn'] + 1;

	$sql = "UPDATE room SET move='$move', turn='$turn' WHERE id='$id';";
	mysqli_query($conn, $sql);

	echo 'success';
}

else if($_GET['page'] == 'waitChange') {

	$id = $data->id;

	$sql = "SELECT * FROM room WHERE id='$id';";
	$result = mysqli_query($conn, $sql);

	$row = mysqli_fetch_assoc($result);

	$turn = $row['turn'];
	$move = $row['move'];

	if(($_SESSION['uname']==$row['p1'] && (($turn%2==0)) || ($_SESSION['uname']!=$row['p1'] && (($turn%2!=0)))))
		echo '{
			"move" : '.$move.',
			"status": "success"
		}';
	else
		echo '{
			"status": "error"
		}';
}

else if($_GET['page'] == 'Mupd') {
	$res = $data->res;
	$id = $data->id;

	$uname = $_SESSION['uname'];

	//You

	$sql = "SELECT * FROM user WHERE uname='$uname';";
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) != 1)
	{
		echo 'error';
		exit();
	}

	$row = mysqli_fetch_assoc($result);

	$arr = explode(',', $row['multi']);

	$sql = "SELECT * FROM room WHERE id='$id'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	if($res == 'you') {
		$arr[0]++;
	}
	else if($res == 'ai') {
		$arr[2]++;
	}
	else if($res == 'draw') {
		$arr[1]++;
	}
	$start = $row['start'] ^ 1;

	$sql = "UPDATE room SET move='', turn='$start', start='$start' WHERE id='$id';";
	mysqli_query($conn, $sql);

	$arr = join(',', $arr);

	$sql = "UPDATE user SET multi='$arr' WHERE uname='$uname';";
	mysqli_query($conn, $sql);

	//Opponent

	$sql = "SELECT * FROM room WHERE id='$id'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if($_SESSION['uname'] == $row['p1'])
		$opuname = $row['p2'];
	else
		$opuname = $row['p1'];

	$sql = "SELECT * FROM user WHERE uname='$opuname';";
	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) != 1)
	{
		echo 'error';
		exit();
	}

	$row = mysqli_fetch_assoc($result);

	$arr = explode(',', $row['multi']);

	if($res == 'ai') {
		$arr[0]++;
	}
	else if($res == 'you') {
		$arr[2]++;
	}
	else if($res == 'draw') {
		$arr[1]++;
	}

	$arr = join(',', $arr);

	$sql = "UPDATE user SET multi='$arr' WHERE uname='$opuname';";
	mysqli_query($conn, $sql);

	echo 'success';
}