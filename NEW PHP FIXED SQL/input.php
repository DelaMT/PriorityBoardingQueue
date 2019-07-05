<?php
/*
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
    
} */
if(isset($_GET['submit'])){
    $name = htmlentities($_GET['passengername']);
    $number = htmlentities($_GET['number']);
   // $vehicle = htmlentities($_GET['vehicle']);
   // $remarks = htmlentities($_GET['remarks']);
    $idcard = htmlentities($_GET['idcard']);
    $dbc = mssql_connect('intranet1\sqlexpress','GOZOCHANNEL\daniel.sumler','','PriorityBoarding')
    or die('Error connecting to
      the   SQL Server database.');
    $query="INSERT INTO Passengers(PassengerName, PassengerIDCard, ContactNumber)
        VALUES('$name', '$idcard', '$number')";
    $result = mssql_query($query,$dbc);
    if (!$result)
    {
        exit("Error in SQL");
    }

    echo "Added to Database!";


}





?>