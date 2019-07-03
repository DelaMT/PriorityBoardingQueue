<?php
if( isset($_GET['submit']) ){
	$val1 = htmlentities($_GET['val1']);
    $val2 = htmlentities($_GET['val2']);
	
	$conn=odbc_connect('Boarding','','');
if (!$conn)
  {exit("Connection Failed: " . $conn);}
$sql=("INSERT INTO Employees(name, Grade) VALUES('$val1', '$val2')");
$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}
echo "Added to Database!";
    
}
?>

<?php if( isset($result) ) echo $result; //print the result above the form ?>

<form action="" method="get">
    Input number1: 
    <input type="text" name="val1" id="val1"></input>

    <br></br>
    Input number2:
    <input type="text" name="val2" id="val2"></input>

    <br></br>

    <input type="submit" name="submit" value="send"></input>
</form>