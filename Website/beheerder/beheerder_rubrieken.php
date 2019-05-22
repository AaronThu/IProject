<?php
include_once 'prefabs/header.php';
include_once 'logica/beheer_rubrieken_systeem.php';
include_once '../includes/databaseFunctions.php';
?>

<div class="main">
    <script src="js/beheer_rubrieken.js"></script>
    <?php include_once "prefabs/sidenav.php"?>
    <div class="contentblok">
    <h1 class="title">Rubrieken</h1>
        <div class="row">
            <div class="rij options">
                <h4>Opties</h4>
                <a class="knoppen highlight" onclick="Aanpassen(this)">Aanpassen</a>
                <a class="knoppen" onclick="Maken(this)">Maken</a>
            </div>
            <div class="rij zoeken">
            <!-- Zoek Resultaten -->
            <form id="Search" action="" method="GET">
                <input type="search" name="SearchBar" id="SearchBar" value="<?php echo (isset($_GET["SearchBar"]) ? ($_GET["SearchBar"]) : "") ?>" placeholder="Zoeken" autofocus>
                <input  type="submit" value="Zoek">
            </form>
            <h5>Filters </h5>
            <div class="filters">
                <div class="checkBox"><input type="checkbox" onChange="this.form.submit()" name="Naam" id="Naam" form="Search" <?php echo (isset($_GET["Naam"]) ? "checked" : "") ?>> <label for="Naam">Naam</label></div>
                <div class="checkBox"><input type="checkbox" onChange="this.form.submit()" name="volgnummer" id="volgnummer" form="Search" <?php echo (isset($_GET["volgnummer"]) ? "checked" : "") ?>> <label for="volgnummer">Volgnummer</label></div>
                <div class="checkBox"><input type="checkbox" onChange="this.form.submit()" name="parentRubriek" id="parentRubriek" form="Search" <?php echo (isset($_GET["parentRubriek"]) ? "checked" : "") ?>> <label for="parentRubriek">Parent Rubriek</label></div>
            </div>
            <div class="zoekresultaten">
<?php
if (!isset($results) || sizeof($results) <= 0) {
    if (isset($_GET["SearchBar"]) && $_GET["SearchBar"] === "") {
        echo ("<h5 class=\"noResults\">Geen resultaten gevonden</h5>");
    } else {
        echo ("<h5 class=\"noResults\">Zoek rubrieken</h5>");
    }
} else {
    foreach ($results as $key => $value) {
        echo ('<a onClick=setRubriek(this,' . $value["Rubrieknummer"] . ',' . '"' . str_replace(" ", "_", $value["Rubrieknaam"]) . '",' . $value["Parent_rubriek"] . ',' . $value["Volgnr"] . ') class="zoekresultaat">');
        echo ("<div class=\"block\">");
        echo ("<h5 class=\"name\">$value[Rubrieknaam]</h5>");
        echo ("<h6 class=\"parent\">$value[Parent_name]</h6>");
        echo ("</div>");
        echo ("<h6 class=\"volgnr\">volg nr:$value[Volgnr]</h6>");
        echo ("</a>");
    }
}
?>
            </div>
        </div>
        <div class="rij eigenschappen noShow">
            <div>
                <!-- INFO -->
            <h3 id="Title">Title</h3>
            <h5 id="parentID">parentID</h5>
            <h5>|</h5>
            <h5 id="Volgnummer">Volgnummer</h5>
            </div>
            <div>
                <!-- FORMS -->
                <!-- UPDATE -->
                <h3>Update</h3>
            <form action="" method="POST">
                <div>
                    <!-- ID -->
                    <input class="Title" type="number" name="RubriekID" id="RubriekID" hidden>
                </div>
                <div>
                    <!-- NAME -->
                    <input class="Title" type="text" name="RubriekName" id="RubriekName">
                </div>
                <div>
                    <!-- PARENT ID -->
                    <input type="number" name="RubriekParent" id="RubriekParent">
                </div>
                <div>
                    <!-- VOLG NUMMER -->
                    <input type="number" name="RubriekVolgNummer" id="RubriekVolgNummer" hidden>
                </div>
                <div>
                    <!-- VOLG NUMMER -->
                    <input type="checkbox" name="Accept" id="Accept">
                    <input type="submit" name="DeleteRubriek" value="DELETE">
                </div>
            </form>
            </div>
            <div>
                <h3>Delete</h3>
                <!-- DELETE -->
            <form action="" method="POST">
                <!-- <h4>DELETE</h4>
                <input type="text" name="RubriekID" id="RubriekID">
                <input type="checkbox" name="Accept" id="Accept">
                <input type="submit" name="DeleteRubriek" value="DELETE"> -->
            </form>
            </div>
        </div>
    </div>
</div>
</div>
<?php
include_once 'prefabs/footer.php';
?>