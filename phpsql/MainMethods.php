<?php
function numOfID($conn){
    $query_num = "SELECT COUNT(ID) AS num FROM dbo.Main;";
    $rowSQL = sqlsrv_query($conn, $query_num);
    $row = sqlsrv_fetch_array($rowSQL);
    return $row["num"];
}
function findLargestID(&$highest, $conn){
    $query_largest = "SELECT MAX(ID) AS highest FROM dbo.Main;";
    $rowSQL = sqlsrv_query($conn, $query_largest);
    $row = sqlsrv_fetch_array($rowSQL);
    $highest = $row["highest"];
    if ($highest == NULL && numOfID($conn) == 0) {
        $highest = -1;
    }
}
function checkFerry($mgarr, &$mgarrtime, &$mgarrdate){
    if($mgarr == "Open"){
        $mgarrtime=NULL;
        $mgarrdate=NULL;
    }
}
function findPID($idcard, $conn){
    $query_pid = "SELECT PID AS pid FROM dbo.Passengers WHERE PassengerIDCard = '$idcard';";
    $rowSQL = sqlsrv_query($conn, $query_pid);
    $row = sqlsrv_fetch_array($rowSQL);
    return $row["pid"];
}