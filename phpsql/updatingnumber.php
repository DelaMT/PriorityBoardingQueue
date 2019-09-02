<?php
$serverName = "192.168.5.20\sqlexpress"; //serverName\instanceName

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
$connectionInfo = array( "Database"=>"PriorityBoarding","UID"=>"daniel.sumler", "PWD"=>"12345");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
    echo "Connection established.<br />";
}else{
    echo "Connection could not be established.<br />";
    die( print_r( sqlsrv_errors(), true));
}

$oldnumber = $_POST['oldnumber'];
$newnumber = $_POST['number'];
$idcard = $_POST['idcard'];

$sql = "UPDATE dbo.Passengers SET ContactNumber = '$newnumber' WHERE PassengerIDCard = '$idcard';";
$result = sqlsrv_query($conn, $sql);
if($result){
    echo "<h1>Name succesfully changed from '$oldnumber' to '$newnumber'</h1>";
} else{
    echo "<h1>An error occurred! Please try again later!</h1>";
    die(print_r(sqlsrv_errors(), true));
}

?>