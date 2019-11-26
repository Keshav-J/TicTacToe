<?php

session_start();

include_once 'dbh.inc.php';

$nodeId = $_SESSION['nodeId'];
$uname = $_SESSION['uname'];
$sql = "UPDATE user SET active=0 WHERE uname='$uname';";
mysqli_query($conn, $sql);

session_unset();

session_destroy();

session_start();

$_SESSION['nodeId'] = $nodeId;

?>