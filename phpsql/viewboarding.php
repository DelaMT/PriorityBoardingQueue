<?php
$serverName = "192.168.5.20\sqlexpress"; //serverName\instanceName

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
$connectionInfo = array( "Database"=>"PriorityBoarding","UID"=>"daniel.sumler", "PWD"=>"12345");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( !$conn ) {
    echo "Connection could not be established.<br />";
    die( print_r( sqlsrv_errors(), true));
}


?>
<table style="width:50%;" class="mgarrtable">

    <?php
    $boardingid = $_POST['bid'];

    $query_priority1 = "SELECT Main.ID, Main.PID, Extra_Reqs.Extra_Requirements, Passengers.PassengerIDCard, Passengers.PassengerName, Passengers.ContactNumber, Main.Mgarr_Date_of_travel_from, Main.Mgarr_Specific_Trip_1, Main.Mgarr_Date_of_travel_to, Main.Mgarr_Specific_Trip_2, Main.Cirkewwa_Date_of_travel_to, Main.Cirkewwa_Specific_Trip_1, Main.Cirkewwa_Date_of_travel_from, Main.Cirkewwa_Specific_Trip_2, Remarks.Reason, Main.Registration_1, Main.Registration_2, Main.Registration_3, Main.Registration_4, Vehicle.Vehicle_Make  
    FROM dbo.Main INNER JOIN dbo.Passengers ON Main.PID=Passengers.PID 
    INNER JOIN dbo.Extra_Reqs ON Main.ER_ID=Extra_Reqs.ER_ID
    INNER JOIN dbo.Remarks ON Main.RemarksID = Remarks.Remark_ID
    INNER JOIN dbo.MainVehicle ON Main.ID = MainVehicle.Main_ID
    INNER JOIN dbo.Vehicle ON MainVehicle.Registration_ID = Vehicle.Registration_ID
    WHERE Main.ID = $boardingid;";

    $rowSQL = sqlsrv_query($conn, $query_priority1);
    while (($row = sqlsrv_fetch_array($rowSQL))!=NULL){
        echo"<table style=\"width:50%; margin-left:auto; margin-right:auto;\" class=\"mgarrtable\">";
        echo"<tr>
        <th><h2>ID</h2></th>
        <th><h2>PID</h2></th>
        <th><h2>Passenger ID Card No.</h2></th>
        <th><h2>Passenger Name</h2></th>
        <th><h2>Extra Reqs</h2></th>
        <th><h2>Reason</h2></th>
    </tr>";
        echo "<tr><td style='text-align:center;'>" . $row['ID'] . "</td><td style='text-align:center;'>" . $row['PID'] . "</td><td style='text-align:center;'>"
            . $row['PassengerIDCard'] . "</td><td style='text-align:center;'>"
            . $row['PassengerName'] . "</td><td style='text-align:center;'>"
            . $row['Extra_Requirements'] . "</td><td style='text-align:center;'>" . $row['Reason'] . "</td></tr>";

        $temp = $row['Mgarr_Date_of_travel_from'];
        if($row['Mgarr_Date_of_travel_from'] != NULL) {
            $temp = date("Y-m-d", strtotime($row['Mgarr_Date_of_travel_from']->format('Y-m-d')));
        }else{
            $row['Mgarr_Date_of_travel_from'] = "N/A";
            $temp = "N/A";
        }
        if($row['Mgarr_Specific_Trip_1'] != NULL) {
            $temp2 = date("H:i:s", strtotime($row['Mgarr_Specific_Trip_1']->format('H:i:s')));
        } else{
            $row['Mgarr_Specific_Trip_1'] = "N/A";
            $temp2="N/A";
        }
        $temp3 = $row['Mgarr_Date_of_travel_to'];
        if($row['Mgarr_Date_of_travel_to'] != NULL) {
            $temp3 = date("Y-m-d", strtotime($row['Mgarr_Date_of_travel_to']->format('Y-m-d')));
        }else{
            $row['Mgarr_Date_of_travel_to'] = "N/A";
            $temp3 = "N/A";
        }
        if($row['Mgarr_Specific_Trip_2'] != NULL) {
            $temp4 = date("H:i:s", strtotime($row['Mgarr_Specific_Trip_2']->format('H:i:s')));
        } else{
            $row['Mgarr_Specific_Trip_2'] = "N/A";
            $temp4="N/A";
        }
        $temp5 = $row['Cirkewwa_Date_of_travel_to'];
        if($row['Cirkewwa_Date_of_travel_to'] != NULL) {
            $temp5 = date("Y-m-d", strtotime($row['Cirkewwa_Date_of_travel_to']->format('Y-m-d')));
        }else{
            $row['Cirkewwa_Date_of_travel_to'] = "N/A";
            $temp5 = "N/A";
        }
        if($row['Cirkewwa_Specific_Trip_1'] != NULL) {
            $temp6 = date("H:i:s", strtotime($row['Cirkewwa_Specific_Trip_1']->format('H:i:s')));
        } else{
            $row['Cirkewwa_Specific_Trip_1'] = "N/A";
            $temp6="N/A";
        }
        $temp7 = $row['Cirkewwa_Date_of_travel_from'];
        if($row['Cirkewwa_Date_of_travel_from'] != NULL) {
            $temp7 = date("Y-m-d", strtotime($row['Cirkewwa_Date_of_travel_from']->format('Y-m-d')));
        }else{
            $row['Cirkewwa_Date_of_travel_from'] = "N/A";
            $temp7 = "N/A";
        }
        if($row['Cirkewwa_Specific_Trip_2'] != NULL) {
            $temp8 = date("H:i:s", strtotime($row['Cirkewwa_Specific_Trip_2']->format('H:i:s')));
        } else{
            $row['Cirkewwa_Specific_Trip_2'] = "N/A";
            $temp8="N/A";
        }

        $pid = $row['PID'];
        $er = $row['Extra_Requirements'];
        $reason = $row['Reason'];

        echo"<th><h2>Mgarr - FROM</h2></th>
        <th><h2>MTime - FROM</h2></th>
        <th><h2>Mgarr - TO</h2></th>
        <th><h2>MTime - TO</h2></th>";

        echo"<tr><td style='text-align:center;'>  $temp  </td><td style='text-align:center;'>  $temp2  </td><td style='text-align:center;'>  $temp3  </td>
<td style='text-align:center;'>  $temp4  </td></tr>";

        echo"<th><h2>Cirkewwa - TO</h2></th>
        <th><h2>CTime - TO</h2></th>
        <th><h2>Cirkewwa - FROM</h2></th>
        <th><h2>CTime - FROM</h2></th>";

        echo"<tr><td style='text-align:center;'>  $temp5  </td><td style='text-align:center;'>  $temp6  </td><td style='text-align:center;'>  $temp7  </td>
<td style='text-align:center;'>  $temp8  </td></tr>";

        echo"
        <th><h2>Vehicle Reg. 1</h2></th>
        <th><h2>Vehicle Reg. 2</h2></th>
        <th><h2>Vehicle Reg. 3</h2></th>
        <th><h2>Vehicle Reg. 4</h2></th>";
        if($row['Registration_1'] ==  NULL){
            $row['Registration_1'] = "N/A";
        }
        if($row['Registration_2'] ==  NULL){
            $row['Registration_2'] = "N/A";
        }
        if($row['Registration_3'] ==  NULL){
            $row['Registration_3'] = "N/A";
        }
        if($row['Registration_4'] ==  NULL){
            $row['Registration_4'] = "N/A";
        }
        echo"<tr><td style='text-align:center;'>" . $row['Registration_1'] . "</td><td style='text-align:center;'>" . $row['Registration_2'] . "</td><td style='text-align:center;'>" . $row['Registration_3'] . "</td>
<td style='text-align:center;'>" . $row['Registration_4'] . "</td></tr>";

        echo"</table>";
        echo"<br><br><br>";

    }

    $rowSQL = sqlsrv_query($conn, $query_priority1);

    echo"</table>
    
    <h3>ISSUE THIS BOOKING</h3>
<form action='issueboarding.php' method='post'>
    <label for='issuername'>ISSUER NAME</label>
    <input type='text' id='issuername' required>
    <br><br>
    <label for='issuedate'>DATE OF ISSUE</label>
    <input type='date' id='issuedate' required>
    <input type='hidden' id='bid' value='$boardingid'>
    <input type='submit' value='ISSUE BOOKING'>
</form>";


?>
