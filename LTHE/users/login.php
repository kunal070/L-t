<?php
// Start the session
session_start();
?>

<?php

require_once ('../process/dbh.php');

$email = $_POST['mailuid'];
$password = $_POST['pwd'];

$sql = "SELECT * from `login` WHERE Email = '$email' AND Password = '$password'";
$result = mysqli_query($conn, $sql);


if(mysqli_num_rows($result) == 1){
	
	$sql = "SELECT * FROM login WHERE Email = '$email' AND Password = '$password'";
    $result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $Role = $row["Role"];
	$id = $row["Email"];
	$name = $row["Name"];
	if($Role == "User" || $Role == "Approver" || $Role == "Admin"){

		$_SESSION["role"] =$Role;
		$_SESSION["User_ID"] =$id;
		$_SESSION["User_Name"] =$name;

		header("Location: ..//users/userlogin.php");
		
	}
	else{
		echo "No results found1.";
		echo  $Role;
		echo  $id;
		echo  $name;
	
	
	}

} else {
    echo "No results found.2";
		}	
}

else{
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Invalid Email or Password')
    window.location.href='javascript:history.go(-1)';
    </SCRIPT>");
}
?>