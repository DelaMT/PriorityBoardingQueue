<html>
<head>
    <link rel="stylesheet" type="text/css" href="./AdminUtil.css"/>
</head>

<body>
<div class="namesearch">
    <form action="./AdminSearch/searchname.php" method="post">
    <label for="personname">Search by passenger name:</label>
    <input type="text" id="personname" name="personname">
    <input type="submit" value="Search Database">
    </form>
</div>
<br><br>
<div class="idsearch">
    <form action="./AdminSearch/searchpid.php" method="post">
    <label for="personid">Search by passenger ID (PID):</label>
    <input type="text" id="personid" name="personid">
    <input type="submit" value="Search Database">
    </form>
</div>
<br>
<div class="idcardsearch">
    <form action="./AdminSearch/searchidcard.php" method="post">
    <label for="personidcard">Search by passenger ID CARD number:</label>
    <input type="text" id="personidcard" name="personidcard">
    <input type="submit" id="personidcard" value="Search Database">
    </form>
</div>
<div class="statistics">
    <form action="./AdminSearch/statistics.html" method="post">
    <input type="submit" value="View Boarding Statistics">
    </form>
</div>

<?php




?>


</body>

</html>



