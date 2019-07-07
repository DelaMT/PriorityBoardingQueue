<!DOCTYPE html>
<html>

<?php
//START OF SETTING PASSENGER DB
function checkPassenger($idcard, $conn){
    $query_exists="SELECT COUNT(PassengerIDCard) AS card FROM dbo.Passengers WHERE PassengerIDCard = '$idcard';";
    $rowSQL = sqlsrv_query($conn, $query_exists);
    $row = sqlsrv_fetch_array($rowSQL);
    return $row["card"];
}
function numOfPassengers($conn){
    $query_num = "SELECT COUNT(PID) AS num FROM dbo.Passengers;";
    $rowSQL = sqlsrv_query($conn, $query_num);
    $row = sqlsrv_fetch_array($rowSQL);
    return $row["num"];
}
function numOfTrips($conn){
    $query_num = "SELECT COUNT(ID) AS num FROM dbo.Trips;";
    $rowSQL = sqlsrv_query($conn, $query_num);
    $row = sqlsrv_fetch_array($rowSQL);
    return $row["num"];
}

function findLargest(&$highest, $conn){
    $query_largest = "SELECT MAX(PID) AS highest FROM dbo.Passengers;";
    $rowSQL = sqlsrv_query($conn, $query_largest);
    $row = sqlsrv_fetch_array($rowSQL);
    $highest = $row["highest"];
    if ($highest == NULL && numOfPassengers($conn) == 0) {
        $highest = -1;
    }
}
function findLargestID(&$highest, $conn){
    $query_largest="SELECT MAX(ID) AS highest FROM dbo.Trips;";
    $rowSQL = sqlsrv_query($conn, $query_largest);
    $row = sqlsrv_fetch_array($rowSQL);
    $highest = $row["highest"];
    if($highest == NULL && numOfTrips($conn) == 0){
        $highest = -1;
    }
}
$highest=0;
$name = htmlentities($_GET['passengername']);
$number = htmlentities($_GET['number']);
// $vehicle = htmlentities($_GET['vehicle']);
// $remarks = htmlentities($_GET['remarks']);
$idcard = htmlentities($_GET['idcard']);
$countrycode = htmlentities($_GET['countryCode']);
echo $countrycode . "\n";
//concatenating the country code with the phone number
$number = $countrycode . " " . $number;
echo $name;
echo $number;
echo $idcard;

$serverName = "DESKTOP-HA0C2O5\SQLEXPRESS"; //serverName\instanceName

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
$connectionInfo = array( "Database"=>"TestingWithDB");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
    echo "Connection established.<br />";
}else{
    echo "Connection could not be established.<br />";
    die( print_r( sqlsrv_errors(), true));
}
//checking if the passenger exists in dbo.passenger
//if they are not registered, register them
if(checkPassenger($idcard, $conn) == 0) {
    //finding the next PID number
    findLargest($highest, $conn);
    $highest += 1;
    //input the passenger's information
    $query = "SET IDENTITY_INSERT dbo.Passengers ON
 INSERT INTO dbo.Passengers(PID, PassengerIDCard, PassengerName, ContactNumber)
        VALUES($highest, '$idcard', '$name', '$number');";
    $result = sqlsrv_query($conn, $query);
    if (!$result) {
        die(print_r(sqlsrv_errors(), true));

    }
    echo "Added to Database!";
} else{
    echo "Welcome Back!";
}
//START OF TRIPS DB
$vehicle1 = htmlentities($_GET['vehicle1']);
$reg1 = htmlentities($_GET['reg1']);
$vehicle2 = htmlentities($_GET['vehicle2']);
$reg2 = htmlentities($_GET['reg2']);
$vehicle3 = htmlentities($_GET['vehicle3']);
$reg3 = htmlentities($_GET['reg3']);
$vehicle4 = htmlentities($_GET['vehicle4']);
$reg4 = htmlentities($_GET['reg4']);

$ID = 0;
findLargestID($ID, $conn);
$ID +=1;
$query = "SET IDENTITY_INSERT dbo.Trips ON
INSERT INTO dbo.Trips(ID, Vehicle_1, Registration_1,Vehicle_2, Registration_2, Vehicle_3, Registration_3, Vehicle_4, Registration_4)
VALUES ($ID, '$vehicle1', '$reg1', '$vehicle2', '$reg2', '$vehicle3', '$reg3', '$vehicle4', '$reg4')";
$result = sqlsrv_query($conn, $query);
    if (!$result) {
        die(print_r(sqlsrv_errors(), true));

    }
    echo "Added to Database!";

?>
<br><br>
<h2><a href="../mainMenu.html">Return to Menu</a></h2>
</html>
