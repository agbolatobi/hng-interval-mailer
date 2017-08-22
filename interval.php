<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Interval.PHP</title>
</head>
<body>
<?php include"server/conn.php"; //imports connection file
include"randompassword_function.php";//import randompassword generator 
//checks if GET[id] is set
if(isset($_GET['id'])&&ctype_digit($_GET['id'])){  
	$sql = "SELECT * FROM maildbtable WHERE id=".$_GET['id'].""; // Query to pull record for the current ID
$result = $conn->query($sql); // runs query and stores values 
if ($result->num_rows > 0) { //if any results are returned 
    // stores output data 
    $row = $result->fetch_assoc();
	if(getHourCount($row["last_updated"]) > 0){ // checks if it has been an hour
		$newpassword=generateRandompassword(); // generate and stores new password
		echo"New Password: ".$newpassword." ".getHourCount($row["last_updated"]); // prints out results
		updatePassword($_GET["id"],$newpassword, $conn); // calls update function
		}else{
			echo"Old Password: ".$row["password"] ; // prints old password when the time elapsed is not up to an hour 
			}
} else {
    echo "User Does Not EXist"; //print error message
}
	}else{
		echo"Error: No ID try Sample http://localhost/hng-mailer/interval.php?id=2"; //print error message
}

function getHourCount($last_update){
	// compares current time with last update and returns the number of hours between them
	return floor(abs(strtotime(date("Y-m-d H:i:s")) - strtotime($last_update))/3600); 
	
	}
function updatePassword($id, $newpassword, $conn){
	//updates the Database with the current password and current last update time
	$sql = "UPDATE maildbtable SET password='$newpassword' ,last_updated='".date("Y-m-d H:i:s")."' WHERE id=".$id."";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
$conn->close();
	}
?>

</body>
</html>