<?php
function getReqID($er, $conn){
    $query_id = "SELECT ER_ID AS id FROM dbo.Extra_Reqs WHERE Extra_Requirements = '$er';";
    $rowSQL = sqlsrv_query($conn, $query_id);
    $row = sqlsrv_fetch_array($rowSQL);
    return $row["id"];
}