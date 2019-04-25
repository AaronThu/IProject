<?php

$hostname = "(local)";
$dbname = "testDatabase";
$username = "sa";
$pw = "QrpQ5736";

try {
    $dbh = new PDO ("sqlsrv:Server=$hostname;Database=$dbname;
			ConnectionPooling=0", "$username", "$pw");
    if(!$dbh) {
        throw new Exception();
    }
}
catch(Exception $e){
    echo "het werkt";
    $_SESSION['foutmelding'] = "Fout: kan geen verbinding maken met de server, probeer het later opnieuw";
}

if(!isset($_SESSION))
{
    session_start();
}
