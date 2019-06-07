 <!-- Sorting box -->
 <div class="sortingContainer">
     <div>
         <div>
             <h5 class="title">Sorteren op:</h5>
         </div>
         <div><input type="checkbox" onChange="this.form.submit()" name="SortNaam" id="SortNaam" form="<?php echo (isset($formName) ? $formName : "PageInfo") ?>" <?php echo (isset($_GET["SortNaam"]) ? "checked" : "") ?>> <label for="SortNaam">Naam</label></div>
         <div><input type="checkbox" onChange="this.form.submit()" name="SortPrijs" id="SortPrijs" form="<?php echo (isset($formName) ? $formName : "PageInfo") ?>" <?php echo (isset($_GET["SortPrijs"]) ? "checked" : "") ?>> <label for="SortPrijs">Prijs</label></div>
         <div><input type="checkbox" onChange="this.form.submit()" name="SortTijdResterend" id="SortTijdResterend" form="<?php echo (isset($formName) ? $formName : "PageInfo") ?>" <?php echo (isset($_GET["SortTijdResterend"]) ? "checked" : "") ?>> <label for="SortTijdResterend">Tijd Resterend</label></div>
         <div><input type="checkbox" onChange="this.form.submit()" name="SortAflopend" id="SortAflopend" form="<?php echo (isset($formName) ? $formName : "PageInfo") ?>" <?php echo (isset($_GET["SortAflopend"]) ? "checked" : "") ?>> <label for="SortAflopend">Aflopend</label></div>
     </div>
 </div>