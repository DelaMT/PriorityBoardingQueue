<!DOCTYPE html>
<html>
<head>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
    <!-- BOOTSTRAP LINKS -->
    <link rel="stylesheet" href="../css/others/bootstrapCustom.css">
    <!-- BOOTSTRAP LINKS -->
    <title>View Boarding</title>
</head>
<body>
<!-- NavBar -->
<nav class="navbar navbar-expand-sm bg-gozoChannelHeader navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item active">
            <a href="#" class="nav-logo-style"><img src="../GozoChannelLogo.png" height="49" alt=""></a>
        </li>
        <li class="nav-item active">
            <text class="nav-brand-style" href="">All Boardings</text>
        </li>
        <li class="nav-item active">
            <a class="nav-item-style" href="../../mainMenu.html">Main Menu</a>
        </li>
        <li class="nav-item active">
            <a class="nav-item-style" href="#" onclick="window.print()">Print</a>
        </li>
    </ul>
</nav>
<br>
<!-- NavBar -->
<table style="width:50%;" class="mgarrtable">
    <?php
    $serverName = "192.168.5.20\sqlexpress";$connectionInfo = array( "Database"=>"PriorityBoarding","UID"=>"daniel.sumler", "PWD"=>"12345");
    $connectionInfo = array( "Database"=>"PriorityBoarding","UID"=>"daniel.sumler", "PWD"=>"12345");
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    $id = $_POST['personidcard'];


    $query_priority1 = "SELECT Main.ID, Main.PID, Extra_Reqs.Extra_Requirements, Passengers.PassengerIDCard, Main.Mgarr_Date_of_travel_from, Main.Mgarr_Specific_Trip_1, Main.Mgarr_Date_of_travel_to, Main.Mgarr_Specific_Trip_2, Main.Cirkewwa_Date_of_travel_to, Main.Cirkewwa_Specific_Trip_1, Main.Cirkewwa_Date_of_travel_from, Main.Cirkewwa_Specific_Trip_2, Remarks.Reason, Main.IssuerID, Main.IssueDate 
    FROM dbo.Main INNER JOIN dbo.Passengers ON Main.PID=Passengers.PID 
    INNER JOIN dbo.Extra_Reqs ON Main.ER_ID=Extra_Reqs.ER_ID
    INNER JOIN dbo.Remarks ON Main.RemarksID = Remarks.Remark_ID
    WHERE Passengers.PassengerIDCard = '$id';";

    $rowSQL = sqlsrv_query($conn, $query_priority1);
    //die(print_r(sqlsrv_errors(), true));
    while (($row = sqlsrv_fetch_array($rowSQL))!=NULL){
        $issuerid = $row['issuerid'];
        echo"<table style=\"width:50%; margin-left:auto; margin-right:auto;\" class=\"mgarrtable\">";
        echo"<tr>
        <th><h2>ID</h2></th>
        <th><h2>PID</h2></th>
        <th><h2>Extra Reqs</h2></th>
        <th><h2>Reason</h2></th>
    </tr>";
        echo "<tr><td style='text-align:center;'>" . $row['ID'] . "</td><td style='text-align:center;'>" . $row['PID'] . "</td><td style='text-align:center;'>"
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
       echo"<br><br><br>";

       $sql = "SELECT Issuer_Name FROM dbo.Issuer WHERE IssuerID = '$issuerid';";


       echo"<th><h2>Issuer Name</h2></th>
       <th><h2>Issue Date</h2></th>";
        echo"<tr><td style='text-align:center;'>    </td><td style='text-align:center;'>  $temp6  </td></tr>";
        echo"</table>";
        echo"<br><br><br>";
    }



    ?>
</table>
<br><br>

<?php
    echo '<img src="./MedicalCerts/' . "$id" . '.JPG" alt="No Medical Certificate found associated with this person"/>';
?>
<form>
    <input type=button name=print value="Print" onClick="window.print()">
</form>
</body>
</html>
