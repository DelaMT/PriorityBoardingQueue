<!DOCTYPE html>
<html>


<?php
//START OF SETTING PASSENGER DB
require 'PassengerMethods.php';
require 'VehicleMethods.php';
require 'RemarkMethods.php';
require 'MainMethods.php';
require 'ExtraReqMethods.php';
$changes = [false, false];
$highest=0;
$name = htmlentities($_GET['passengername']);
$number = htmlentities($_GET['number']);
$idcard = htmlentities($_GET['idcard']);
$countrycode = htmlentities($_GET['countryCode']);

//concatenating the country code with the phone number
if($number != NULL) {
    $number = $countrycode . " " . $number;
}
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
    //echo "Added to Database!";
}else{


   // echo "Welcome Back!";
    if(checkName($idcard, $name, $conn)==false){
        $changes[0] = true;
        $sql = "SELECT PassengerName AS name FROM dbo.Passengers WHERE PassengerIDCard = '$idcard';";
        $result = sqlsrv_query($conn, $sql);
        $row = sqlsrv_fetch_array($result);
        $oldname = $row["name"];

        echo "<h2>Update passenger's name with id no. " . $idcard . " from " . $oldname . " to " . $name . " in database?</h2>
        <form action='updatingname.php' method='post' id='form1' name='form1'>
        <input type='hidden' value=" . $oldname . " id='oldname' name='oldname'>
        <input type='hidden' value=" . $name . " id='name' name='name'>
        <input type='hidden' value=" . $idcard . " id='idcard' name='idcard'> 
        <input type='submit' form='form1' value='UPDATE NAME'>
        </form>";
    } else{
        $oldname = NULL;
    }

    if($number != NULL){
        if(checkContactNum($idcard, $number, $conn) == false) {
            $changes[1] = true;
            $sql = "SELECT ContactNumber AS number FROM dbo.Passengers WHERE PassengerIDCard = '$idcard';";
            $result = sqlsrv_query($conn, $sql);
            $row = sqlsrv_fetch_array($result);
            $oldnumber = $row["number"];
            if ($oldnumber != $number && $number != NULL) {
                echo "<h2>Update passenger's contact number with ID card '$idcard' from " . $oldnumber . " to " . $number . " in database?</h2>
        <form action='updatingnumber.php' method='post' id='form2' name='form2'>
        <input type='hidden' value='$oldnumber' name='oldnumber' id='oldnumber'>
        <input type='hidden' value='$number' name='number' id='number'>
        <input type='hidden' value=" . $idcard . " name='idcard' id='idcard'>
        <input type='submit' form='form2' value='UPDATE CONTACT NUMBER'>
        </form>
        <!--<button type='submit' form='form2' value='UPDATE CONTACT NUMBER'>UPDATE CONTACT NUMBER</button>-->";
            }
        }
    }

    if($changes[0] == true && $changes[1] == true){
        echo "<h2>Update both name and contact number?</h2>
        <form action='updateboth.php' method='post' id='form3'>
        <input type='hidden' value='$oldnumber' name='oldnumber' id='oldnumber'>
        <input type='hidden' value='$number' name='number' id='number'>
        <input type='hidden' value=" . $oldname . " id='oldname' name='oldname'>
        <input type='hidden' value=" . $name . " id='name' name='name'>
        <input type='hidden' value=" . $idcard . " id='idcard' name='idcard'> 
        <input type='submit' value='UPDATE BOTH' form='form3'>
        </form>";
    }

    //UPDATE CONTACT NUMBER
  //  $query = "UPDATE dbo.Passengers SET ContactNumber = '$number', PassengerName = '$name' WHERE PassengerIDCard = '$idcard';";
  //  $result = sqlsrv_query($conn, $query);
   // if (!$result) {
   //     die(print_r(sqlsrv_errors(), true));


   // echo "Welcome Back!";
}

$reason = htmlentities($_GET['reason']);
echo "<br><br><br>
    <form action='remarks.php' method='post' id='form4'>
    <input type='hidden' value=" . $reason ." id='reason' name='reason'>
    <input type='submit' form='form4' value='IGNORE AND VIEW REMARK'>
    </form>";
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

//START OF MAIN DB
$extrareqs = htmlentities($_GET['er']);
echo "extra reqs is $extrareqs";
$extrareqs=getReqID($extrareqs, $conn);

$remarkid = getRemarkID($reason, $conn);


$PID = findPID($idcard, $conn);

$ID = 0;
findLargestID($ID, $conn);
$ID += 1;
$mgarrtrip1 = htmlentities($_GET['mgarr']);
$cirkewwatrip1 = htmlentities($_GET['cirkewwa']);
$mgarrtrip2 = htmlentities($_GET['mgarr2']);
$cirkewwatrip2 = htmlentities($_GET['cirkewwa2']);

