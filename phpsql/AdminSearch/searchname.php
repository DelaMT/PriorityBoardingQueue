<html>
<head>
    <link rel="stylesheet" type="text/css" href="../AdminUtil.css"/>

</head>
<body>
<table style="width:100%;">
    <tr>
        <th><h2>PID</h2></th>
        <th><h2>Passenger Name</h2></th>
        <th><h2>ID Card no.</h2></th>
        <th><h2>Contact Number</h2></th>
    </tr>
    <tr>
<?php
$name = $_POST['personname'];

$serverName = "192.168.5.20\sqlexpress";
$connectionInfo = array( "Database"=>"PriorityBoarding","UID"=>"daniel.sumler", "PWD"=>"12345");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( !$conn ) {
    echo "Connection could not be established.<br />";
    die( print_r( sqlsrv_errors(), true));
}
$query_id = "SELECT PID, PassengerIDCard, PassengerName, ContactNumber FROM dbo.Passengers WHERE PassengerName = '$name';";
$rowSQL = sqlsrv_query($conn, $query_id);
    while (($row = sqlsrv_fetch_array($rowSQL))!=NULL){
		//echo \"<option value=\"'.$row['reason'] .'\">\" . $row['reason'] . \"</option>\";
        echo "the row pid is -> " . $row['PID'];
		echo "<tr><td style='text-align:center;'>" . $row['PID'] . "</td><td style='text-align:center;'>" . $row['PassengerName'] . "</td><td style='text-align:center;'>" . $row['PassengerIDCard'] . "</td><td style='text-align:center;'>" . $row['ContactNumber'] . "</td></tr>";
	}
?>
</tr>
</table>
<br><br>
<h1>Last Priority Boarding details :</h1>
<br>
<table style="width:100%;">
    <tr>
        <th><h2>PID</h2></th>
        <th><h2>Mgarr - Date of travel FROM</h2></th>
        <th><h2>Time</h2></th>
       <!-- <th><h2>Cirkewwa - Date of travel FROM</h2></th>
        <th><h2>Cirkewwa - Date of travel TO</h2></th>
        <th><h2>Extra Requirements</h2></th>
        <th><h2>Reason</h2></th>-->
    </tr>
    <tr>
        <?php

        $query_priority1 = "SELECT p.PID, MAX(m.Mgarr_Date_of_travel_from), m.Mgarr_Specific_Trip_1 
        FROM dbo.Main m INNER JOIN dbo.Passengers p ON p.PID=m.PID
        WHERE p.PassengerName = '$name'
        GROUP BY p.PID, m.Mgarr_Specific_Trip_1;";

        /*$query_priority2 = "SELECT PID, MAX(Mgarr_Date_of_travel_to), Mgarr_Specific_Trip_2;
        FROM dbo.Main
        WHERE PassengerName = '$name'
        GROUP BY Mgarr_Specific_Trip_1, PID;";

        $query_priority3 = "SELECT PID, MAX(Cirkewwa_Date_of_travel_to), Cirkewwa_Specific_Trip_1;
        FROM dbo.Main
        WHERE PassengerName = '$name'
        GROUP BY Mgarr_Specific_Trip_1, PID;";

        $query_priority4 = "SELECT PID, MAX(Cirkewwa_Date_of_travel_from), Cirkewwa_Specific_Trip_2;
        FROM dbo.Main
        WHERE PassengerName = '$name'
        GROUP BY Mgarr_Specific_Trip_1, PID;";*/

        $rowSQL = sqlsrv_query($conn, $query_priority1);
        while (($row = sqlsrv_fetch_array($rowSQL))!=NULL){
            //echo \"<option value=\"'.$row['reason'] .'\">\" . $row['reason'] . \"</option>\";
            echo "<tr><td style='text-align:center;'>" . $row['PID'] . "</td><td style='text-align:center;'>" . $row['Mgarr_Date_of_travel_from'] . "</td><td style='text-align:center;'>" . $row['Mgarr_Specific_Trip_1'] . "</td></tr>";
        }

        ?>


</body>
</html>