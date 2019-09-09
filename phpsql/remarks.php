<!DOCTYPE html>
<html>
<head>
    <title>Main Menu</title>
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
            <text class="nav-brand-style" href="">Remarks</text>
        </li>
        <li class="nav-item active">
            <a class="nav-item-style" href="../mainMenu.html">Main Menu</a>
        </li>
    </ul>
</nav>
<!-- NavBar -->
<section class="mainSectionStyle">

    <?php
    require 'RemarkMethods.php';
    $serverName = "192.168.5.20\sqlexpress"; //serverName\instanceName

    // Since UID and PWD are not specified in the $connectionInfo array,
    // The connection will be attempted using Windows Authentication.
    $connectionInfo = array( "Database"=>"PriorityBoarding","UID"=>"daniel.sumler", "PWD"=>"12345");
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if( !$conn ) {
        echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
    }

    $reason = $_POST['reason'];

    if(($rem = fetchRemark($reason, $conn))!=NULL) {
        echo "
    <table style='border:solid; width:600px; margin:0 auto; margin-top: 300px; color: #FFFFFF'>
        <thead>
            <th style='border: solid 10px; width: 600px; margin:0 auto;'>
            <h3 style='font-size:50px; padding:15px; text-align: center'><strong>ATTENTION</strong></h3>
        </th>
        </thead>
        <tbody>
            <td style='border:solid; text-align:center;'>
                <h4 style='font-size:30px; padding: 15px'>'$rem'</h4>
            </td>
        </tbody>
    </table>
    ";
    }
    ?>

</section>
<!-- BOOTSTRAP LINKS -->
<script src ="./../js/bootstrap.js"></script>
<!-- BOOTSTRAP LINKS -->
</body>
</html>