<?php
$conn = mysqli_connect("localhost","root","","db");
if (!$conn) 
{
	// echo "Aman";
	die("Connection Unsuccessfull" . mysqli_connect_error());
	// console.log("1");
}
// $query="ALTER TABLE foods DROP FoodID";
// $query1="ALTER TABLE foods ADD  FoodID INT(11) NOT NULL AUTO_INCREMENT FIRST ,ADD PRIMARY KEY (FoodID)";
// $run=mysqli_query($conn, $query);
// $run1=mysqli_query($conn, $query1);

// echo "Done";