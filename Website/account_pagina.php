<?php
include_once "includes/database.php";
include_once "includes/functies.php";
if (!isset($_SESSION['Gebruikersnaam']) || $_SESSION['Gebruikersnaam'] === "") {
    header("Location: login_pagina.php");
    return;
}
include_once "includes/header.php";
include_once "includes/databaseFunctions.php";
?>
<div class="Main">
    <div class="content title">
        <h5>Welkom <?php echo ($_SESSION["Gebruikersnaam"]); ?></h5>
    </div>
    <div class="content">
        <div class="tabs">
            <a class="highlight">Home</a>
            <a class="">Settings</a>
        </div>
        <!-- START HOME -->
        <div class="">asdsadasdad</div>
        <!-- END HOME -->
        <!-- START SETTINGS -->
        <div class="">adasdsrghjkjjhgfwertyukjmnbvcxzertyuikljhgfdsadfgxc234568o</div>
        <!-- END SETTINGS -->
    </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/timer.js"></script>
<script src="assets/js/pagenation.js"></script>
<?php
include_once "includes/footer.php"; ?>