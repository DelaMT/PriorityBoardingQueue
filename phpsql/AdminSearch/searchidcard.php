<!-- SEARCH THE DATABASE FOR A MATCHING PID
ALSO DISPLAY PASSENGERS LAST PRIORITY BORADING DATE
ALSO DISPLAY VEHICLES THAT PASSENGER HAS REGISTERED-->
<html>
<head>
    <!-- BOOTSTRAP LINKS -->
    <link rel="stylesheet" href="../css/bootstrap/bootstrap.css">
    <!-- BOOTSTRAP LINKS -->
    <title>Search ID Card</title>
</head>
<body class="body-background-style">
<!-- NavBar -->
<nav class="navbar navbar-expand-sm bg-gozoChannelHeader navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item active">
            <a href="#" class="nav-logo-style"><img src="../GozoChannelLogo.png" height="49" alt=""></a>
        </li>
        <li class="nav-item active">
            <text class="nav-brand-style" href="">Searched ID Card</text>
        </li>
        <li class="nav-item active">
            <a class="nav-item-style" href="../AdminAdd.php">Back</a>
        </li>
        <li class="nav-item active">
            <a class="nav-item-style" href="../../mainMenu.html">Main Menu</a>
        </li>
    </ul>
</nav>
<!-- NavBar -->
<section class="mainSectionStyle">
    <table class="table table-bigBorder">
        <thead>
            <tr class="tableTitleText">
                <th><h2>PID</h2></th>
                <th><h2>Passenger Name</h2></th>
                <th><h2>ID Card no.</h2></th>
                <th><h2>Contact Number</h2></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                $id = $_POST['personidcard'];

                $serverName = "192.168.5.20\sqlexpress";
                $connectionInfo = array( "Database"=>"PriorityBoarding","UID"=>"daniel.sumler", "PWD"=>"12345");
                $conn = sqlsrv_connect( $serverName, $connectionInfo);

                if( !$conn ) {
                    echo "Connection could not be established.<br />";
                    die( print_r( sqlsrv_errors(), true));
                }
                $query_id = "SELECT PID, PassengerIDCard, PassengerName, ContactNumber FROM dbo.Passengers WHERE PassengerIDCard = '$id';";
                $rowSQL = sqlsrv_query($conn, $query_id);

                while (($row = sqlsrv_fetch_array($rowSQL))!=NULL){
                    echo "<tr class='tableResultText'><td>" . $row['PID'] . "</td><td>" . $row['PassengerName'] . "</td><td>" . $row['PassengerIDCard'] . "</td><td>" . $row['ContactNumber'] . "</td></tr>";
                }

                ?>
            </tr>
        </tbody>
    </table>
    <br>
    <h1 class="mainSubtitleTextStyleUnderlined">Registered Vehicles :</h1>
    <table class="table table-bigBorderHalved" style="width: 50%">
        <thead>
            <tr class="tableTitleText">
                <th><h2>Registration ID</h2></th>
                <th><h2>Vehicle Make</h2></th>
                <th><h2>ID Card no.</h2></th>
            </tr>
        </thead>
        <tbody>
        <?php
        $id = $_POST['personidcard'];

        $query_priority1 = "Select DISTINCT Vehicle.Registration_ID, Vehicle.Vehicle_Make, Vehicle.PassengerIDCard
            FROM dbo.Vehicle INNER JOIN dbo.Passengers ON Vehicle.PassengerIDCard=Passengers.PassengerIDCard
            INNER JOIN dbo.Main ON Passengers.PID=Main.PID
            WHERE Passengers.PassengerIDCard = '$id';";

        $rowSQL = sqlsrv_query($conn, $query_priority1);
        //die(print_r(sqlsrv_errors(), true));
        while (($row = sqlsrv_fetch_array($rowSQL))!=NULL){
            echo "<tr class='tableResultText'><td style='text-align:center;'>" . $row['Registration_ID'] . "</td><td style='text-align:center;'>" . $row['Vehicle_Make'] . "</td><td style='text-align:center;'>" . $row['PassengerIDCard'] . "</td></tr>";
        }

        ?>
        </tbody>
    </table>
    <br>
    <h1 class="mainSubtitleTextStyleUnderlined">Last Priority Boarding details :</h1>
    <table class="table table-bigBorderHalved" style="width: 50%">
        <thead>
            <tr class="tableTitleText">
                <th><h2>PID</h2></th>
                <th><h2>Mgarr - Date of travel FROM</h2></th>
                <th><h2>Time</h2></th>
            </tr>
        </thead>
        <tbody>
        <?php

        $query_priority1 = "Select TOP 1 Main.PID, Main.Mgarr_Date_of_travel_from, Main.Mgarr_Specific_Trip_1 
        FROM dbo.Main INNER JOIN dbo.Passengers ON Main.PID = Passengers.PID 
        WHERE Passengers.PassengerIDCard = '$id'
        ORDER BY Main.Mgarr_Date_of_travel_from DESC, Main.Mgarr_Specific_Trip_1 DESC;";

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

            echo "<tr class='tableResultText'><td style='text-align:center;'>" . $row['PID'] . "</td><td style='text-align:center;'>" . $temp . "</td><td style='text-align:center;'>" . $temp2 . "</td></tr>";
        }

        ?>
        </tbody>
    </table>
    <br>
    <table class="table table-bigBorderHalved" style="width: 50%">
        <thead>
            <tr class="tableTitleText">
                <th><h2>PID</h2></th>
                <th><h2>Mgarr - Date of travel TO</h2></th>
                <th><h2>Time</h2></th>
            </tr>
        </thead>
        <tbody>
        <?php
        $query_priority2 = "Select TOP 1 Main.PID, Main.Mgarr_Date_of_travel_to, Main.Mgarr_Specific_Trip_2 
        FROM dbo.Main INNER JOIN dbo.Passengers ON Main.PID = Passengers.PID 
        WHERE Passengers.PassengerIDCard = '$id'
        ORDER BY Main.Mgarr_Date_of_travel_to DESC, Main.Mgarr_Specific_Trip_2 DESC;";

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

            echo "<tr class='tableResultText'><td>" . $row['PID'] . "</td><td style='text-align:center;'>" . $temp . "</td><td style='text-align:center;'>" . $temp2 . "</td></tr>";
        }
        ?>
        </tbody>
    </table>
    <br>
    <table class="table table-bigBorderHalved" style="width: 50%">
        <thead>
        <tr class="tableTitleText">
            <th><h2>PID</h2></th>
            <th><h2>Cirkewwa - Date of travel FROM</h2></th>
            <th><h2>Time</h2></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $query_priority2 = "Select TOP 1 Main.PID, Main.Cirkewwa_Date_of_travel_from, Main.Cirkewwa_Specific_Trip_2 
        FROM dbo.Main INNER JOIN dbo.Passengers ON Main.PID = Passengers.PID 
        WHERE Passengers.PassengerIDCard = '$id'
        ORDER BY Main.Cirkewwa_Date_of_travel_from DESC, Main.Cirkewwa_Specific_Trip_2 DESC;";

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

            echo "<tr class='tableResultText'><td style='text-align:center;'>" . $row['PID'] . "</td><td style='text-align:center;'>" . $temp . "</td><td style='text-align:center;'>" . $temp2 . "</td></tr>";
        }
        ?>
        </tbody>
    </table>
    <br>
    <table class="table table-bigBorderHalved" style="width: 50%">
        <thead>
            <tr class="tableTitleText">
                <th><h2>PID</h2></th>
                <th><h2>Cirkewwa - Date of travel TO</h2></th>
                <th><h2>Time</h2></th>
            </tr>
        </thead>
        <tbody>
        <?php
        $query_priority2 = "Select TOP 1 Main.PID, Main.Cirkewwa_Date_of_travel_to, Main.Cirkewwa_Specific_Trip_1 
        FROM dbo.Main INNER JOIN dbo.Passengers ON Main.PID = Passengers.PID 
        WHERE Passengers.PassengerIDCard = '$id'
        ORDER BY Main.Cirkewwa_Date_of_travel_to DESC, Main.Cirkewwa_Specific_Trip_1 DESC;";

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

            echo "<tr class='tableResultText'><td>" . $row['PID'] . "</td><td style='text-align:center;'>" . $temp . "</td><td style='text-align:center;'>" . $temp2 . "</td></tr>";
        }
        ?>
        </tbody>
    </table>
    <br>
    <form action="./ViewAllBoardingIDCard.php" method="post">
        <?php
        echo '<input type="hidden" name="personidcard" value="'.
            $id.'">';
        ?>
        <input type="submit" value="View All Boardings" class="btn-gozoChannelOption" >
    </form>
</section>
</body>
</html>


<?php
