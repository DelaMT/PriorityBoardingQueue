<?php
function numOfID($conn){
    $query_num = "SELECT COUNT(ID) AS num FROM dbo.Main;";
    $rowSQL = sqlsrv_query($conn, $query_num);
    $row = sqlsrv_fetch_array($rowSQL);
    return $row["num"];
}
function numOfMVID($conn){
    $query_num = "SELECT COUNT(ID) AS num FROM dbo.MainVehicle;";
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
    if($mgarr == "open"){
        $mgarrtime='';
        $mgarrdate='';
    }
}
function findPID($idcard, $conn){
    $query_pid = "SELECT PID AS pid FROM dbo.Passengers WHERE PassengerIDCard = '$idcard';";
    $rowSQL = sqlsrv_query($conn, $query_pid);
    $row = sqlsrv_fetch_array($rowSQL);
    return $row["pid"];
}
function findLargestMVID(&$highest, $conn){
    $query_largest = "SELECT MAX(ID) AS highest FROM dbo.MainVehicle;";
    $rowSQL = sqlsrv_query($conn, $query_largest);
    $row = sqlsrv_fetch_array($rowSQL);
    $highest = $row["highest"];
    if ($highest == NULL && numOfMVID($conn) == 0) {
        $highest = -1;
    }
}
function inputReg($reg, &$MVID, $MainID, $conn){
    if($reg != NULL) {
        $MVID+=1;
        $query = "
        INSERT INTO dbo.MainVehicle(ID, Registration_ID, Main_ID)
        VALUES($MVID, '$reg', $MainID);";
        $result = sqlsrv_query($conn, $query);
        //inputMainID($MVID, $MainID, $conn);
        if (!$result) {
            die(print_r(sqlsrv_errors(), true));
        }
    }
}
/*
function inputMainID($MVID, $ID, $conn){
    $query = "INSERT INTO dbo.MainVehicle(Main_ID)
        VALUES($ID) WHERE ID = $MVID;";
    $result = sqlsrv_query($conn, $query);
    if (!$result) {
        die(print_r(sqlsrv_errors(), true));
    }
}*/

