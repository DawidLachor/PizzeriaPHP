<?php
include "laczenieZBaza.php";
if ($polaczenie->connect_errno) {
    echo "<script>console.log('Brak polaczenia z baza');</script>";
    exit;
} else {
    $nazwaPizzy = array();
    $dzien = $polaczenie->query("select idMenu, idKlienta from zamowienia where Czas=\"" . $_POST["dzien"] . "\";");
    while ($row = mysqli_fetch_array($dzien)) {

        $menu = $polaczenie->query("select idPizzy from manupizze where idMenu = " . $row['idMenu'] . ";");

        while ($row1 = mysqli_fetch_array($menu)) {

            $pizza = $polaczenie->query("select NazwaPizzy from pizze where idPizza = " . $row1['idPizzy'] . ";");

            while ($row2 = mysqli_fetch_array($pizza)) {

                $ile = $polaczenie->query("select count(NazwaPizzy) as ile from pizze where NazwaPizzy =  \"" . $row2['NazwaPizzy'] . "\";");

                while ($row3 = mysqli_fetch_array($ile)) {

                    if ($row3["ile"] >= 3) {

                        if (count($nazwaPizzy) != 0) {
                            $item_array_id = array_column($nazwaPizzy, 'nazwa');

                            $count = count($nazwaPizzy);
                            $item_array = array(
                                'idKlienta' => $row['idKlienta'],
                                'nazwa' => $row2['NazwaPizzy'],
                                'idPizzy' => $row1['idPizzy']
                            );
                            $nazwaPizzy[$count] = $item_array;

                        } else {
                            $item_array = array(
                                'idKlienta' => $row['idKlienta'],
                                'nazwa' => $row2['NazwaPizzy'],
                                'idPizzy' => $row1['idPizzy']
                            );
                            $nazwaPizzy[0] = $item_array;
                        }

                    }
                }
            }
        }
    }


    $ilePizzy = array();
    foreach ($nazwaPizzy as $keys => $values) {

        if (count($ilePizzy) != 0) {
            $item_array_id = array_column($ilePizzy, 'nazwa');
            if (!in_array($values['nazwa'],$item_array_id)) {
                $count = count($ilePizzy);
                $item_array = array(
                    'nazwa' => $values['nazwa']
                );
                $ilePizzy[$count] = $item_array;
            }
        } else {
            $item_array = array(
                'nazwa' => $values['nazwa']
            );
            $ilePizzy[0] = $item_array;
        }

    }

    foreach ($ilePizzy as $key => $value) {

        $newPizza = "";

        foreach ($nazwaPizzy as $keys => $values){
            if ($values['nazwa'] == $value['nazwa']){

                $dodIdPizzy = $values['idPizzy'];

                $klient = $polaczenie->query("select Imie from klienci where idKlienci = ".$values['idKlienta'].";");
                while ($row4 = mysqli_fetch_array($klient)) {
                    $newPizza .= $row4['Imie'];
                    }
            }
        }

        $czyIstnieje = $polaczenie->query("select count(NazwaPizzy) as suma from pizze where NazwaPizzy = \"".$newPizza."\";");
        while ($row6 = mysqli_fetch_array($czyIstnieje)) {
            $istnieje = $row6['suma'];
        }
        if ($istnieje == 0) {
            $polaczenie->query("insert into pizze values(0,'" . $newPizza . "',1);");

            $idpizzy = $polaczenie->query("select idPizza from pizze where NazwaPizzy = \"" . $newPizza . "\";");
            while ($row5 = mysqli_fetch_array($idpizzy)) {
                $idPizzy = $row5['idPizza'];
                echo "<div class='col-12'>IdPizzy: ".$idPizzy."<br>";
            }

            $idDodatku = $polaczenie->query("select idDodatku, Podwojen  from dod_pizz where idPizzy = " . $dodIdPizzy . ";");
            while ($row6 = mysqli_fetch_array($idDodatku)) {
//                echo "<div class='col-12'>IdPizzy1: ".$idPizzy."<br>";
                echo "<div class='col-12'>IdDodatku: ".$row6['idDodatku']."<br>";
                echo "<div class='col-12'>Podwujne: ".$row6['Podwojen']."<br>";
                $polaczenie->query("insert into dod_pizz values(0," . $idPizzy . "," . $row6['idDodatku'] . "," . $row6['Podwojen'] . ");");
            }
        }
    }
}
