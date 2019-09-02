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

$oldname = $_POST['oldname'];
$newname = $_POST['name'];
$oldnumber = $_POST['oldnumber'];
$newnumber = $_POST['number'];
$idcard = $_POST['idcard'];

$sql1 = "UPDATE dbo.Passengers SET ContactNumber = '$newnumber' WHERE PassengerIDCard = '$idcard';";
$result1 = sqlsrv_query($conn, $sql1);

$sql2 = "UPDATE dbo.Passengers SET PassengerName = '$newname' WHERE PassengerIDCard = '$idcard';";
$result2 = sqlsrv_query($conn, $sql2);

if($result1 && $result2){
    echo "<h1>Name successfully changed from '$oldname' to '$newname'</h1>
          <h1>Number successfully changed from $oldnumber to $newnumber</h1>";
} else{
    echo "<h1>An error occurred! Please try again later!</h1>";
    die(print_r(sqlsrv_errors(), true));
}
