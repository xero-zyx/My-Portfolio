<?php
session_start();
include "dbconn.php";

if (isset($_POST['username']) && isset($_POST['password'])) {

	function validate($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	$inputusername = validate($_POST['username']);
	$inputpassword = validate($_POST['password']);

	if (empty($inputusername)) {
		header("Location: administrator.php?error=Username Required");
		exit();
	} else if (empty($inputpassword)) {
		header("Location: administrator.php?error=Password Required");
		exit();
	} else {
		$sql = "SELECT * FROM users WHERE username='$inputusername' AND password='$inputpassword'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
			if ($row['username'] === $inputusername && $row['password'] === $inputpassword) {
				$_SESSION['postname'] = $row['username'];
				$_SESSION['postpass'] = $row['password'];
				header("Location: indextable.php");
				exit();
			} else {
				header("Location: administrator.php?error=Incorect Credentials");
				exit();
			}
		} else {
			header("Location: administrator.php?error=Incorect Credentials");
			exit();
		}
	}

} else {
	header("Location: administrator.php");
	exit();
}
?>