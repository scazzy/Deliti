<?php
$pagename=explode('/',$_SERVER['REQUEST_URI']);
$thispage=$pagename[count($pagename)-1];
//echo $thispage;
?>

<nav id="navigation"  class="w800">
<ul>
    	<li><a href="home.php" class="<?php if($thispage=="home.php"){ echo " active";} ?>">Home</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
        <li><a href="edit-profile.php" class="<?php if($thispage=="edit-profile.php"){ echo " active";} ?>">Edit Profile</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
    	<li><a href="changepwd.php" class="<?php if($thispage=="changepwd.php"){ echo " active";} ?>">Change Password</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
        <li><a href="join-room.php" class="<?php if($thispage=="join-room.php"){ echo " active";} ?>">Join a room</a></li>
        <li><img src="images/homepage_nav_seperator.gif"/></li>
        <li><a href="search-rooms.php" class="<?php if($thispage=="search-rooms.php"){ echo " active";} ?>">Search Rooms</a></li>
    </ul>
</nav>