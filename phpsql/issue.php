<!DOCTYPE html>
<html>
    <head>
        <title>Issue Boardings</title>
        <!-- BOOTSTRAP LINKS -->
        <link rel="stylesheet" href="./css/bootstrap/bootstrap.css">
        <!-- BOOTSTRAP LINKS -->
    </head>
    <body class="body-background-style">
        <!-- NavBar -->
        <nav class="navbar navbar-expand-sm bg-gozoChannelHeader navbar-dark">
            <ul class="navbar-nav">
                <a href="#" class="nav-logo-style">
                    <img src="./GozoChannelLogo.png" height="49" alt="">
                </a>
                <li class="nav-item active">
                    <text class="nav-brand-style" href="">Issue Boardings</text>
                </li>
                <li class="nav-item active">
                    <a class="nav-item-style" href="./adminUtils.html">Back</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-item-style" href="../mainMenu.html">Main Menu</a>
                </li>
            </ul>
        </nav>
        <!-- NavBar -->
        <section class="mainSectionStyle">
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
            <h1>ALL BOARDINGS</h1 class="tableTitleText">
            <table class="table table-bigBorderHalved" style="width:50%;">
                <tr class="issueTitleTextStyle">
                    <th><h2>BOARDING ID</h2></th>
                    <th><h2>PASSENGER NAME</h2></th>
                    <th><h2>PASSENGER ID CARD NO.</h2></th>
                </tr>

                <?php
                $query_priority2 = "SELECT Main.ID AS id, Passengers.PassengerName AS name, Passengers.PassengerIDCard AS idcard FROM dbo.Main INNER JOIN 
                                    dbo.Passengers ON Main.PID = Passengers.PID WHERE Main.IssuerID IS NULL OR Main.IssuerID IS NOT NULL;";

                $rowSQL = sqlsrv_query($conn, $query_priority2);
                //die(print_r(sqlsrv_errors(), true));
                while (($row = sqlsrv_fetch_array($rowSQL))!=NULL){
                    $temp = $row['id'];
                    $temp2 = $row['name'];
                    $temp3 = $row['idcard'];
                    echo "<tr class='issueResultTextStyle'><td style='text-align:center;'>" . $temp . "</td><td style='text-align:center;'>" . $temp2 . "</td><td style='text-align:center;'>" . $temp3 . "</td></tr>";
                }
                ?>
            </table>
            <h3 style="text-align: left"class="tableTitleText">View more info about a booking</h3>
        </section>
    </body>
</html>
