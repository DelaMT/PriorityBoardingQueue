<?php
function fetchRemark($reason, $conn){
    $query_exists="SELECT Remarks AS remark FROM dbo.Remarks WHERE Reason = '$reason';";
    $rowSQL = sqlsrv_query($conn, $query_exists);
    $row = sqlsrv_fetch_array($rowSQL);
    return $row["remark"];
}
function getRemarkID($reason, $conn){
    $query_exists="SELECT Remark_ID AS remarkid FROM dbo.Remarks WHERE Reason = '$reason';";
    $rowSQL = sqlsrv_query($conn, $query_exists);
    $row = sqlsrv_fetch_array($rowSQL);
    return $row["remarkid"];

}