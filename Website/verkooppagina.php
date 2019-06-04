<?php

include_once "includes/functies.php";
include_once "includes/database.php";
include_once "includes/header.php";
?>

<body class="d-flex flex-column">
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Product verkopen</h1>
                </div>
            </div>
            <div class="row">         
               
                <div class="col-md-6 verkooppagina">
                <form method="post" action="index.php"> 
                <p class = "verkoophead"> Product specificaties </p>    
                        <h6>Titel van je product</h6>
                        <input type="text" class= "form-control inputforms" name="titel" required>
                        <h6>Beschrijving van je product</h6>
                        <input type="text" class= "form-control inputforms" name="beschrijving" required>
                        <h6>Afbeelding(en) van je product</h6>
                        <input type="file" class= "form-control inputforms" name="bestand" required>

                </div>

                
                <div class="col-md-6 verkooppagina">
                <p class = "verkoophead"> Prijs specificaties</p>
                    <h6>Startprijs</h6>
                    <input type="text" class= "form-control inputforms" required>
                    <h6>Betalingsinstructies</h6>
                    <input type="text" class= "form-control inputforms">
                    <h6>Betalingswijze</h6>
                    <select class = "form-control inputforms" name="betalingswijze" required>
                        <option value = 'iDeal'>iDeal</option>
                        <option value = 'Creditcard'>Creditcard</option>
                    </select>
                </div>
                

                             
                <div class="col-md-6 verkooppagina">
                <p class = "verkoophead"> Overige specificaties</p>

                <h6> Rubriek van product </h6>
                        <select class = "form-control inputforms" name = "rubriek" required>
</select>
                        <h6>Looptijd</h6>
                        <select class = "form-control inputforms" name = "looptijd" required>
                            <option value = "1">1 dag</option>
                            <option value = "3">3 dagen</option>
                            <option value = "5">5 dagen</option>
                            <option value = "7">7 dagen</option>
                            <option value = "9">9 dagen</option>
                        </select>
                        <h6> Jouw locatie</h6>
                <select class = "form-control inputforms" name = "locatie" required>
                    <option value ="#">#</option>
</select>
                </div>
                
                
            </div>
        </div>
        <div class="text-center" style="margin: 20px;">
    <button class="btn btn-primary" type="submit" style="background-color: #a9976a;" name="veilen">Start veiling</button>
    </div>
    </form>
    </div>
    </div>
    <div class= "spacing">
</div>
    
   
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

<?php
include_once "includes/footer.php";
?>