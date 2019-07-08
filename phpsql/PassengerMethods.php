<?php
function checkPassenger($idcard, $conn){
    $query_exists="SELECT COUNT(PassengerIDCard) AS card FROM dbo.Passengers WHERE PassengerIDCard = '$idcard';";
    $rowSQL = sqlsrv_query($conn, $query_exists);
    $row = sqlsrv_fetch_array($rowSQL);
    return $row["card"];
}
function numOfPassengers($conn){
    $query_num = "SELECT COUNT(PID) AS num FROM dbo.Passengers;";
    $rowSQL = sqlsrv_query($conn, $query_num);
    $row = sqlsrv_fetch_array($rowSQL);
    return $row["num"];
}
function numOfTrips($conn){
    $query_num = "SELECT COUNT(ID) AS num FROM dbo.Trips;";
    $rowSQL = sqlsrv_query($conn, $query_num);
    $row = sqlsrv_fetch_array($rowSQL);
    return $row["num"];
}

function findLargest(&$highest, $conn){
    $query_largest = "SELECT MAX(PID) AS highest FROM dbo.Passengers;";
    $rowSQL = sqlsrv_query($conn, $query_largest);
    $row = sqlsrv_fetch_array($rowSQL);
    $highest = $row["highest"];
    if ($highest == NULL && numOfPassengers($conn) == 0) {
        $highest = -1;
    }
}
?>
