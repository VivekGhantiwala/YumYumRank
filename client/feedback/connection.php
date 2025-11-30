<?php
$conn = mysqli_connect("localhost","root","","db");
if (!$conn) 
{
	echo "Aman";
	die("Connection Unsuccessfull" . mysqli_connect_error());
	// console.log("1");
}
// $query="ALTER TABLE category DROP SID";
// $query1="ALTER TABLE catrgory ADD  SID INT(11) NOT NULL AUTO_INCREMENT FIRST ,ADD PRIMARY KEY (SID)";
// $run=mysqli_query($conn, $query);
// $run1=mysqli_query($conn, $query1);

