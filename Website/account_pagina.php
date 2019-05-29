<?php
include_once "includes/database.php";
include_once "includes/functies.php";
include_once "includes/header.php";
include_once "includes/databaseFunctions.php";

if (empty($_SESSION['Gebruikersnaam'])) {
    header("Location: /login_pagina.php");
    return;
}

?>
<div class="Main">
    <div>
        <h5>Welkom <?php echo ($_SESSION["Gebruikersnaam"]); ?></h5>
    </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/timer.js"></script>
<script src="assets/js/pagenation.js"></script>
<?php
include_once "includes/footer.php";?>
