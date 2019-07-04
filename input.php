<?php
if( isset($_GET['submit']) ){
	$name = htmlentities($_GET['passengername']);
	$number = htmlentities($_GET['number']);
	$vehicle = htmlentities($_GET['vehicle']);
	$remarks = htmlentities($_GET['remarks']);
	$conn=odbc_connect('Boarding','','');
if (!$conn)
  {exit("Connection Failed: " . $conn);}
$sql=("INSERT INTO Main(Passenger_Name, Contact_Number)
 VALUES($name, $number)");
$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}
echo "Added to Database!";
    
}
?>