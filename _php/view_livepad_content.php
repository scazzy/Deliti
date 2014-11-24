<title>Download</title>

<?php
if(isset($_POST['notepad_text'])){
$content=$_POST['notepad_text'];
echo "<pre>".$content."</pre>";
}
?>