$query = "INSERT INTO dbo.Main(ID, PID, ER_ID, Registration_1, Registration_2, Registration_3, Registration_4, Mgarr_Trips_1, Mgarr_Trips_2, Cirkewwa_Trips_1, Cirkewwa_Trips_2, RemarksID)
 VALUES($ID, $PID, '$extrareqs', '$reg1', '$reg2', '$reg3', '$reg4', '$mgarrtrip1', '$mgarrtrip2', '$cirkewwatrip1', '$cirkewwatrip2', $remarkid)";

$result = sqlsrv_query($conn, $query);
if (!$result) {
    die(print_r(sqlsrv_errors(), true));
}
echo "Added to Database!";

if(($mgarrtrip1 = htmlentities($_GET['mgarr']))=="specific") {
    $mgarrdate1 = htmlentities($_GET['mgarrdate']);
    $mgarrtime1 = htmlentities($_GET['mgarrtime']);
    $mgarrdate1=date("Y-m-d",strtotime($mgarrdate1));
    $query_update = "UPDATE dbo.Main SET Mgarr_Date_of_travel_from='$mgarrdate1',Mgarr_Specific_Trip_1='$mgarrtime1' WHERE ID=$ID;";
    $result = sqlsrv_query($conn, $query_update);
} else if(($mgarrtrip1 = htmlentities($_GET['mgarr']))=="open"){
    $mgarrdate1 = htmlentities($_GET['mgarrdate']);
    $query_update = "UPDATE dbo.Main SET Mgarr_Date_of_travel_from='$mgarrdate1' WHERE ID=$ID;";
    $result = sqlsrv_query($conn, $query_update);
}
if(($cirkewwatrip1 = htmlentities($_GET['cirkewwa']))=="specific") {
    $cirkewwadate1 = htmlentities($_GET['cirkewwadate']);
    $cirkewwatime1 = htmlentities($_GET['cirkewwatime']);
    $cirkewwadate1=date("Y-m-d",strtotime($cirkewwadate1));
    $query_update = "UPDATE dbo.Main SET Cirkewwa_Date_of_travel_to='$cirkewwadate1',Cirkewwa_Specific_Trip_1='$cirkewwatime1' WHERE ID=$ID;";
    $result = sqlsrv_query($conn, $query_update);
} else if(($cirkewwatrip1 = htmlentities($_GET['cirkewwa']))=="open"){
    $cirkewwadate1 = htmlentities($_GET['cirkewwadate']);
    $query_update = "UPDATE dbo.Main SET Cirkewwa_Date_of_travel_to='$cirkewwadate1' WHERE ID=$ID;";
    $result = sqlsrv_query($conn, $query_update);
}
if(($mgarrtrip2 = htmlentities($_GET['mgarr2']))=="specific") {
    $mgarrdate2 = htmlentities($_GET['mgarrdate2']);
    $mgarrtime2 = htmlentities($_GET['mgarrtime2']);
    $mgarrdate2=date("Y-m-d",strtotime($mgarrdate2));
    $query_update = "UPDATE dbo.Main SET Mgarr_Date_of_travel_to='$mgarrdate2',Mgarr_Specific_Trip_2='$mgarrtime2' WHERE ID=$ID;";
    $result = sqlsrv_query($conn, $query_update);
} else if(($mgarrtrip2 = htmlentities($_GET['mgarr2']))=="open"){
    $mgarrdate2 = htmlentities($_GET['mgarrdate2']);
    $query_update = "UPDATE dbo.Main SET Mgarr_Date_of_travel_to='$mgarrdate2' WHERE ID=$ID;";
    $result = sqlsrv_query($conn, $query_update);
}
if(($cirkewwatrip2 = htmlentities($_GET['cirkewwa2']))=="specific") {
    $cirkewwadate2 = htmlentities($_GET['cirkewwadate2']);
    $cirkewwatime2 = htmlentities($_GET['cirkewwatime2']);
    $cirkewwadate2=date("Y-m-d",strtotime($cirkewwadate2));
    $query_update = "UPDATE dbo.Main SET Cirkewwa_Date_of_travel_from='$cirkewwadate2',Cirkewwa_Specific_Trip_2='$cirkewwatime2' WHERE ID=$ID;";
    $result = sqlsrv_query($conn, $query_update);
} else if(($cirkewwatrip2 = htmlentities($_GET['cirkewwa2']))=="open"){
    $cirkewwadate2 = htmlentities($_GET['cirkewwadate2']);
    $query_update = "UPDATE dbo.Main SET Cirkewwa_Date_of_travel_from='$cirkewwadate2' WHERE ID=$ID;";
    $result = sqlsrv_query($conn, $query_update);
}

//START OF MAINVEHICLE DB
$MVID = 0;
findLargestMVID($MVID, $conn);
inputReg($reg1, $MVID, $ID, $conn);
inputReg($reg2, $MVID, $ID, $conn);
inputReg($reg3, $MVID, $ID, $conn);
inputReg($reg4, $MVID, $ID, $conn);

?>
<br><br>
<h2><a href="../mainMenu.html">Return to Menu</a></h2>
</html>
