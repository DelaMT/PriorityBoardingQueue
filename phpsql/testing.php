<!DOCTYPE html>
<html>

<?php
//START OF SETTING PASSENGER DB
require 'PassengerMethods.php';
require 'VehicleMethods.php';
require 'RemarkMethods.php';
require 'MainMethods.php';

$highest=0;
$name = htmlentities($_GET['passengername']);
$number = htmlentities($_GET['number']);
$idcard = htmlentities($_GET['idcard']);
$countrycode = htmlentities($_GET['countryCode']);
echo $countrycode . "\n";

//concatenating the country code with the phone number
$number = $countrycode . " " . $number;
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
//checking if the passenger exists in dbo.passenger
//if they are not registered, register them

if(checkPassenger($idcard, $conn) == 0) {
    //finding the next PID number
    findLargest($highest, $conn);
    $highest += 1;
    //input the passenger's information
    $query = "INSERT INTO dbo.Passengers(PID, PassengerIDCard, PassengerName, ContactNumber)
        VALUES($highest, '$idcard', '$name', '$number');";
    $result = sqlsrv_query($conn, $query);
    if (!$result) {
        die(print_r(sqlsrv_errors(), true));

    }
    echo "Added to Database!";
} else{
    echo "Welcome Back!";
}

//START OF VEHICLE DB
$vehicle1 = htmlentities($_GET['vehicle1']);
$reg1 = htmlentities($_GET['reg1']);
$vehicle2 = htmlentities($_GET['vehicle2']);
$reg2 = htmlentities($_GET['reg2']);
$vehicle3 = htmlentities($_GET['vehicle3']);
$reg3 = htmlentities($_GET['reg3']);
$vehicle4 = htmlentities($_GET['vehicle4']);
$reg4 = htmlentities($_GET['reg4']);
//IF THE VEHICLE IS NOT NULL AND TEH REGISTRATION HASNT ALREADY BEEN REGISTERED, ADD THE VEHICLE TO THE DB
if(DetectVehicle($vehicle1, $reg1)==true && checkReg($reg1, $conn) == 0){
    addVehicle($vehicle1, $reg1, $idcard, $conn);
}
if(DetectVehicle($vehicle2, $reg2)==true && checkReg($reg2, $conn) == 0){
    addVehicle($vehicle2, $reg2, $idcard, $conn);
}
if(DetectVehicle($vehicle3, $reg3)==true && checkReg($reg3, $conn) == 0){
    addVehicle($vehicle3, $reg3, $idcard, $conn);
}
if(DetectVehicle($vehicle4, $reg4)==true && checkReg($reg4, $conn) == 0){
    addVehicle($vehicle4, $reg4, $idcard, $conn);
}

//START OF REMARK DB
$reason = htmlentities($_GET['reason']);
if(($rem = fetchRemark($reason, $conn))!=NULL) {
    echo
    "<table style='border:solid; width:600px; margin:0 auto;'>
    <thead>
    <th style='border: solid 10px; width: 600px; margin:0 auto;'>
    <h3 style='font-size:50px; padding:0px;'><strong>ATTENTION</strong></h3>
    </th>
    </thead>
    <tbody>
    <td style='border:solid; text-align:center;'>
    <h4 style='font-size:30px;'>'$rem'</h4>
    </td>
    </tbody>
    </table>";
}

//START OF MAIN DB
$extrareqs = htmlentities($_GET['er']);
$mgarrtrip1 = htmlentities($_GET['mgarr']);
$mgarrdate1 = htmlentities($_GET['mgarrdate']);
$mgarrtime1 = htmlentities($_GET['mgarrtime']);
$cirkewwatrip1 = htmlentities($_GET['cirkewwa']);
$cirkewwadate1 = htmlentities($_GET['cirkewwadate']);
$cirkewwatime1 = htmlentities($_GET['cirkewwatime']);
$mgarrtrip2 = htmlentities($_GET['mgarr2']);
$mgarrdate2 = htmlentities($_GET['mgarrdate2']);
$mgarrtime2 = htmlentities($_GET['mgarrtime2']);
$cirkewwatrip2 = htmlentities($_GET['cirkewwa2']);
$cirkewwadate2 = htmlentities($_GET['cirkewwadate2']);
$cirkewwatime2 = htmlentities($_GET['cirkewwatime2']);
$remarkid = getRemarkID($reason, $conn);
$ID = 0;
findLargestID($ID, $conn);
$ID += 1;

//START OF MAIN/VEHICLE DB
$query = "INSERT INTO dbo.Main()
        VALUES();";
$result = sqlsrv_query($conn, $query);
if (!$result) {
    die(print_r(sqlsrv_errors(), true));
}
echo "Added to Database!";



checkFerry($mgarrtrip1, $mgarrtime1, $mgarrdate1);
checkFerry($mgarrtrip2, $mgarrtime2, $mgarrdate2);
checkFerry($cirkewwatrip1, $cirkewwatime1, $cirkewwadate1);
checkFerry($cirkewwatrip2, $cirkewwatime2, $cirkewwadate2);

$PID = findPID($idcard, $conn);
//echo "\n\n\nThe found PID is $PID\n\n\n";

$query = "INSERT INTO dbo.Main(ID, PID, Extra_Requirements, Registration_1, Registration_2, Registration_3, Registration_4, Mgarr_Date_of_travel_from, Mgarr_Trips_1,
Mgarr_Specific_Trip_1, Mgarr_Date_of_travel_to, Mgarr_Trips_2, Mgarr_Specific_Trip_2, Cirkewwa_Date_of_travel_from, Cirkewwa_Trips_1, Cirkewwa_Specific_Trip_1, Cirkewwa_Date_of_travel_to,
Cirkewwa_Trips_2, Cirkewwa_Specific_Trip_2, RemarksID)
        VALUES($ID, $PID, '$extrareqs', '$reg1', '$reg2', '$reg3', '$reg4', '$mgarrdate1', '$mgarrtrip1', '$mgarrtime1', '$mgarrdate2', '$mgarrtrip2', '$mgarrtime2', '$cirkewwadate1', '$cirkewwatrip1', '$cirkewwatime1',
         '$cirkewwadate2', '$cirkewwatrip2', '$cirkewwatime2', $remarkid);";
    $result = sqlsrv_query($conn, $query);
    if (!$result) {
        die(print_r(sqlsrv_errors(), true));
    }
    echo "Added to Database!";

?>
<br><br>
<h2><a href="../mainMenu.html">Return to Menu</a></h2>
</html>
