<?php
$pagename=explode('/',$_SERVER['REQUEST_URI']);
$thispage=$pagename[count($pagename)-1];
//echo $thispage;
?>

<nav id="navigation"  class="w800">
	<ul>
    	<li><a href="index.php" class="<?php if($thispage=="index.php"){ echo " active";} ?>">Home</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
    	<li><a href="features.php" class="<?php if($thispage=="features.php"){ echo " active";} ?>">Features</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
        <li><a href="tour.php" class="<?php if($thispage=="tour.php"){ echo " active";} ?>">Take-a-Tour</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
        <li><a href="register.php" class="<?php if($thispage=="register.php"){echo " active";} ?>">Join Now!</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
        <li><a href="search-rooms.php" class="<?php if($thispage=="search-rooms.php"){echo " active";} ?>">Search Rooms</a></li>
    </ul>
</nav>

