<!DOCTYPE html>
<html>
<head>
    <!-- BOOTSTRAP LINKS -->
    <link rel="stylesheet" href="./../css/bootstrap/bootstrap.css">
    <!-- BOOTSTRAP LINKS -->
    <title>Boarding Statistics</title>
</head>
<body class="body-background-style">
<!-- NavBar -->
<nav class="navbar navbar-expand-sm bg-gozoChannelHeader navbar-dark">
    <ul class="navbar-nav">
        <a href="#" class="nav-logo-style">
            <img src="../GozoChannelLogo.png" height="49" alt="">
        </a>
        <li class="nav-item active">
            <text class="nav-brand-style" href="">Statistics</text>
        </li>
        <li class="nav-item active">
            <a class="nav-item-style" href="../adminUtils.html">Back</a>
        </li>
        <li class="nav-item active">
            <a class="nav-item-style" href="../../mainMenu.html">Main Menu</a>
        </li>
    </ul>
</nav>
<!-- NavBar -->
<section class="mainSectionStyle">
    <?php
    $check = false;
    $selectyr = $_POST["stats"];
    $curyear = date("Y");

    echo "<h1 class='mainSubtitleTextStyleUnderlined'>NUMBER OF PRIORITY BOARDINGS IN $selectyr </h1>";

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
        <table class='table table-bigBorderHalved' style='width: 50%'>
            <thead>
                <tr class='tableTitleText'>
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
            </thead>
        ";

        $temp = $row['id'];
        echo"
        <tbody>
        <tr class='tableResultText'>
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
        </tbody>
        </table>";

        echo"<br>
        <h1 class='mainSubtitleTextStyleUnderlined'>REASON</h1>
        <table class='table table-bigBorderHalved' style='width: 50%'>
            <thead>
                <tr class='tableTitleText'>
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
                </tr>
            </thead>";

        $sql = "SELECT COUNT(Main.ID) AS id FROM dbo.Main INNER JOIN dbo.Remarks ON Main.RemarksID = Remarks.Remark_ID WHERE Remarks.Reason = 'V.I.P.' AND (year(Mgarr_Date_of_travel_to) = $selectyr OR year(Mgarr_Date_of_travel_from) = $selectyr OR year(Cirkewwa_Date_of_travel_to) = $selectyr OR year(Cirkewwa_Date_of_travel_from) = $selectyr)";
        $rowSQL = sqlsrv_query($conn, $sql);
        //die(print_r(sqlsrv_errors(), true));
        $row = sqlsrv_fetch_array($rowSQL);

        $temp = $row['id'];
        echo"
        <tbody>
        <tr class='tableResultText'>
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
        </tbody>
        </table>";

        echo"<br>
        <h1 class='mainSubtitleTextStyleUnderlined'>EXTRA REQUIREMENTS</h1>
        <table class='table table-bigBorderHalved' style='width: 50%'>
            <thead>
                <tr class='tableTitleText'>
                    <td>
                    Wheelchair Use
                    </td>
                    <td>
                    None
                    </td>
                </tr>
            </thead>";

        $sql = "SELECT COUNT(Main.ID) AS id FROM dbo.Main INNER JOIN dbo.Extra_Reqs ON Main.ER_ID = Extra_Reqs.ER_ID WHERE Extra_Reqs.Extra_Requirements = 'Wheelchair Use' AND (year(Mgarr_Date_of_travel_to) = $selectyr OR year(Mgarr_Date_of_travel_from) = $selectyr OR year(Cirkewwa_Date_of_travel_to) = $selectyr OR year(Cirkewwa_Date_of_travel_from) = $selectyr)";
        $rowSQL = sqlsrv_query($conn, $sql);
        //die(print_r(sqlsrv_errors(), true));
        $row = sqlsrv_fetch_array($rowSQL);

        $temp = $row['id'];

        echo"
        <tbody>
        <tr class='tableResultText'>
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
        </tbody>
        </table>";

    } else{
        echo "AN INVALID VALUE WAS ENTERED, PLEASE GO BACK AND ENTER AN INTEGER BETWEEN 1971 AND " . $curyear;
        echo"<a href='statistics.html'><input type='button' value='BACK'></a>";
        $check = true;
    }


    ?>

</section>
</body>
</html>
