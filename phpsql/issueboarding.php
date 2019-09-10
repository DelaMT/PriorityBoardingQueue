<!DOCTYPE html>
<html>
<body>

<?php

function checkIssuer($conn, $name){
    $query_exists = "SELECT COUNT(IssuerID) AS id FROM dbo.Issuer WHERE Issuer_Name = '$name';";
    $rowSQL = sqlsrv_query($conn, $query_exists);
    $row = sqlsrv_fetch_array($rowSQL);
    return $row["id"];
}
function getIssuerID($conn, $name){
    $sql = "SELECT IssuerID as id FROM dbo.Issuer WHERE Issuer_Name = '$name';";
    $rowSQL = sqlsrv_query($conn, $sql);
    $row = sqlsrv_fetch_array($rowSQL);
    return $row["id"];
}
function findLargest(&$highest, $conn){
    $query_largest = "SELECT MAX(IssuerID) AS highest FROM dbo.Issuer;";
    $rowSQL = sqlsrv_query($conn, $query_largest);
    $row = sqlsrv_fetch_array($rowSQL);
    $highest = $row["highest"];
    if ($highest == NULL && numOfPassengers($conn) == 0) {
        $highest = -1;
    }
}
function numOfIssuers($conn){
    $query_num = "SELECT COUNT(PID) AS num FROM dbo.Passengers;";
    $rowSQL = sqlsrv_query($conn, $query_num);
    $row = sqlsrv_fetch_array($rowSQL);
    return $row["num"];
}

$serverName = "192.168.5.20\sqlexpress"; //serverName\instanceName

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
$connectionInfo = array( "Database"=>"PriorityBoarding","UID"=>"daniel.sumler", "PWD"=>"12345");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( !$conn ) {
    echo "Connection could not be established.<br />";
    die( print_r( sqlsrv_errors(), true));
}

$issuername = htmlentities($_POST['issuername']);
$issuedate = date('Y-m-d', strtotime($_POST['issuedate']));
$boardingid = $_POST['bid'];

$result = checkIssuer($conn, $issuername);
findLargest($highest, $conn);

if($result == 0) {
    $highest += 1;
    $sql = "INSERT INTO dbo.Issuer (IssuerID, Issuer_Name) VALUES ($highest, '$issuername');";
    $rowSQL = sqlsrv_query($conn, $sql);
    //$id = getIssuerID($conn, $issuername);
    $sql = "UPDATE dbo.Main SET IssuerID = $highest, Issue_Date = '$issuedate';";
    $rowSQL = sqlsrv_query($conn, $sql);
    echo "Added to database";

} else{
    $id = getIssuerID($conn, $issuername);
    $sql = "UPDATE dbo.Main SET IssuerID = $id, Issue_Date = '$issuedate';";
    $rowSQL = sqlsrv_query($conn, $sql);
    echo "Added to database";
}

?>

</body>
</html>
