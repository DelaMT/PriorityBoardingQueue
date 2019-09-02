<!DOCTYPE html>
<html>
<head>
    <!-- BOOTSTRAP LINKS -->
    <link rel="stylesheet" href="././css/bootstrap/bootstrap.css">
    <!-- BOOTSTRAP LINKS -->
    <title>Admin Utilities</title>
</head>

<body class="body-background-style">
<!-- NavBar -->
<nav class="navbar navbar-expand-sm bg-gozoChannelHeader navbar-dark">
    <ul class="navbar-nav">
        <a href="#" class="nav-logo-style">
            <img src="GozoChannelLogo.png" height="49" alt="">
        </a>
        <li class="nav-item active">
            <text class="nav-brand-style" href="">Search Booking</text>
        </li>
        <li class="nav-item active">
            <a class="nav-item-style" href="adminUtils.html">Back</a>
        </li>
        <li class="nav-item active">
            <a class="nav-item-style" href="../mainMenu.html">Main Menu</a>
        </li>
    </ul>
</nav>
<!-- NavBar -->
<section class="mainSectionStyle">
    <div class="idcardsearch">
        <form action="./AdminSearch/searchidcard.php" method="post">
            <label for="personidcard" class="inputTextStyle">Search by passenger ID CARD number:</label>
            <input type="text" id="personidcard" name="personidcard">
            <input type="submit" id="personidcard" value="Search Database" class="btn-gozoChannelOption">
        </form>
    </div>
</section>
<!-- BOOTSTRAP LINKS -->
<script src ="../js/bootstrap.js"></script>
<!-- BOOTSTRAP LINKS -->
</body>

</html>



