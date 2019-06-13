<!-- Beschrijving van voorwerp (word in iFrame geplaatst) -->
<?php
session_start();
echo $_SESSION['Beschrijving'];
$_SESSION['Beschrijving'] = "";
?>