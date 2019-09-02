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
    echo
    "<table style='border:solid; width:600px; margin:0 auto;'>
    <thead>
    <th style='border: solid 10px; width: 600px; margin:0 auto;'>
    <h3 style='font-size:50px; padding:0px;'><strong>ATTENTION</strong></h3>
    </th>
    </thead>
    <tbody>
    <td style='border:solid; text-align:center;'>
    <h4 style='font-size:30px;'>'$rem'</h4>
    </td>
    </tbody>
    </table>";
}