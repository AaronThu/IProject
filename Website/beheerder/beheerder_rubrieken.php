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
            <h5>Zoek op</h5>
            <div class="filters">
                <div class="checkBox"><input type="checkbox" onChange="this.form.submit()" name="NaamRubriek" id="NaamRubriek" form="Search" <?php echo (isset($_GET["NaamRubriek"]) ? "checked" : "") ?>> <label for="NaamRubriek">Naam</label></div>
                <div class="checkBox"><input type="checkbox" onChange="this.form.submit()" name="NaamParent" id="NaamParent" form="Search" <?php echo (isset($_GET["NaamParent"]) ? "checked" : "") ?>> <label for="NaamParent">Naam Parent</label></div>
            </div>
            <h5>Sorteren op </h5>
            <div class="filters">
                <div class="checkBox"><input type="checkbox" onChange="this.form.submit()" name="sortNaamRubriek" id="sortNaamRubriek" form="Search" <?php echo (isset($_GET["sortNaamRubriek"]) ? "checked" : "") ?>> <label for="sortNaamRubriek">Naam</label></div>
                <div class="checkBox"><input type="checkbox" onChange="this.form.submit()" name="sortVolgnummer" id="sortVolgnummer" form="Search" <?php echo (isset($_GET["sortVolgnummer"]) ? "checked" : "") ?>> <label for="sortVolgnummer">Volgnummer</label></div>
                <div class="checkBox"><input type="checkbox" onChange="this.form.submit()" name="sortParentRubriek" id="sortParentRubriek" form="Search" <?php echo (isset($_GET["sortParentRubriek"]) ? "checked" : "") ?>> <label for="sortParentRubriek">Parent Rubriek</label></div>
                <div class="checkBox"><input type="checkbox" onChange="this.form.submit()" name="sortAflopend" id="sortAflopend" form="Search" <?php echo (isset($_GET["sortAflopend"]) ? "checked" : "") ?>> <label for="sortAflopend">Aflopend</label></div>
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
        $parent = $value["Parent_rubriek"];
        if (!isset($parent)) {
            $parent = $value["Rubrieknummer"];
        }
        $open = ($value["Status"] === "open") ? "open" : "gesloten";
        $openIdex = ($value["Status"] === "open") ? 1 : 0;
        echo ('<a onClick=setRubriek(this,' . $value["Rubrieknummer"] . ',' . '"' . str_replace(" ", "_", $value["Rubrieknaam"]) . '",' . $parent . ',"' . str_replace(" ", "_", $value["Parent_name"]) . '",' . $value["Volgnr"] . ',' . $openIdex . ') class="zoekresultaat ' . $open . '">');
        echo ("<div class=\"block\">");
        echo ("<h5 class=\"id\">ID: $value[Rubrieknummer]</h5>");
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
            <h2 id="Title">Title</h2>
            </div>
            <div class="wijzegingen">
                <!-- FORMS -->
                <!-- UPDATE -->
                <h4>Update Rubriek</h4>
                <form action="" method="POST">
                    <!-- ID -->
                    <input id="RubriekenID" class="ID" type="number" name="RubriekID" value="" id="RubriekID" hidden>
                    <!-- NAME -->
                    <div class="inputField">
                        <label for="RubriekenName">Naam</label>
                        <input id="RubriekenName" class="Name" type="text" name="RubriekName" value="" placeholder="Naam" id="RubriekName">
                    </div>
                    <!-- PARENT ID -->
                    <div class="inputField">
                        <label for="ParentRubriekID">Parent rubriek ID</label>
                        <input id="ParentRubriekID" class="RubriekParent" type="number" name="RubriekParent" value="" placeholder="Parent rubriek ID" id="RubriekParent">
                    </div>
                    <!-- VOLG NUMMER -->
                    <label for="VolgNummerID">Volg Nummer</label>
                    <div>
                        <input type="button" onclick="CountVolgnummer(1)" value="+">
                        <input id="VolgNummerID" class="VolgNummer inputNummer" type="number" name="RubriekVolgNummer" id="RubriekVolgNummer">
                        <input type="button" onclick="CountVolgnummer(-1)" value="-">
                    </div>
                    <!-- ACCEPT -->
                    <div class="inputField">
                        <input id="AcceptBox1" type="checkbox" name="Accept" id="Accept">
                        <label for="AcceptBox1">Zeker weten</label>
                        <input type="submit" name="UpdateRubriek" value="Update">
                    </div>
                </form>
            </div>
            <div class="wijzegingen delete">
                <h4>Sluit Rubriek</h4>
                <!-- DELETE -->
                <form action="" method="POST">
                    <!-- ID -->
                    <input id="RubriekenID" class="ID" type="number" name="RubriekID" value="" id="RubriekID" hidden>
                    <!-- ACCEPT -->
                    <div class="inputField">
                        <input id="AcceptBox2" type="checkbox" name="Accept" id="Accept">
                        <label for="AcceptBox2">Zeker weten</label>
                        <input type="submit" name="DeleteRubriek" value="Sluit">
                    </div>
                </form>
            </div>
            <div class="wijzegingen heropen">
                <h4>Heropen Rubriek</h4>
                <!-- DELETE -->
                <form action="" method="POST">
                    <!-- ID -->
                    <input id="RubriekenID" class="ID" type="number" name="RubriekID" value="" id="RubriekID" hidden>
                    <!-- ACCEPT -->
                    <div class="inputField">
                        <input id="AcceptBox4" type="checkbox" name="Accept" id="Accept">
                        <label for="AcceptBox4">Zeker weten</label>
                        <input type="submit" name="HerOpenRubriek" value="Heropen">
                    </div>
                </form>
            </div>
        </div>

        <div class="rij maken noShow">
            <h4>Maken</h4>
            <div class="wijzegingen">
            <form action="" method="POST">
                    <!-- NAME -->
                    <div class="inputField">
                        <label for="RubriekenName">Naam</label>
                        <input id="RubriekenName" class="" type="text" name="RubriekName" value="<?php echo (isset($_POST["RubriekName"]) ? ($_POST["RubriekName"]) : "") ?>" placeholder="Naam" id="RubriekName">
                    </div>
                    <!-- PARENT ID -->
                    <div class="inputField">
                        <label for="ParentRubriekID">Select parent rubriek </label>
                        <input id="ParentRubriekID" class="ID" type="number" name="RubriekParent" placeholder="Parent rubriek ID" hidden>
                        <input id="ParentRubriekName" class="Name" type="text" name="RubriekParent" placeholder="Parent rubriek" disabled>
                    </div>
                    <!-- VOLG NUMMER -->
                    <label for="VolgNummerID">Volg Nummer</label>
                    <div>
                        <input type="button" onclick="CountVolgnummer(1)" value="+">
                        <input id="VolgNummerID" class="inputNummer" type="number" name="RubriekVolgNummer" id="RubriekVolgNummer" value="1">
                        <input type="button" onclick="CountVolgnummer(-1)" value="-">
                    </div>
                    <!-- ACCEPT -->
                    <div class="inputField">
                        <input id="AcceptBox3" type="checkbox" name="Accept" id="Accept">
                        <label for="AcceptBox3">Zeker weten</label>
                        <input type="submit" name="InsertRubriek" value="Creëer">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?php
include_once 'prefabs/footer.php';
?>