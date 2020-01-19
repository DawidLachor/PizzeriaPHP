<?php
include "laczenieZBaza.php";

if ($polaczenie->connect_errno) {
    echo "<script>console.log('Brak polaczenia z baza');</script>";
    exit;
} else {
    if (isset($_POST['procentButton'])) {

        $procent = $_POST['procent'] / 100;
        $query = "select * from kelnerzy;";
        $result = mysqli_query($polaczenie, $query);

        while ($row = mysqli_fetch_array($result)) {

            $dochod = 0;
            $query1 = "select idMenu from zamowienia where idKelnera = " . $row['idKelnera'] . " and Czas = '".$_POST['dzienPremi']."';";
            $result1 = mysqli_query($polaczenie, $query1);

            while ($row1 = mysqli_fetch_array($result1)) {

                $query2 = "select idPizzy, idRodzajCiasta from manupizze where idMenu = " . $row1['idMenu'] . ";";
                $result2 = mysqli_query($polaczenie, $query2);

                while ($row2 = mysqli_fetch_array($result2)) {

                    $query3 = "select sum(CenaDodatku) as suma from dodatki inner join dod_pizz on dodatki.idDodatku = dod_pizz.idDodatku inner join pizze on pizze.idPizza = dod_pizz.idPizzy where dod_pizz.idPizzy=" . $row2['idPizzy'] . ";";
                    $result3 = mysqli_query($polaczenie, $query3);

                    while ($row3 = mysqli_fetch_array($result3)) {

                        $dochod += $row3['suma'];

                    }

                    $query2 = "select Cena from rodzajeciasta where idRodzajCiasta = " . $row1['idRodzajCiasta'] . ";";

                    while ($row4 = mysqli_fetch_array($result3)) {

                        $dochod += $row4['Cena'];

                    }
                }
            }
            echo "<p class='col-12'> Premia dla ".$row['Imie']." ".$row["Nazwisko"]." wynosi: ".round($dochod*$procent,2)." zł</p>";
        }
    }
}
