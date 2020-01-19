<?php
include "laczenieZBaza.php";
if ($polaczenie->connect_errno) {
    echo "<script>console.log('Brak polaczenia z baza');</script>";
    exit;
} else {
    $zapytanie = $polaczenie->query(" select Imie, Nazwisko from kelnerzy where idKelnera = ".$_SESSION["random"].";");

    while ($row = mysqli_fetch_array($zapytanie)) {
        $imie = $row['Imie'];
        $nazwisko = $row['Nazwisko'];
    }

    echo $imie." ".$nazwisko;
}
