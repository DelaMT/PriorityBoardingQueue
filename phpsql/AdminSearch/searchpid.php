<!-- SEARCH THE DATABASE FOR A MATCHING PID
ALSO DISPLAY PASSENGERS LAST PRIORITY BORADING DATE
ALSO DISPLAY VEHICLES THAT PASSENGER HAS REGISTERED-->
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
        $id = $_POST['personid'];

        $serverName = "192.168.5.20\sqlexpress";
        $connectionInfo = array( "Database"=>"PriorityBoarding","UID"=>"daniel.sumler", "PWD"=>"12345");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);

        if( !$conn ) {
            echo "Connection could not be established.<br />";
            die( print_r( sqlsrv_errors(), true));
        }
        $query_id = "SELECT PID, PassengerIDCard, PassengerName, ContactNumber FROM dbo.Passengers WHERE PID = $id;";
        $rowSQL = sqlsrv_query($conn, $query_id);

        while (($row = sqlsrv_fetch_array($rowSQL))!=NULL){
            echo "<tr><td style='text-align:center;'>" . $row['PID'] . "</td><td style='text-align:center;'>" . $row['PassengerName'] . "</td><td style='text-align:center;'>" . $row['PassengerIDCard'] . "</td><td style='text-align:center;'>" . $row['ContactNumber'] . "</td></tr>";
        }

        ?>
    </tr>
</table>
<br><br>
<h1>Registered Vehicles :</h1>
<table style="width:50%;">
    <tr>
        <th><h2>Registration ID</h2></th>
        <th><h2>Vehicle Make</h2></th>
        <th><h2>ID Card no.</h2></th>
    </tr>
        <?php
        $id = $_POST['personid'];

        $query_priority1 = "Select DISTINCT Vehicle.Registration_ID, Vehicle.Vehicle_Make, Vehicle.PassengerIDCard
        FROM dbo.Vehicle INNER JOIN dbo.Passengers ON Vehicle.PassengerIDCard=Passengers.PassengerIDCard
        INNER JOIN dbo.Main ON Passengers.PID=Main.PID
        WHERE Main.PID=$id;";

        $rowSQL = sqlsrv_query($conn, $query_priority1);
        //die(print_r(sqlsrv_errors(), true));
        while (($row = sqlsrv_fetch_array($rowSQL))!=NULL){
            echo "<tr><td style='text-align:center;'>" . $row['Registration_ID'] . "</td><td style='text-align:center;'>" . $row['Vehicle_Make'] . "</td><td style='text-align:center;'>" . $row['PassengerIDCard'] . "</td></tr>";
        }

        ?>
    </table>
    <br><br>

<h1>Last Priority Boarding details :</h1>
<br>
<table style="width:50%;" class="mgarrtable">
    <tr>
        <th><h2>PID</h2></th>
        <th><h2>Mgarr - Date of travel FROM</h2></th>
        <th><h2>Time</h2></th>
    </tr>
        <?php
        $id = $_POST['personid'];

       $query_priority1 = "Select TOP 1 PID, Mgarr_Date_of_travel_from, Mgarr_Specific_Trip_1 FROM dbo.Main WHERE PID = $id
     ORDER BY Mgarr_Date_of_travel_from DESC, Mgarr_Specific_Trip_1 DESC;";

        $rowSQL = sqlsrv_query($conn, $query_priority1);
        //die(print_r(sqlsrv_errors(), true));
        while (($row = sqlsrv_fetch_array($rowSQL))!=NULL){
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

            echo "<tr><td style='text-align:center;'>" . $row['PID'] . "</td><td style='text-align:center;'>" . $temp . "</td><td style='text-align:center;'>" . $temp2 . "</td></tr>";
        }

        ?>
</table>
<br><br>
<table style="width:50%;" class="mgarrtable">
    <tr>
        <th><h2>PID</h2></th>
        <th><h2>Mgarr - Date of travel TO</h2></th>
        <th><h2>Time</h2></th>
    </tr>
        <?php
        $query_priority2 = "Select TOP 1 PID, Mgarr_Date_of_travel_to, Mgarr_Specific_Trip_2 FROM dbo.Main WHERE PID = $id
        ORDER BY Mgarr_Date_of_travel_to DESC, Mgarr_Specific_Trip_2 DESC;";

        $rowSQL = sqlsrv_query($conn, $query_priority2);
        //die(print_r(sqlsrv_errors(), true));
        while (($row = sqlsrv_fetch_array($rowSQL))!=NULL){
            $temp = $row['Mgarr_Date_of_travel_to'];
            if($row['Mgarr_Date_of_travel_to'] != NULL) {
                $temp = date("Y-m-d", strtotime($row['Mgarr_Date_of_travel_to']->format('Y-m-d')));
            }else{
                $row['Mgarr_Date_of_travel_to'] = "N/A";
                $temp = "N/A";
            }
            if($row['Mgarr_Specific_Trip_2'] != NULL) {
                $temp2 = date("H:i:s", strtotime($row['Mgarr_Specific_Trip_2']->format('H:i:s')));
            } else{
                $row['Mgarr_Specific_Trip_2'] = "N/A";
                $temp2="N/A";
            }

            echo "<tr><td style='text-align:center;'>" . $row['PID'] . "</td><td style='text-align:center;'>" . $temp . "</td><td style='text-align:center;'>" . $temp2 . "</td></tr>";
        }
        ?>
