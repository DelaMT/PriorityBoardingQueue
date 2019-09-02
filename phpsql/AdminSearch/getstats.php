<!DOCTYPE html>
<html>
<head>
    <title>STATISTICS</title>
    <link rel="stylesheet" type="text/css" href="../AdminUtil.css"/>
</head>
<body>

<?php
$check = false;
$selectyr = $_POST["stats"];
$curyear = date("Y");

echo "<h1>NUMBER OF PRIOIRITY BOARDINGS IN $selectyr </h1>";

if($selectyr <= $curyear && $selectyr >= 1971) {

    $serverName = "192.168.5.20\sqlexpress";
    $connectionInfo = array("Database" => "PriorityBoarding", "UID" => "daniel.sumler", "PWD" => "12345");
    $conn = sqlsrv_connect($serverName, $connectionInfo);

    if (!$conn) {
        echo "Connection could not be established.<br/>";
        die(print_r(sqlsrv_errors(), true));
    }

    $sql = "SELECT COUNT(ID) AS id FROM dbo.Main WHERE year(Mgarr_Date_of_travel_from) = $selectyr";
    $rowSQL = sqlsrv_query($conn, $sql);
    //die(print_r(sqlsrv_errors(), true));
    $row = sqlsrv_fetch_array($rowSQL);
    echo "
    <table style=\"width:100%; margin-left:auto; margin-right:auto;\" class=\"mgarrtable\">
    <tr>
    <td>
    Mgarr Travel From
    </td>
    <td>
    Mgarr Travel To
    </td>
    <td>
    Cirkewwa Travel From
    </td>
    <td>
    Cirkewwa Travel To
    </td>
    </tr>
    ";

    $temp = $row['id'];
    echo"<tr>
    <td>
    $temp
    </td>";

    $sql = "SELECT COUNT(ID) AS id FROM dbo.Main WHERE year(Mgarr_Date_of_travel_to) = $selectyr";
    $rowSQL = sqlsrv_query($conn, $sql);
    //die(print_r(sqlsrv_errors(), true));
    $row = sqlsrv_fetch_array($rowSQL);

    $temp = $row['id'];
    echo"
    <td>
    $temp
    </td>";

    $sql = "SELECT COUNT(ID) AS id FROM dbo.Main WHERE year(Cirkewwa_Date_of_travel_from) = $selectyr";
    $rowSQL = sqlsrv_query($conn, $sql);
    //die(print_r(sqlsrv_errors(), true));
    $row = sqlsrv_fetch_array($rowSQL);

    $temp = $row['id'];
    echo"
    <td>
    $temp
    </td>";

    $sql = "SELECT COUNT(ID) AS id FROM dbo.Main WHERE year(Cirkewwa_Date_of_travel_to) = $selectyr";
    $rowSQL = sqlsrv_query($conn, $sql);
    //die(print_r(sqlsrv_errors(), true));
    $row = sqlsrv_fetch_array($rowSQL);

    $temp = $row['id'];
    echo"
    <td>
    $temp
    </td>
    </tr>
    </table>";

    echo"<br><br><br>
    <h1>REASON</h1>
    <br>
    <table style=\"width:100%; margin-left:auto; margin-right:auto;\" class=\"mgarrtable\">
    <tr>
    <td>
    VIP
    </td>
    <td>
    Medical/Disabled
    </td>
    <td>
    Commercial
    </td>
    <td>
    Standard
    </td>
    </tr>";

    $sql = "SELECT COUNT(Main.ID) AS id FROM dbo.Main INNER JOIN dbo.Remarks ON Main.RemarksID = Remarks.Remark_ID WHERE Remarks.Reason = 'V.I.P.' AND (year(Mgarr_Date_of_travel_to) = $selectyr OR year(Mgarr_Date_of_travel_from) = $selectyr OR year(Cirkewwa_Date_of_travel_to) = $selectyr OR year(Cirkewwa_Date_of_travel_from) = $selectyr)";
    $rowSQL = sqlsrv_query($conn, $sql);
    //die(print_r(sqlsrv_errors(), true));
    $row = sqlsrv_fetch_array($rowSQL);

    $temp = $row['id'];
    echo"
    <tr>
    <td>
    $temp
    </td>";

    $sql = "SELECT COUNT(Main.ID) AS id FROM dbo.Main INNER JOIN dbo.Remarks ON Main.RemarksID = Remarks.Remark_ID WHERE Remarks.Reason = 'Medical/Disabled' AND (year(Mgarr_Date_of_travel_to) = $selectyr OR year(Mgarr_Date_of_travel_from) = $selectyr OR year(Cirkewwa_Date_of_travel_to) = $selectyr OR year(Cirkewwa_Date_of_travel_from) = $selectyr)";
    $rowSQL = sqlsrv_query($conn, $sql);
    //die(print_r(sqlsrv_errors(), true));
    $row = sqlsrv_fetch_array($rowSQL);

    $temp = $row['id'];
    echo"
    <td>
    $temp
    </td>";

    $sql = "SELECT COUNT(Main.ID) AS id FROM dbo.Main INNER JOIN dbo.Remarks ON Main.RemarksID = Remarks.Remark_ID WHERE Remarks.Reason = 'Commercial' AND (year(Mgarr_Date_of_travel_to) = $selectyr OR year(Mgarr_Date_of_travel_from) = $selectyr OR year(Cirkewwa_Date_of_travel_to) = $selectyr OR year(Cirkewwa_Date_of_travel_from) = $selectyr)";
    $rowSQL = sqlsrv_query($conn, $sql);
    //die(print_r(sqlsrv_errors(), true));
    $row = sqlsrv_fetch_array($rowSQL);

    $temp = $row['id'];
    echo"
    <td>
    $temp
    </td>";

    $sql = "SELECT COUNT(Main.ID) AS id FROM dbo.Main INNER JOIN dbo.Remarks ON Main.RemarksID = Remarks.Remark_ID WHERE Remarks.Reason = 'Standard' AND (year(Mgarr_Date_of_travel_to) = $selectyr OR year(Mgarr_Date_of_travel_from) = $selectyr OR year(Cirkewwa_Date_of_travel_to) = $selectyr OR year(Cirkewwa_Date_of_travel_from) = $selectyr)";
    $rowSQL = sqlsrv_query($conn, $sql);
    //die(print_r(sqlsrv_errors(), true));
    $row = sqlsrv_fetch_array($rowSQL);

    $temp = $row['id'];
    echo"
    <td>
    $temp
    </td>
    </tr>
    </table>";

    echo"<br><br><br>
    <h1>EXTRA REQUIREMENTS</h1>
    <br>
    <table style=\"width:100%; margin-left:auto; margin-right:auto;\" class=\"mgarrtable\">
    <tr>
    <td>
    Wheelchair Use
    </td>
    <td>
    None
    </td>
    </tr>";

    $sql = "SELECT COUNT(Main.ID) AS id FROM dbo.Main INNER JOIN dbo.Extra_Reqs ON Main.ER_ID = Extra_Reqs.ER_ID WHERE Extra_Reqs.Extra_Requirements = 'Wheelchair Use' AND (year(Mgarr_Date_of_travel_to) = $selectyr OR year(Mgarr_Date_of_travel_from) = $selectyr OR year(Cirkewwa_Date_of_travel_to) = $selectyr OR year(Cirkewwa_Date_of_travel_from) = $selectyr)";
    $rowSQL = sqlsrv_query($conn, $sql);
    //die(print_r(sqlsrv_errors(), true));
    $row = sqlsrv_fetch_array($rowSQL);

    $temp = $row['id'];

    echo"
    <tr>
    <td>
    $temp
    </td>";

    $sql = "SELECT COUNT(Main.ID) AS id FROM dbo.Main INNER JOIN dbo.Extra_Reqs ON Main.ER_ID = Extra_Reqs.ER_ID WHERE Extra_Reqs.Extra_Requirements = 'None' AND (year(Mgarr_Date_of_travel_to) = $selectyr OR year(Mgarr_Date_of_travel_from) = $selectyr OR year(Cirkewwa_Date_of_travel_to) = $selectyr OR year(Cirkewwa_Date_of_travel_from) = $selectyr)";
    $rowSQL = sqlsrv_query($conn, $sql);
    //die(print_r(sqlsrv_errors(), true));
    $row = sqlsrv_fetch_array($rowSQL);

    $temp = $row['id'];

    echo"
    <td>
    $temp
    </td>
    </tr>
    </table>";

} else{
    echo "AN INVALID VALUE WAS ENTERED, PLEASE GO BACK AND ENTER AN INTEGER BETWEEN 1971 AND " . $curyear;
    echo"<a href='statistics.html'><input type='button' value='BACK'></a>";
    $check = true;
}


?>


</body>
</html>
