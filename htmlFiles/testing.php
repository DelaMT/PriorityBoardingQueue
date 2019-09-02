
<?php
$name = htmlentities($_GET['passengername']);
$number = htmlentities($_GET['number']);
// $vehicle = htmlentities($_GET['vehicle']);
// $remarks = htmlentities($_GET['remarks']);
$idcard = htmlentities($_GET['idcard']);
echo $name;
echo $number;
echo $idcard;

$serverName = "intranet1\sqlexpress"; //serverName\instanceName

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
$connectionInfo = array( "Database"=>"PriorityBoarding");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
    echo "Connection established.<br />";
}else{
    echo "Connection could not be established.<br />";
    die( print_r( sqlsrv_errors(), true));
}

$query="INSERT INTO dbo.Passengers(PID, PassengerIDCard, PassengerName, ContactNumber)
        VALUES(100, '$idcard', '$name', '$number')";
$result = sqlsrv_query($conn, $query);
if (!$result)
{
    die( print_r( sqlsrv_errors(), true));
    //exit("Error in SQL");

}
echo "Added to Database!";
?>