</table>
<br><br>
<table style="width:50%;" class="cirkewwatable">
    <tr>
        <th><h2>PID</h2></th>
        <th><h2>Cirkewwa - Date of travel TO</h2></th>
        <th><h2>Time</h2></th>
    </tr>
        <?php
        $query_priority2 = "Select TOP 1 PID, Cirkewwa_Date_of_travel_to, Cirkewwa_Specific_Trip_1 FROM dbo.Main WHERE PID = $id
        ORDER BY Cirkewwa_Date_of_travel_to DESC, Cirkewwa_Specific_Trip_1 DESC;";

        $rowSQL = sqlsrv_query($conn, $query_priority2);
        //die(print_r(sqlsrv_errors(), true));
        while (($row = sqlsrv_fetch_array($rowSQL))!=NULL){
            $temp = $row['Cirkewwa_Date_of_travel_to'];
            if($row['Cirkewwa_Date_of_travel_to'] != NULL) {
                $temp = date("Y-m-d", strtotime($row['Cirkewwa_Date_of_travel_to']->format('Y-m-d')));
            }else{
                $row['Cirkewwa_Date_of_travel_to'] = "N/A";
                $temp = "N/A";
            }
            if($row['Cirkewwa_Specific_Trip_1'] != NULL) {
                $temp2 = date("H:i:s", strtotime($row['Cirkewwa_Specific_Trip_1']->format('H:i:s')));
            } else{
                $row['Cirkewwa_Specific_Trip_1'] = "N/A";
                $temp2="N/A";
            }

        echo "<tr><td style='text-align:center;'>" . $row['PID'] . "</td><td style='text-align:center;'>" . $temp . "</td><td style='text-align:center;'>" . $temp2 . "</td></tr>";
    }
    ?>
</table>
<br><br>
<table style="width:50%;" class="cirkewwatable">
    <tr>
        <th><h2>PID</h2></th>
        <th><h2>Cirkewwa - Date of travel TO</h2></th>
        <th><h2>Time</h2></th>
    </tr>
        <?php
        $query_priority2 = "Select TOP 1 PID, Cirkewwa_Date_of_travel_from, Cirkewwa_Specific_Trip_2 FROM dbo.Main WHERE PID = $id
        ORDER BY Cirkewwa_Date_of_travel_from DESC, Cirkewwa_Specific_Trip_2 DESC;";

        $rowSQL = sqlsrv_query($conn, $query_priority2);
        //die(print_r(sqlsrv_errors(), true));
        while (($row = sqlsrv_fetch_array($rowSQL))!=NULL){
            $temp = $row['Cirkewwa_Date_of_travel_from'];
            if($row['Cirkewwa_Date_of_travel_from'] != NULL) {
                $temp = date("Y-m-d", strtotime($row['Cirkewwa_Date_of_travel_from']->format('Y-m-d')));
            }else{
                $row['Cirkewwa_Date_of_travel_from'] = "N/A";
                $temp = "N/A";
            }
            if($row['Cirkewwa_Specific_Trip_2'] != NULL) {
                $temp2 = date("H:i:s", strtotime($row['Cirkewwa_Specific_Trip_2']->format('H:i:s')));
            } else{
                $row['Cirkewwa_Specific_Trip_2'] = "N/A";
                $temp2="N/A";
            }

            echo "<tr><td style='text-align:center;'>" . $row['PID'] . "</td><td style='text-align:center;'>" . $temp . "</td><td style='text-align:center;'>" . $temp2 . "</td></tr>";
        }
        ?>
</table>
<br><br><br><br>
    <h2><a href="../AdminAdd.php">GO BACK</a></h2>
<br>
    <form action="./ViewAllBoarding.php" method="post">
        <?php
        echo '<input type="hidden" name="personid" value="'.
     $id.'">';
        ?>
        <input type="submit" value="View All Boardings" >
    </form>
</body>
</html>


<?php
