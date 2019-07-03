<html>
<body>
<?php
$conn=odbc_connect('Boarding','','');
if (!$conn)
  {exit("Connection Failed: " . $conn);}
$sql="SELECT Name, Grade FROM Employees";
$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}
echo "<table><tr>";
echo "<th>Name</th>";
echo "<th>Grade</th></tr>";
while (odbc_fetch_row($rs))
{
  $name=odbc_result($rs,"Name");
  $grade=odbc_result($rs,"Grade");
  echo "<tr><td>$name</td>";
  echo "<td>$grade</td></tr>";
}
odbc_close($conn);
echo "</table>";
?>
</body>
</html>