<?php
//QUERY THE DB TO CHECK IF THE REGISTRATION NUMBER ALREADY EXISTS
//RETURN NUMBER OF APPEARANCES IN THE DB
function checkReg($reg, $conn){
    $query_exists="SELECT COUNT(Registration_ID) AS card FROM dbo.Vehicle WHERE Registration_ID = '$reg';";
    $rowSQL = sqlsrv_query($conn, $query_exists);
    $row = sqlsrv_fetch_array($rowSQL);
    if($row["card"]!=0){
        echo "\nRegistration '$reg' has already been registered!\n";
    }
    return $row["card"];
}
//CHECK IF THE VEHICLE AND REG VARIABLES ARE FILLED OR CONTAIN NULL
//RETURN TRUE IF THEY ARE FILLED, OR FALSE OTHERWISE
function DetectVehicle($vehicle, $reg){
    if($vehicle==NULL && $reg==NULL){
        return false;
    } else{
        return true;
    }
}
//ADD A VEHICLE INTO THE DB TOGETHER WITH THE CORRESPONDING REG AND PASSENGER ID CARD NUMBER
function addVehicle($vehicle, $reg, $idcard, $conn){

    $query = "INSERT INTO dbo.Vehicle (Registration_ID, Vehicle_Make, PassengerIDCard) VALUES ('$reg', '$vehicle', '$idcard')";
    $result = sqlsrv_query($conn, $query);
    if (!$result) {
        die(print_r(sqlsrv_errors(), true));

    }
    echo "Added to Database!";
}
function DetectReg($reg){
    if($reg==NULL){
        return false;
    }else{
        return true;
    }
}
?>